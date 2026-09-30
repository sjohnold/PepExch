<script setup>
import { ref, computed, watch } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { countries, formatLocation } from '@/data/locations';

const props = defineProps({
    colors: Array,
    brands: Array,
    categories: Array,
});

// Computed parent categories
const parentCategories = computed(() => (props.categories || []).filter(c => !c.parent_id));
const subCategories = computed(() => {
    if (!form.category) return [];
    return (props.categories || []).filter(c => c.parent_id === parseInt(form.category));
});

const form = useForm({
    name: '',
    description: '',
    condition: 'used',
    category: '',
    subcategory: '',
    country: 'Srbija',
    city: '',
    location: '',
    phone: '',
    thumbnail: null,
    additional_images: [],
    brand: '',
    // Guest info
    user_name: '',
    email: '',
});

const thumbnailPreview = ref(null);
const additionalPreviews = ref([]);
const selectedCountry = computed(() => countries.find((country) => country.name === form.country) || countries[0]);

const handleThumbnail = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.thumbnail = file;
        thumbnailPreview.value = URL.createObjectURL(file);
    }
};

const handleAdditionalImages = (e) => {
    const files = Array.from(e.target.files);
    form.additional_images = files;
    additionalPreviews.value = files.map(f => URL.createObjectURL(f));
};

const submit = () => {
    form.post(route('products.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            thumbnailPreview.value = null;
            additionalPreviews.value = [];
        },
    });
};

watch(() => form.category, () => {
    form.subcategory = '';
});

watch(() => form.country, () => {
    form.city = '';
});

watch([() => form.city, () => form.country], () => {
    form.location = form.city ? formatLocation(form.city, form.country) : '';
}, { immediate: true });
</script>

<template>
    <Head title="Novi Oglas" />
    <AppLayout>
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fas fa-plus-circle text-green-600"></i> Kreiraj Novi Oglas
                </h1>
                <p class="text-gray-500 mt-1">Popunite podatke o predmetu koji želite da razmenjujete</p>
            </div>

            <!-- Global errors -->
            <div v-if="Object.keys(form.errors).length > 0" class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                <p class="font-bold mb-1"><i class="fas fa-exclamation-circle"></i> Molimo ispravite sledeće greške:</p>
                <ul class="list-disc ml-5 text-sm">
                    <li v-for="(error, key) in form.errors" :key="key">{{ error }}</li>
                </ul>
            </div>

            <form @submit.prevent="submit" class="space-y-6">
                <!-- User Info (Guest only) -->
                <div v-if="!$page.props.auth?.user" class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-green-600"></i> Vaši podaci
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Vaše Ime *</label>
                            <input v-model="form.user_name" type="text" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Npr. Petar Petrović" :required="!$page.props.auth?.user">
                            <div v-if="form.errors.user_name" class="text-red-500 text-xs mt-1">{{ form.errors.user_name }}</div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Email adresa *</label>
                            <input v-model="form.email" type="email" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="primer@email.com" :required="!$page.props.auth?.user">
                            <div v-if="form.errors.email" class="text-red-500 text-xs mt-1">{{ form.errors.email }}</div>
                        </div>
                    </div>
                </div>

                <!-- Basic Info -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-tag text-green-600"></i> Osnovni podaci
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Naziv predmeta *</label>
                            <input v-model="form.name" type="text" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Npr. iPhone 13, Bicikl Trek..." required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Opis *</label>
                            <textarea v-model="form.description" rows="5" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="Opišite predmet, stanje, šta tražite za uzvrat..." required></textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Stanje *</label>
                                <select v-model="form.condition" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500" required>
                                    <option value="new">Novo</option>
                                    <option value="used">Korišćeno</option>
                                    <option value="like_new">Kao novo</option>
                                    <option value="refurbished">Obnovljeno</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kontakt telefon *</label>
                                <input v-model="form.phone" type="text" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500" placeholder="+381..." required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories & Brand -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-folder text-green-600"></i> Kategorija i Brend
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Kategorija *</label>
                            <select v-model="form.category" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500" required>
                                <option value="">Izaberite</option>
                                <option v-for="cat in parentCategories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Podkategorija</label>
                            <select v-model="form.subcategory" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500" :disabled="!subCategories.length">
                                <option value="">Izaberite</option>
                                <option v-for="sub in subCategories" :key="sub.id" :value="sub.id">{{ sub.name }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Brend *</label>
                            <select v-model="form.brand" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500" required>
                                <option value="">Izaberite</option>
                                <option v-for="b in brands" :key="b.id" :value="b.id">{{ b.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Location -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-green-600"></i> Lokacija
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Država</label>
                            <select v-model="form.country" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500">
                                <option v-for="country in countries" :key="country.code" :value="country.name">
                                    {{ country.name }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Grad / mesto</label>
                            <input
                                v-model.trim="form.city"
                                type="text"
                                :list="`city-options-${selectedCountry.code}`"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500"
                                placeholder="Unesite grad ili selo"
                                autocomplete="address-level2"
                            >
                            <datalist :id="`city-options-${selectedCountry.code}`">
                                <option v-for="city in selectedCountry.cities" :key="city" :value="city"></option>
                            </datalist>
                            <p class="mt-1 text-xs text-gray-500">Mozete izabrati predlog ili upisati bilo koji grad, selo ili naselje.</p>
                        </div>
                        <div v-if="form.errors.location" class="sm:col-span-2 text-red-500 text-xs">
                            {{ form.errors.location }}
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-images text-green-600"></i> Fotografije
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Glavna slika</label>
                            <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-green-400 transition bg-gray-50">
                                <img v-if="thumbnailPreview" :src="thumbnailPreview" class="w-full h-full object-contain rounded-xl p-1">
                                <div v-else class="text-center">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 mb-2"></i>
                                    <p class="text-xs text-gray-500">Kliknite za upload (Opciono)</p>
                                </div>
                                <input type="file" class="hidden" @change="handleThumbnail" accept="image/*">
                            </label>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Dodatne slike (max 5)</label>
                            <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-green-400 transition bg-gray-50">
                                <i class="fas fa-plus text-2xl text-gray-300 mb-1"></i>
                                <p class="text-xs text-gray-500">Dodajte slike</p>
                                <input type="file" class="hidden" @change="handleAdditionalImages" accept="image/*" multiple>
                            </label>
                            <div v-if="additionalPreviews.length" class="flex gap-2 mt-3 flex-wrap">
                                <img v-for="(src, i) in additionalPreviews" :key="i" :src="src" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-end gap-4">
                    <button type="submit" :disabled="form.processing" class="bg-green-600 hover:bg-green-700 disabled:bg-gray-300 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg shadow-green-200 flex items-center gap-2">
                        <i :class="form.processing ? 'fas fa-spinner fa-spin' : 'fas fa-check'"></i>
                        {{ form.processing ? 'Kreiranje...' : 'Objavi Oglas' }}
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>

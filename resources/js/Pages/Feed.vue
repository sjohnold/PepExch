<script setup>
import { computed, ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ListingCard from '@/Components/ListingCard.vue';

const props = defineProps({
    products: Object,
    conditions: Array,
    locations: Array,
    brands: Array,
    DateFilters: Array,
    allCategories: Array,
    filters: Object // current query parameters
});

const isLoading = ref(false);
const searchQuery = ref(props.filters?.product_search || props.filters?.search || '');
const selectedCategory = ref(props.filters?.category || '');
const selectedCondition = ref(props.filters?.conditions || props.filters?.condition || '');
const selectedLocation = ref(props.filters?.location || '');
const selectedSort = ref(props.filters?.price_sort || (searchQuery.value ? 'relevance' : 'recent'));

const conditionItems = computed(() => (props.conditions || [])
    .map((cond) => {
        if (typeof cond === 'string') {
            return { value: cond, label: cond, total: null };
        }

        const value = cond.condition || cond.conditions || cond.value || '';

        return {
            value,
            label: cond.label || value,
            total: cond.total ?? null,
        };
    })
    .filter((cond) => cond.value));

const locationItems = computed(() => {
    if (Array.isArray(props.locations)) {
        return props.locations
            .map((loc) => {
                if (typeof loc === 'string') {
                    return { value: loc, label: loc, total: null };
                }

                const value = loc.city || loc.location || loc.value || '';

                return {
                    value,
                    label: loc.label || value,
                    total: loc.total ?? null,
                };
            })
            .filter((loc) => loc.value);
    }

    return Object.entries(props.locations || {})
        .map(([location, total]) => ({ value: location, label: location, total }))
        .filter((loc) => loc.value);
});

const applyFilters = () => {
    isLoading.value = true;
    router.get(
        route('products'),
        {
            product_search: searchQuery.value,
            category: selectedCategory.value,
            conditions: selectedCondition.value,
            location: selectedLocation.value,
            price_sort: selectedSort.value === 'relevance' ? '' : selectedSort.value,
        },
        { 
            preserveState: true, 
            preserveScroll: true,
            onFinish: () => isLoading.value = false
        }
    );
};

const paginationLabel = (label = '') => label
    .replaceAll('&laquo;', '<')
    .replaceAll('&raquo;', '>');

// Auto-apply on change
watch([selectedCategory, selectedCondition, selectedLocation, selectedSort], () => {
    applyFilters();
});
</script>

<template>
    <Head title="Oglasi - Feed" />

    <AppLayout>
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-6">
            
            <!-- Sidebar Filters -->
            <aside class="w-full md:w-1/4 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 self-start">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                    <i class="fas fa-filter text-green-600"></i> Filteri
                </h3>

                <!-- Search -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pretraga</label>
                    <div class="relative">
                        <input type="text" v-model="searchQuery" @keyup.enter="applyFilters" placeholder="Unesite pojam..." class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500 transition-all">
                        <i class="fas fa-search absolute right-4 top-3.5 text-gray-400"></i>
                    </div>
                </div>

                <!-- Categories -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategorije</label>
                    <select v-model="selectedCategory" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">Sve kategorije</option>
                        <option v-for="cat in allCategories" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
                    </select>
                </div>

                <!-- Condition -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Stanje</label>
                    <div class="space-y-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" v-model="selectedCondition" value="" class="text-green-600 focus:ring-green-500 bg-gray-100 border-gray-300">
                            <span class="text-sm text-gray-700">Sve</span>
                        </label>
                        <label v-for="cond in conditionItems" :key="cond.value" class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" v-model="selectedCondition" :value="cond.value" class="text-green-600 focus:ring-green-500 bg-gray-100 border-gray-300">
                            <span class="text-sm text-gray-700">
                                {{ cond.label }}<template v-if="cond.total !== null"> ({{ cond.total }})</template>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Location -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokacija</label>
                    <select v-model="selectedLocation" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">Sve lokacije</option>
                        <option v-for="loc in locationItems" :key="loc.value" :value="loc.value">
                            {{ loc.label }}<template v-if="loc.total !== null"> ({{ loc.total }})</template>
                        </option>
                    </select>
                </div>
                
                <button @click="applyFilters" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl transition shadow-sm mt-2">
                    Primenite Filtere
                </button>
            </aside>

            <!-- Feed Content -->
            <main class="w-full md:w-3/4">
                <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6 flex flex-wrap gap-3 justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Pronađeno: {{ products.total }} oglasa</h2>
                    <select v-model="selectedSort" aria-label="Sortiranje rezultata" class="bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 text-sm">
                        <option value="relevance" :disabled="!searchQuery">Najrelevantnije</option>
                        <option value="recent">Najnovije</option>
                        <option value="low_high">Cena: rastuće</option>
                        <option value="high_low">Cena: opadajuće</option>
                    </select>
                </div>

                <!-- Skeletons -->
                <div v-if="isLoading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="i in 6" :key="i" class="bg-white rounded-2xl p-4 animate-pulse shadow-sm border border-gray-100">
                        <div class="w-full h-48 bg-gray-200 rounded-xl mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-3"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2 mb-4"></div>
                        <div class="flex gap-2 mt-4">
                            <div class="h-8 bg-gray-200 rounded-lg w-1/2"></div>
                        </div>
                    </div>
                </div>

                <!-- Grid -->
                <div v-else-if="products.data && products.data.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <ListingCard 
                        v-for="listing in products.data" 
                        :key="listing.id"
                        :listing="listing"
                        @click="router.visit(route('product-details', listing.id))"
                    />
                </div>

                <!-- Empty state -->
                <div v-else class="flex flex-col items-center justify-center bg-white rounded-2xl py-20 border border-gray-100 shadow-sm text-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-box-open text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Nema rezultata</h3>
                    <p class="text-gray-500 mb-6 max-w-sm">Pokušajte da promenite parametre pretrage ili uklonite neke filtere.</p>
                    <button @click="() => { selectedCategory = ''; selectedCondition = ''; selectedLocation = ''; searchQuery = ''; applyFilters(); }" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-6 rounded-lg transition">
                        Resetuj filtere
                    </button>
                </div>

                <!-- Pagination -->
                <div v-if="products.links && products.data.length > 0" class="mt-8 flex justify-center gap-2 flex-wrap">
                    <template v-for="(link, i) in products.links" :key="i">
                        <Link 
                            v-if="link.url"
                            :href="link.url" 
                            class="px-4 py-2 rounded-lg text-sm font-medium transition"
                            :class="link.active ? 'bg-green-600 text-white shadow-sm' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-200'"
                        >
                            {{ paginationLabel(link.label) }}
                        </Link>
                        <span v-else class="px-4 py-2 rounded-lg text-sm font-medium text-gray-400 bg-gray-50 border border-gray-100">
                            {{ paginationLabel(link.label) }}
                        </span>
                    </template>
                </div>
            </main>
            
        </div>
    </AppLayout>
</template>

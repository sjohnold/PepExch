<script setup>
import { computed, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    profile: Object,
    languages: {
        type: Array,
        default: () => [],
    },
});

const previewUrl = ref(props.profile?.profile_photo_path || '/media/demo-img.png');

const form = useForm({
    name: props.profile?.name || '',
    phone_no: props.profile?.phone_no || '',
    email: props.profile?.email || '',
    whatsapp_number: props.profile?.whatsapp_number || '',
    address: props.profile?.address || '',
    latitude: props.profile?.latitude || '',
    longitude: props.profile?.longitude || '',
    profile_photo: null,
});

const isVerified = computed(() => props.profile?.email_verified || props.profile?.phone_verified);

const onPhotoChange = (event) => {
    const file = event.target.files?.[0];
    form.profile_photo = file || null;

    if (file) {
        previewUrl.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    form.post(route('user.profile-update', props.profile.id), {
        preserveScroll: true,
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Profil" />

    <AppLayout>
        <div class="mx-auto grid max-w-7xl gap-6 lg:grid-cols-[0.85fr_1.15fr]">
            <section class="rounded-3xl bg-gradient-to-br from-green-600 to-green-800 p-6 text-white shadow-2xl md:p-8">
                <div class="flex flex-col items-center text-center">
                    <label class="group relative cursor-pointer">
                        <img :src="previewUrl" alt="Profil" class="h-36 w-36 rounded-full border-4 border-white/30 object-cover shadow-2xl">
                        <span class="absolute inset-x-3 bottom-2 rounded-full bg-slate-900/70 px-3 py-1.5 text-[10px] font-black uppercase tracking-wider opacity-0 backdrop-blur transition group-hover:opacity-100">
                            Promeni
                        </span>
                        <input type="file" accept="image/*" class="hidden" @change="onPhotoChange">
                    </label>

                    <h1 class="mt-5 text-3xl font-black">{{ profile.name || 'Korisnik' }}</h1>
                    <p class="mt-1 text-sm text-green-50">{{ profile.email || profile.phone_no }}</p>

                    <div class="mt-5 inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-2 text-xs font-black uppercase tracking-widest backdrop-blur">
                        <i :class="isVerified ? 'fas fa-check-circle' : 'fas fa-circle-exclamation'"></i>
                        {{ isVerified ? 'Verifikovan profil' : 'Profil nije verifikovan' }}
                    </div>
                </div>

                <div class="mt-8 grid gap-3 text-sm">
                    <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs font-black uppercase tracking-widest text-green-100">Telefon</p>
                        <p class="mt-1 font-semibold">{{ profile.phone_no || 'Nije unet' }}</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-4 backdrop-blur">
                        <p class="text-xs font-black uppercase tracking-widest text-green-100">Adresa</p>
                        <p class="mt-1 font-semibold">{{ profile.address || 'Nije uneta' }}</p>
                    </div>
                </div>
            </section>

            <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm md:p-8">
                <div class="mb-8">
                    <p class="text-xs font-black uppercase tracking-widest text-green-600">Moj profil</p>
                    <h2 class="mt-2 text-3xl font-black text-gray-900">Podaci naloga</h2>
                </div>

                <form class="grid gap-5" @submit.prevent="submit">
                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">Ime i prezime</span>
                            <input v-model="form.name" type="text" class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white">
                            <span v-if="form.errors.name" class="mt-2 block text-xs font-bold text-red-500">{{ form.errors.name }}</span>
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">Telefon</span>
                            <input v-model="form.phone_no" type="text" class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white">
                            <span v-if="form.errors.phone_no" class="mt-2 block text-xs font-bold text-red-500">{{ form.errors.phone_no }}</span>
                        </label>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">Email</span>
                            <input v-model="form.email" type="email" class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white">
                            <span v-if="form.errors.email" class="mt-2 block text-xs font-bold text-red-500">{{ form.errors.email }}</span>
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">WhatsApp</span>
                            <input v-model="form.whatsapp_number" type="text" class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white">
                            <span v-if="form.errors.whatsapp_number" class="mt-2 block text-xs font-bold text-red-500">{{ form.errors.whatsapp_number }}</span>
                        </label>
                    </div>

                    <label class="block">
                        <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">Adresa</span>
                        <input v-model="form.address" type="text" class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white">
                        <span v-if="form.errors.address" class="mt-2 block text-xs font-bold text-red-500">{{ form.errors.address }}</span>
                    </label>

                    <div class="flex justify-end">
                        <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 rounded-2xl bg-green-600 px-7 py-3.5 text-sm font-black text-white shadow-lg shadow-green-100 transition hover:-translate-y-0.5 hover:bg-green-700 disabled:cursor-not-allowed disabled:bg-gray-300">
                            <i :class="form.processing ? 'fas fa-spinner fa-spin' : 'fas fa-save'"></i>
                            {{ form.processing ? 'Čuvanje...' : 'Sačuvaj izmene' }}
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </AppLayout>
</template>

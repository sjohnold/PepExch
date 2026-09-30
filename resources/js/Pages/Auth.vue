<script setup>
import { computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import AuthModal from '@/Components/AuthModal.vue';

const props = defineProps({
    mode: {
        type: String,
        default: 'login',
    },
});

const title = computed(() => props.mode === 'register' ? 'Registracija' : 'Prijava');
</script>

<template>
    <Head :title="title" />

    <AppLayout>
        <section class="mx-auto flex min-h-[70vh] max-w-5xl flex-col items-center justify-center rounded-3xl bg-gradient-to-br from-green-600 to-green-800 p-8 text-center text-white shadow-2xl">
            <span class="mb-4 inline-flex rounded-full bg-white/20 px-4 py-1.5 text-xs font-black uppercase tracking-widest backdrop-blur">
                PepExch nalog
            </span>
            <h1 class="max-w-2xl text-4xl font-black leading-tight md:text-5xl">
                {{ mode === 'register' ? 'Kreirajte nalog bez napuštanja novog iskustva.' : 'Prijavite se u PepExch.' }}
            </h1>
            <p class="mt-4 max-w-xl text-sm leading-relaxed text-green-50 md:text-base">
                Ovaj ekran koristi isti izgled kao glavna stranica i otvara sigurni modal za pristup nalogu.
            </p>
            <Link :href="route('home')" class="mt-8 inline-flex items-center gap-2 rounded-2xl bg-white px-6 py-3 text-sm font-black text-green-700 shadow-lg transition hover:-translate-y-0.5 hover:shadow-xl">
                <i class="fas fa-home"></i>
                Nazad na početnu
            </Link>
        </section>

        <AuthModal :is-open="true" :initial-mode="mode" @close="router.visit(route('home'))" />
    </AppLayout>
</template>

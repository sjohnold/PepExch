<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    support: Object,
});

const features = [
    {
        icon: 'fas fa-repeat',
        title: 'Razmena bez komplikacija',
        text: 'PepExch je napravljen za ljude koji žele da predmete brzo zamene, poklone ili pronađu bolju vrednost bez suvišnih koraka.',
    },
    {
        icon: 'fas fa-shield-halved',
        title: 'Bezbedniji dogovori',
        text: 'Profili, poruke i ponude su povezani u jednom toku, tako da svaki dogovor ostaje pregledan i lak za praćenje.',
    },
    {
        icon: 'fas fa-location-dot',
        title: 'Lokalna zajednica',
        text: 'Fokus je na stvarnim predmetima, stvarnim korisnicima i dogovorima u blizini.',
    },
];
</script>

<template>
    <Head title="O PepExchu" />

    <AppLayout>
        <div class="max-w-7xl mx-auto space-y-8">
            <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-green-600 to-green-800 shadow-2xl">
                <div class="absolute inset-0 opacity-20">
                    <img src="/assets/frontend/img/about/about-01.jpg" alt="" class="h-full w-full object-cover">
                </div>
                <div class="relative grid gap-8 p-8 md:grid-cols-[1.1fr_0.9fr] md:p-12">
                    <div class="flex flex-col justify-center text-white">
                        <span class="mb-4 inline-flex w-fit rounded-full bg-white/20 px-4 py-1.5 text-xs font-black uppercase tracking-widest backdrop-blur">
                            O PepExchu
                        </span>
                        <h1 class="max-w-3xl text-4xl font-black leading-tight md:text-6xl">
                            Pametniji način da predmeti nastave život.
                        </h1>
                        <p class="mt-5 max-w-2xl text-base leading-relaxed text-green-50 md:text-lg">
                            Glavna ideja je jednostavna: ono što vama više ne treba može nekome biti baš ono što traži.
                            Zato je PepExch fokusiran na razmenu, jasne oglase i dogovor bez posrednika.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <Link :href="route('products')" class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-black text-green-700 shadow-lg transition hover:-translate-y-0.5 hover:shadow-xl">
                                <i class="fas fa-search"></i>
                                Pogledaj oglase
                            </Link>
                            <Link :href="route('product-ad')" class="inline-flex items-center gap-2 rounded-xl border border-white/30 bg-white/10 px-6 py-3 text-sm font-black text-white backdrop-blur transition hover:bg-white/20">
                                <i class="fas fa-plus"></i>
                                Dodaj oglas
                            </Link>
                        </div>
                    </div>
                    <div class="hidden items-center justify-center md:flex">
                        <div class="aspect-[4/5] w-full max-w-sm overflow-hidden rounded-2xl border-4 border-white/20 shadow-2xl">
                            <img src="/assets/frontend/img/about/about-02.jpg" alt="PepExch zajednica" class="h-full w-full object-cover">
                        </div>
                    </div>
                </div>
            </section>

            <section class="grid gap-5 md:grid-cols-3">
                <article v-for="feature in features" :key="feature.title" class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-xl text-green-600">
                        <i :class="feature.icon"></i>
                    </div>
                    <h2 class="mb-2 text-lg font-black text-gray-900">{{ feature.title }}</h2>
                    <p class="text-sm leading-relaxed text-gray-500">{{ feature.text }}</p>
                </article>
            </section>

            <section class="grid gap-6 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm md:grid-cols-[0.9fr_1.1fr] md:p-8">
                <div class="overflow-hidden rounded-2xl bg-gray-100">
                    <img src="/assets/frontend/img/about/about-03.jpg" alt="Sigurna razmena" class="h-full min-h-72 w-full object-cover">
                </div>
                <div class="flex flex-col justify-center">
                    <span class="mb-3 text-xs font-black uppercase tracking-widest text-green-600">Kako razmišljamo</span>
                    <h2 class="text-3xl font-black text-gray-900">Manje šuma, više korisnih dogovora.</h2>
                    <p class="mt-4 text-sm leading-relaxed text-gray-600">
                        Dizajn glavne stranice stavlja oglase, kategorije i razmenu u prvi plan. Ista logika sada važi i ovde:
                        kratke informacije, jasne akcije i vizuelni stil koji pripada PepExchu, a ne starom generičkom sajtu.
                    </p>
                    <div class="mt-6 grid gap-3 text-sm text-gray-600 sm:grid-cols-3">
                        <div v-if="support?.email" class="rounded-2xl bg-gray-50 p-4">
                            <i class="fas fa-envelope mb-2 text-green-600"></i>
                            <p class="break-words font-semibold">{{ support.email }}</p>
                        </div>
                        <div v-if="support?.phone" class="rounded-2xl bg-gray-50 p-4">
                            <i class="fas fa-phone mb-2 text-green-600"></i>
                            <p class="font-semibold">{{ support.phone }}</p>
                        </div>
                        <div v-if="support?.address" class="rounded-2xl bg-gray-50 p-4">
                            <i class="fas fa-location-dot mb-2 text-green-600"></i>
                            <p class="font-semibold">{{ support.address }}</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </AppLayout>
</template>

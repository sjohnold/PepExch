<script setup>
import { computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ListingCard from '@/Components/ListingCard.vue';

const props = defineProps({
    products: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
    wishlistIds: {
        type: Array,
        default: () => [],
    },
});

const items = computed(() => props.products?.data || []);

const toggleFavorite = (id) => {
    router.get(route('wishlist.add', id), {}, {
        preserveScroll: true,
        preserveState: false,
    });
};

const paginationLabel = (label = '') => label
    .replaceAll('&laquo;', '<')
    .replaceAll('&raquo;', '>');
</script>

<template>
    <Head title="Omiljeno" />

    <AppLayout>
        <div class="mx-auto max-w-7xl space-y-6">
            <section class="flex flex-col gap-4 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-green-600">Sačuvano</p>
                    <h1 class="mt-2 text-3xl font-black text-gray-900">Omiljeni oglasi</h1>
                    <p class="mt-2 text-sm text-gray-500">Lista prati isti ritam kartica kao glavna stranica.</p>
                </div>
                <Link :href="route('products')" class="inline-flex w-fit items-center gap-2 rounded-2xl bg-green-600 px-6 py-3 text-sm font-black text-white shadow-lg shadow-green-100 transition hover:-translate-y-0.5 hover:bg-green-700">
                    <i class="fas fa-search"></i>
                    Pronađi još
                </Link>
            </section>

            <section v-if="items.length" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <ListingCard
                    v-for="listing in items"
                    :key="listing.id"
                    :listing="listing"
                    :is-favorite="wishlistIds.includes(listing.id)"
                    @click="router.visit(route('product-details', listing.id))"
                    @toggle-favorite="toggleFavorite"
                    @send-offer="(id) => router.visit(route('product-details', id))"
                />
            </section>

            <section v-else class="flex min-h-96 flex-col items-center justify-center rounded-3xl border border-gray-100 bg-white p-8 text-center shadow-sm">
                <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-green-50 text-3xl text-green-600">
                    <i class="far fa-heart"></i>
                </div>
                <h2 class="text-2xl font-black text-gray-900">Lista je prazna</h2>
                <p class="mt-2 max-w-sm text-sm text-gray-500">Sačuvani oglasi će se pojaviti ovde čim kliknete srce na kartici.</p>
                <Link :href="route('products')" class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-green-600 px-6 py-3 text-sm font-black text-white shadow-lg shadow-green-100 transition hover:-translate-y-0.5 hover:bg-green-700">
                    <i class="fas fa-search"></i>
                    Pregledaj oglase
                </Link>
            </section>

            <div v-if="products.links && items.length" class="flex flex-wrap justify-center gap-2">
                <template v-for="(link, index) in products.links" :key="index">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="rounded-xl px-4 py-2 text-sm font-bold transition"
                        :class="link.active ? 'bg-green-600 text-white shadow-sm' : 'border border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                    >
                        {{ paginationLabel(link.label) }}
                    </Link>
                    <span v-else class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-2 text-sm font-bold text-gray-400">
                        {{ paginationLabel(link.label) }}
                    </span>
                </template>
            </div>
        </div>
    </AppLayout>
</template>

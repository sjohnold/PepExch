<script setup>
import { computed, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import ListingCard from '@/Components/ListingCard.vue';

const props = defineProps({
    products: {
        type: Array,
        default: () => [],
    },
    wishlistIds: {
        type: Array,
        default: () => [],
    },
    mode: {
        type: String,
        default: 'active',
    },
});

const selectedProduct = ref(null);
const buyerName = ref('');

const title = computed(() => props.mode === 'sold' ? 'Zamenjeni oglasi' : 'Moji oglasi');

const openSoldModal = (product) => {
    selectedProduct.value = product;
    buyerName.value = '';
};

const closeSoldModal = () => {
    selectedProduct.value = null;
    buyerName.value = '';
};

const markAsSold = () => {
    if (!selectedProduct.value) {
        return;
    }

    router.post(route('user.soldout-mark'), {
        product_id: selectedProduct.value.id,
        buyer_name: buyerName.value,
        sold_price: null,
    }, {
        preserveScroll: true,
        onSuccess: closeSoldModal,
    });
};

const moveToTrash = (product) => {
    if (window.confirm('Premestiti oglas u arhivu?')) {
        router.post(route('selling-post.trash', product.id), {}, { preserveScroll: true });
    }
};

const makeCopy = (product) => {
    router.post(route('product.makeCopy', product.id), {}, { preserveScroll: true });
};
</script>

<template>
    <Head :title="title" />

    <AppLayout>
        <div class="mx-auto max-w-7xl space-y-6">
            <section class="flex flex-col gap-5 rounded-3xl bg-white p-6 shadow-sm border border-gray-100 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-green-600">Kabinet</p>
                    <h1 class="mt-2 text-3xl font-black text-gray-900">{{ title }}</h1>
                    <p class="mt-2 text-sm text-gray-500">
                        Upravljajte oglasima u istom interfejsu kao na glavnoj strani.
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <Link :href="route('user.my-ads')" :class="['rounded-xl px-4 py-2 text-xs font-black transition', mode === 'active' ? 'bg-green-600 text-white shadow-lg shadow-green-100' : 'bg-gray-100 text-gray-700 hover:bg-gray-200']">
                        Aktivni
                    </Link>
                    <Link :href="route('user.soldout')" :class="['rounded-xl px-4 py-2 text-xs font-black transition', mode === 'sold' ? 'bg-green-600 text-white shadow-lg shadow-green-100' : 'bg-gray-100 text-gray-700 hover:bg-gray-200']">
                        Zamenjeni
                    </Link>
                    <Link :href="route('product-ad')" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-green-500 to-green-600 px-4 py-2 text-xs font-black text-white shadow-lg shadow-green-100 transition hover:-translate-y-0.5">
                        <i class="fas fa-plus"></i>
                        Novi oglas
                    </Link>
                </div>
            </section>

            <section v-if="products.length" class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <article v-for="product in products" :key="product.id" class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm">
                    <ListingCard
                        :listing="product"
                        :is-mine="true"
                        :is-favorite="wishlistIds.includes(product.id)"
                        @click="router.visit(route('product-details', product.id))"
                    />
                    <div class="grid gap-2 border-t border-gray-100 p-3">
                        <div class="flex items-center justify-between gap-2 text-xs">
                            <span class="rounded-full bg-gray-100 px-2.5 py-1 font-bold text-gray-600">{{ product.status || 'Aktivan' }}</span>
                            <span class="text-gray-400">{{ product.created_label }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <Link :href="route('product.edit', product.id)" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-gray-100 px-3 py-2 text-xs font-black text-gray-700 transition hover:bg-gray-200">
                                <i class="fas fa-pen"></i>
                                Izmeni
                            </Link>
                            <button v-if="mode !== 'sold'" type="button" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-green-50 px-3 py-2 text-xs font-black text-green-700 transition hover:bg-green-100" @click="openSoldModal(product)">
                                <i class="fas fa-handshake"></i>
                                Zamenjeno
                            </button>
                            <button v-else type="button" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-gray-50 px-3 py-2 text-xs font-black text-gray-500" disabled>
                                <i class="fas fa-check"></i>
                                Gotovo
                            </button>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-gray-50 px-3 py-2 text-xs font-black text-gray-600 transition hover:bg-gray-100" @click="makeCopy(product)">
                                <i class="fas fa-copy"></i>
                                Kopija
                            </button>
                            <button type="button" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-red-50 px-3 py-2 text-xs font-black text-red-600 transition hover:bg-red-100" @click="moveToTrash(product)">
                                <i class="fas fa-box-archive"></i>
                                Arhiva
                            </button>
                        </div>
                    </div>
                </article>
            </section>

            <section v-else class="flex min-h-96 flex-col items-center justify-center rounded-3xl border border-gray-100 bg-white p-8 text-center shadow-sm">
                <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-green-50 text-3xl text-green-600">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h2 class="text-2xl font-black text-gray-900">Nema oglasa</h2>
                <p class="mt-2 max-w-sm text-sm text-gray-500">Dodajte prvi oglas i pojaviće se ovde u istom formatu kao kartice na glavnoj.</p>
                <Link :href="route('product-ad')" class="mt-6 inline-flex items-center gap-2 rounded-2xl bg-green-600 px-6 py-3 text-sm font-black text-white shadow-lg shadow-green-100 transition hover:-translate-y-0.5 hover:bg-green-700">
                    <i class="fas fa-plus"></i>
                    Dodaj oglas
                </Link>
            </section>
        </div>

        <div v-if="selectedProduct" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
            <div class="w-full max-w-md rounded-3xl bg-white p-6 shadow-2xl">
                <div class="mb-5 flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-green-600">Završena razmena</p>
                        <h3 class="mt-1 text-2xl font-black text-gray-900">{{ selectedProduct.title }}</h3>
                    </div>
                    <button type="button" class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200" @click="closeSoldModal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <label class="block">
                    <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">Ime partnera</span>
                    <input v-model="buyerName" type="text" class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white" placeholder="Opcionalno">
                </label>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" class="rounded-xl bg-gray-100 px-5 py-3 text-xs font-black text-gray-700 hover:bg-gray-200" @click="closeSoldModal">Otkaži</button>
                    <button type="button" class="rounded-xl bg-green-600 px-5 py-3 text-xs font-black text-white hover:bg-green-700" @click="markAsSold">Sačuvaj</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

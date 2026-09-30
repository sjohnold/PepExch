<script setup>
import { Head, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import RingCategories from '@/Components/RingCategories.vue';
import ListingCard from '@/Components/ListingCard.vue';
import Hero from '@/Components/Hero.vue';

const props = defineProps({
    listings: Array,
    boostedProducts: Array,
    newProducts: Array,
    categories: Array,
    banner: Object,
    testimonials: Array,
    wishlistIds: Array
});

const handleListingClick = (id) => {
    router.visit(route('product-details', id));
};

const handleFavorite = (id) => {
    console.log('Toggle favorite:', id);
};

const handleReport = (id) => {
    console.log('Report listing:', id);
};

const handleSendOffer = (id) => {
    router.visit(route('product-details', id));
};
</script>

<template>
    <Head title="Početna" />

    <AppLayout>
        <div class="flex flex-col gap-8 pb-12">
            <!-- Hero Section -->
            <Hero :banner="banner" />

            <!-- Categories Section -->
            <RingCategories :categories="categories" />

            <!-- Boosted Products (Trending) -->
            <section v-if="boostedProducts && boostedProducts.length > 0" class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-fire text-orange-500"></i> Izdvojeni Oglasi
                    </h2>
                    <Link :href="route('products')" class="text-green-600 font-bold hover:underline">Vidi sve</Link>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    <ListingCard 
                        v-for="listing in boostedProducts" 
                        :key="listing.id"
                        :listing="listing"
                        :is-favorite="wishlistIds.includes(listing.id)"
                        @click="handleListingClick"
                        @send-offer="handleSendOffer"
                        @toggle-favorite="handleFavorite"
                        @report="handleReport"
                    />
                </div>
            </section>

            <!-- New Products -->
            <section v-if="newProducts && newProducts.length > 0" class="space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-sparkles text-yellow-500"></i> Najnovije na PepExchu
                    </h2>
                    <Link :href="route('products')" class="text-green-600 font-bold hover:underline">Vidi sve</Link>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                    <ListingCard 
                        v-for="listing in newProducts" 
                        :key="listing.id"
                        :listing="listing"
                        :is-favorite="wishlistIds.includes(listing.id)"
                        @click="handleListingClick"
                        @send-offer="handleSendOffer"
                        @toggle-favorite="handleFavorite"
                        @report="handleReport"
                    />
                </div>
            </section>

            <!-- Testimonials Section -->
            <section v-if="testimonials && testimonials.length > 0" class="mt-12 bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Šta kažu naši korisnici</h2>
                    <p class="text-gray-500">Pridružite se hiljadama zadovoljnih korisnika PepExcha</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="(t, idx) in testimonials" :key="idx" class="bg-gray-50 p-6 rounded-2xl relative">
                        <div class="flex items-center gap-4 mb-4">
                            <img :src="t.avatar" class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-sm" :alt="t.name">
                            <div>
                                <h4 class="font-bold text-sm text-gray-800">{{ t.name }}</h4>
                                <p class="text-xs text-gray-500">{{ t.designation }}</p>
                            </div>
                        </div>
                        <div class="flex text-yellow-400 text-xs mb-3">
                            <i v-for="s in 5" :key="s" :class="[s <= t.star ? 'fas' : 'far', 'fa-star']"></i>
                        </div>
                        <p class="text-sm text-gray-600 italic">"{{ t.comment }}"</p>
                        <i class="fas fa-quote-right absolute top-4 right-4 text-gray-100 text-4xl -z-0"></i>
                    </div>
                </div>
            </section>

            <!-- Empty State -->
            <div v-if="listings.length === 0" class="flex flex-col items-center justify-center py-20 text-gray-400">
                <i class="fas fa-search text-5xl mb-4"></i>
                <p class="text-lg font-medium">Nema pronađenih oglasa</p>
                <p class="text-sm">Pokušajte sa drugačijim filterima ili pretragom.</p>
            </div>
        </div>
    </AppLayout>
</template>

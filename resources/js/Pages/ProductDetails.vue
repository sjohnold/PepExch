<script setup>
import { computed, ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    product: Object,
    location_name: String,
    relatedProducts: Array,
    reviewes: Array,
    totalReviews: Number,
    averageRating: [Number, String],
});

const isSendingOffer = ref(false);

const displayLocation = computed(() => props.location_name || props.product.location || 'Nepoznata lokacija');
const mapQuery = computed(() => {
    return props.product.latitude && props.product.longitude
        ? `${props.product.latitude},${props.product.longitude}`
        : displayLocation.value;
});
const mapSrc = computed(() => `https://maps.google.com/maps?q=${encodeURIComponent(mapQuery.value)}&hl=sr;z=15&output=embed`);
const relatedLocation = (item) => item.location || item.location_name || 'Nepoznata lokacija';

const handleSendOffer = () => {
    if (isSendingOffer.value) return;
    isSendingOffer.value = true;
    
    // Redirect to chat with pre-filled post_id
    router.visit(route('chat.index', { 
        seller_id: props.product.user_id, 
        post_id: props.product.id 
    }));
};

const handleContactSeller = () => {
    router.visit(route('chat.index', { seller_id: props.product.user_id }));
};
</script>

<template>
    <Head :title="product.name" />

    <AppLayout>
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm font-medium text-gray-500" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><Link :href="route('home')" class="hover:text-green-600 transition">Početna</Link></li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <Link :href="route('products')" class="hover:text-green-600 transition">Oglasi</Link>
                    </li>
                    <li class="flex items-center gap-2 text-gray-900">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <span class="truncate max-w-[200px]">{{ product.name }}</span>
                    </li>
                </ol>
            </nav>

            <div class="lg:flex lg:gap-10">
                <!-- Left Column: Gallery -->
                <div class="lg:w-2/3">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden p-4 sm:p-8">
                        <div class="aspect-square sm:aspect-video bg-gray-50 rounded-2xl flex items-center justify-center overflow-hidden mb-6 group relative">
                            <img 
                                :src="product.profilePath || 'https://placehold.co/600x400?text=Nema+Slike'" 
                                :alt="product.name" 
                                class="max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105"
                            >
                            <div class="absolute top-4 left-4">
                                <span class="bg-green-600 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-sm uppercase tracking-wider">
                                    {{ product.status }}
                                </span>
                            </div>
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1 uppercase tracking-tighter">Stanje</p>
                                <p class="font-bold text-gray-900">{{ product.conditions }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1 uppercase tracking-tighter">Pregleda</p>
                                <p class="font-bold text-gray-900">{{ product.views_count || 0 }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1 uppercase tracking-tighter">Kategorija</p>
                                <p class="font-bold text-gray-900 truncate">{{ product.category?.name || 'N/A' }}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1 uppercase tracking-tighter">Lokacija</p>
                                <p class="font-bold text-gray-900 truncate">{{ displayLocation }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="prose max-w-none">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Opis oglasa</h3>
                            <div class="text-gray-600 leading-relaxed whitespace-pre-line bg-gray-50/50 p-6 rounded-2xl border border-gray-100">
                                {{ product.description }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sidebar -->
                <div class="lg:w-1/3 mt-8 lg:mt-0">
                    <div class="sticky top-24 space-y-6">
                        <!-- Main Action Card -->
                        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8">
                            <h1 class="text-2xl font-black text-gray-900 mb-6 leading-tight">{{ product.name }}</h1>
                            
                            <div class="space-y-4">
                                <button 
                                    @click="handleSendOffer" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white font-black py-4 px-6 rounded-2xl transition duration-300 shadow-md hover:shadow-lg flex items-center justify-center gap-3 transform hover:-translate-y-0.5 active:translate-y-0"
                                >
                                    <i :class="isSendingOffer ? 'fas fa-spinner fa-spin' : 'fas fa-handshake text-xl'"></i>
                                    {{ isSendingOffer ? 'Učitavanje...' : 'PONUDI RAZMENU' }}
                                </button>
                                
                                <button 
                                    @click="handleContactSeller" 
                                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-4 px-6 rounded-2xl transition duration-300 flex items-center justify-center gap-3"
                                >
                                    <i class="fas fa-comment-dots text-xl text-gray-400"></i>
                                    POŠALJI PORUKU
                                </button>
                            </div>

                            <div class="mt-8 pt-8 border-t border-gray-100">
                                <div class="flex items-center gap-4">
                                    <img 
                                        :src="product.user?.profile_photo || 'https://placehold.co/100x100?text=Korisnik'" 
                                        class="w-14 h-14 rounded-full border-4 border-gray-50 shadow-sm object-cover"
                                    >
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Vlasnik</p>
                                        <h4 class="text-lg font-black text-gray-900">{{ product.user?.name || 'Korisnik' }}</h4>
                                        <div class="flex items-center text-xs mt-1">
                                            <div class="flex text-yellow-400 mr-2">
                                                <i v-for="s in 5" :key="s" :class="[s <= Math.round(averageRating) ? 'fas' : 'far', 'fa-star']"></i>
                                            </div>
                                            <span class="text-gray-500 font-medium">{{ averageRating }} ({{ totalReviews }})</span>
                                        </div>
                                    </div>
                                </div>
                                <Link :href="route('seller-info', product.user_id)" class="block text-center mt-6 text-sm font-bold text-green-600 hover:text-green-700 transition">
                                    Pogledaj sve oglase ovog korisnika
                                </Link>
                            </div>
                        </div>

                        <!-- Location Preview Card -->
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 overflow-hidden">
                            <h4 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-red-500"></i> Lokacija
                            </h4>
                            <div class="h-48 bg-gray-100 rounded-2xl overflow-hidden relative group">
                                <iframe 
                                    class="w-full h-full grayscale-[0.3] opacity-80 group-hover:grayscale-0 group-hover:opacity-100 transition duration-500"
                                    :src="mapSrc"
                                    style="border:0;" 
                                    allowfullscreen="" 
                                    loading="lazy"
                                ></iframe>
                                <div class="absolute bottom-4 left-4 bg-white px-3 py-1.5 rounded-xl shadow-md text-xs font-bold text-gray-800">
                                    {{ displayLocation }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            <div v-if="relatedProducts && relatedProducts.length > 0" class="mt-16">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-2xl font-black text-gray-900">Preporučeno za razmenu</h3>
                    <Link :href="route('products')" class="text-green-600 font-bold hover:underline">Vidi sve</Link>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    <div 
                        v-for="item in relatedProducts" 
                        :key="item.id" 
                        class="group bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden cursor-pointer hover:shadow-xl transition duration-500 transform hover:-translate-y-1" 
                        @click="router.visit(route('product-details', item.id))"
                    >
                        <div class="aspect-square bg-gray-50 overflow-hidden relative">
                            <img :src="item.profilePath" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                            <div class="absolute bottom-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-[10px] font-bold text-gray-700">
                                <i class="fas fa-map-marker-alt text-red-500 mr-1"></i> {{ relatedLocation(item) }}
                            </div>
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-gray-900 truncate group-hover:text-green-600 transition">{{ item.name }}</h4>
                            <p class="text-xs text-gray-400 mt-1 font-medium">{{ item.category?.name || 'Kategorija' }}</p>
                            <p v-if="item.recommendation_reasons?.length" class="text-xs text-green-700 mt-2">
                                {{ item.recommendation_reasons.slice(0, 2).join(' · ') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.prose {
    color: #4b5563;
}
</style>

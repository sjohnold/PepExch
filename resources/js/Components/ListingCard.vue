<script setup>
import { computed } from 'vue';

const props = defineProps({
    listing: Object,
    isMine: Boolean,
    isFavorite: Boolean
});

const emit = defineEmits(['toggle-favorite', 'report', 'send-offer', 'click']);

const listingTitle = computed(() => props.listing.title || props.listing.name || 'Oglas bez naslova');
const listingDescription = computed(() => props.listing.desc || props.listing.description || 'Bez opisa');
const categoryLabel = computed(() => {
    return props.listing.category?.name
        || props.listing.categories?.[0]?.name
        || 'Kategorija';
});

const locationLabel = computed(() => {
    return props.listing.location || props.listing.location_name || 'Nepoznata lokacija';
});

const normalizeMediaUrl = (src) => {
    if (!src) {
        return null;
    }

    if (src.startsWith('http') || src.startsWith('/')) {
        return src;
    }

    return `/${src}`;
};

const imageUrl = computed(() => {
    return normalizeMediaUrl(
        props.listing.img_url
        || props.listing.profilePath
        || props.listing.thumbnail
        || props.listing.profile_path
        || props.listing.thumbnail_paths?.[0]
        || props.listing.thumbnails?.[0]?.src
    );
});

const viewCount = computed(() => props.listing.views_count || props.listing.number_of_view || 0);
const offerCount = computed(() => props.listing.offers_count || 0);
</script>

<template>
    <div
        class="listing-card bg-white rounded-lg shadow-md hover:shadow-lg transition-all overflow-hidden transform hover:-translate-y-0.5 relative cursor-pointer group"
        @click="emit('click', listing.id)"
    >
        <button
            v-if="!isMine"
            type="button"
            :class="['card-fav-btn absolute top-2 left-2 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-white/90 shadow-sm border border-gray-100 transition-colors', isFavorite ? 'text-red-500' : 'text-gray-400 hover:text-red-400']"
            aria-label="Dodaj u omiljeno"
            @click.stop="emit('toggle-favorite', listing.id)"
        >
            <i :class="[isFavorite ? 'fas' : 'far', 'fa-heart text-sm']"></i>
        </button>

        <button
            v-if="!isMine"
            type="button"
            class="card-report-btn absolute top-2 right-2 z-10 w-8 h-8 flex items-center justify-center rounded-full bg-white/90 shadow-sm border border-gray-100 text-gray-400 hover:text-red-400 transition-colors opacity-0 group-hover:opacity-100"
            aria-label="Prijavi oglas"
            @click.stop="emit('report', listing.id)"
        >
            <i class="fas fa-flag text-xs"></i>
        </button>

        <div class="h-32 bg-gray-100 flex items-center justify-center overflow-hidden">
            <img v-if="imageUrl" :src="imageUrl" :alt="listingTitle" class="w-full h-full object-cover" loading="lazy">
            <div v-else class="w-full h-full bg-gradient-to-br from-green-50 to-emerald-100 text-green-700 flex flex-col items-center justify-center gap-2">
                <i class="fas fa-box-open text-3xl"></i>
                <span class="text-xs font-bold">Nema slike</span>
            </div>
        </div>

        <div class="p-3">
            <h3 class="font-bold text-sm text-gray-800 mb-1 line-clamp-2 h-10">{{ listingTitle }}</h3>
            <p class="text-gray-600 text-xs mb-2 line-clamp-2 h-8">{{ listingDescription }}</p>

            <div class="flex items-center justify-between gap-1 mb-2">
                <span class="inline-block bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-[10px] font-bold">
                    {{ categoryLabel }}
                </span>
                <span class="text-[10px] font-medium text-gray-500 truncate max-w-[80px]">
                    {{ locationLabel }}
                </span>
            </div>

            <p class="text-[10px] text-gray-400">
                {{ viewCount }} pregleda <span v-if="offerCount > 0">· {{ offerCount }} ponuda</span>
            </p>

            <button
                v-if="!isMine"
                type="button"
                class="card-send-offer-btn mt-3 w-full py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white text-[11px] font-bold transition-colors flex items-center justify-center gap-1.5 shadow-sm"
                @click.stop="emit('send-offer', listing.id)"
            >
                <i class="fas fa-handshake"></i> Pošalji ponudu
            </button>
        </div>
    </div>
</template>

<style scoped>
.listing-card:hover .card-report-btn {
    opacity: 1;
}
</style>

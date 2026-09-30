<script setup>
import { ref, reactive, computed, onMounted, onUnmounted, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    categories: Array
});

const isExpanded = ref(false);
const searchQuery = ref('');
const currentPosition = ref(0);

const state = reactive({});

// Initialize state when categories prop changes
watch(() => props.categories, (newCats) => {
    if (!newCats) return;
    newCats.forEach(c => {
        if (!state[c.id]) {
            state[c.id] = { sel: 0, subs: Array(c.subs.length).fill(false) };
        }
    });
}, { immediate: true });

const filteredCategories = computed(() => {
    if (!props.categories) return [];
    if (!searchQuery.value) return props.categories;
    const q = searchQuery.value.toLowerCase();
    return props.categories.filter(c => c.name.toLowerCase().includes(q));
});

// Mapping for emojis (could be passed from server or hardcoded)
const categoryMeta = {
    "Hrana i piće": "🍎", "Nekretnine": "🏠", "Sve za Kuću": "🛋️", "Bašta i Dvorište": "🌿",
    "Motorna Vozila i Autoprikolice": "🚗", "Bicikli i Trotineti": "🚲", 
    "Poljoprivredne Mašine i priključci": "🚜", "Radne Mašine i priključci": "🏗️",
    "Alati i zanati": "🧰", "Računari, komponente i periferije": "💻",
    "Mobilni telefoni i Tableti": "📱", "Mali kućni aparati": "🍳", "Bela tehnika": "🧊",
    "Životinje, hrana, oprema": "🐾", "Usluge": "🛠️", "Odeća, obuća i aksesoari": "👕",
    "Sport i razonoda": "⚽", "Kolekcionarstvo": "🧿", "Škola, knjige i sveske": "📚",
    "Ručni radovi": "🧵", "Pokloni": "🎁", "Sve Ostalo": "✨"
};

const getEmoji = (name) => categoryMeta[name] || '📦';

const toggleExpanded = () => {
    isExpanded.value = !isExpanded.value;
};

const selectCategory = (catId) => {
    const s = state[catId];
    if (!s) return;
    if (s.sel === 2) {
        s.sel = 0;
        s.subs.fill(false);
    } else {
        s.sel = 2;
        s.subs.fill(true);
        // Navigate to category
        router.visit(route('products', catId));
    }
};

const moveRing = (direction) => {
    const step = 200;
    if (direction === 'left') {
        currentPosition.value = Math.min(0, currentPosition.value + step);
    } else {
        currentPosition.value -= step;
    }
};

const openDropdownId = ref(null);

const toggleDropdown = (event, catId) => {
    event.stopPropagation();
    openDropdownId.value = openDropdownId.value === catId ? null : catId;
};

const handleClickOutside = (e) => {
    if (openDropdownId.value && !e.target.closest('.dropdown-panel') && !e.target.closest('.arrow-icon')) {
        openDropdownId.value = null;
    }
};

onMounted(() => {
    window.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    window.removeEventListener('click', handleClickOutside);
});

</script>

<template>
    <div id="categoriesContainer" class="relative bg-white border-b border-gray-200 px-4 py-2 flex flex-col gap-2">
        
        <!-- Toggle Row -->
        <div class="categories-toggle-row flex items-center justify-center gap-2">
            <div :class="['category-search-wrap flex items-center transition-all overflow-hidden', searchQuery ? 'w-40' : 'w-0']">
                <input v-model="searchQuery" type="text" placeholder="Traži..." class="category-search-input text-xs border border-gray-300 rounded px-2 py-1 focus:outline-none focus:border-green-500">
            </div>
            <button @click="searchQuery = searchQuery ? '' : ' '" class="text-gray-500 hover:text-green-600 transition-colors">
                <i class="fas fa-search text-xs"></i>
            </button>
            <button @click="toggleExpanded" class="flex items-center gap-1 text-gray-600 hover:text-green-600 font-semibold text-xs transition-colors">
                <span>{{ isExpanded ? 'Manje' : 'Sve kategorije' }}</span>
                <i :class="['fas', isExpanded ? 'fa-chevron-up' : 'fa-chevron-down', 'text-[10px]']"></i>
            </button>
        </div>

        <!-- Ring View -->
        <div v-if="!isExpanded" class="categories-view flex items-center gap-2 h-14">
            <button @click="moveRing('left')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-green-600 transition-colors shrink-0">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="ring-container flex-1 overflow-hidden relative">
                <div class="ring-track flex gap-3 transition-transform duration-500" :style="{ transform: `translateX(${currentPosition}px)` }">
                    <div v-for="cat in filteredCategories" :key="cat.id" 
                        :class="['category-btn flex items-center gap-2 px-3 py-1.5 rounded-xl border-2 transition-all whitespace-nowrap cursor-pointer h-10', 
                                 state[cat.id]?.sel === 2 ? 'bg-green-500 border-green-600 text-white' : 'bg-white border-gray-200 text-gray-700 hover:border-green-400']"
                        @click="selectCategory(cat.id)">
                        <div class="w-6 h-6 shrink-0 flex items-center justify-center overflow-hidden rounded">
                            <img v-if="cat.icon_url" :src="cat.icon_url" class="w-full h-full object-cover" :alt="cat.name">
                            <span v-else class="text-lg">{{ getEmoji(cat.name) }}</span>
                        </div>
                        <span class="text-xs font-bold">{{ cat.name }}</span>
                        <span :class="['text-[10px]', state[cat.id]?.sel === 2 ? 'text-white/80' : 'text-gray-400']">(0)</span>
                        
                        <div v-if="cat.subs.length > 0" class="arrow-icon ml-1 w-5 h-5 flex items-center justify-center rounded hover:bg-black/10 transition-colors" @click="toggleDropdown($event, cat.id)">
                            <i class="fas fa-chevron-down text-[10px]"></i>
                        </div>
                    </div>
                </div>
            </div>

            <button @click="moveRing('right')" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-400 hover:text-green-600 transition-colors shrink-0">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <!-- Expanded Grid View -->
        <div v-else class="categories-view grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 py-4 max-h-[500px] overflow-y-auto">
            <div v-for="cat in filteredCategories" :key="cat.id"
                :class="['category-btn flex items-center gap-2 px-3 py-2 rounded-xl border-2 transition-all cursor-pointer h-12', 
                         state[cat.id]?.sel === 2 ? 'bg-green-500 border-green-600 text-white' : 'bg-white border-gray-200 text-gray-700 hover:border-green-400']"
                @click="selectCategory(cat.id)">
                <div class="w-6 h-6 shrink-0 flex items-center justify-center overflow-hidden rounded">
                    <img v-if="cat.icon_url" :src="cat.icon_url" class="w-full h-full object-cover" :alt="cat.name">
                    <span v-else class="text-lg">{{ getEmoji(cat.name) }}</span>
                </div>
                <span class="text-xs font-bold truncate flex-1">{{ cat.name }}</span>
                <span :class="['text-[10px]', state[cat.id]?.sel === 2 ? 'text-white/80' : 'text-gray-400']">(0)</span>
            </div>
        </div>

        <!-- Action Buttons (Visible only if changes made - logic to be implemented) -->
        <div class="flex items-center justify-center gap-4 py-1">
            <button class="px-6 py-1.5 bg-green-500 text-white text-xs font-bold rounded-full shadow-lg hover:bg-green-600 transition-all opacity-50 cursor-not-allowed">
                Primeni filtere
            </button>
            <button class="px-6 py-1.5 bg-gray-200 text-gray-600 text-xs font-bold rounded-full hover:bg-gray-300 transition-all">
                Poništi
            </button>
        </div>
    </div>
</template>

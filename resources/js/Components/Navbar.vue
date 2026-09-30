<script setup>
import { ref, inject, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';

const page = usePage();
const user = computed(() => page.props.auth.user);
const openLoginModal = inject('openLoginModal');

const searchQuery = ref('');

const handleSearch = () => {
    if (searchQuery.value.trim()) {
        router.visit(route('products.search', { search: searchQuery.value }));
    }
};
</script>

<template>
    <header class="bg-white shadow-md p-2 max-w-full sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <div class="flex-1 relative">
                <input 
                    v-model="searchQuery"
                    @keyup.enter="handleSearch"
                    type="text" 
                    placeholder="Pretraži oglase..." 
                    class="w-full px-3 py-2 pr-10 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-sm" 
                    autocomplete="off"
                >
                <button 
                    @click="handleSearch"
                    class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-green-500 text-white w-8 h-8 rounded-lg hover:bg-green-600 flex items-center justify-center transition-colors" 
                    aria-label="Pretraži"
                >
                    <i class="fas fa-search text-xs" aria-hidden="true"></i>
                </button>
            </div>
            
            <select id="countrySelect" class="px-2.5 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-green-500 text-xs font-medium" aria-label="Izaberi državu">
                <option value="RS">Srbija</option>
                <option value="BA">BiH</option>
                <option value="HR">Hrvatska</option>
                <option value="ME">Crna Gora</option>
            </select>

            <Link :href="route('product-ad')" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-lg font-semibold text-xs flex items-center gap-1.5 shadow-lg transition-all" aria-label="Dodaj novi oglas">
                <i class="fas fa-plus text-xs" aria-hidden="true"></i> Dodaj Oglas 
            </Link>

            <button v-if="!user" @click="openLoginModal" class="flex items-center gap-2 px-3 py-2 text-gray-700 hover:text-green-600 transition-colors">
                <i class="fas fa-sign-in-alt text-lg"></i>
                <span class="text-xs font-bold hidden sm:block">PRIJAVI SE</span>
            </button>
        </div>
    </header>
</template>

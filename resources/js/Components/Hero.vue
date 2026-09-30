<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    banner: Object
});
</script>

<template>
    <section v-if="banner" class="relative bg-gradient-to-br from-green-600 to-green-800 rounded-3xl overflow-hidden shadow-2xl mb-8 p-8 md:p-12">
        <!-- Background decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-green-400/10 rounded-full translate-y-1/2 -translate-x-1/2 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center gap-12">
            <div class="flex-1 space-y-6">
                <span class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-white text-xs font-bold tracking-wider uppercase">
                    {{ banner.title }}
                </span>
                
                <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight">
                    {{ banner.sub_title }}
                </h1>
                
                <p class="text-green-50 text-lg leading-relaxed max-w-xl">
                    {{ banner.description }}
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-4">
                    <Link :href="route('products')" class="px-8 py-3.5 bg-white text-green-700 font-bold rounded-xl shadow-lg hover:shadow-xl transition-all hover:-translate-y-1 flex items-center gap-2">
                        <i class="fas fa-shopping-cart"></i> Istraži proizvode
                    </Link>
                    <div class="flex items-center gap-2 text-white/80">
                        <i class="fas fa-location-dot"></i>
                        <span class="text-sm font-medium">{{ banner.address }}</span>
                    </div>
                </div>
            </div>

            <div class="flex-1 relative group">
                <div class="relative w-full aspect-square md:aspect-auto md:h-[400px] rounded-2xl overflow-hidden shadow-2xl border-4 border-white/20">
                    <img 
                        v-if="banner.images && banner.images.length > 0"
                        :src="banner.images[0]" 
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700"
                        alt="Hero Banner"
                    >
                    <div v-else class="w-full h-full bg-green-700 flex items-center justify-center text-8xl">
                        🎁
                    </div>
                </div>
                
                <!-- Floating badge -->
                <div class="absolute -bottom-6 -right-6 bg-white p-4 rounded-2xl shadow-xl hidden lg:flex items-center gap-4 animate-bounce">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 text-2xl">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-bold uppercase tracking-tighter">Provereno</p>
                        <p class="text-sm font-extrabold text-gray-800">100% Sigurna Zamena</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, provide, ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Sidebar from '@/Components/Sidebar.vue';
import Footer from '@/Components/Footer.vue';
import AuthModal from '@/Components/AuthModal.vue';

const isCollapsed = ref(false);
const isAuthModalOpen = ref(false);
const isMobile = ref(false);

const mainContentMargin = computed(() => {
    if (isMobile.value) {
        return '60px';
    }

    return isCollapsed.value ? '60px' : '200px';
});

const syncViewport = () => {
    const mobile = window.innerWidth < 768;
    isMobile.value = mobile;

    if (mobile) {
        isCollapsed.value = true;
    }
};

const toggleSidebar = () => {
    isCollapsed.value = !isCollapsed.value;
};

const openLoginModal = () => {
    isAuthModalOpen.value = true;
};

const closeLoginModal = () => {
    isAuthModalOpen.value = false;
};

provide('openLoginModal', openLoginModal);

onMounted(() => {
    syncViewport();
    window.addEventListener('resize', syncViewport);
    window.addEventListener('open-login-modal', openLoginModal);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', syncViewport);
    window.removeEventListener('open-login-modal', openLoginModal);
});
</script>

<template>
    <div class="flex h-full w-full">
        <Sidebar :is-collapsed="isCollapsed" @toggle-sidebar="toggleSidebar" />
        
        <div id="mainContent" class="flex-1 transition-all duration-300 overflow-x-hidden flex flex-col h-full" :style="{ marginLeft: mainContentMargin }">
            <Navbar />
            
            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
                <slot />
            </main>

            <!-- Footer -->
            <Footer />
        </div>

        <AuthModal :is-open="isAuthModalOpen" @close="closeLoginModal" />
    </div>
</template>

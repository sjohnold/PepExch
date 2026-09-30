<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, inject } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
const openLoginModal = inject('openLoginModal');
const logoUrl = computed(() => page.props.applogo?.logo_url || '/assets/frontend/img/logo/header-logo.png');

defineProps({
    isCollapsed: Boolean,
});

const emit = defineEmits(['toggle-sidebar']);

const fallbackLinks = [
    { label: 'Početna', icon: 'fas fa-home', page: 'Home', route_name: 'home', url: route('home'), sort_order: 10, visibility: 'public', is_visible: true },
    { label: 'Oglasi', icon: 'fas fa-search', page: 'Feed', route_name: 'products', url: route('products'), sort_order: 20, visibility: 'public', is_visible: true },
    { label: 'Ponude', icon: 'fas fa-handshake', page: 'MyOffers', route_name: 'user.offers', url: route('user.offers'), sort_order: 30, visibility: 'auth', is_visible: true },
    { label: 'Moji oglasi', icon: 'fas fa-list', page: 'MyAds', route_name: 'user.my-ads', url: route('user.my-ads'), sort_order: 40, visibility: 'auth', is_visible: true },
    { label: 'Poruke', icon: 'fas fa-envelope', page: 'Chat', route_name: 'chat.index', url: route('chat.index'), sort_order: 50, visibility: 'auth', is_visible: true },
    { label: 'Obaveštenja', icon: 'fas fa-bell', page: 'Notifications', route_name: 'user.show-notifications', url: route('user.show-notifications'), sort_order: 60, visibility: 'auth', is_visible: true },
    { label: 'Omiljeno', icon: 'fas fa-heart', page: 'Wishlist', route_name: 'wishlist.index', url: route('wishlist.index'), sort_order: 70, visibility: 'auth', is_visible: true },
    { label: 'Profil', icon: 'fas fa-user', page: 'Profile', route_name: 'user.profile', url: route('user.profile'), sort_order: 80, visibility: 'auth', is_visible: true },
    { label: 'Podrška', icon: 'fas fa-comment-dots', page: 'Contact', route_name: 'contact.us', url: route('contact.us'), sort_order: 90, visibility: 'public', is_visible: true },
    { label: 'O PepExchu', icon: 'fas fa-info-circle', page: 'About', route_name: 'about.us', url: route('about.us'), sort_order: 100, visibility: 'public', is_visible: true },
];

const allLinks = computed(() => {
    const configured = page.props.navigation?.sidebar || [];
    return configured.length ? configured : fallbackLinks;
});

const navLinks = computed(() => allLinks.value.filter((link) => Number(link.sort_order ?? 0) < 90));
const bottomLinks = computed(() => allLinks.value.filter((link) => Number(link.sort_order ?? 0) >= 90));

const isActive = (link) => page.component === link.page;
const canShowLink = (link) => link.is_visible !== false && (
    link.visibility === 'public' ||
    (link.visibility === 'auth' && user.value) ||
    (link.visibility === 'guest' && !user.value)
);
const requiresLogin = (link) => link.visibility === 'auth' && !user.value;
const linkUrl = (link) => link.url || (link.route_name ? route(link.route_name) : '#');

const navClass = (link) => [
    'nav-link flex items-center gap-2 px-2.5 py-2 rounded-xl transition-all w-full',
    isActive(link)
        ? 'bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg shadow-green-100'
        : 'hover:bg-green-50 text-gray-700',
];
const iconClass = (link) => [
    link.icon || 'fas fa-circle',
    'text-base w-5 text-center',
    isActive(link) ? 'text-white' : 'text-green-600',
];
</script>

<template>
    <aside id="sidebar" :class="['sidebar bg-white/95 border-r border-green-100 shadow-2xl fixed left-0 top-0 h-full z-50 flex flex-col backdrop-blur', isCollapsed ? 'sidebar-collapsed' : '']" role="navigation" aria-label="Glavna navigacija">
        <div class="flex items-center justify-center pt-2 pb-1 relative flex-shrink-0">
            <div id="logoRingWrap" class="logo-ring-wrap" :style="{ width: isCollapsed ? '50px' : '160px', height: isCollapsed ? '50px' : '160px' }">
                <img id="sidebarLogo" :src="logoUrl" alt="PepExch" class="logo-img" :style="{ width: isCollapsed ? '34px' : '106px', height: isCollapsed ? '34px' : '106px' }" loading="lazy">
                <svg v-if="!isCollapsed" id="rotatingText" class="logo-ring-svg rotating-text" viewBox="0 0 140 140" preserveAspectRatio="xMidYMid meet">
                    <defs>
                        <path id="circlePath" d="M 70,70 m -55,0 a 55,55 0 1,1 110,0 a 55,55 0 1,1 -110,0" />
                    </defs>
                    <text font-weight="700" font-size="10" textLength="345" lengthAdjust="spacingAndGlyphs">
                        <textPath href="#circlePath">
                            <tspan fill="#022c22">PEPEXCH • </tspan><tspan fill="#064e3b">ZAMENI • </tspan><tspan fill="#065f46">PROMENI • </tspan><tspan fill="#047857">BILO ŠTA • </tspan><tspan fill="#059669">BILO GDE • </tspan>
                        </textPath>
                    </text>
                </svg>
            </div>
        </div>

        <div @click="emit('toggle-sidebar')" class="absolute left-full top-1/2 -translate-y-1/2 -translate-x-1/2 cursor-pointer bg-green-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg shadow-green-100 hover:bg-green-700 z-50" role="button" aria-label="Sažmi/Proširi bočni meni">
            <i :class="['fas', isCollapsed ? 'fa-chevron-right' : 'fa-chevron-left', 'text-sm']"></i>
        </div>

        <nav class="flex-1 px-2 flex flex-col mt-4">
            <ul class="space-y-1 flex-shrink-0">
                <li v-for="link in navLinks" v-show="canShowLink(link) || requiresLogin(link)" :key="link.id || link.page || link.label">
                    <Link v-if="!requiresLogin(link)" :href="linkUrl(link)" :title="isCollapsed ? link.label : null" :class="navClass(link)">
                        <i :class="iconClass(link)"></i>
                        <span v-if="!isCollapsed" class="nav-text font-medium text-xs">{{ link.label }}</span>
                        <span v-if="!isCollapsed && link.countId" class="nav-count text-[10px] ml-auto">(0)</span>
                    </Link>
                    <button v-else type="button" :title="isCollapsed ? link.label : null" :class="navClass(link)" @click="openLoginModal">
                        <i :class="iconClass(link)"></i>
                        <span v-if="!isCollapsed" class="nav-text font-medium text-xs">{{ link.label }}</span>
                        <span v-if="!isCollapsed && link.countId" class="nav-count text-[10px] ml-auto">(0)</span>
                    </button>
                </li>

                <li v-if="user">
                    <Link :href="route('logout')" method="post" as="button" class="w-full nav-link flex items-center gap-2 px-2.5 py-2 rounded-xl hover:bg-green-50 transition-colors text-gray-700">
                        <i class="fas fa-sign-out-alt text-green-600 text-base w-5 text-center"></i>
                        <span v-if="!isCollapsed" class="nav-text font-medium text-xs">Odjavi se</span>
                    </Link>
                </li>
                <li v-else>
                    <button @click="openLoginModal" class="w-full nav-link flex items-center gap-2 px-2.5 py-2 rounded-xl hover:bg-green-50 transition-colors text-gray-700">
                        <i class="fas fa-sign-in-alt text-green-600 text-base w-5 text-center"></i>
                        <span v-if="!isCollapsed" class="nav-text font-medium text-xs">Prijavi se/Registruj se</span>
                    </button>
                </li>

                <li v-if="!isCollapsed" class="pt-3">
                    <div class="border-t border-green-100"></div>
                </li>

                <li v-for="link in bottomLinks" v-show="canShowLink(link) || requiresLogin(link)" :key="link.id || link.route_name || link.label">
                    <Link v-if="!requiresLogin(link)" :href="linkUrl(link)" :title="isCollapsed ? link.label : null" :class="navClass(link)">
                        <i :class="iconClass(link)"></i>
                        <span v-if="!isCollapsed" class="nav-text font-medium text-xs">{{ link.label }}</span>
                    </Link>
                    <button v-else type="button" :title="isCollapsed ? link.label : null" :class="navClass(link)" @click="openLoginModal">
                        <i :class="iconClass(link)"></i>
                        <span v-if="!isCollapsed" class="nav-text font-medium text-xs">{{ link.label }}</span>
                    </button>
                </li>
            </ul>
        </nav>
    </aside>
</template>

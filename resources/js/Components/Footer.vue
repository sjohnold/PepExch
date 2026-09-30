<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const footerLogo = computed(() => page.props.footerLogo);
const footerSubtitle = computed(() => page.props.footerSubtitle);
const footerCopyright = computed(() => page.props.footerCopyright);
const footerMenuCards = computed(() => page.props.footerMenuCards || []);
const socialLinks = computed(() => page.props.socialLinks || []);

const fallbackRoute = (name, params = undefined) => {
    try {
        return params === undefined ? route(name) : route(name, params);
    } catch (error) {
        return '#';
    }
};

const footerItemUrl = (card, item) => {
    if (item.url) {
        return item.url;
    }

    const routes = {
        'quick-links': {
            add_post: fallbackRoute('product-ad'),
            login: fallbackRoute('login'),
            registration: fallbackRoute('register'),
        },
        company: {
            about_us: fallbackRoute('about.us'),
            most_popular: fallbackRoute('products'),
            terms: fallbackRoute('guest.pages', 'terms-conditions'),
            privacy: fallbackRoute('guest.pages', 'privacy-policy'),
        },
        'help-support': {
            contact: fallbackRoute('contact.us'),
        },
    };

    return routes[card.id]?.[item.id] || '#';
};

const footerCardLabel = (card) => ({
    'footer-info': 'Informacije',
    'quick-links': 'Brze veze',
    company: 'PepExch',
    'help-support': 'Podrška',
}[card.id] || card.label);

const footerItemLabel = (card, item) => ({
    address: 'Adresa',
    support_mail: 'Email podrške',
    support_contact: 'Telefon podrške',
    subscription: 'Pretplata',
    add_post: 'Dodaj oglas',
    login: 'Prijava',
    registration: 'Registracija',
    about_us: 'O PepExchu',
    most_popular: 'Oglasi',
    terms: 'Uslovi korišćenja',
    privacy: 'Privatnost',
    faq: 'Pitanja',
    stay_safe: 'Bezbednost',
    contact: 'Podrška',
}[item.id] || item.label);

</script>

<template>
    <footer class="bg-[#17181D] text-white pt-16 pb-8 mt-12 rounded-t-[3rem]">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                <!-- Logo & About -->
                <div class="col-span-1 lg:col-span-1">
                    <img v-if="footerLogo" :src="footerLogo.footer_url" alt="Footer Logo" class="h-8 mb-6">
                    <p v-if="footerSubtitle" class="text-gray-400 text-sm leading-relaxed mb-6">
                        {{ footerSubtitle.value }}
                    </p>
                    <div v-if="socialLinks.length" class="flex gap-4">
                        <a v-for="item in socialLinks" :key="item.icon || item.label" :href="item.url || '#'" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-green-500 transition-all">
                            <i :class="`fab fa-${item.icon}`"></i>
                        </a>
                    </div>
                </div>

                <!-- Dynamic Menu Cards -->
                <div v-for="card in footerMenuCards" :key="card.id" class="col-span-1">
                    <h4 class="text-lg font-bold mb-6 text-white">{{ footerCardLabel(card) }}</h4>
                    <ul class="space-y-4">
                        <li v-for="item in card.items" :key="item.id">
                            <a :href="footerItemUrl(card, item)" class="text-gray-400 hover:text-green-500 transition-colors text-sm">
                                {{ footerItemLabel(card, item) }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p v-if="footerCopyright" class="text-gray-500 text-xs">
                    {{ footerCopyright.value }}
                </p>
                <div class="flex gap-6 text-xs text-gray-500">
                    <Link :href="fallbackRoute('guest.pages', 'privacy-policy')" class="hover:text-white transition-colors">Privatnost</Link>
                    <Link :href="fallbackRoute('guest.pages', 'terms-conditions')" class="hover:text-white transition-colors">Uslovi korišćenja</Link>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    support: Object,
    socialLinks: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: '',
    email: '',
    subject: '',
    message: '',
});

const submit = () => {
    form.post(route('guest.contact.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Podrška" />

    <AppLayout>
        <div class="max-w-7xl mx-auto space-y-8">
            <section class="grid gap-6 rounded-3xl bg-white p-6 shadow-sm border border-gray-100 lg:grid-cols-[0.85fr_1.15fr]">
                <div class="relative min-h-96 overflow-hidden rounded-2xl bg-gradient-to-br from-green-600 to-green-800 p-8 text-white">
                    <img src="/assets/frontend/img/contact/contact-01.jpg" alt="" class="absolute inset-0 h-full w-full object-cover opacity-20">
                    <div class="relative flex h-full flex-col justify-between">
                        <div>
                            <span class="inline-flex rounded-full bg-white/20 px-4 py-1.5 text-xs font-black uppercase tracking-widest backdrop-blur">
                                Podrška
                            </span>
                            <h1 class="mt-5 text-4xl font-black leading-tight md:text-5xl">
                                Primedbe, sugestije i pomoć na jednom mestu.
                            </h1>
                            <p class="mt-4 text-sm leading-relaxed text-green-50 md:text-base">
                                Pošaljite nam pitanje, prijavite problem ili predložite poboljšanje. Stranica je prebačena u isti miran,
                                moderan tok kao glavna, bez starog rasporeda i vizuelnog šuma.
                            </p>
                        </div>

                        <div class="mt-8 grid gap-3">
                            <a v-if="support?.email" :href="`mailto:${support.email}`" class="flex items-center gap-3 rounded-2xl bg-white/10 p-4 text-sm font-semibold backdrop-blur transition hover:bg-white/20">
                                <i class="fas fa-envelope w-5 text-center"></i>
                                <span class="break-all">{{ support.email }}</span>
                            </a>
                            <a v-if="support?.phone" :href="`tel:${support.phone}`" class="flex items-center gap-3 rounded-2xl bg-white/10 p-4 text-sm font-semibold backdrop-blur transition hover:bg-white/20">
                                <i class="fas fa-phone w-5 text-center"></i>
                                <span>{{ support.phone }}</span>
                            </a>
                            <div v-if="support?.address" class="flex items-center gap-3 rounded-2xl bg-white/10 p-4 text-sm font-semibold backdrop-blur">
                                <i class="fas fa-location-dot w-5 text-center"></i>
                                <span>{{ support.address }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="grid content-start gap-5 p-2 md:p-4" @submit.prevent="submit">
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-green-600">Kontakt forma</p>
                        <h2 class="mt-2 text-3xl font-black text-gray-900">Pišite nam</h2>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">Ime</span>
                            <input v-model="form.name" type="text" class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white" placeholder="Vaše ime">
                            <span v-if="form.errors.name" class="mt-2 block text-xs font-bold text-red-500">{{ form.errors.name }}</span>
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">Email</span>
                            <input v-model="form.email" type="email" class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white" placeholder="primer@email.com">
                            <span v-if="form.errors.email" class="mt-2 block text-xs font-bold text-red-500">{{ form.errors.email }}</span>
                        </label>
                    </div>

                    <label class="block">
                        <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">Tema</span>
                        <input v-model="form.subject" type="text" class="w-full rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white" placeholder="Ukratko opišite razlog poruke">
                        <span v-if="form.errors.subject" class="mt-2 block text-xs font-bold text-red-500">{{ form.errors.subject }}</span>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-xs font-black uppercase tracking-wider text-gray-600">Poruka</span>
                        <textarea v-model="form.message" rows="7" class="w-full resize-none rounded-2xl border-2 border-gray-100 bg-gray-50 px-5 py-4 text-sm outline-none transition focus:border-green-500 focus:bg-white" placeholder="Napišite detalje"></textarea>
                        <span v-if="form.errors.message" class="mt-2 block text-xs font-bold text-red-500">{{ form.errors.message }}</span>
                    </label>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex gap-3">
                            <a v-for="item in socialLinks" :key="item.icon || item.label" :href="item.url || '#'" target="_blank" rel="noopener noreferrer" class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-50 text-gray-500 transition hover:bg-green-50 hover:text-green-600">
                                <i :class="`fab fa-${item.icon}`"></i>
                            </a>
                        </div>
                        <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 rounded-2xl bg-green-600 px-7 py-3.5 text-sm font-black text-white shadow-lg shadow-green-100 transition hover:-translate-y-0.5 hover:bg-green-700 disabled:cursor-not-allowed disabled:bg-gray-300">
                            <i :class="form.processing ? 'fas fa-spinner fa-spin' : 'fas fa-paper-plane'"></i>
                            {{ form.processing ? 'Slanje...' : 'Pošalji poruku' }}
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </AppLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    notifications: {
        type: Object,
        default: () => ({ data: [], links: [] }),
    },
});

const items = computed(() => props.notifications?.data || []);

const openNotification = async (notification) => {
    try {
        await window.axios.post(route('user.notification.read'), {
            notification_id: notification.id,
        });
    } finally {
        window.location.href = notification.redirect_url || route('user.show-notifications');
    }
};

const markAll = () => {
    router.visit(route('user.read-all-notifications'), {
        preserveScroll: true,
    });
};

const paginationLabel = (label = '') => label
    .replaceAll('&laquo;', '<')
    .replaceAll('&raquo;', '>');
</script>

<template>
    <Head title="Obaveštenja" />

    <AppLayout>
        <div class="mx-auto max-w-5xl space-y-6">
            <section class="flex flex-col gap-4 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-widest text-green-600">Aktivnosti</p>
                    <h1 class="mt-2 text-3xl font-black text-gray-900">Obaveštenja</h1>
                    <p class="mt-2 text-sm text-gray-500">Čistiji prikaz poruka sistema i aktivnosti naloga.</p>
                </div>
                <button type="button" class="inline-flex w-fit items-center gap-2 rounded-2xl bg-gray-100 px-5 py-3 text-xs font-black text-gray-700 transition hover:bg-gray-200" @click="markAll">
                    <i class="fas fa-check-double text-green-600"></i>
                    Označi sve kao pročitano
                </button>
            </section>

            <section v-if="items.length" class="space-y-3">
                <button
                    v-for="notification in items"
                    :key="notification.id"
                    type="button"
                    class="group flex w-full items-start gap-4 rounded-2xl border bg-white p-4 text-left shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
                    :class="notification.is_read ? 'border-gray-100' : 'border-green-200 ring-1 ring-green-100'"
                    @click="openNotification(notification)"
                >
                    <img :src="notification.sender_photo" :alt="notification.sender_name" class="h-12 w-12 flex-shrink-0 rounded-full border-2 border-white object-cover shadow-sm">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-start justify-between gap-2">
                            <h2 :class="['text-sm font-black', notification.is_read ? 'text-gray-600' : 'text-gray-900']">
                                {{ notification.subject }}
                            </h2>
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-400">{{ notification.created_label }}</span>
                        </div>
                        <p :class="['mt-1 text-sm leading-relaxed', notification.is_read ? 'text-gray-400' : 'text-gray-600']">
                            {{ notification.body }}
                        </p>
                    </div>
                    <span v-if="!notification.is_read" class="mt-2 h-2.5 w-2.5 flex-shrink-0 rounded-full bg-green-500"></span>
                </button>
            </section>

            <section v-else class="flex min-h-96 flex-col items-center justify-center rounded-3xl border border-gray-100 bg-white p-8 text-center shadow-sm">
                <div class="mb-5 flex h-20 w-20 items-center justify-center rounded-full bg-green-50 text-3xl text-green-600">
                    <i class="far fa-bell"></i>
                </div>
                <h2 class="text-2xl font-black text-gray-900">Još nema obaveštenja</h2>
                <p class="mt-2 max-w-sm text-sm text-gray-500">Kada se pojave nove ponude, poruke ili statusi, videćete ih ovde.</p>
            </section>

            <div v-if="notifications.links && items.length" class="flex flex-wrap justify-center gap-2">
                <template v-for="(link, index) in notifications.links" :key="index">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        class="rounded-xl px-4 py-2 text-sm font-bold transition"
                        :class="link.active ? 'bg-green-600 text-white shadow-sm' : 'border border-gray-200 bg-white text-gray-700 hover:bg-gray-50'"
                    >
                        {{ paginationLabel(link.label) }}
                    </Link>
                    <span v-else class="rounded-xl border border-gray-100 bg-gray-50 px-4 py-2 text-sm font-bold text-gray-400">
                        {{ paginationLabel(link.label) }}
                    </span>
                </template>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
const axios = window.axios;

const page = usePage();
const authUser = computed(() => page.props.auth?.user);

const activeTab = ref('received');
const sentOffers = ref([]);
const receivedOffers = ref([]);
const isLoading = ref(true);
const actionLoading = ref(null);

const fetchOffers = async () => {
    isLoading.value = true;
    try {
        const res = await axios.get('/api/offers', {
            headers: { 'Authorization': `Bearer ${authUser.value?.api_token || ''}` }
        });
        sentOffers.value = res.data.sent || [];
        receivedOffers.value = res.data.received || [];
    } catch (e) {
        console.error('Failed to fetch offers:', e);
    } finally {
        isLoading.value = false;
    }
};

const updateOfferStatus = async (offer, status) => {
    actionLoading.value = `${offer.id}-${status}`;
    try {
        await axios.post(`/api/offers/update-status/${offer.id}`, { status }, {
            headers: { 'X-Idempotency-Key': `${offer.id}-${status}-${Date.now()}` }
        });
        await fetchOffers();
    } catch (e) {
        alert(e.response?.data?.message || 'Greška pri promeni statusa.');
    } finally {
        actionLoading.value = null;
    }
};

const confirmExchange = async (offer) => {
    actionLoading.value = `${offer.id}-confirm`;
    try {
        const res = await axios.post(`/api/offers/confirm/${offer.id}`, {}, {
            headers: { 'X-Idempotency-Key': `confirm-${offer.id}-${Date.now()}` }
        });
        alert(res.data.message);
        await fetchOffers();
    } catch (e) {
        alert(e.response?.data?.message || 'Greška pri potvrdi razmene.');
    } finally {
        actionLoading.value = null;
    }
};

const downloadReceipt = (offerId) => {
    window.open(`/user/offers/${offerId}/receipt`, '_blank', 'noopener');
};

const statusBadge = (status) => {
    const map = {
        pending: { bg: 'bg-yellow-100', text: 'text-yellow-700', icon: 'fas fa-clock', label: 'Na čekanju' },
        accepted: { bg: 'bg-blue-100', text: 'text-blue-700', icon: 'fas fa-handshake', label: 'Prihvaćeno' },
        rejected: { bg: 'bg-red-100', text: 'text-red-700', icon: 'fas fa-times-circle', label: 'Odbijeno' },
        withdrawn: { bg: 'bg-gray-100', text: 'text-gray-600', icon: 'fas fa-undo', label: 'Povučeno' },
        completed: { bg: 'bg-green-100', text: 'text-green-700', icon: 'fas fa-check-circle', label: 'Završeno' },
    };
    return map[status] || map.pending;
};

const currentOffers = computed(() => activeTab.value === 'received' ? receivedOffers.value : sentOffers.value);

onMounted(fetchOffers);
</script>

<template>
    <Head title="Moje Ponude" />
    <AppLayout>
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fas fa-handshake text-green-600"></i> Moje Ponude
                </h1>
                <div class="text-sm text-gray-500">
                    <span class="font-semibold text-green-600">{{ sentOffers.length + receivedOffers.length }}</span> ukupno
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex gap-2 mb-6">
                <button
                    @click="activeTab = 'received'"
                    :class="[
                        'px-6 py-2.5 rounded-xl text-sm font-semibold transition-all',
                        activeTab === 'received'
                            ? 'bg-green-600 text-white shadow-lg shadow-green-200'
                            : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'
                    ]"
                >
                    <i class="fas fa-inbox mr-2"></i> Primljene ({{ receivedOffers.length }})
                </button>
                <button
                    @click="activeTab = 'sent'"
                    :class="[
                        'px-6 py-2.5 rounded-xl text-sm font-semibold transition-all',
                        activeTab === 'sent'
                            ? 'bg-green-600 text-white shadow-lg shadow-green-200'
                            : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'
                    ]"
                >
                    <i class="fas fa-paper-plane mr-2"></i> Poslate ({{ sentOffers.length }})
                </button>
            </div>

            <!-- Loading -->
            <div v-if="isLoading" class="space-y-4">
                <div v-for="i in 3" :key="i" class="bg-white rounded-2xl p-6 animate-pulse border border-gray-100">
                    <div class="flex gap-4">
                        <div class="w-20 h-20 bg-gray-200 rounded-xl"></div>
                        <div class="flex-1 space-y-3">
                            <div class="h-4 bg-gray-200 rounded w-1/3"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/4"></div>
                            <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty -->
            <div v-else-if="currentOffers.length === 0" class="bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm">
                <div class="w-20 h-20 bg-gray-50 rounded-full mx-auto flex items-center justify-center mb-6">
                    <i class="fas fa-handshake text-4xl text-gray-200"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Nema ponuda</h3>
                <p class="text-gray-500 max-w-md mx-auto">
                    {{ activeTab === 'received' ? 'Još niste dobili nijednu ponudu za razmenu.' : 'Još niste poslali nijednu ponudu za razmenu.' }}
                </p>
            </div>

            <!-- Offers List -->
            <div v-else class="space-y-4">
                <div
                    v-for="offer in currentOffers"
                    :key="offer.id"
                    class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow"
                >
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Post Image -->
                        <div class="flex-shrink-0">
                            <img
                                :src="offer.selling_post?.profilePath || '/assets/img/no-image.png'"
                                class="w-24 h-24 rounded-xl object-cover bg-gray-100"
                                :alt="offer.selling_post?.name"
                            >
                        </div>

                        <!-- Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">{{ offer.selling_post?.name || 'Oglas' }}</h3>
                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ activeTab === 'received' ? 'Od:' : 'Ka:' }}
                                        <span class="font-semibold">{{ activeTab === 'received' ? offer.sender?.name : offer.receiver?.name }}</span>
                                    </p>
                                </div>
                                <span :class="[statusBadge(offer.status).bg, statusBadge(offer.status).text, 'px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5']">
                                    <i :class="statusBadge(offer.status).icon"></i>
                                    {{ statusBadge(offer.status).label }}
                                </span>
                            </div>

                            <!-- Items -->
                            <div class="flex flex-col sm:flex-row gap-4 mb-4">
                                <div class="flex-1">
                                    <p class="text-xs font-bold text-gray-500 uppercase mb-1.5">Ponuđeno</p>
                                    <div class="flex flex-wrap gap-1.5">
                                        <span v-for="(item, i) in offer.sender_items" :key="i" class="bg-green-50 text-green-700 px-2.5 py-1 rounded-lg text-xs font-medium">
                                            {{ item }}
                                        </span>
                                    </div>
                                </div>
                                <div v-if="offer.receiver_items && offer.receiver_items.length" class="flex-1">
                                    <p class="text-xs font-bold text-gray-500 uppercase mb-1.5">Traženo za uzvrat</p>
                                    <div class="flex flex-wrap gap-1.5">
                                        <span v-for="(item, i) in offer.receiver_items" :key="i" class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-medium">
                                            {{ item }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-wrap items-center gap-2">
                                <!-- Receiver actions for pending offers -->
                                <template v-if="activeTab === 'received' && offer.status === 'pending'">
                                    <button
                                        @click="updateOfferStatus(offer, 'accepted')"
                                        :disabled="actionLoading === `${offer.id}-accepted`"
                                        class="bg-green-600 hover:bg-green-700 disabled:bg-gray-300 text-white text-xs font-bold px-4 py-2 rounded-lg transition flex items-center gap-1.5"
                                    >
                                        <i :class="actionLoading === `${offer.id}-accepted` ? 'fas fa-spinner fa-spin' : 'fas fa-check'"></i> Prihvati
                                    </button>
                                    <button
                                        @click="updateOfferStatus(offer, 'rejected')"
                                        :disabled="actionLoading === `${offer.id}-rejected`"
                                        class="bg-red-500 hover:bg-red-600 disabled:bg-gray-300 text-white text-xs font-bold px-4 py-2 rounded-lg transition flex items-center gap-1.5"
                                    >
                                        <i :class="actionLoading === `${offer.id}-rejected` ? 'fas fa-spinner fa-spin' : 'fas fa-times'"></i> Odbij
                                    </button>
                                </template>

                                <!-- Sender actions for pending offers -->
                                <template v-if="activeTab === 'sent' && offer.status === 'pending'">
                                    <button
                                        @click="updateOfferStatus(offer, 'withdrawn')"
                                        :disabled="actionLoading === `${offer.id}-withdrawn`"
                                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold px-4 py-2 rounded-lg transition flex items-center gap-1.5"
                                    >
                                        <i :class="actionLoading === `${offer.id}-withdrawn` ? 'fas fa-spinner fa-spin' : 'fas fa-undo'"></i> Povuci
                                    </button>
                                </template>

                                <!-- Confirm exchange (both sides, when accepted) -->
                                <template v-if="offer.status === 'accepted'">
                                    <button
                                        @click="confirmExchange(offer)"
                                        :disabled="actionLoading === `${offer.id}-confirm`"
                                        class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 text-white text-xs font-bold px-4 py-2 rounded-lg transition flex items-center gap-1.5"
                                    >
                                        <i :class="actionLoading === `${offer.id}-confirm` ? 'fas fa-spinner fa-spin' : 'fas fa-handshake'"></i> Potvrdi Razmenu
                                    </button>
                                    <div class="text-xs text-gray-400 ml-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Sender: {{ offer.sender_confirmed ? '✅' : '⏳' }} |
                                        Receiver: {{ offer.receiver_confirmed ? '✅' : '⏳' }}
                                    </div>
                                </template>

                                <!-- Download receipt for completed -->
                                <template v-if="offer.status === 'completed'">
                                    <button
                                        @click="downloadReceipt(offer.id)"
                                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2 rounded-lg transition flex items-center gap-1.5"
                                    >
                                        <i class="fas fa-file-pdf text-red-500"></i> Preuzmi potvrdu (PDF)
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed, nextTick, onMounted, watch } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
const axios = window.axios;

const props = defineProps({
    chatUsers: Array,
    initialSellerId: Number,
    initialPostId: Number,
});

const page = usePage();
const authUser = computed(() => page.props.auth?.user);

const selectedUser = ref(null);
const messages = ref([]);
const newMessage = ref('');
const isLoadingMessages = ref(false);
const isSending = ref(false);
const chatContainer = ref(null);
const chatFile = ref(null);
const nextPage = ref(null);
const currentPage = ref(1);

// Offer related
const offerProduct = ref(null);
const offerItems = ref('');
const isSendingOffer = ref(false);

onMounted(async () => {
    if (props.initialSellerId) {
        let user = props.chatUsers.find(u => u.id === props.initialSellerId);
        if (!user) {
            try {
                const res = await axios.get(route('chat.user.details'), { params: { id: props.initialSellerId } });
                user = res.data;
            } catch (e) {}
        }
        if (user) {
            await selectUser(user, true); // Added true to indicate automated selection
            if (props.initialPostId) {
                fetchProductDetails(props.initialPostId);
            }
        }
    }
});

const fetchProductDetails = async (id) => {
    try {
        const res = await axios.get(`/api/products/show/${id}`);
        offerProduct.value = res.data.data?.product || res.data.data || res.data;
    } catch (e) {
        console.error('Error fetching product details:', e);
    }
};

const selectUser = async (user, isAuto = false) => {
    selectedUser.value = user;
    messages.value = [];
    currentPage.value = 1;
    nextPage.value = null;
    if (!isAuto) {
        offerProduct.value = null;
    }
    await fetchMessages(user.id, 1);

    try {
        await axios.post(route('mark.read', user.id));
        user.hasUnread = false;
    } catch (e) {}
};

const fetchMessages = async (userId, pg = 1) => {
    isLoadingMessages.value = true;
    try {
        const res = await axios.get(route('fetch.messages', userId), { params: { page: pg } });
        if (pg === 1) {
            messages.value = res.data.messages || [];
        } else {
            messages.value = [...(res.data.messages || []), ...messages.value];
        }
        nextPage.value = res.data.next_page ? pg + 1 : null;
        currentPage.value = pg;

        if (pg === 1) {
            await nextTick();
            scrollToBottom();
        }
    } catch (e) {
        console.error('Error fetching messages:', e);
    } finally {
        isLoadingMessages.value = false;
    }
};

const sendBarterOffer = async () => {
    if (!offerItems.value.trim() || !offerProduct.value) return;
    isSendingOffer.value = true;

    try {
        const offerRes = await axios.post('/api/offers/store', {
            selling_post_id: offerProduct.value.id,
            sender_items: offerItems.value.split(',').map(i => i.trim()),
            receiver_items: [offerProduct.value.name]
        });

        if (offerRes.data.offer) {
            await axios.post(route('send.message'), {
                receiver_id: selectedUser.value.id,
                message: `Poslao sam ponudu za vaš oglas: ${offerProduct.value.name}`,
                offer_id: offerRes.data.offer.id,
                selling_post_id: offerProduct.value.id
            });

            offerItems.value = '';
            offerProduct.value = null;
            await fetchMessages(selectedUser.value.id, 1);
        }
    } catch (e) {
        alert(e.response?.data?.message || 'Greška pri slanju ponude');
    } finally {
        isSendingOffer.value = false;
    }
};

const sendMessage = async () => {
    if (!newMessage.value.trim() && !chatFile.value) return;
    isSending.value = true;

    const formData = new FormData();
    formData.append('receiver_id', selectedUser.value.id);
    formData.append('message', newMessage.value);
    if (chatFile.value) {
        formData.append('chatFile', chatFile.value);
    }

    try {
        const res = await axios.post(route('send.message'), formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
        if (res.data.success) {
            newMessage.value = '';
            chatFile.value = null;
            await fetchMessages(selectedUser.value.id, 1);
        }
    } catch (e) {
        console.error('Error sending message:', e);
    } finally {
        isSending.value = false;
    }
};

const loadOlderMessages = () => {
    if (nextPage.value && selectedUser.value) {
        fetchMessages(selectedUser.value.id, nextPage.value);
    }
};

const scrollToBottom = () => {
    if (chatContainer.value) {
        chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
    }
};

const handleFileSelect = (e) => {
    chatFile.value = e.target.files[0] || null;
};

const formatTime = (dateStr) => {
    if (!dateStr) return '';
    const d = new Date(dateStr);
    return d.toLocaleTimeString('sr-Latn', { hour: '2-digit', minute: '2-digit' });
};
</script>

<template>
    <Head title="Poruke" />
    <AppLayout>
        <div class="flex h-[calc(100vh-140px)] bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">

            <!-- Users List -->
            <div class="w-full md:w-80 border-r border-gray-100 flex flex-col bg-gray-50/20" :class="{ 'hidden md:flex': selectedUser }">
                <div class="p-6 border-b border-gray-100 bg-white">
                    <h2 class="text-xl font-black text-gray-800 flex items-center gap-3">
                        <i class="fas fa-comments text-green-600"></i> Poruke
                    </h2>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <div v-if="chatUsers.length === 0" class="flex flex-col items-center justify-center h-full text-gray-300 p-8 text-center">
                        <i class="fas fa-inbox text-5xl mb-4 opacity-20"></i>
                        <p class="text-sm font-bold uppercase tracking-widest">Nema konverzacija</p>
                    </div>

                    <div
                        v-for="user in chatUsers"
                        :key="user.id"
                        @click="selectUser(user)"
                        :class="[
                            'flex items-center gap-4 px-6 py-4 cursor-pointer transition-all border-b border-gray-50',
                            selectedUser?.id === user.id ? 'bg-white shadow-inner border-l-4 border-l-green-600' : 'hover:bg-white/50',
                        ]"
                    >
                        <div class="relative flex-shrink-0">
                            <img :src="user.profilePhotoPath || '/media/demo-img.png'" class="w-12 h-12 rounded-full object-cover bg-gray-200 border-2 border-white shadow-sm">
                            <span v-if="user.is_online" class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white shadow-sm"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ user.name }}</p>
                                <span v-if="user.hasUnread" class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></span>
                            </div>
                            <p class="text-xs text-gray-400 truncate mt-0.5">{{ user.lastMessageWithAuth?.contact || 'Započnite razgovor' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Area -->
            <div class="flex-1 flex flex-col bg-white" :class="{ 'hidden md:flex': !selectedUser }">
                <!-- No user selected -->
                <div v-if="!selectedUser" class="flex-1 flex flex-col items-center justify-center text-gray-400 bg-gray-50/30">
                    <div class="w-24 h-24 bg-white rounded-3xl shadow-sm flex items-center justify-center mb-6">
                        <i class="fas fa-paper-plane text-4xl text-green-100"></i>
                    </div>
                    <p class="font-black text-xl text-gray-800">Izaberite razgovor</p>
                    <p class="text-sm mt-1">Vaše poruke i ponude na jednom mestu</p>
                </div>

                <!-- Chat active -->
                <template v-else>
                    <!-- Header -->
                    <div class="flex items-center gap-4 px-8 py-5 border-b border-gray-100 bg-white/80 backdrop-blur-md sticky top-0 z-10">
                        <button @click="selectedUser = null" class="md:hidden p-2 -ml-2 text-gray-400 hover:text-green-600">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <img :src="selectedUser.profilePhotoPath || '/media/demo-img.png'" class="w-11 h-11 rounded-full object-cover bg-gray-200 border-2 border-white shadow-sm">
                        <div>
                            <p class="font-black text-gray-900 text-base leading-none">{{ selectedUser.name }}</p>
                            <div class="flex items-center gap-1.5 mt-1">
                                <span :class="['w-2 h-2 rounded-full', selectedUser.is_online ? 'bg-green-500' : 'bg-gray-300']"></span>
                                <p class="text-[10px] font-bold uppercase tracking-widest" :class="selectedUser.is_online ? 'text-green-600' : 'text-gray-400'">
                                    {{ selectedUser.is_online ? 'Aktivan' : 'Neaktivan' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="ml-auto">
                            <Link :href="route('seller-info', selectedUser.id)" class="text-xs font-bold text-green-600 hover:underline">
                                Profil
                            </Link>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div ref="chatContainer" class="flex-1 overflow-y-auto p-8 space-y-6 bg-gray-50/50">
                        <button v-if="nextPage" @click="loadOlderMessages" class="mx-auto block bg-white px-4 py-2 rounded-full shadow-sm text-[10px] font-black text-green-600 uppercase tracking-widest hover:bg-green-50 transition mb-6">
                            <i class="fas fa-arrow-up mr-1"></i> Prethodne poruke
                        </button>

                        <div v-if="isLoadingMessages && messages.length === 0" class="flex justify-center py-12">
                            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-green-600"></div>
                        </div>

                        <div
                            v-for="msg in messages"
                            :key="msg.id"
                            :class="['flex flex-col', msg.sender_id === authUser?.id ? 'items-end' : 'items-start']"
                        >
                            <div :class="[
                                'max-w-[85%] sm:max-w-[70%] px-5 py-3 rounded-2xl shadow-sm text-sm transition-all',
                                msg.sender_id === authUser?.id
                                    ? 'bg-green-600 text-white rounded-tr-none'
                                    : 'bg-white text-gray-800 rounded-tl-none border border-gray-100'
                            ]">
                                <div v-if="msg.media" class="mb-3">
                                    <img :src="msg.media" class="max-w-full rounded-xl max-h-64 object-cover shadow-sm">
                                </div>

                                <!-- Offer Card -->
                                <div v-if="msg.offer" class="chat-offer-card mt-1">
                                    <div class="chat-offer-title">
                                        <i class="fas fa-handshake"></i> Ponuda za Razmenu
                                    </div>
                                    <div v-if="msg.product" class="chat-offer-product">
                                        <img :src="msg.product.thumbnail || '/assets/img/no-image.png'" class="chat-offer-img">
                                        <div>
                                            <p class="text-xs font-bold text-gray-900 leading-tight">{{ msg.product.name }}</p>
                                            <p class="text-[10px] text-gray-500 mt-1"><i class="fas fa-map-marker-alt mr-1"></i> {{ msg.product.location }}</p>
                                        </div>
                                    </div>
                                    <div class="chat-offer-items-grid">
                                        <div>
                                            <p class="chat-offer-label">Nudi se:</p>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <span v-for="(item, i) in msg.offer.sender_items" :key="i" class="chat-offer-tag">
                                                    {{ item }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chat-offer-actions">
                                        <Link :href="route('user.offers')" class="chat-offer-btn-view">
                                            Upravljaj Ponudom <i class="fas fa-chevron-right text-[8px]"></i>
                                        </Link>
                                    </div>
                                </div>

                                <p v-if="!msg.offer" class="leading-relaxed">{{ msg.body || msg.contact }}</p>
                                
                                <p :class="['text-[10px] mt-1.5 font-bold opacity-60', msg.sender_id === authUser?.id ? 'text-white' : 'text-gray-400']">
                                    {{ formatTime(msg.created_at) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Offer Panel -->
                    <div v-if="offerProduct" class="px-8 py-6 bg-green-50 border-t border-green-100 animate-slide-up">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex gap-4">
                                <div class="w-16 h-16 bg-white rounded-xl shadow-sm border border-green-200 overflow-hidden flex-shrink-0">
                                    <img :src="offerProduct.thumbnail || offerProduct.profilePath || '/media/demo-img.png'" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-green-600 uppercase tracking-widest mb-1">Pravite ponudu za:</p>
                                    <h4 class="font-black text-gray-900 leading-tight">{{ offerProduct.name }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ offerProduct.location || offerProduct.location_name || 'Nepoznata lokacija' }} • {{ offerProduct.conditions }}</p>
                                </div>
                            </div>
                            <button @click="offerProduct = null" class="w-8 h-8 rounded-full bg-white border border-green-200 text-green-600 flex items-center justify-center hover:bg-green-100 transition">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                        
                        <div>
                            <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2 block">Šta nudite u zamenu? (odvojite zarezom)</label>
                            <div class="flex gap-3">
                                <input 
                                    v-model="offerItems" 
                                    type="text" 
                                    placeholder="npr. Telefon, Sat, Knjige..." 
                                    class="flex-1 bg-white border-2 border-green-100 rounded-2xl px-5 py-3 text-sm focus:border-green-500 focus:ring-0 transition"
                                >
                                <button 
                                    @click="sendBarterOffer" 
                                    :disabled="isSendingOffer || !offerItems.trim()"
                                    class="bg-green-600 hover:bg-green-700 disabled:bg-gray-300 text-white font-black px-6 rounded-2xl transition shadow-md flex items-center gap-2 whitespace-nowrap"
                                >
                                    <i :class="isSendingOffer ? 'fas fa-spinner fa-spin' : 'fas fa-handshake'"></i>
                                    POŠALJI PONUDU
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Input Area -->
                    <div class="p-6 bg-white border-t border-gray-50">
                        <div v-if="chatFile" class="mb-4 flex items-center gap-3 text-xs text-gray-600 bg-gray-50 p-3 rounded-2xl border border-gray-100 animate-fade-in">
                            <i class="fas fa-paperclip text-green-600"></i>
                            <span class="flex-1 truncate font-bold">{{ chatFile.name }}</span>
                            <button @click="chatFile = null" class="w-6 h-6 rounded-full bg-red-50 text-red-500 flex items-center justify-center hover:bg-red-100 transition"><i class="fas fa-times text-[10px]"></i></button>
                        </div>
                        
                        <form @submit.prevent="sendMessage" class="flex items-center gap-4">
                            <label class="w-12 h-12 flex-shrink-0 bg-gray-50 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-2xl flex items-center justify-center cursor-pointer transition shadow-sm border border-gray-100">
                                <i class="fas fa-plus text-lg"></i>
                                <input type="file" class="hidden" @change="handleFileSelect" accept="image/*,video/*,.pdf,.doc,.docx">
                            </label>
                            
                            <div class="flex-1 relative">
                                <input
                                    v-model="newMessage"
                                    type="text"
                                    placeholder="Napišite nešto..."
                                    class="w-full bg-gray-50 border-2 border-transparent rounded-2xl px-6 py-3.5 text-sm focus:bg-white focus:border-green-500 focus:ring-0 transition shadow-inner"
                                    :disabled="isSending"
                                >
                            </div>
                            
                            <button 
                                type="submit" 
                                :disabled="isSending || (!newMessage.trim() && !chatFile)" 
                                class="w-12 h-12 flex-shrink-0 bg-green-600 hover:bg-green-700 disabled:bg-gray-200 text-white rounded-2xl flex items-center justify-center transition shadow-lg shadow-green-200"
                            >
                                <i :class="isSending ? 'fas fa-spinner fa-spin' : 'fas fa-paper-plane'"></i>
                            </button>
                        </form>
                    </div>
                </template>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.animate-slide-up {
    animation: slideUp 0.3s ease-out;
}
.animate-fade-in {
    animation: fadeIn 0.3s ease-out;
}
@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
</style>

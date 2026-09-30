<script setup>
import { ref, watch } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    isOpen: Boolean,
    initialMode: {
        type: String,
        default: 'login',
    },
});

const emit = defineEmits(['close']);

const mode = ref(props.initialMode);

watch(() => props.initialMode, (value) => {
    mode.value = value || 'login';
});

const loginForm = useForm({
    contact: '',
    password: '',
    remember: false
});

const registerForm = useForm({
    name: '',
    email: '',
    phone_no: '',
    password: '',
});

const submit = () => {
    loginForm.post(route('user.login.submit'), {
        onFinish: () => loginForm.reset('password'),
        onSuccess: () => emit('close'),
    });
};

const submitRegistration = () => {
    registerForm.post(route('user.register.submit'), {
        onFinish: () => registerForm.reset('password'),
        onSuccess: () => emit('close'),
    });
};
</script>

<template>
    <div v-if="isOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="emit('close')"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all animate-in fade-in zoom-in duration-300">
            <button @click="emit('close')" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="p-8 sm:p-10">
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-black text-gray-900 mb-2">
                        {{ mode === 'login' ? 'Dobrodošli nazad!' : 'Kreirajte nalog' }}
                    </h2>
                    <p class="text-gray-500 text-sm">
                        {{ mode === 'login' ? 'Prijavite se na svoj PepExch nalog' : 'Registrujte se i nastavite u PepExch iskustvu' }}
                    </p>
                </div>

                <form v-if="mode === 'login'" @submit.prevent="submit" class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 ml-1">Email ili Telefon</label>
                        <input 
                            v-model="loginForm.contact"
                            type="text" 
                            required
                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-500 focus:bg-white outline-none transition-all text-sm"
                            placeholder="primer@email.com"
                        >
                        <div v-if="loginForm.errors.contact" class="mt-2 text-red-500 text-xs font-bold ml-1">{{ loginForm.errors.contact }}</div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 ml-1">Lozinka</label>
                        <input 
                            v-model="loginForm.password"
                            type="password" 
                            required
                            class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-500 focus:bg-white outline-none transition-all text-sm"
                            placeholder="••••••••"
                        >
                        <div v-if="loginForm.errors.password" class="mt-2 text-red-500 text-xs font-bold ml-1">{{ loginForm.errors.password }}</div>
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" v-model="loginForm.remember" class="w-4 h-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="text-xs text-gray-500 group-hover:text-gray-700 transition-colors">Zapamti me</span>
                        </label>
                        <Link :href="route('user.forgot.password')" class="text-xs font-bold text-green-600 hover:text-green-700 transition-colors">
                            Zaboravljena lozinka?
                        </Link>
                    </div>

                    <button 
                        type="submit" 
                        :disabled="loginForm.processing"
                        class="login-btn w-full bg-green-600 hover:bg-green-700 disabled:bg-gray-400 text-white font-black py-4 rounded-2xl shadow-lg shadow-green-200 transition-all transform hover:-translate-y-0.5 active:translate-y-0"
                    >
                        {{ loginForm.processing ? 'PRIJAVLJIVANJE...' : 'PRIJAVI SE' }}
                    </button>
                </form>

                <form v-else @submit.prevent="submitRegistration" class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 ml-1">Ime i prezime</label>
                        <input v-model="registerForm.name" type="text" required class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-500 focus:bg-white outline-none transition-all text-sm" placeholder="Petar Petrović">
                        <div v-if="registerForm.errors.name" class="mt-2 text-red-500 text-xs font-bold ml-1">{{ registerForm.errors.name }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 ml-1">Email</label>
                        <input v-model="registerForm.email" type="email" required class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-500 focus:bg-white outline-none transition-all text-sm" placeholder="primer@email.com">
                        <div v-if="registerForm.errors.email" class="mt-2 text-red-500 text-xs font-bold ml-1">{{ registerForm.errors.email }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 ml-1">Telefon</label>
                        <input v-model="registerForm.phone_no" type="text" required class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-500 focus:bg-white outline-none transition-all text-sm" placeholder="+381...">
                        <div v-if="registerForm.errors.phone_no" class="mt-2 text-red-500 text-xs font-bold ml-1">{{ registerForm.errors.phone_no }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 ml-1">Lozinka</label>
                        <input v-model="registerForm.password" type="password" required class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-green-500 focus:bg-white outline-none transition-all text-sm" placeholder="••••••••">
                        <div v-if="registerForm.errors.password" class="mt-2 text-red-500 text-xs font-bold ml-1">{{ registerForm.errors.password }}</div>
                    </div>
                    <button 
                        type="submit" 
                        :disabled="registerForm.processing"
                        class="login-btn w-full bg-green-600 hover:bg-green-700 disabled:bg-gray-400 text-white font-black py-4 rounded-2xl shadow-lg shadow-green-200 transition-all transform hover:-translate-y-0.5 active:translate-y-0"
                    >
                        {{ registerForm.processing ? 'REGISTRACIJA...' : 'REGISTRUJ SE' }}
                    </button>
                </form>

                <div class="mt-8 pt-8 border-t border-gray-100 text-center">
                    <p class="text-sm text-gray-500">
                        {{ mode === 'login' ? 'Nemate nalog?' : 'Već imate nalog?' }}
                        <button type="button" class="text-green-600 font-black hover:underline ml-1" @click="mode = mode === 'login' ? 'register' : 'login'">
                            {{ mode === 'login' ? 'Registrujte se' : 'Prijavite se' }}
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar Sesión" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ status }}
        </div>

        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Te hemos extrañado</h2>
            <p class="text-gray-500 dark:text-gray-400 mt-2">Bienvenido de nuevo</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Campo de Email con Label -->
            <div>
                <InputLabel for="email" value="Correo Electrónico" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    placeholder="Email o Usuario"
                >
                    <template #icon>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                    </template>
                </TextInput>
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <!-- Campo de Contraseña con Label -->
            <div>
                <InputLabel for="password" value="Contraseña" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    placeholder="Contraseña"
                >
                    <template #icon>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </template>
                </TextInput>
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Checkbox y Olvidé mi contraseña -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center text-gray-600 dark:text-gray-400">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2">Recordarme</span>
                </label>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="font-medium text-gray-600 dark:text-gray-400 hover:text-brand-green-dark"
                >
                    ¿Olvidaste tu contraseña?
                </Link>
            </div>

            <!-- Botón de Iniciar Sesión -->
            <div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Ingresar
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </PrimaryButton>
            </div>
             <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                ¿No tienes una cuenta?
                <Link :href="route('register')" class="font-medium text-brand-green-dark dark:text-brand-green hover:underline">
                    Crea una aquí
                </Link>
            </p>
        </form>
    </GuestLayout>
</template>

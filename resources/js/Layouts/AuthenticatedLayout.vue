<script setup>
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import SidebarLink from '@/Components/SidebarLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

// --- LÓGICA PARA EL MENÚ DESPLEGABLE ---
const openMenus = ref({});
const toggleMenu = (menuId) => {
    // Cierra todos los demás menús para un efecto 'acordeón'
    Object.keys(openMenus.value).forEach(key => {
        if (key != menuId) {
            openMenus.value[key] = false;
        }
    });
    // Abre o cierra el menú actual
    openMenus.value[menuId] = !openMenus.value[menuId];
};

// --- Props computadas ---
const sidebarOpen = ref(true);
const toggleSidebar = () => sidebarOpen.value = !sidebarOpen.value;
const menu = computed(() => usePage().props.menu || []);
const user = computed(() => usePage().props.auth.user);
const userInitial = computed(() => user.value?.name?.charAt(0).toUpperCase() || 'U');

// Debug: Verificar que el menú se está cargando
console.log('Menu data:', menu.value);
</script>

<template>
    <div class="h-screen flex overflow-hidden bg-gray-50 dark:bg-gray-900">
        <!-- BARRA LATERAL MEJORADA -->
        <aside
            class="flex-shrink-0 w-72 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col shadow-lg transition-all duration-300"
            :class="{ '-ml-72': !sidebarOpen }"
        >
            <!-- HEADER DEL SIDEBAR -->
            <div class="h-16 flex-shrink-0 flex items-center justify-center px-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-600 to-purple-600">
                <Link :href="route('dashboard')" class="flex items-center space-x-3">
                    <ApplicationLogo class="block h-8 w-auto text-white" />
                    <span class="text-white font-bold text-lg">Sistema</span>
                </Link>
            </div>

            <!-- NAVEGACIÓN -->
            <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-3">
                <!-- Verificar si hay menús -->
                <div v-if="menu.length === 0" class="text-center text-gray-500 dark:text-gray-400 mt-8">
                    <p class="text-sm">No hay menús disponibles</p>
                </div>

                <div v-for="menuItem in menu" :key="menuItem.id" class="space-y-2">
                    <!-- BOTÓN DEL MENÚ PRINCIPAL -->
                    <button 
                        @click="toggleMenu(menuItem.id)" 
                        class="w-full group flex items-center justify-between px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 transform hover:scale-[1.02]"
                    >
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center mr-4 group-hover:shadow-lg transition-shadow duration-200">
                                <i :class="menuItem.icon || 'fa-solid fa-layer-group'" class="text-white text-lg"></i>
                            </div>
                            <span class="font-semibold">{{ menuItem.name }}</span>
                        </div>
                        <i class="fa-solid fa-chevron-down transition-transform duration-300 text-gray-400" 
                           :class="{ 'rotate-180': openMenus[menuItem.id] }"></i>
                    </button>

                    <!-- SUBMENÚ DESPLEGABLE CON ANIMACIÓN MEJORADA -->
                    <div class="overflow-hidden transition-all duration-300 ease-in-out"
                         :class="openMenus[menuItem.id] ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'">
                        <div class="pl-6 space-y-2 pt-2">
                            <SidebarLink
                                v-for="subMenuItem in menuItem.subMenus"
                                :key="subMenuItem.id"
                                :href="route(subMenuItem.route)"
                                :active="route().current(subMenuItem.route)"
                                class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 group hover:transform hover:translate-x-2"
                            >
                                <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center mr-3 group-hover:bg-blue-100 dark:group-hover:bg-blue-900 transition-colors duration-200">
                                    <i :class="subMenuItem.icon || 'fa-solid fa-circle'" class="text-sm text-gray-600 dark:text-gray-300 group-hover:text-blue-600 dark:group-hover:text-blue-400"></i>
                                </div>
                                <div>
                                    <span class="block font-medium">{{ subMenuItem.name }}</span>
                                    <span v-if="subMenuItem.description" class="block text-xs text-gray-500 dark:text-gray-400">{{ subMenuItem.description }}</span>
                                </div>
                            </SidebarLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- FOOTER DEL SIDEBAR -->
            <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700">
                <div v-if="user" class="flex items-center space-x-3 text-sm">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center font-bold">
                        {{ userInitial }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 dark:text-white truncate">{{ user.name }}</p>
                        <p class="text-gray-500 dark:text-gray-400 truncate">{{ user.email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- HEADER -->
            <header class="h-16 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 flex-shrink-0 shadow-sm">
                <div class="flex items-center justify-between h-full px-6">
                    <button 
                        @click="toggleSidebar" 
                        class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- DROPDOWN DEL USUARIO -->
                    <div class="ml-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button class="flex items-center space-x-3 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-white flex items-center justify-center font-bold">
                                        {{ userInitial }}
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <div class="font-semibold">{{ user.name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Administrador</div>
                                    </div>
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </template>
                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    <i class="fa-solid fa-user-gear w-4 h-4 mr-3 text-blue-500"></i>
                                    Mi Perfil
                                </DropdownLink>
                                <hr class="my-1">
                                <DropdownLink :href="route('logout')" method="post" as="button" class="text-red-600 hover:text-red-700">
                                    <i class="fa-solid fa-right-from-bracket w-4 h-4 mr-3"></i>
                                    Cerrar Sesión
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </header>

            <!-- CONTENIDO PRINCIPAL -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="p-6">
                    <header v-if="$slots.header" class="mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 border border-gray-200 dark:border-gray-700">
                            <h1 class="font-bold text-3xl text-gray-900 dark:text-white">
                                <slot name="header" />
                            </h1>
                        </div>
                    </header>
                    
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
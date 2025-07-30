<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref } from 'vue';

// Volvemos a añadir la lógica para el efecto 3D
const coverPanel = ref(null);

const handleMouseMove = (event) => {
    if (!coverPanel.value) return;
    const { left, top, width, height } = coverPanel.value.getBoundingClientRect();
    const mouseX = (event.clientX - left) / width - 0.5;
    const mouseY = (event.clientY - top) / height - 0.5;
    const rotateX = mouseY * -12; // Un poco más sutil
    const rotateY = mouseX * 12;
    coverPanel.value.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05, 1.05, 1.05)`;
};

const handleMouseLeave = () => {
    if (!coverPanel.value) return;
    coverPanel.value.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
};
</script>

<template>
    <!-- 1. El fondo de toda la página mantiene la animación de "olas" -->
    <div class="min-h-screen flex items-center justify-center p-4 animated-gradient">
        <!-- Tarjeta principal más grande -->
        <div class="w-full max-w-5xl flex rounded-2xl shadow-2xl overflow-hidden">
            
            <!-- 2. La columna izquierda ahora tiene de nuevo el efecto 3D al pasar el mouse -->
            <div 
                ref="coverPanel"
                @mousemove="handleMouseMove"
                @mouseleave="handleMouseLeave"
                class="hidden md:block w-1/2 lg:w-[55%] bg-[#0a192f] p-8 lg:p-12 relative text-white transition-transform duration-300 ease-out"
            >
                <!-- SVG decorativo -->
                <svg class="absolute inset-0 w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                    <path fill="#12EDC1" fill-opacity="0.3" d="M0,224L48,213.3C96,203,192,181,288,186.7C384,192,480,224,576,240C672,256,768,256,864,229.3C960,203,1056,149,1152,117.3C1248,85,1344,75,1392,69.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                </svg>

                <div class="relative z-10 flex flex-col h-full justify-center">
                    <h1 class="text-4xl font-bold mb-4">Bienvenido JR</h1>
                    <p class="text-gray-300">
                        Defensa de Julio
                    </p>
                </div>
            </div>

            <!-- COLUMNA DERECHA: El Formulario (sin cambios) -->
            <div class="w-full md:w-1/2 lg:w-[45%] bg-white dark:bg-gray-800 p-8 lg:p-12">
                <div class="w-full">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* La animación de fondo se mantiene igual */
.animated-gradient {
    background: linear-gradient(45deg, #0a192f, #112240, #233554, #112240);
    background-size: 400% 400%;
    animation: gradient-flow 15s ease infinite;
}

@keyframes gradient-flow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
</style>

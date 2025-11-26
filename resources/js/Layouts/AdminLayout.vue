<template>
    <div class="flex flex-col min-h-screen">
        <header class="p-4 text-white bg-blue-600">
            <h1 class="text-lg font-bold">Panel Administrativo</h1>
        </header>

        <div class="flex flex-1">
            <!-- Sidebar -->
            <aside class="w-64 p-4 text-white bg-gray-800">
                <nav>
                    <ul>
                        <li ><a href="/admin/ventas" class="block px-4 py-2 hover:bg-gray-700">Ventas</a></li>
                        <li ><a href="/admin/usuarios" class="block px-4 py-2 hover:bg-gray-700">Usuarios</a></li>
                        <li><a href="/admin/categorias" class="block px-4 py-2 hover:bg-gray-700">Categorías</a></li>
                        <li ><a href="/admin/pagos" class="block px-4 py-2 hover:bg-gray-700">Pagos</a></li>
                        <li  ><a href="/admin/productos" class="block px-4 py-2 hover:bg-gray-700">Productos</a></li>
                        <li  ><a href="/admin/promocion" class="block px-4 py-2 hover:bg-gray-700">Promociones</a></li>
                        <li ><a href="/admin/inventarios" class="block px-4 py-2 hover:bg-gray-700">Inventario</a></li>
                        <li ><a href="/admin/compras" class="block px-4 py-2 hover:bg-gray-700">Compras</a></li>                      
                      </ul>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-6 bg-gray-100">
                <slot />
            </main>
        </div>
        
        <!-- Footer con contador de visitas -->
        
    </div>
</template>

<script setup>
import Footer from '@/Components/Footer.vue';
</script>
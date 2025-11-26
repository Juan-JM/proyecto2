<template>
    <AppLayout title="Inicio">
    <div class="container mx-auto">
        <h1 class="mb-4 text-2xl font-bold">Formulario de Pago</h1>
        <form @submit.prevent="enviarDatos">
            <div class="mb-4">
                <label for="tnTelefono" class="block text-gray-700">Teléfono:</label>
                <input v-model="form.tnTelefono" type="text" id="tnTelefono" class="w-full p-2 border rounded" />
            </div>

            <div class="mb-4">
                <label for="tcRazonSocial" class="block text-gray-700">Razón Social:</label>
                <input v-model="form.tcRazonSocial" type="text" id="tcRazonSocial" class="w-full p-2 border rounded" />
            </div>

            <div class="mb-4">
                <label for="tcCiNit" class="block text-gray-700">CI/NIT:</label>
                <input v-model="form.tcCiNit" type="text" id="tcCiNit" class="w-full p-2 border rounded" />
            </div>

            <div class="mb-4">
                <label for="tcCorreo" class="block text-gray-700">Correo:</label>
                <input v-model="form.tcCorreo" type="email" id="tcCorreo" class="w-full p-2 border rounded" />
            </div>

            <div class="mb-4">
                <label for="tnMonto" class="block text-gray-700">Monto:</label>
                <input v-model="form.tnMonto" type="number" id="tnMonto" step="0.01"
                    class="w-full p-2 border rounded" />
            </div>

            <div class="mb-4">
                <label for="tcSerial" class="block text-gray-700">Serial:</label>
                <input v-model="form.tcSerial" type="text" id="tcSerial" class="w-full p-2 border rounded" />
            </div>

            <div class="mb-4">
                <label for="tnDescuento" class="block text-gray-700">Descuento:</label>
                <input v-model="form.tnDescuento" type="number" id="tnDescuento" step="0.01"
                    class="w-full p-2 border rounded" />
            </div>

            <div class="mb-4">
                <label for="tnTotal" class="block text-gray-700">Total:</label>
                <input v-model="form.tnTotal" type="number" id="tnTotal" step="0.01"
                    class="w-full p-2 border rounded" />
            </div>

            <div class="mb-4">
                <label for="tnTipoServicio" class="block text-gray-700">Tipo de Servicio:</label>
                <select v-model="form.tnTipoServicio" id="tnTipoServicio" class="w-full p-2 border rounded">
                    <option value="1">Pago QR</option>
                    <option value="2">Tigo Money</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="taPedidoDetalle" class="block text-gray-700">Detalle del Pedido:</label>
                <textarea v-model="form.taPedidoDetalle" id="taPedidoDetalle" rows="3"
                    class="w-full p-2 border rounded"></textarea>
            </div>

            <button type="submit" class="p-2 text-white bg-blue-500 rounded hover:bg-blue-700">Enviar</button>
        </form>

        <div v-if="response" class="p-4 mt-6 text-green-800 bg-green-100 rounded">
            <h2 class="font-bold">Respuesta:</h2>
            <pre>{{ response }}</pre>
        </div>

        <div v-if="qrImage" class="mt-6">
            <h2 class="text-lg font-bold">Código QR:</h2>
            <img :src="qrImage" alt="Código QR generado" class="h-128 w-128" />
        </div>
    </div>
</AppLayout>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
export default {
    name: 'RecolectarDatos',
    data() {
        return {
            form: {
                tnTelefono: '',
                tcRazonSocial: '',
                tcCiNit: '',
                tcCorreo: '',
                tnMonto: null,
                tcSerial: '',
                tnDescuento: null,
                tnTotal: null,
                tnTipoServicio: 1,
                taPedidoDetalle: ''
            },
            response: null,
            qrImage: null,
        };
    },
    methods: {
        async enviarDatos() {
            try {
                const { data } = await axios.post("/recolectar-datos", this.form);
                this.response = data;

                if (data.values) {
                    const valuesParts = data.values.split(";");

                    if (valuesParts.length > 1) {
                        const jsonData = JSON.parse(valuesParts[1]); // Parsear la segunda parte que es el JSON

                        if (jsonData.qrImage) {
                            this.qrImage = `data:image/png;base64,${jsonData.qrImage}`;
                        } else {
                            this.qrImage = null;  // Si no hay qrImage, asignar null
                        }
                    } else {
                        this.qrImage = null;  // Si no hay JSON, asignar null
                    }
                } else {
                    this.qrImage = null;  // Si `values` no existe, asignar null
                }
            } catch (error) {
                console.error(error);
                this.response = error.response ? error.response.data : "Error al enviar datos";  // Almacena el error en la variable response
                this.qrImage = null;  // Asegurarse de que qrImage esté null en caso de error
            }
        }
    }
};
</script>

<style scoped>
.container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
}
</style>

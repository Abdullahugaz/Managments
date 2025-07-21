<template>
  <AppLayout>
    <Head title="Edit Product" />
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Edit Product</h2>
      </div>

      <form @submit.prevent="submit" class="max-w-xl mx-auto space-y-4">
        <input
          v-model="form.name"
          type="text"
          placeholder="Name"
          class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <textarea
          v-model="form.description"
          placeholder="Description"
          class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          rows="3"
        ></textarea>

        <input
          v-model.number="form.price"
          type="number"
          step="0.01"
          min="0"
          placeholder="Price"
          class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <input
          v-model.number="form.stock"
          type="number"
          min="0"
          placeholder="Stock"
          class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />

        <button
          type="submit"
          class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700 transition"
        >
          Update
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps({ product: Object })

const form = useForm({
  name: props.product.name,
  description: props.product.description,
  price: props.product.price,
  stock: props.product.stock,
})

const submit = () => form.put(`/products/${props.product.id}`)
</script>

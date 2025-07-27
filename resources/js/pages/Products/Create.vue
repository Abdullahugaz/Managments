<template>
  <AppLayout>
    <Head title="Create Product" />
    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold">Create Product</h2>
      </div>

      <form @submit.prevent="submit" class="max-w-xl mx-auto space-y-4">
      
      <div>
        <label class="block mb-1">Product Name</label>
        <input
          v-model="form.name"
          type="text"
          placeholder="Name"
          class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
</div>
<div>
        <label class="block mb-1">Product Description</label>
        <textarea
          v-model="form.description"
          placeholder="Description"
          class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
          rows="3"
        ></textarea>
        </div>
<div>
        <label class="block mb-1">Product Price</label>
        <input
          v-model.number="form.price"
          type="number"
          step="0.01"
          min="0"
          placeholder="Price"
          class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
</div>
<div>
        <label class="block mb-1">Product Quantity</label>
        <input
          v-model.number="form.stock"
          type="number"
          min="0"
          placeholder="Stock"
          class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
</div>
        <button
          type="submit"
          class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition"
        >
          Create
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const form = useForm({
  name: '',
  description: '',
  price: 0,
  stock: 0,
})

const submit = () => form.post('/products')
</script>

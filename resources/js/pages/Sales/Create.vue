<script setup>
import { ref, computed } from 'vue'
import { useForm, Head } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineOptions({ layout: AppLayout })

const props = defineProps({
  customers: Array,
  products: Array
})

const selectedProduct = ref(null)

const form = useForm({
  customer_id: '',
  product_id: '',
  quantity: 1,
  price: 0,
})

// When product changes, auto-fill price
const onProductChange = () => {
  const product = props.products.find(p => p.id === form.product_id)
  if (product) {
    selectedProduct.value = product
    form.price = product.price
  }
}

// Computed total price
const total = computed(() => form.price * form.quantity)

// Submit
const submit = () => {
  if (!selectedProduct.value) {
    alert('Please select a product.')
    return
  }

  if (form.quantity > selectedProduct.value.quantity) {
    alert('Not enough stock!')
    return
  }

  form.post(route('sales.store'))
}
</script>

<template>
  <Head title="New Sale" />
  <div class="p-6">
      <div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-bold mb-4">New Sale</h2>
</div>
    <form @submit.prevent="submit">

      <!-- Customer -->
      <div class="mb-4">
        <label class="block mb-1">Customer</label>
        <select v-model="form.customer_id" class="w-full border rounded px-2 py-1">
          <option disabled value="">Select Customer</option>
          <option v-for="c in customers" :key="c.id" :value="c.id">{{ c.name }}</option>
        </select>
      </div>

      <!-- Product -->
      <div class="mb-4">
        <label class="block mb-1">Product</label>
        <select v-model="form.product_id" @change="onProductChange" class="w-full border rounded px-2 py-1">
          <option disabled value="">Select Product</option>
          <option v-for="p in products" :key="p.id" :value="p.id">{{ p.name }} (Stock: {{ p.quantity }})</option>
        </select>
      </div>

      <!-- Quantity -->
      <div class="mb-4">
        <label class="block mb-1">Quantity</label>
        <input type="number" v-model="form.quantity" min="1" class="w-full border rounded px-2 py-1" />
      </div>

      <!-- Price (read-only) -->
      <div class="mb-4">
        <label class="block mb-1">Price per Unit</label>
        <input type="text" v-model="form.price" readonly class="w-full bg-gray-100 border rounded px-2 py-1" />
      </div>

      <!-- Total -->
      <div class="mb-4">
        <strong>Total: ${{ total }}</strong>
      </div>

      <!-- Submit -->
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Submit Sale</button>
    </form>
  </div>
</template>

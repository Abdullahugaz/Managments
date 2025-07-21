<template>
  <AppLayout>
    <Head title="Edit Sale" />
    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
      <h1 class="text-xl font-semibold mb-4">Edit Sale</h1>
</div>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block mb-1 font-medium">Customer</label>
          <select v-model="form.customer_id" class="w-full border p-2 rounded">
            <option disabled value="">Select a customer</option>
            <option v-for="c in customers" :key="c.id" :value="c.id">{{ c.name }}</option>
          </select>
        </div>

        <div>
          <label class="block mb-1 font-medium">Product</label>
          <select v-model="form.product_id" @change="onProductChange" class="w-full border p-2 rounded">
            <option disabled value="">Select a product</option>
            <option v-for="p in products" :key="p.id" :value="p.id">
              {{ p.name }} (Stock: {{ p.stock }})
            </option>
          </select>
        </div>

        <div>
          <label class="block mb-1 font-medium">Quantity</label>
          <input
            type="number"
            v-model.number="form.quantity"
            class="w-full border p-2 rounded"
            min="1"
            :max="maxQuantity"
          />
        </div>

        <div v-if="selectedProduct">
          <p>Price per unit: ${{ selectedProduct.price }}</p>
          <p>Total: ${{ totalPrice }}</p>
        </div>

        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          :disabled="form.processing"
        >
          Update Sale
        </button>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import { ref, computed, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  sale: Object,
  customers: Array,
  products: Array,
})

const form = useForm({
  customer_id: props.sale.customer_id,
  product_id: props.sale.product_id,
  quantity: props.sale.quantity,
})

const selectedProduct = ref(
  props.products.find((p) => p.id === form.product_id) || null
)

// Calculate max quantity allowed based on stock + original sale quantity
const maxQuantity = computed(() => {
  if (!selectedProduct.value) return 1
  // Add back the original sale quantity because stock was decremented before
  return selectedProduct.value.stock + props.sale.quantity
})

const onProductChange = () => {
  selectedProduct.value = props.products.find((p) => p.id === form.product_id) || null
  if (selectedProduct.value && form.quantity > maxQuantity.value) {
    form.quantity = maxQuantity.value
  }
}

const totalPrice = computed(() => {
  if (!selectedProduct.value) return 0
  return (selectedProduct.value.price * form.quantity).toFixed(2)
})

const submit = () => {
  if (!form.customer_id || !form.product_id) {
    alert('Please select customer and product.')
    return
  }
  if (form.quantity < 1) {
    alert('Quantity must be at least 1.')
    return
  }
  if (form.quantity > maxQuantity.value) {
    alert('Not enough stock available.')
    return
  }
  form.put(route('sales.update', props.sale.id))
}
</script>

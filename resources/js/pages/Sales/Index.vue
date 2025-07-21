<template>
  <AppLayout>
    <Head title="Sales" />

    <div class="p-6">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Sales</h1>
        <Link href="/sales/create" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">New Sale</Link>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full border rounded shadow">
          <thead class="bg-gray-100">
            <tr class="text-left">
              <th class="p-2">Customer</th>
              <th class="p-2">Product</th>
              <th class="p-2">Quantity</th>
              <th class="p-2">Total</th>
              <th class="p-2">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="sale in sales" :key="sale.id" class="border-t hover:bg-gray-50">
              <td class="p-2">{{ sale.customer.name }}</td>
              <td class="p-2">{{ sale.product.name }}</td>
              <td class="p-2">{{ sale.quantity }}</td>
              <td class="p-2">${{ sale.total_price }}</td>
              <td class="p-2">
                <Link :href="`/sales/${sale.id}/edit`" class="text-blue-600 hover:underline">Edit</Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({ sales: Array })
</script>

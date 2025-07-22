<template>
  <AppLayout>
    <Head title="Sales" />

    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Sales</h1>
        <Link href="/sales/create"  class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition">New Sale</Link>
      </div>

      <div class="overflow-x-auto">
       <table class="w-full table-auto text-white">
  <thead class="bg-[#1A1F3C] text-white">
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
                <Link :href="`/sales/${sale.id}/edit`" class=" text-[#e10ec2] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition hover:underline">Edit</Link>
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

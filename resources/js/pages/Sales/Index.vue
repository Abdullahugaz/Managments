<template>
  <AppLayout>
    <Head title="Sales" />

    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <!-- Header -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Sales</h1>
        <Link href="/sales/create">
          <BaseButton>
            New Sale
          </BaseButton>
        </Link>
      </div>

      <!-- DataTable -->
      <DataTable :items="salesFormatted" :columns="columns">
        <template #actions="{ item }">
          <Link
            :href="`/sales/${item.id}/edit`"
            class="text-[#e10ec2] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition hover:underline"
          >
            Edit
          </Link>
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import DataTable from '@/components/DataTable.vue'
import BaseButton from '@/components/BaseButton.vue'

const props = defineProps({
  sales: Array,
})

const salesFormatted = props.sales.map(sale => ({
  id: sale.id,
  customer: sale.customer.name,
  product: sale.product.name,
  quantity: sale.quantity,
  total: `$${sale.total_price}`,
}))

const columns = [
  { key: 'customer', label: 'Customer' },
  { key: 'product', label: 'Product' },
  { key: 'quantity', label: 'Quantity' },
  { key: 'total', label: 'Total' },
  { key: 'actions', label: 'Actions' },
]
</script>

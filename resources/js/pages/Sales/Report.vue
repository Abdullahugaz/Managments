<template>
  <AppLayout>
    <Head title="Sales Report" />
    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white" id="printable-area">
      <h1 class="text-xl font-semibold mb-4">Sales Report</h1>

      <!-- Filters -->
      <form @submit.prevent="fetchReport" class="flex flex-wrap gap-4 mb-6">
        <div>
          <label class="block mb-1 font-medium">Start Date</label>
          <input type="date" v-model="filters.start_date" class="border p-2 rounded w-full" />
        </div>
        <div>
          <label class="block mb-1 font-medium">End Date</label>
          <input type="date" v-model="filters.end_date" class="border p-2 rounded w-full" />
        </div>
        <div>
          <label class="block mb-1 font-medium">Customer</label>
          <select v-model="filters.customer_id" class="border p-2 rounded w-full">
            <option value="">All Customers</option>
            <option v-for="c in customers" :key="c.id" :value="c.id">{{ c.name }}</option>
          </select>
        </div>
        <div>
          <label class="block mb-1 font-medium">Product</label>
          <select v-model="filters.product_id" class="border p-2 rounded w-full">
            <option value="">All Products</option>
            <option v-for="p in products" :key="p.id" :value="p.id">{{ p.name }}</option>
          </select>
        </div>
        <div class="self-end">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Filter
          </button>
        </div>
      </form>

      <!-- Print Button -->
      <button
        @click="printReport"
         class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition print:hidden"
      >
        Print Report
      </button>

      <!-- Chart -->
      <canvas id="salesChart" height="100" class="mb-6 print:hidden"></canvas>

      <!-- Sales Table -->
      <table class="w-full border rounded shadow">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2 text-left">Date</th>
            <th class="p-2 text-left">Customer</th>
            <th class="p-2 text-left">Product</th>
            <th class="p-2 text-left">Quantity</th>
            <th class="p-2 text-left">Total Price</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="sale in sales" :key="sale.id" class="border-t">
            <td class="p-2">{{ formatDate(sale.created_at) }}</td>
            <td class="p-2">{{ sale.customer.name }}</td>
            <td class="p-2">{{ sale.product.name }}</td>
            <td class="p-2">{{ sale.quantity }}</td>
            <td class="p-2">${{ formatPrice(sale.total_price) }}</td>
          </tr>
          <tr class="font-semibold border-t bg-gray-100">
            <td colspan="4" class="p-2 text-right">Total Sales:</td>
            <td class="p-2">${{ formatPrice(totalSales) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, watch, onMounted, nextTick } from 'vue'
import Chart from 'chart.js/auto'

// Props
const props = defineProps({
  sales: Array,
  totalSales: Number,
  customers: Array,
  products: Array,
  filters: Object,
})

// Reactive state
const filters = ref({ ...props.filters })
const sales = ref(props.sales)
const totalSales = ref(props.totalSales)
const customers = props.customers
const products = props.products

// Format helpers
const formatPrice = (price) => {
  const n = parseFloat(price)
  return isNaN(n) ? '0.00' : n.toFixed(2)
}
const formatDate = (date) => new Date(date).toLocaleDateString()

// Fetch Report
function fetchReport() {
  router.get(route('sales.report'), filters.value, {
    preserveState: true,
    replace: true,
    onSuccess: () => nextTick(() => renderChart()), // Ensure chart updates after DOM
  })
}

// Chart setup
let salesChart = null

const prepareChartData = () => {
  const grouped = sales.value.reduce((acc, sale) => {
    const date = formatDate(sale.created_at)
    acc[date] = (acc[date] || 0) + sale.total_price
    return acc
  }, {})

  const labels = Object.keys(grouped).sort((a, b) => new Date(a) - new Date(b))
  const data = labels.map(label => grouped[label])

  return { labels, data }
}

const renderChart = () => {
  const ctx = document.getElementById('salesChart')?.getContext('2d')
  if (!ctx) return

  if (salesChart) salesChart.destroy()

  const { labels, data } = prepareChartData()

  salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Sales Total ($)',
        data,
        backgroundColor: 'rgba(59, 130, 246, 0.7)',
      }],
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true },
      },
    },
  })
}

// Print handler
const printReport = () => window.print()

// Lifecycle
onMounted(() => renderChart())
watch(() => props.sales, (newSales) => {
  sales.value = newSales
  nextTick(() => renderChart())
})
</script>

<style>
@media print {
  body * {
    visibility: hidden;
  }
  #printable-area, #printable-area * {
    visibility: visible;
  }
  #printable-area {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }

  .print\\:hidden {
    display: none !important;
  }
}
</style>

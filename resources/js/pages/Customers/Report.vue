<template>
  <AppLayout>
    <Head title="Customer Report" />
    <div class="p-6 max-w-5xl mx-auto bg-white rounded shadow" id="printable-area">
      <h1 class="text-xl font-semibold mb-4">Customer Report</h1>

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
        <div class="self-end">
          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Filter
          </button>
        </div>
      </form>

      <!-- Print Button -->
      <button
        @click="printReport"
        class="mb-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 print:hidden"
      >
        Print Report
      </button>

      <!-- Chart -->
      <canvas id="customerChart" height="100" class="mb-6 print:hidden"></canvas>

      <!-- Customer Table -->
      <table class="w-full border rounded shadow">
        <thead class="bg-gray-200">
          <tr>
            <th class="p-2 text-left">Name</th>
            <th class="p-2 text-left">Email</th>
            <th class="p-2 text-left">Phone</th>
            <th class="p-2 text-left">Total Purchases</th>
            <th class="p-2 text-left">Total Spent</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="customer in customers" :key="customer.id" class="border-t">
            <td class="p-2">{{ customer.name }}</td>
            <td class="p-2">{{ customer.email }}</td>
            <td class="p-2">{{ customer.phone }}</td>
            <td class="p-2">{{ customer.total_orders }}</td>
            <td class="p-2">${{ formatPrice(customer.total_spent) }}</td>
          </tr>
          <tr class="font-semibold border-t bg-gray-100">
            <td colspan="4" class="p-2 text-right">Total Spent (All Customers):</td>
            <td class="p-2">${{ formatPrice(totalSpent) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import { Head, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, onMounted, watch, nextTick } from 'vue'
import Chart from 'chart.js/auto'

// Props
const props = defineProps({
  customers: Array,
  filters: Object,
  totalSpent: Number,
})

// Reactive state
const customers = ref(props.customers)
const filters = ref({ ...props.filters })
const totalSpent = ref(props.totalSpent)

// Format helpers
const formatPrice = (price) => {
  const n = parseFloat(price)
  return isNaN(n) ? '0.00' : n.toFixed(2)
}

// Fetch Report
function fetchReport() {
  router.get(route('customers.report'), filters.value, {
    preserveState: true,
    replace: true,
    onSuccess: () => nextTick(() => renderChart()),
  })
}

// Chart setup
let customerChart = null

const prepareChartData = () => {
  const labels = customers.value.map(c => c.name)
  const data = customers.value.map(c => c.total_spent)

  return { labels, data }
}

const renderChart = () => {
  const ctx = document.getElementById('customerChart')?.getContext('2d')
  if (!ctx) return

  if (customerChart) customerChart.destroy()

  const { labels, data } = prepareChartData()

  customerChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Total Spent ($)',
        data,
        backgroundColor: 'rgba(34, 197, 94, 0.7)',
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

// Print
const printReport = () => window.print()

// Lifecycle
onMounted(() => renderChart())
watch(() => props.customers, (newCustomers) => {
  customers.value = newCustomers
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

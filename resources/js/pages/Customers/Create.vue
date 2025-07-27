<template>
  <AppLayout>
    <Head title="Create Customer" />
    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-black">
      <h2 class="text-xl font-semibold mb-6">New Customer</h2>

      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Left column -->
          <div>
            <label class="block mb-1">Name</label>
            <input
              v-model="form.name"
              type="text"
              class="w-full border px-3 py-2 rounded"
            />
          </div>

          <div>
            <label class="block mb-1">Email</label>
            <input
              v-model="form.email"
              type="email"
              class="w-full border px-3 py-2 rounded"
            />
          </div>

          <!-- Right column -->
          <div class="md:col-span-2">
            <label class="block mb-1">Phone</label>
            <input
              v-model="form.phone"
              type="text"
              class="w-full border px-3 py-2 rounded"
            />
          </div>
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


<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const form = useForm({
  name: '',
  email: '',
  phone: '',
})

function submit() {
  form.post('/customers')
}
</script>

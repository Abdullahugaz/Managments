<template>
  <AppLayout>
    <Head title="Edit Customer" />
    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-white">
      <h2 class="text-2xl font-semibold mb-6">Edit Customer</h2>

      <form @submit.prevent="submit" class="space-y-6 max-w-none">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 w-full">
          <!-- Left column: Name and Email stacked -->
          <div class="flex flex-col space-y-4 w-full">
            <div>
              <label class="block text-sm font-medium mb-1">Name</label>
              <input
                v-model="form.name"
                type="text"
                class="w-full border border-gray-300 rounded px-4 py-2"
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Email</label>
              <input
                v-model="form.email"
                type="email"
                class="w-full border border-gray-300 rounded px-4 py-2"
              />
            </div>
          </div>

          <!-- Right column: Phone -->
          <div class="w-full">
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input
              v-model="form.phone"
              type="text"
              class="w-full border border-gray-300 rounded px-4 py-2"
            />
          </div>
        </div>

        <button
          type="submit"
 class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition"
        >
          Update
        </button>
      </form>
    </div>
  </AppLayout>
</template>


<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const props = defineProps<{
  customer: {
    id: number
    name: string
    email: string
    phone: string
  }
}>()

const form = useForm({
  name: props.customer.name,
  email: props.customer.email,
  phone: props.customer.phone,
})

function submit() {
  form.put(`/customers/${props.customer.id}`)
}
</script>

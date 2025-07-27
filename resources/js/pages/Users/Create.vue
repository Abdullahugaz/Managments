<template>
  <AppLayout>
    <Head title="Create User" />
<div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-black">
      <div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-semibold mb-6">Create User</h2>
</div>
    <form @submit.prevent="submit" class="space-y-4 max-w-xl">
      <input
        v-model="form.name"
        type="text"
        placeholder="Name"
        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
      />

      <input
        v-model="form.email"
        type="email"
        placeholder="Email"
        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
      />

      <input
        v-model="form.phone"
        type="text"
        placeholder="Phone"
        class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
      />

     <input
  v-model="form.password"
  type="password"
  placeholder="Password"
  required
  class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
/>


      <button
        type="submit"
         class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition"
      >
        Submit
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
  email: '',
  phone: '',
  password: ''
})

const submit = () => {
  form.post('/users')
}
</script>

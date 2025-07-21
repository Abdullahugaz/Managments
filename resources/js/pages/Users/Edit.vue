<template>
  <AppLayout>
    <Head title="Edit User" />
     <div class="p-6">
      <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-semibold mb-6">Edit User</h2>
</div>
      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block mb-1">Name</label>
            <input
              v-model="form.name"
              type="text"
              class="w-full border px-3 py-2 rounded"
              required
            />
          </div>

          <div>
            <label class="block mb-1">Email</label>
            <input
              v-model="form.email"
              type="email"
              class="w-full border px-3 py-2 rounded"
              required
            />
          </div>

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
          class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition"
          :disabled="form.processing"
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
  user: {
    id: number
    name: string
    email: string
    phone: string
  }
}>()

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  phone: props.user.phone,
})

function submit() {
  form.put(route('users.update', props.user.id))
}
</script>

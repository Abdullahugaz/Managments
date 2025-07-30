<template>
  <AppLayout>
    <Head title="Create Customer" />
    <div class="p-6 min-h-screen bg-gradient-to-br from-[#e45fed] to-[#5739ed] text-black">
      <h2 class="text-xl font-semibold mb-6">New Customer</h2>

      <form @submit.prevent="submit" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Name -->
          <InputField
            v-model="form.name"
            label="Name"
            type="text"
            :error="form.errors.name"
          />

          <!-- Email -->
          <InputField
            v-model="form.email"
            label="Email"
            type="email"
            :error="form.errors.email"
          />

          <!-- Phone -->
          <InputField
            v-model="form.phone"
            label="Phone"
            type="text"
            class="md:col-span-2"
            :error="form.errors.phone"
          />

          <!-- Status Select -->
          <SelectBox
            v-model="form.status"
            label="Status"
            :options="[
              { label: 'Draft', value: 'draft' },
              { label: 'Submit', value: 'submit' }
            ]"
            class="md:col-span-2"
            :error="form.errors.status"
          />

          <!-- Date picker -->
          <InputField
            v-model="form.date"
            label="Registration Date"
            type="date"
            class="md:col-span-2"
            :error="form.errors.date"
          />
        </div>

        <BaseButton
          type="submit"
          class="bg-white text-[#7A5FFF] font-semibold px-5 py-2 rounded-full shadow hover:bg-[#fbe6ff] transition"
        >
          Create
        </BaseButton>
      </form>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { useForm, Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import InputField from '@/components/InputField.vue'
import SelectBox from '@/components/SelectBox.vue'
import BaseButton from '@/components/BaseButton.vue'

const form = useForm({
  name: '',
  email: '',
  phone: '',
  status: 'draft',                      // default status
  date: new Date().toISOString().slice(0, 10), // default to today
})

function submit() {
  form.post('/customers')
}
</script>

<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<template>
  <div class="min-h-screen grid md:grid-cols-2 bg-white">
    <!-- Left Side: Logo or Illustration -->
    <div class="hidden md:flex items-center justify-center bg-gradient-to-br from-[#7A5FFF] to-[#FF57B2] text-white p-10">
      <img src="/images/yiksi.png" alt="Logo" class="w-3/4 max-w-sm" />
    </div>

    <!-- Right Side: Login Form -->
    <div class="flex items-center justify-center   p-6">
      
      <div class="w-full max-w-md">
       <div class="flex items-center justify-center h-20">
  <img src="/images/yiksi.png" alt="Logo" class="w-30 h-30" />
</div>

        <Head title="Log in" />
        <h2 class="text-3xl font-bold text-center mb-2">Welcome Back</h2>
        <p class="text-center text-gray-500 mb-6">Enter your email and password to sign in</p>

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
          {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <Label for="email">Email</Label>
            <Input
              id="email"
              type="email"
              required
              v-model="form.email"
              autocomplete="email"
              class="mt-1"
              placeholder="you@example.com"
            />
            <InputError :message="form.errors.email" />
          </div>

          <div>
            <Label for="password" class="flex justify-between items-center">
              Password
              <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm text-blue-600 hover:underline">
                Forgot?
              </TextLink>
            </Label>
            <Input
              id="password"
              type="password"
              required
              v-model="form.password"
              autocomplete="current-password"
              class="mt-1"
              placeholder="••••••••"
            />
            <InputError :message="form.errors.password" />
          </div>

          <div class="flex items-center space-x-2">
            <Checkbox id="remember" v-model="form.remember" />
            <Label for="remember">Remember me</Label>
          </div>

          <Button class="w-full bg-pink-600 •	hover:bg-blue-900 " :disabled="form.processing">
            <LoaderCircle v-if="form.processing" class="w-4 h-4 animate-spin mr-2" />
            Log in
          </Button>
        </form>
      </div>
    </div>
  </div>
</template>

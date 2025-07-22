<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
</script>

<template>
  <div class="flex items-center">
    <!-- Icon background same as sidebar bg -->
    <div
      class="flex aspect-square w-8 h-8 items-center justify-center rounded-md"
      style="background-color: #fff;"
    >
      <AppLogoIcon class="w-5 h-5 fill-current text-white" />
    </div>

    <!-- Text label with white color -->
    <div class="ml-2 flex-1 text-left text-sm text-black">
      <span class="mb-0.5 truncate leading-tight font-semibold">Product Management</span>
    </div>
  </div>
</template>

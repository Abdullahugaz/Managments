<script setup lang="ts">
import {
  SidebarGroup,
  SidebarGroupLabel,
  SidebarMenu,
  SidebarMenuButton,
  SidebarMenuItem
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';

defineProps<{
  items: NavItem[];
}>();

const page = usePage();
</script>

<template>
  <SidebarGroup class="px-2 py-1">
    <SidebarGroupLabel class="text-sm text-white/70 uppercase tracking-wide mb-1">Platform</SidebarGroupLabel>

    <SidebarMenu>
      <SidebarMenuItem
        v-for="item in items"
        :key="item.href"
        class="rounded-lg"
      >
        <SidebarMenuButton
          as-child
          :is-active="page.url.startsWith(item.href)"
          :tooltip="item.title"
          class="group w-full px-4 py-2 flex items-center gap-3 text-white hover:bg-pink-600 hover:text-white transition rounded-lg"
        >
          <Link :href="item.href" class="flex items-center gap-3">
            <component :is="item.icon" class="w-5 h-5" />
            <span class="text-sm">{{ item.title }}</span>
          </Link>
        </SidebarMenuButton>
      </SidebarMenuItem>
    </SidebarMenu>
  </SidebarGroup>
</template>

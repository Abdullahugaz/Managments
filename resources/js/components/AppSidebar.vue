<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
  Sidebar, SidebarContent, SidebarFooter,
  SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem
} from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import {
  BookOpen, Folder, LayoutGrid,
  Users, ShoppingCart, Boxes, UserPlus
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: '/dashboard',
    icon: LayoutGrid,
  },
  {
    title: 'Customers',
    href: '/customers',
    icon: Users,
  },
  {
    title: 'Sales',
    href: '/sales',
    icon: ShoppingCart,
  },
  {
    title: 'Products',
    href: '/products',
    icon: Boxes,
  },
  {
    title: 'Create Users',
    href: '/users',
    icon: UserPlus,
  },
  {
    title: 'Sales Report',
    href: '/reports/reportsales',
    icon: Folder,
  },
  {
    title: 'Customer Report',
    href: '/reports/report',
    icon: BookOpen,
  },
];
</script>

<template>
  <Sidebar collapsible="icon" variant="inset" class="bg-[#0A005F] text-white min-h-screen">
    <!-- Sidebar Header -->
    <SidebarHeader class="border-b border-[#1A1A7F]">
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="route('dashboard')">
              <AppLogo class="w-10 h-10 text-pink-400" />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <!-- Main Menu -->
    <SidebarContent class="bg-[#0A005F]">
      <NavMain :items="mainNavItems" />
    </SidebarContent>

    <!-- Footer -->
    <SidebarFooter class="border-t border-[#1A1A7F]">
      <NavUser />
    </SidebarFooter>
  </Sidebar>

  <!-- Main Content Slot -->
  <slot />
</template>

<style scoped>
/* Optional: Custom scrollbars or transitions */
</style>

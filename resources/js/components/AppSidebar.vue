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
import Profile from '@/pages/settings/Profile.vue';

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
        href: '/sales/report',
        icon: Folder,
    },
    {
        title: 'Customer Report',
        href: '/customers/report',
        icon: BookOpen,
    },
    // {
    //     title: 'customer Profile',
    //     href: '/customer/profile',
    //     icon: Folder,
    // }
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

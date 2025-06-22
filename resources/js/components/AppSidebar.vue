<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Shield, Settings, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

interface PageProps {
    auth: {
        user?: {
            role: string;
            // Ajoutez ici d'autres propriétés utilisateur si nécessaire
        };
    };
}

const { props } = usePage<PageProps>();
const userRole = props.auth?.user?.role || 'user';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
];

const adminNavItems: NavItem[] = [
    {
        title: 'Manager Users',
        href: '/admin/users',
        icon: Settings,
    },
];

const superAdminNavItems: NavItem[] = [
    {
        title: 'System Controls',
        href: '/superadmin/system',
        icon: Shield,
    },
];

let roleBasedNavItems = [...mainNavItems];

if (userRole === 'admin') {
    roleBasedNavItems = [...roleBasedNavItems, ...adminNavItems];
}
if (userRole === 'superadmin') {
    roleBasedNavItems = [...roleBasedNavItems, ...adminNavItems, ...superAdminNavItems];
}

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
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
            <NavMain :items="roleBasedNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" className="mt-auto" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

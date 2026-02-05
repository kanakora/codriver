<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    BookOpen,
    Folder,
    LayoutGrid,
    FileText,
    Tag,
    Users,
    ShieldCheck,
} from 'lucide-vue-next';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { route } from 'ziggy-js';
import AppLogo from './AppLogo.vue';
import { useAuthRoles } from '@/composables/useAuthRoles';

const {
    isAdmin,
    isStudent,
    canManageContent,
    canManageCategories,
    canManageCollections,
    canViewCollections,
} =
    useAuthRoles();

const dashboardItem = computed(() => {
    if (isAdmin()) {
        return {
            title: 'Admin Dashboard',
            href: route('admin.dashboard'),
            icon: LayoutGrid,
        };
    }

    if (isStudent()) {
        return {
            title: 'Student Dashboard',
            href: route('student.dashboard'),
            icon: LayoutGrid,
        };
    }

    return {
        title: 'Dashboard',
        href: route('dashboard'),
        icon: LayoutGrid,
    };
});

const mainNavItems = computed(() => {
    const items = [dashboardItem.value];

    if (isAdmin() || canManageContent()) {
        items.push({
            title: 'Content',
            href: route('admin.contents.index'),
            icon: FileText,
        });
    }

    if (isAdmin() || canManageCollections()) {
        items.push({
            title: 'Collections',
            href: route('admin.collections.index'),
            icon: BookOpen,
        });
    } else if (isStudent() || canViewCollections()) {
        items.push({
            title: 'Collections',
            href: route('student.collections.index'),
            icon: BookOpen,
        });
    }

    if (isAdmin() || canManageCategories()) {
        items.push({
            title: 'Categories',
            href: route('admin.categories.index'),
            icon: Tag,
        });
    }

    if (isAdmin()) {
        items.push(
            {
                title: 'Users',
                href: route('admin.users.index'),
                icon: Users,
            },
            {
                title: 'Roles',
                href: route('admin.roles.index'),
                icon: ShieldCheck,
            },
        );
    }

    return items;
});

const footerNavItems = [
    {
        title: 'Github Repo',
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
                        <Link :href="dashboardItem.href">
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
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

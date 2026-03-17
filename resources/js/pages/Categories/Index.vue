<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useAuthRoles } from '@/composables/useAuthRoles';
import { route } from 'ziggy-js';
import type { Category } from '@/types';

const props = defineProps<{
    categories: {
        data: Category[];
        links: Array<{
            url: string | null;
            label: string;
            active: boolean;
        }>;
        current_page: number;
        last_page: number;
        from: number;
        to: number;
        total: number;
    };
}>();

const { canManageCategories } = useAuthRoles();

function handleDelete(category: Category) {
    if (
        confirm(
            `Are you sure you want to delete "${category.name}"? This will not delete associated content.`,
        )
    ) {
        router.delete(
            route('admin.categories.destroy', { category: category.id }),
        );
    }
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Category Management',
        href: route('admin.categories.index'),
    },
];
</script>

<template>
    <Head title="Category Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <!-- Header with create button -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        Category Management
                    </h1>
                    <p class="text-muted-foreground">
                        Organize content into categories for better navigation
                    </p>
                </div>
                <Button as-child v-if="canManageCategories()">
                    <Link :href="route('admin.categories.create')">
                        Create New Category
                    </Link>
                </Button>
            </div>

            <!-- Categories Table -->
            <Card>
                <CardContent class="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Slug</TableHead>
                                <TableHead>Description</TableHead>
                                <TableHead>Created</TableHead>
                                <TableHead class="text-right"
                                    >Actions</TableHead
                                >
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="category in categories.data"
                                :key="category.id"
                            >
                                <TableCell class="font-medium">
                                    {{ category.name }}
                                </TableCell>
                                <TableCell class="font-mono text-sm">
                                    {{ category.slug }}
                                </TableCell>
                                <TableCell class="text-muted-foreground">
                                    {{
                                        category.description || 'No description'
                                    }}
                                </TableCell>
                                <TableCell
                                    class="text-sm text-muted-foreground"
                                >
                                    {{
                                        new Date(
                                            category.created_at,
                                        ).toLocaleDateString()
                                    }}
                                </TableCell>
                                <TableCell class="text-right">
                                    <DropdownMenu>
                                        <DropdownMenuTrigger as-child>
                                            <Button variant="ghost" size="sm">
                                                Actions
                                            </Button>
                                        </DropdownMenuTrigger>
                                        <DropdownMenuContent align="end">
                                            <DropdownMenuItem
                                                as-child
                                                v-if="canManageCategories()"
                                            >
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.categories.edit',
                                                            {
                                                                category:
                                                                    category.id,
                                                            },
                                                        )
                                                    "
                                                >
                                                    Edit
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem
                                                v-if="canManageCategories()"
                                                @click="handleDelete(category)"
                                                class="text-destructive"
                                            >
                                                Delete
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="categories.data.length === 0">
                                <TableCell
                                    colspan="5"
                                    class="py-8 text-center text-muted-foreground"
                                >
                                    No categories found.
                                    <Link
                                        v-if="canManageCategories()"
                                        :href="route('admin.categories.create')"
                                        class="text-primary hover:underline"
                                    >
                                        Create your first category
                                    </Link>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>

            <!-- Pagination -->
            <div class="flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Showing {{ categories.from }} to {{ categories.to }} of
                    {{ categories.total }} results
                </div>
                <div class="flex gap-2">
                    <template
                        v-for="link in categories.links"
                        :key="link.label"
                    >
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            class="rounded-md px-3 py-2 text-sm font-medium"
                            :class="
                                link.active
                                    ? 'bg-primary text-primary-foreground'
                                    : 'bg-background hover:bg-accent'
                            "
                            preserve-state
                            preserve-scroll
                        >
                            <span v-html="link.label" />
                        </Link>
                        <span
                            v-else
                            class="px-3 py-2 text-muted-foreground"
                            v-html="link.label"
                        />
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

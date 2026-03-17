<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
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
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useAuthRoles } from '@/composables/useAuthRoles';
import { route } from 'ziggy-js';
import type { Lesson, Category } from '@/types';

const props = defineProps<{
    lessons: {
        data: Lesson[];
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
    categories: Category[];
    filters: {
        search?: string;
        category?: string;
        status?: string;
    };
}>();

const { isAdmin, canManageLessons } = useAuthRoles();

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');
const status = ref(props.filters.status || '');

const debouncedSearch = useDebounceFn(() => {
    router.get(
        route('admin.lessons.index'),
        {
            search: search.value,
            category: category.value,
            status: status.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
}, 300);

watch([search, category, status], () => {
    debouncedSearch();
});

function handleDelete(lesson: Lesson) {
    if (confirm(`Are you sure you want to delete "${lesson.title}"?`)) {
        router.delete(route('admin.lessons.destroy', { lesson: lesson.id }));
    }
}

function getLessonTypeBadgeVariant(type: Lesson['content_type']) {
    switch (type) {
        case 'text':
            return 'default';
        case 'pdf':
            return 'secondary';
        case 'video':
            return 'outline';
        case 'link':
            return 'destructive';
        default:
            return 'default';
    }
}

function getLessonStatus(lesson: Lesson) {
    const now = new Date();

    if (lesson.archived_at) {
        return { label: 'Archived', variant: 'destructive' };
    }

    if (lesson.expires_at && new Date(lesson.expires_at) <= now) {
        return { label: 'Expired', variant: 'destructive' };
    }

    if (lesson.publish_status === 'published') {
        return { label: 'Active', variant: 'default' };
    }

    if (
        lesson.scheduled_publish_at &&
        new Date(lesson.scheduled_publish_at) > now
    ) {
        return { label: 'Scheduled', variant: 'secondary' };
    }

    return { label: 'Draft', variant: 'outline' };
}

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Lesson Management',
        href: route('admin.lessons.index'),
    },
];
</script>

<template>
    <Head title="Lesson Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <!-- Header with title and create button -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        Content Management
                    </h1>
                    <p class="text-muted-foreground">
                        Manage your e-learning content (text, PDFs, videos,
                        links)
                    </p>
                </div>
                <Button as-child v-if="canManageLessons()">
                    <Link :href="route('admin.lessons.create')">
                        Create New Content
                    </Link>
                </Button>
            </div>

            <!-- Filters -->
            <Card>
                <CardHeader>
                    <CardTitle>Filters</CardTitle>
                </CardHeader>
                <CardContent class="grid gap-4 md:grid-cols-3">
                    <div class="space-y-2">
                        <Label for="search">Search</Label>
                        <Input
                            id="search"
                            v-model="search"
                            placeholder="Search by title or description..."
                            type="search"
                        />
                    </div>
                    <div class="space-y-2">
                        <Label for="category">Category</Label>
                        <select
                            id="category"
                            v-model="category"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
                        >
                            <option value="">All categories</option>
                            <option
                                v-for="cat in categories"
                                :key="cat.id"
                                :value="cat.id"
                            >
                                {{ cat.name }}
                            </option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <Label for="status">Status</Label>
                        <select
                            id="status"
                            v-model="status"
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 focus-visible:outline-none"
                        >
                            <option value="">All statuses</option>
                            <option value="draft">Draft</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="active">Active</option>
                            <option value="expired">Expired</option>
                            <option value="archived">Archived</option>
                        </select>
                    </div>
                </CardContent>
            </Card>

            <!-- Content Table -->
            <Card>
                <CardContent class="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Title</TableHead>
                                <TableHead>Type</TableHead>
                                <TableHead>Categories</TableHead>
                                <TableHead>Status</TableHead>
                                <TableHead>Author</TableHead>
                                <TableHead>Created</TableHead>
                                <TableHead class="text-right"
                                    >Actions</TableHead
                                >
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow
                                v-for="lesson in lessons.data"
                                :key="lesson.id"
                            >
                                <TableCell class="font-medium">
                                    <Link
                                        :href="
                                            route('admin.lessons.show', {
                                                lesson: lesson.slug,
                                            })
                                        "
                                        class="hover:text-primary hover:underline"
                                    >
                                        {{ lesson.title }}
                                    </Link>
                                    <p
                                        class="line-clamp-1 text-sm text-muted-foreground"
                                    >
                                        {{ lesson.description }}
                                    </p>
                                </TableCell>
                                <TableCell>
                                    <Badge
                                        :variant="
                                            getLessonTypeBadgeVariant(
                                                lesson.content_type,
                                            )
                                        "
                                    >
                                        {{ lesson.content_type }}
                                    </Badge>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-wrap gap-1">
                                        <Badge
                                            v-for="cat in lesson.categories"
                                            :key="cat.id"
                                            variant="outline"
                                            class="text-xs"
                                        >
                                            {{ cat.name }}
                                        </Badge>
                                        <span
                                            v-if="!lesson.categories?.length"
                                            class="text-sm text-muted-foreground"
                                        >
                                            No categories
                                        </span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="space-y-1">
                                        <Badge
                                            :variant="
                                                getLessonStatus(lesson).variant
                                            "
                                        >
                                            {{ getLessonStatus(lesson).label }}
                                        </Badge>
                                        <p
                                            v-if="lesson.scheduled_publish_at"
                                            class="text-xs text-muted-foreground"
                                        >
                                            Scheduled:
                                            {{
                                                new Date(
                                                    lesson.scheduled_publish_at,
                                                ).toLocaleDateString()
                                            }}
                                        </p>
                                        <p
                                            v-if="lesson.expires_at"
                                            class="text-xs text-muted-foreground"
                                        >
                                            Expires:
                                            {{
                                                new Date(
                                                    lesson.expires_at,
                                                ).toLocaleDateString()
                                            }}
                                        </p>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    {{ lesson.author?.name || 'Unknown' }}
                                </TableCell>
                                <TableCell
                                    class="text-sm text-muted-foreground"
                                >
                                    {{
                                        new Date(
                                            lesson.created_at,
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
                                            <DropdownMenuItem as-child>
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.lessons.show',
                                                            {
                                                                lesson: lesson.id,
                                                            },
                                                        )
                                                    "
                                                >
                                                    View
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem
                                                v-if="canManageLessons()"
                                                as-child
                                            >
                                                <Link
                                                    :href="
                                                        route(
                                                            'admin.lessons.edit',
                                                            {
                                                                lesson: lesson.id,
                                                            },
                                                        )
                                                    "
                                                >
                                                    Edit
                                                </Link>
                                            </DropdownMenuItem>
                                            <DropdownMenuItem
                                                v-if="canManageLessons()"
                                                @click="handleDelete(lesson)"
                                                class="text-destructive"
                                            >
                                                Delete
                                            </DropdownMenuItem>
                                        </DropdownMenuContent>
                                    </DropdownMenu>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="lessons.data.length === 0">
                                <TableCell
                                    colspan="7"
                                    class="py-8 text-center text-muted-foreground"
                                >
                                    No content found.
                                    <Link
                                        v-if="canManageLessons()"
                                        :href="route('admin.lessons.create')"
                                        class="text-primary hover:underline"
                                    >
                                        Create your first content
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
                    Showing {{ lessons.from }} to {{ lessons.to }} of
                    {{ lessons.total }} results
                </div>
                <div class="flex gap-2">
                    <template v-for="link in lessons.links" :key="link.label">
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

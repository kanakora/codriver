<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import AppLayout from '@/layouts/AppLayout.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useAuthRoles } from '@/composables/useAuthRoles';
import { route } from 'ziggy-js';
import type { Content, Category } from '@/types';

const props = defineProps<{
    contents: {
        data: Content[];
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
    };
}>();

const { isStudent } = useAuthRoles();

const search = ref(props.filters.search || '');
const category = ref(props.filters.category || '');

const debouncedSearch = useDebounceFn(() => {
    router.get(
        route('student.contents.index'),
        {
            search: search.value,
            category: category.value,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
}, 300);

watch([search, category], () => {
    debouncedSearch();
});

function getContentTypeBadgeVariant(type: Content['content_type']) {
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

const breadcrumbs = [
    {
        title: 'Student Dashboard',
        href: route('student.dashboard'),
    },
    {
        title: 'Content Library',
        href: route('student.contents.index'),
    },
];
</script>

<template>
    <Head title="Content Library" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <section
                class="rounded-2xl border border-border/60 bg-linear-to-br from-blue-50 via-white to-sky-50 p-6 shadow-sm dark:border-border dark:from-slate-950 dark:via-slate-950 dark:to-slate-900"
            >
                <div class="space-y-2">
                    <p class="text-sm font-medium text-muted-foreground">
                        Student library
                    </p>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        Explore your courses
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Find the latest published lessons, resources, and
                        study materials.
                    </p>
                </div>
            </section>

            <!-- Filters -->
            <Card>
                <CardHeader>
                    <CardTitle>Find your next lesson</CardTitle>
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
                    <div class="hidden items-end md:flex">
                        <div class="text-sm text-muted-foreground">
                            {{ contents.total }} published resources
                        </div>
                    </div>
                </CardContent>
            </Card>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <Card
                    v-for="content in contents.data"
                    :key="content.id"
                    class="flex h-full flex-col"
                >
                    <CardHeader class="space-y-3">
                        <div class="flex items-center justify-between">
                            <Badge
                                :variant="
                                    getContentTypeBadgeVariant(
                                        content.content_type,
                                    )
                                "
                            >
                                {{ content.content_type }}
                            </Badge>
                            <span class="text-xs text-muted-foreground">
                                {{
                                    content.published_at
                                        ? new Date(
                                              content.published_at,
                                          ).toLocaleDateString()
                                        : 'Recently added'
                                }}
                            </span>
                        </div>
                        <div>
                            <Link
                                :href="
                                    route('student.contents.show', {
                                        content: content.id,
                                    })
                                "
                                class="text-lg font-semibold hover:text-primary"
                            >
                                {{ content.title }}
                            </Link>
                            <p class="mt-1 text-sm text-muted-foreground">
                                {{ content.description || 'No description' }}
                            </p>
                        </div>
                    </CardHeader>
                    <CardContent class="mt-auto space-y-3">
                        <div class="flex flex-wrap gap-1">
                            <Badge
                                v-for="cat in content.categories"
                                :key="cat.id"
                                variant="outline"
                                class="text-xs"
                            >
                                {{ cat.name }}
                            </Badge>
                            <span
                                v-if="!content.categories?.length"
                                class="text-xs text-muted-foreground"
                            >
                                No categories
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-muted-foreground">
                                By {{ content.author?.name || 'Unknown' }}
                            </span>
                            <Link
                                :href="
                                    route('student.contents.show', {
                                        content: content.id,
                                    })
                                "
                                class="text-sm font-medium text-primary hover:underline"
                            >
                                Open lesson
                            </Link>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <Card v-if="contents.data.length === 0">
                <CardContent class="py-12 text-center text-muted-foreground">
                    No published content found.
                </CardContent>
            </Card>

            <!-- Pagination -->
            <div class="flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Showing {{ contents.from }} to
                    {{ contents.to }} of {{ contents.total }} results
                </div>
                <div class="flex gap-2">
                    <template v-for="link in contents.links" :key="link.label">
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

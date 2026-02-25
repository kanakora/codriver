<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { useDebounceFn } from '@vueuse/core';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useAuthRoles } from '@/composables/useAuthRoles';
import { route } from 'ziggy-js';

const props = defineProps<{
    classrooms: {
        data: Array<{
            id: number;
            title: string;
            slug: string;
            description?: string | null;
            is_public: boolean;
            sort_order: number;
            lessons_count: number;
            prerequisite?: { id: number; title: string } | null;
        }>;
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
    filters: {
        search?: string;
    };
}>();

const { canManageClassRooms } = useAuthRoles();

const search = ref(props.filters.search || '');

const debouncedSearch = useDebounceFn(() => {
    router.get(
        route('admin.classrooms.index'),
        { search: search.value },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        },
    );
}, 300);

watch(search, () => {
    debouncedSearch();
});

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Classes',
        href: route('admin.classrooms.index'),
    },
];
</script>

<template>
    <Head title="Classes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight">
                        Learning Classes
                    </h1>
                    <p class="text-muted-foreground">
                        Group related content into guided learning paths.
                    </p>
                </div>
                <Button v-if="canManageClassRooms()" as-child>
                    <Link :href="route('admin.classrooms.create')">
                        Create class
                    </Link>
                </Button>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>Search</CardTitle>
                </CardHeader>
                <CardContent class="grid gap-4 md:grid-cols-2">
                    <div class="space-y-2">
                        <Label for="search">Search classes</Label>
                        <Input
                            id="search"
                            v-model="search"
                            placeholder="Search by title or description..."
                            type="search"
                        />
                    </div>
                    <div class="hidden items-end md:flex">
                        <div class="text-sm text-muted-foreground">
                            {{ classrooms.total }} total classes
                        </div>
                    </div>
                </CardContent>
            </Card>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                <Card
                    v-for="classroom in classrooms.data"
                    :key="classroom.id"
                    class="flex h-full flex-col"
                >
                    <CardHeader class="space-y-3">
                        <div class="flex items-center justify-between">
                            <Badge
                                :variant="
                                    classroom.is_public
                                        ? 'default'
                                        : 'outline'
                                "
                            >
                                {{ classroom.is_public ? 'Public' : 'Internal' }}
                            </Badge>
                            <span class="text-xs text-muted-foreground">
                                Order #{{ classroom.sort_order }}
                            </span>
                        </div>
                        <div>
                            <Link
                                :href="
                                    route('admin.classrooms.show', {
                                        classroom: classroom.id,
                                    })
                                "
                                class="text-lg font-semibold hover:text-primary"
                            >
                                {{ classroom.title }}
                            </Link>
                            <p class="mt-1 text-sm text-muted-foreground">
                                {{ classroom.description || 'No description' }}
                            </p>
                        </div>
                    </CardHeader>
                    <CardContent class="mt-auto space-y-3">
                        <div class="flex items-center justify-between text-xs text-muted-foreground">
                            <span>{{ classroom.lessons_count }} items</span>
                            <span v-if="classroom.prerequisite">
                                Requires {{ classroom.prerequisite.title }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <Link
                                :href="
                                    route('admin.classrooms.show', {
                                        classroom: classroom.id,
                                    })
                                "
                                class="text-sm font-medium text-primary hover:underline"
                            >
                                View classroom
                            </Link>
                            <Link
                                v-if="canManageClassRooms()"
                                :href="
                                    route('admin.classrooms.edit', {
                                        classroom: classroom.id,
                                    })
                                "
                                class="text-sm text-muted-foreground hover:text-primary"
                            >
                                Edit
                            </Link>
                        </div>
                    </CardContent>
                </Card>
            </div>

            <Card v-if="classrooms.data.length === 0">
                <CardContent class="py-12 text-center text-muted-foreground">
                    No classes found.
                </CardContent>
            </Card>

            <div class="flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Showing {{ classrooms.from }} to
                    {{ classrooms.to }} of {{ classrooms.total }} results
                </div>
                <div class="flex gap-2">
                    <template v-for="link in classrooms.links" :key="link.label">
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

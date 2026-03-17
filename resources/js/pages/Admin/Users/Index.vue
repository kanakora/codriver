<script setup lang="ts">
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { reactive, watch } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { route } from 'ziggy-js';

type Role = {
    id: number;
    name: string;
};

type UserRow = {
    id: number;
    name: string;
    email: string;
    created_at: string;
    roles: Role[];
};

const props = defineProps<{
    users: {
        data: UserRow[];
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
    roles: Role[];
}>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    roles: [] as number[],
});

const roleSelections = reactive<Record<number, number[]>>({});

watch(
    () => props.users.data,
    (users) => {
        users.forEach((user) => {
            roleSelections[user.id] = user.roles.map((role) => role.id);
        });
    },
    { immediate: true },
);

function updateRoles(userId: number) {
    router.put(
        route('admin.users.update', { user: userId }),
        {
            roles: roleSelections[userId],
        },
        {
            preserveScroll: true,
        },
    );
}

function createUser() {
    form.post(route('admin.users.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
}

const breadcrumbs = [
    {
        title: 'Admin Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Users',
        href: route('admin.users.index'),
    },
];
</script>

<template>
    <Head title="User Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">
                    User Management
                </h1>
                <p class="text-sm text-muted-foreground">
                    Assign roles to control who can manage content and
                    categories.
                </p>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>Create a new user</CardTitle>
                </CardHeader>
                <CardContent>
                    <form class="grid gap-6" @submit.prevent="createUser">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                placeholder="John Doe"
                            />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="email">Email</Label>
                            <Input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="john@example.com"
                            />
                            <InputError :message="form.errors.email" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="password">Password</Label>
                            <Input
                                id="password"
                                v-model="form.password"
                                type="password"
                                placeholder="••••••••"
                            />
                            <InputError :message="form.errors.password" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="password_confirmation"
                                >Confirm Password</Label
                            >
                            <Input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="••••••••"
                            />
                            <InputError
                                :message="form.errors.password_confirmation"
                            />
                        </div>

                        <div class="grid gap-3">
                            <Label>Roles</Label>
                            <select
                                v-model="form.roles"
                                multiple
                                class="min-h-[6.5rem] w-full rounded-md border border-input bg-background px-2 py-2 text-sm"
                            >
                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.id"
                                >
                                    {{ role.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.roles" />
                        </div>

                        <div>
                            <Button type="submit" :disabled="form.processing">
                                Create user
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>Users</CardTitle>
                </CardHeader>
                <CardContent class="p-0">
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>User</TableHead>
                                <TableHead>Roles</TableHead>
                                <TableHead>Assign roles</TableHead>
                                <TableHead class="text-right"
                                    >Actions</TableHead
                                >
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="user in users.data" :key="user.id">
                                <TableCell>
                                    <div class="font-medium">
                                        {{ user.name }}
                                    </div>
                                    <div class="text-sm text-muted-foreground">
                                        {{ user.email }}
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <div class="flex flex-wrap gap-1">
                                        <Badge
                                            v-for="role in user.roles"
                                            :key="role.id"
                                            variant="outline"
                                            class="text-xs"
                                        >
                                            {{ role.name }}
                                        </Badge>
                                        <span
                                            v-if="!user.roles.length"
                                            class="text-xs text-muted-foreground"
                                        >
                                            No roles
                                        </span>
                                    </div>
                                </TableCell>
                                <TableCell>
                                    <select
                                        v-model="roleSelections[user.id]"
                                        multiple
                                        class="min-h-[6.5rem] w-full rounded-md border border-input bg-background px-2 py-2 text-sm"
                                    >
                                        <option
                                            v-for="role in roles"
                                            :key="role.id"
                                            :value="role.id"
                                        >
                                            {{ role.name }}
                                        </option>
                                    </select>
                                </TableCell>
                                <TableCell class="text-right">
                                    <Button
                                        size="sm"
                                        @click="updateRoles(user.id)"
                                    >
                                        Save
                                    </Button>
                                </TableCell>
                            </TableRow>
                            <TableRow v-if="users.data.length === 0">
                                <TableCell
                                    colspan="4"
                                    class="py-8 text-center text-muted-foreground"
                                >
                                    No users found.
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>

            <div class="flex items-center justify-between">
                <div class="text-sm text-muted-foreground">
                    Showing {{ users.from }} to {{ users.to }} of
                    {{ users.total }} users
                </div>
                <div class="flex gap-2">
                    <template v-for="link in users.links" :key="link.label">
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

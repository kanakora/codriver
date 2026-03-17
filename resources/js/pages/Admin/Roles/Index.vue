<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Badge } from '@/components/ui/badge';
import { route } from 'ziggy-js';

type Permission = {
    id: number;
    name: string;
};

type Role = {
    id: number;
    name: string;
    permissions: Permission[];
};

const props = defineProps<{
    roles: Role[];
    permissions: Permission[];
}>();

const form = useForm({
    name: '',
    permissions: [] as number[],
});

const breadcrumbs = [
    {
        title: 'Admin Dashboard',
        href: route('admin.dashboard'),
    },
    {
        title: 'Roles',
        href: route('admin.roles.index'),
    },
];
</script>

<template>
    <Head title="Role Management" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="space-y-6 p-6">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">
                    Role Management
                </h1>
                <p class="text-sm text-muted-foreground">
                    Create roles and assign permission sets for the platform.
                </p>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>Create a new role</CardTitle>
                </CardHeader>
                <CardContent>
                    <form
                        class="grid gap-6"
                        @submit.prevent="form.post(route('admin.roles.store'))"
                    >
                        <div class="grid gap-2">
                            <Label for="role-name">Role name</Label>
                            <Input
                                id="role-name"
                                v-model="form.name"
                                placeholder="e.g. instructor"
                            />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="grid gap-3">
                            <Label>Permissions</Label>
                            <div class="grid gap-3 md:grid-cols-2">
                                <label
                                    v-for="permission in permissions"
                                    :key="permission.id"
                                    class="flex items-center gap-3 rounded-md border border-border/60 px-3 py-2 text-sm"
                                >
                                    <Checkbox
                                        :id="`permission-${permission.id}`"
                                        :model-value="
                                            form.permissions.includes(
                                                permission.id,
                                            )
                                        "
                                        @update:modelValue="
                                            (checked) => {
                                                if (checked) {
                                                    if (
                                                        !form.permissions.includes(
                                                            permission.id,
                                                        )
                                                    ) {
                                                        form.permissions.push(
                                                            permission.id,
                                                        );
                                                    }
                                                } else {
                                                    form.permissions =
                                                        form.permissions.filter(
                                                            (value) =>
                                                                value !==
                                                                permission.id,
                                                        );
                                                }
                                            }
                                        "
                                    />
                                    <span>{{ permission.name }}</span>
                                </label>
                            </div>
                            <InputError :message="form.errors.permissions" />
                        </div>

                        <div>
                            <Button type="submit" :disabled="form.processing">
                                Create role
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>

            <Card>
                <CardHeader>
                    <CardTitle>Existing roles</CardTitle>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div
                        v-for="role in roles"
                        :key="role.id"
                        class="rounded-lg border border-border/60 p-4"
                    >
                        <div class="flex items-center justify-between">
                            <div class="font-medium">{{ role.name }}</div>
                            <span class="text-xs text-muted-foreground">
                                {{ role.permissions.length }} permissions
                            </span>
                        </div>
                        <div class="mt-3 flex flex-wrap gap-2">
                            <Badge
                                v-for="permission in role.permissions"
                                :key="permission.id"
                                variant="outline"
                                class="text-xs"
                            >
                                {{ permission.name }}
                            </Badge>
                            <span
                                v-if="role.permissions.length === 0"
                                class="text-xs text-muted-foreground"
                            >
                                No permissions assigned.
                            </span>
                        </div>
                    </div>
                    <div
                        v-if="roles.length === 0"
                        class="text-sm text-muted-foreground"
                    >
                        No roles yet. Create your first role above.
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>

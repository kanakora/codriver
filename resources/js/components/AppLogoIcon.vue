<script setup lang="ts">
import type { HTMLAttributes } from 'vue';
import { computed } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
    size?: 'sm' | 'md' | 'lg';
};

const props = defineProps<Props>();

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'h-8 w-8';
        case 'lg':
            return 'h-12 w-12';
        case 'md':
        default:
            return 'h-10 w-10';
    }
});
</script>

<template>
    <img
        src="../../img/codriver-icon.png"
        alt="Codriver"
        class="object-contain"
        :class="[sizeClasses, props.className]"
        v-bind="$attrs"
    >
</template>
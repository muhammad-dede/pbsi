<script setup>
import { cn } from "@/lib/utils";

const props = defineProps({
    class: { type: null, required: false },
});
</script>

<template>
    <div
        :class="
            cn(
                'flex h-full flex-1 flex-col gap-4 rounded-xl px-8 pt-4 pb-12 md:px-4 md:pt-4 md:pb-8',
                props.class
            )
        "
    >
        <slot />
    </div>
</template>

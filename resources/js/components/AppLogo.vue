<script setup>
import AppLogoIcon from "@/components/AppLogoIcon.vue";
import Logo from "@/assets/svg/logo.svg";
</script>

<template>
    <div
        class="flex aspect-square size-8 items-center justify-center rounded-md"
    >
        <img :src="Logo" alt="Logo" class="size-8" />
    </div>
    <div class="ml-1 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate font-semibold leading-none">PBSI</span>
    </div>
</template>

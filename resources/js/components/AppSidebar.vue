<script setup>
import NavFooter from "@/components/NavFooter.vue";
import NavMain from "@/components/NavMain.vue";
import NavUser from "@/components/NavUser.vue";
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from "@/components/ui/sidebar";
import { Link } from "@inertiajs/vue3";
import { Bell, LayoutGrid, Trophy, User } from "lucide-vue-next";
import AppLogo from "./AppLogo.vue";

const mainNavItems = [
    {
        icon: LayoutGrid,
        title: "Dashboard",
        href: route("dashboard"),
        routeMatch: "dashboard",
    },
    {
        icon: User,
        title: "Pengguna",
        href: route("users.index"),
        routeMatch: "users.*",
        permission: "view_any_user",
    },
    {
        icon: Trophy,
        title: "Turnamen",
        href: route("tournaments.index"),
        routeMatch: "tournaments.*",
        permission: "view_any_tournament",
    },
];

const footerNavItems = [
    {
        title: "Notifikasi",
        href: "#",
        icon: Bell,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
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

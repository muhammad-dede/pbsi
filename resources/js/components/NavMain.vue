<script setup>
import {
    SidebarContent,
    SidebarGroup,
    SidebarGroupContent,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubItem,
    SidebarMenuSubButton,
} from "@/components/ui/sidebar";
import {
    Collapsible,
    CollapsibleTrigger,
    CollapsibleContent,
} from "@/components/ui/collapsible";
import { ChevronDown } from "lucide-vue-next";
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { usePermissions } from "@/composables/usePermissions";

const props = defineProps({
    items: Array,
});

const { can } = usePermissions();

function checkActive(menu) {
    return menu.subMenus
        ? menu.subMenus.some(checkActive)
        : route().current(menu.routeMatch);
}

const menus = computed(() =>
    props.items
        .filter((menu) => {
            if (menu.subMenus) {
                menu.subMenus = menu.subMenus.filter((sub) =>
                    sub.permission ? can(sub.permission) : true
                );
                return menu.subMenus.length > 0;
            }
            return menu.permission || menu.permissions
                ? can(menu.permission || menu.permissions)
                : true;
        })
        .map((m) => ({ ...m, isActive: checkActive(m) }))
);
</script>

<template>
    <SidebarContent>
        <SidebarGroup>
            <SidebarGroupContent>
                <SidebarMenu>
                    <SidebarMenuItem v-for="menu in menus" :key="menu.title">
                        <template v-if="menu.subMenus">
                            <Collapsible
                                :default-open="menu.isActive"
                                class="group/collapsible"
                            >
                                <CollapsibleTrigger as-child>
                                    <SidebarMenuButton
                                        :tooltip="menu.title"
                                        :is-active="menu.isActive"
                                        class="select-none"
                                    >
                                        <component
                                            v-if="menu.icon"
                                            :is="menu.icon"
                                        />
                                        <span
                                            v-if="menu.title"
                                            class="whitespace-nowrap truncate"
                                        >
                                            {{ menu.title }}
                                        </span>
                                        <ChevronDown
                                            class="ml-auto transition-transform group-data-[state=open]/collapsible:rotate-180"
                                        />
                                    </SidebarMenuButton>
                                </CollapsibleTrigger>
                                <CollapsibleContent>
                                    <SidebarMenuSub>
                                        <SidebarMenuSubItem
                                            v-for="subMenu in menu.subMenus"
                                            :key="subMenu.title"
                                            as-child
                                        >
                                            <SidebarMenuSubButton
                                                :as="Link"
                                                :href="subMenu.href"
                                                :is-active="
                                                    checkActive(subMenu)
                                                "
                                            >
                                                <span
                                                    v-if="subMenu.title"
                                                    class="whitespace-nowrap truncate"
                                                >
                                                    {{ subMenu.title }}
                                                </span>
                                            </SidebarMenuSubButton>
                                        </SidebarMenuSubItem>
                                    </SidebarMenuSub>
                                </CollapsibleContent>
                            </Collapsible>
                        </template>

                        <template v-else>
                            <SidebarMenuButton
                                :as="Link"
                                :href="menu.href"
                                :tooltip="menu.title"
                                :is-active="menu.isActive"
                            >
                                <component v-if="menu.icon" :is="menu.icon" />
                                <span
                                    v-if="menu.title"
                                    class="whitespace-nowrap truncate"
                                >
                                    {{ menu.title }}
                                </span>
                            </SidebarMenuButton>
                        </template>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarGroupContent>
        </SidebarGroup>
    </SidebarContent>
</template>

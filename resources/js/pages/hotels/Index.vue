<script setup>
import { Head, router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { debounce } from "lodash";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from "@/components/ui/alert-dialog";
import { usePermissions } from "@/composables/usePermissions";
import { useFormatter } from "@/composables/useFormatter";
import AppLayout from "@/layouts/AppLayout.vue";
import AppMain from "@/components/AppMain.vue";
import SearchBox from "@/components/SearchBox.vue";
import Pagination from "@/components/Pagination.vue";
import ButtonCreate from "@/components/ButtonCreate.vue";
import ButtonEdit from "@/components/ButtonEdit.vue";
import ButtonDelete from "@/components/ButtonDelete.vue";
import ButtonDetail from "@/components/ButtonDetail.vue";

const { can } = usePermissions();
const { formatCurrency } = useFormatter();

const props = defineProps({
    filters: Object,
    data: Object,
});

const perPage = ref(Number(props.filters.per_page) || 5);
const search = ref(props.filters.search || null);
const hotel = ref(null);
const showDeleteModal = ref(false);

watch([perPage], updateData);
watch(search, debounce(updateData, 500));

function updateData() {
    const query = {
        ...(search.value ? { search: search.value } : {}),
        ...(perPage.value && perPage.value !== 5
            ? { per_page: perPage.value }
            : {}),
    };
    router.get(route("hotels.index"), query, {
        preserveState: true,
        replace: true,
    });
}

const confirmDelete = (item) => {
    hotel.value = item;
    showDeleteModal.value = true;
};
const closeDeleteModal = () => {
    showDeleteModal.value = false;
    hotel.value = null;
};
const destroy = () => {
    if (!hotel.value) return;
    router.delete(route("hotels.destroy", hotel.value.id), {
        preserveScroll: true,
        onFinish: () => {
            closeDeleteModal();
        },
    });
};

const breadcrumbs = [{ title: "Hotel", href: route("hotels.index") }];
</script>

<template>
    <Head title="Hotel" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppMain>
            <div
                class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"
            >
                <h2 class="text-lg md:text-xl font-bold">Kelola Hotel</h2>
                <div class="flex items-center gap-2">
                    <SearchBox v-model="search" />
                    <ButtonCreate
                        v-if="can('create_tournament')"
                        :href="route('hotels.create')"
                    />
                </div>
            </div>
            <Table>
                <TableHeader class="bg-muted/50">
                    <TableRow>
                        <TableHead class="w-10">No.</TableHead>
                        <TableHead>Turnamen</TableHead>
                        <TableHead>Nama</TableHead>
                        <TableHead>Tarif Single</TableHead>
                        <TableHead>Tarif Double</TableHead>
                        <TableHead>Tarif Twin</TableHead>
                        <TableHead class="text-right">Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-if="props.data.data.length === 0">
                        <TableCell
                            :colspan="7"
                            class="text-center py-4 text-muted-foreground"
                        >
                            Tidak ada data
                        </TableCell>
                    </TableRow>
                    <TableRow
                        v-else
                        v-for="(item, index) in props.data.data"
                        :key="item.id"
                    >
                        <TableCell>{{ index + 1 }}</TableCell>
                        <TableCell>
                            {{ item.tournament.name ?? "-" }}
                        </TableCell>
                        <TableCell>
                            {{ item.name ?? "-" }}
                        </TableCell>
                        <TableCell>
                            {{
                                formatCurrency(
                                    item.rate_single ?? 0,
                                    item.currency_code
                                )
                            }}
                        </TableCell>
                        <TableCell>
                            {{
                                formatCurrency(
                                    item.rate_double ?? 0,
                                    item.currency_code
                                )
                            }}
                        </TableCell>
                        <TableCell>
                            {{
                                formatCurrency(
                                    item.rate_twin ?? 0,
                                    item.currency_code
                                )
                            }}
                        </TableCell>
                        <TableCell class="text-right space-x-2">
                            <ButtonDetail
                                v-if="can('view_tournament')"
                                :href="route('hotels.show', item.id)"
                            />
                            <ButtonEdit
                                v-if="can('edit_tournament')"
                                :href="route('hotels.edit', item.id)"
                            />
                            <ButtonDelete
                                v-if="can('delete_tournament')"
                                @click="confirmDelete(item)"
                            />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
            <Pagination v-model="perPage" :pagination="props.data" />
        </AppMain>
    </AppLayout>
    <AlertDialog :open="!!showDeleteModal">
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>
                    Apakah Anda benar-benar yakin?
                </AlertDialogTitle>
                <AlertDialogDescription>
                    Tindakan ini tidak dapat dibatalkan. Ini akan secara
                    permanen menghapus data terkait dari server kami.
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel @click="closeDeleteModal">
                    Batal
                </AlertDialogCancel>
                <AlertDialogAction @click="destroy">Hapus</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>

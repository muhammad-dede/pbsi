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
import { useDateFormatter } from "@/composables/useDateFormatter";
import { useStatusEnum } from "@/composables/useStatusEnum";
import AppLayout from "@/layouts/AppLayout.vue";
import AppMain from "@/components/AppMain.vue";
import SearchBox from "@/components/SearchBox.vue";
import Pagination from "@/components/Pagination.vue";
import ButtonCreate from "@/components/ButtonCreate.vue";
import ButtonEdit from "@/components/ButtonEdit.vue";
import ButtonDelete from "@/components/ButtonDelete.vue";
import ButtonDetail from "@/components/ButtonDetail.vue";

const { can } = usePermissions();
const { formatDate } = useDateFormatter();
const { getStatusLabel } = useStatusEnum();

const props = defineProps({
    filters: Object,
    data: Object,
});

const perPage = ref(Number(props.filters.per_page) || 5);
const search = ref(props.filters.search || null);
const tournament = ref(null);
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
    router.get(route("tournaments.index"), query, {
        preserveState: true,
        replace: true,
    });
}

const confirmDelete = (item) => {
    tournament.value = item;
    showDeleteModal.value = true;
};
const closeDeleteModal = () => {
    showDeleteModal.value = false;
    tournament.value = null;
};
const destroy = () => {
    if (!tournament.value) return;
    router.delete(route("tournaments.destroy", tournament.value.id), {
        preserveScroll: true,
        onFinish: () => {
            closeDeleteModal();
        },
    });
};

const breadcrumbs = [{ title: "Turnamen", href: route("tournaments.index") }];
</script>

<template>
    <Head title="Turnamen" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppMain>
            <div
                class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"
            >
                <h2 class="text-lg md:text-xl font-bold">Kelola Turnamen</h2>
                <div class="flex items-center gap-2">
                    <SearchBox v-model="search" />
                    <ButtonCreate
                        v-if="can('create_tournament')"
                        :href="route('tournaments.create')"
                    />
                </div>
            </div>
            <Table>
                <TableHeader class="bg-muted/50">
                    <TableRow>
                        <TableHead class="w-10">No.</TableHead>
                        <TableHead>Nama</TableHead>
                        <TableHead>Tanggal</TableHead>
                        <TableHead>Sanction</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead class="text-right">Action</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-if="props.data.data.length === 0">
                        <TableCell
                            :colspan="6"
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
                            {{ item.name ?? "-" }}
                        </TableCell>
                        <TableCell>
                            {{ formatDate(item.start_date) ?? "N/A" }} -
                            {{ formatDate(item.end_date) ?? "N/A" }}
                        </TableCell>
                        <TableCell>
                            {{ item.sanction ?? "-" }}
                        </TableCell>
                        <TableCell>
                            {{ getStatusLabel(item.status) ?? "-" }}
                        </TableCell>
                        <TableCell class="text-right space-x-2">
                            <ButtonDetail
                                v-if="can('view_tournament')"
                                :href="route('tournaments.show', item.id)"
                            />
                            <ButtonEdit
                                v-if="can('edit_tournament')"
                                :href="route('tournaments.edit', item.id)"
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

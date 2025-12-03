<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { Field, FieldLabel } from "@/components/ui/field";
import { Input } from "@/components/ui/input";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import AppLayout from "@/layouts/AppLayout.vue";
import AppMain from "@/components/AppMain.vue";
import ButtonBack from "@/components/ButtonBack.vue";

const props = defineProps({
    tournament: Object,
    currencies: Array,
});

const form = useForm({
    name: props.tournament.name || "",
    title: props.tournament.title || "",
    prize_money: props.tournament.prize_money || "",
    currency_code: props.tournament.currency_code || "",
    start_date: props.tournament.start_date || "",
    end_date: props.tournament.end_date || "",
    venue_name: props.tournament.venue_name || "",
    venue_address: props.tournament.venue_address || "",
    organizer: props.tournament.organizer || "",
    organizer_address: props.tournament.organizer_address || "",
    sanction: props.tournament.sanction || "",
    official_shuttlecock: props.tournament.official_shuttlecock || "",
    status: props.tournament.status || "INACTIVE",
});

const breadcrumbs = [
    { title: "Turnamen", href: route("tournaments.index") },
    {
        title: "Detail Turnamen",
        href: route("tournaments.show", props.tournament.id),
    },
];
</script>

<template>
    <Head title="Detail Turnamen" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppMain>
            <div
                class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"
            >
                <h2 class="text-lg md:text-xl font-bold">Detail Turnamen</h2>
            </div>
            <div class="w-full">
                <div class="grid grid-cols-1 mb-3">
                    <Field>
                        <FieldLabel for="name">Nama</FieldLabel>
                        <Input
                            id="name"
                            placeholder="Masukkan nama"
                            autocomplete="off"
                            v-model="form.name"
                            disabled
                        />
                    </Field>
                </div>
                <div class="grid grid-cols-1 mb-3">
                    <Field>
                        <FieldLabel for="title">Title</FieldLabel>
                        <Input
                            id="title"
                            type="text"
                            placeholder="Masukkan title"
                            autocomplete="off"
                            v-model="form.title"
                            disabled
                        />
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="prize_money">Uang Hadiah</FieldLabel>
                        <Input
                            id="prize_money"
                            type="number"
                            placeholder="Masukkan uang hadiah"
                            autocomplete="off"
                            v-model="form.prize_money"
                            disabled
                        />
                    </Field>
                    <Field>
                        <FieldLabel for="currency_code">Mata Uang</FieldLabel>
                        <Select
                            v-model="form.currency_code"
                            name="currency_code"
                        >
                            <SelectTrigger id="currency_code" disabled>
                                <SelectValue placeholder="Pilih Mata Uang" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="currency in currencies"
                                    :key="currency.code"
                                    :value="currency.code"
                                >
                                    {{ currency.code }} - {{ currency.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="start_date">Tanggal Mulai</FieldLabel>
                        <Input
                            id="start_date"
                            type="date"
                            placeholder="Masukkan tanggal mulai"
                            autocomplete="off"
                            v-model="form.start_date"
                            disabled
                        />
                    </Field>
                    <Field>
                        <FieldLabel for="end_date">Tanggal Selesai</FieldLabel>
                        <Input
                            id="end_date"
                            type="date"
                            placeholder="Masukkan tanggal selesai"
                            autocomplete="off"
                            v-model="form.end_date"
                            disabled
                        />
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="venue_name">Nama Tempat</FieldLabel>
                        <Input
                            id="venue_name"
                            type="text"
                            placeholder="Masukkan nama tempat"
                            autocomplete="off"
                            v-model="form.venue_name"
                            disabled
                        />
                    </Field>
                    <Field>
                        <FieldLabel for="venue_address"
                            >Alamat Tempat</FieldLabel
                        >
                        <Input
                            id="venue_address"
                            type="text"
                            placeholder="Masukkan alamat tempat"
                            autocomplete="off"
                            v-model="form.venue_address"
                            disabled
                        />
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="organizer">Penyelenggara</FieldLabel>
                        <Input
                            id="organizer"
                            type="text"
                            placeholder="Masukkan penyelenggara"
                            autocomplete="off"
                            v-model="form.organizer"
                            disabled
                        />
                    </Field>
                    <Field>
                        <FieldLabel for="organizer_address"
                            >Alamat Penyelenggara</FieldLabel
                        >
                        <Input
                            id="organizer_address"
                            type="text"
                            placeholder="Masukkan alamat penyelenggara"
                            autocomplete="off"
                            v-model="form.organizer_address"
                            disabled
                        />
                    </Field>
                </div>
                <div class="grid grid-cols-1 mb-3">
                    <Field>
                        <FieldLabel for="sanction">Sanction</FieldLabel>
                        <Input
                            id="sanction"
                            type="text"
                            placeholder="Masukkan sanction"
                            autocomplete="off"
                            v-model="form.sanction"
                            disabled
                        />
                    </Field>
                </div>
                <div class="grid grid-cols-1 mb-3">
                    <Field>
                        <FieldLabel for="official_shuttlecock"
                            >Official Shuttlecock</FieldLabel
                        >
                        <Input
                            id="official_shuttlecock"
                            type="text"
                            placeholder="Masukkan official shuttlecock"
                            autocomplete="off"
                            v-model="form.official_shuttlecock"
                            disabled
                        />
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="status">Status</FieldLabel>
                        <Select v-model="form.status" name="status">
                            <SelectTrigger id="status" disabled>
                                <SelectValue placeholder="Pilih Status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="ACTIVE">Aktif</SelectItem>
                                <SelectItem value="INACTIVE">
                                    Non Aktif
                                </SelectItem>
                            </SelectContent>
                        </Select>
                    </Field>
                </div>
                <Field orientation="horizontal">
                    <ButtonBack :href="route('tournaments.index')" />
                </Field>
            </div>
        </AppMain>
    </AppLayout>
</template>

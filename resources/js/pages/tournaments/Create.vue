<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
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
import ButtonSubmit from "@/components/ButtonSubmit.vue";
import ButtonCancel from "@/components/ButtonCancel.vue";

const form = useForm({
    name: "",
    title: "",
    prize_money: "",
    currency: "",
    start_date: "",
    end_date: "",
    venue_name: "",
    venue_address: "",
    organizer: "",
    organizer_address: "",
    sanction: "",
    official_shuttlecock: "",
    status: "INACTIVE",
});

const submit = () => {
    form.clearErrors();
    form.post(route("tournaments.store"), {
        preserveScroll: true,
    });
};

const breadcrumbs = [
    { title: "Turnamen", href: route("tournaments.index") },
    { title: "Tambah Turnamen", href: route("tournaments.create") },
];
</script>

<template>
    <Head title="Tambah Turnamen" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppMain>
            <div
                class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"
            >
                <h2 class="text-lg md:text-xl font-bold">Tambah Turnamen</h2>
            </div>
            <form @submit.prevent="submit" class="w-full">
                <div class="grid grid-cols-1 mb-3">
                    <Field>
                        <FieldLabel for="name">Nama</FieldLabel>
                        <Input
                            id="name"
                            placeholder="Masukkan nama"
                            autocomplete="off"
                            v-model="form.name"
                        />
                        <FieldError>
                            {{ form.errors.name }}
                        </FieldError>
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
                        />
                        <FieldError>
                            {{ form.errors.title }}
                        </FieldError>
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
                        />
                        <FieldError>
                            {{ form.errors.prize_money }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="currency">Mata Uang</FieldLabel>
                        <Input
                            id="currency"
                            type="text"
                            placeholder="Masukkan mata uang"
                            autocomplete="off"
                            max="3"
                            v-model="form.currency"
                        />
                        <FieldError>
                            {{ form.errors.currency }}
                        </FieldError>
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
                        />
                        <FieldError>
                            {{ form.errors.start_date }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="end_date">Tanggal Selesai</FieldLabel>
                        <Input
                            id="end_date"
                            type="date"
                            placeholder="Masukkan tanggal selesai"
                            autocomplete="off"
                            v-model="form.end_date"
                        />
                        <FieldError>
                            {{ form.errors.end_date }}
                        </FieldError>
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
                        />
                        <FieldError>
                            {{ form.errors.venue_name }}
                        </FieldError>
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
                        />
                        <FieldError>
                            {{ form.errors.venue_address }}
                        </FieldError>
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
                        />
                        <FieldError>
                            {{ form.errors.organizer }}
                        </FieldError>
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
                        />
                        <FieldError>
                            {{ form.errors.organizer_address }}
                        </FieldError>
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
                        />
                        <FieldError>
                            {{ form.errors.sanction }}
                        </FieldError>
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
                        />
                        <FieldError>
                            {{ form.errors.official_shuttlecock }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="status">Status</FieldLabel>
                        <Select v-model="form.status" name="status">
                            <SelectTrigger id="status">
                                <SelectValue placeholder="Pilih Status" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="ACTIVE">Aktif</SelectItem>
                                <SelectItem value="INACTIVE">
                                    Non Aktif
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>{{ form.errors.status }}</FieldError>
                    </Field>
                </div>
                <Field orientation="horizontal">
                    <ButtonSubmit />
                    <ButtonCancel :href="route('tournaments.index')" />
                </Field>
            </form>
        </AppMain>
    </AppLayout>
</template>

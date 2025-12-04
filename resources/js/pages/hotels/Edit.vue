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

const props = defineProps({
    hotel: Object,
    tournaments: Object,
    currencies: Object,
});

const form = useForm({
    tournament_id: props.hotel.tournament_id || "",
    name: props.hotel.name || "",
    address: props.hotel.address || "",
    rate_single: props.hotel.rate_single || "",
    rate_double: props.hotel.rate_double || "",
    rate_twin: props.hotel.rate_twin || "",
    currency_code: props.hotel.currency_code || "",
    facilities: props.hotel.facilities || "",
    breakfast_included: props.hotel.breakfast_included ? "1" : "0",
    breakfast_persons: props.hotel.breakfast_persons || "",
    is_official: props.hotel.is_official ? "1" : "0",
});

const submit = () => {
    form.clearErrors();
    form.put(route("hotels.update", props.hotel.id), {
        preserveScroll: true,
    });
};

const breadcrumbs = [
    { title: "Hotel", href: route("hotels.index") },
    { title: "Ubah Hotel", href: route("hotels.edit", props.hotel.id) },
];
</script>

<template>
    <Head title="Ubah Hotel" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppMain>
            <div
                class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"
            >
                <h2 class="text-lg md:text-xl font-bold">Ubah Hotel</h2>
            </div>
            <form @submit.prevent="submit" class="w-full">
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="tournament_id">Turnamen</FieldLabel>
                        <Select
                            v-model="form.tournament_id"
                            name="tournament_id"
                        >
                            <SelectTrigger id="tournament_id">
                                <SelectValue placeholder="Pilih Turnamen" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="tournament in props.tournaments"
                                    :key="tournament.id"
                                    :value="tournament.id"
                                >
                                    {{ tournament.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>
                            {{ form.errors.tournament_id }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="name">Nama</FieldLabel>
                        <Input
                            id="name"
                            type="text"
                            name="name"
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
                        <FieldLabel for="address">Alamat</FieldLabel>
                        <Input
                            id="address"
                            type="text"
                            name="address"
                            placeholder="Masukkan alamat"
                            autocomplete="off"
                            v-model="form.address"
                        />
                        <FieldError>
                            {{ form.errors.address }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-3 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="rate_single">Tarif Single</FieldLabel>
                        <Input
                            id="rate_single"
                            type="number"
                            name="rate_single"
                            placeholder="Masukkan rate single"
                            autocomplete="off"
                            v-model="form.rate_single"
                        />
                        <FieldError>
                            {{ form.errors.rate_single }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="rate_double">Tarif Double</FieldLabel>
                        <Input
                            id="rate_double"
                            type="number"
                            name="rate_double"
                            placeholder="Masukkan rate double"
                            autocomplete="off"
                            v-model="form.rate_double"
                        />
                        <FieldError>
                            {{ form.errors.rate_double }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="rate_twin">Tarif Twin</FieldLabel>
                        <Input
                            id="rate_twin"
                            type="number"
                            name="rate_twin"
                            placeholder="Masukkan rate twin"
                            autocomplete="off"
                            v-model="form.rate_twin"
                        />
                        <FieldError>
                            {{ form.errors.rate_twin }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="currency_code">Mata Uang</FieldLabel>
                        <Select
                            v-model="form.currency_code"
                            name="currency_code"
                        >
                            <SelectTrigger id="currency_code">
                                <SelectValue placeholder="Pilih Mata Uang" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="currency in props.currencies"
                                    :key="currency.code"
                                    :value="currency.code"
                                >
                                    {{ currency.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>
                            {{ form.errors.currency_code }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="facilities">Fasilitas</FieldLabel>
                        <Input
                            id="facilities"
                            type="text"
                            name="facilities"
                            placeholder="Masukkan fasilitas"
                            autocomplete="off"
                            v-model="form.facilities"
                        />
                        <FieldError>
                            {{ form.errors.facilities }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="breakfast_included">
                            Termasuk Sarapan
                        </FieldLabel>
                        <Select
                            v-model="form.breakfast_included"
                            name="breakfast_included"
                        >
                            <SelectTrigger id="breakfast_included">
                                <SelectValue placeholder="Pilih" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="1">Ya</SelectItem>
                                <SelectItem value="0">Tidak</SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>
                            {{ form.errors.breakfast_included }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="breakfast_persons">
                            Jumlah Orang Sarapan
                        </FieldLabel>
                        <Input
                            id="breakfast_persons"
                            type="number"
                            name="breakfast_persons"
                            placeholder="Masukkan fasilitas"
                            autocomplete="off"
                            v-model="form.breakfast_persons"
                        />
                        <FieldError>
                            {{ form.errors.breakfast_persons }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="is_official">Resmi</FieldLabel>
                        <Select v-model="form.is_official" name="is_official">
                            <SelectTrigger id="is_official">
                                <SelectValue placeholder="Pilih" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="1">Ya</SelectItem>
                                <SelectItem value="0">Tidak</SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>
                            {{ form.errors.is_official }}
                        </FieldError>
                    </Field>
                </div>
                <Field orientation="horizontal">
                    <ButtonSubmit />
                    <ButtonCancel :href="route('hotels.index')" />
                </Field>
            </form>
        </AppMain>
    </AppLayout>
</template>

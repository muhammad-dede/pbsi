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
    tournaments: Object,
    official_roles: Object,
    countries: Object,
});

const form = useForm({
    tournament_id: "",
    official_role_code: "",
    name: "",
    country_code: "",
});

const submit = () => {
    form.clearErrors();
    form.post(route("tournament-officials.store"), {
        preserveScroll: true,
    });
};

const breadcrumbs = [
    { title: "Official", href: route("tournament-officials.index") },
    { title: "Tambah Official", href: route("tournament-officials.create") },
];
</script>

<template>
    <Head title="Tambah Official" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppMain>
            <div
                class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"
            >
                <h2 class="text-lg md:text-xl font-bold">Tambah Official</h2>
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
                        <FieldLabel for="official_role_code"
                            >Official</FieldLabel
                        >
                        <Select
                            v-model="form.official_role_code"
                            name="official_role_code"
                        >
                            <SelectTrigger id="official_role_code">
                                <SelectValue placeholder="Pilih Official" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="official in props.official_roles"
                                    :key="official.code"
                                    :value="official.code"
                                >
                                    {{ official.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>
                            {{ form.errors.official_role_code }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
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
                    <Field>
                        <FieldLabel for="country_code">Negara</FieldLabel>
                        <Select v-model="form.country_code" name="country_code">
                            <SelectTrigger id="country_code">
                                <SelectValue placeholder="Pilih Negara" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="country in props.countries"
                                    :key="country.code"
                                    :value="country.code"
                                >
                                    {{ country.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>
                            {{ form.errors.country_code }}
                        </FieldError>
                    </Field>
                </div>
                <Field orientation="horizontal">
                    <ButtonSubmit />
                    <ButtonCancel :href="route('tournament-officials.index')" />
                </Field>
            </form>
        </AppMain>
    </AppLayout>
</template>

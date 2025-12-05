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
import { useFormatter } from "@/composables/useFormatter";
import AppLayout from "@/layouts/AppLayout.vue";
import AppMain from "@/components/AppMain.vue";
import ButtonSubmit from "@/components/ButtonSubmit.vue";
import ButtonCancel from "@/components/ButtonCancel.vue";

const { formatShortTime } = useFormatter();

const props = defineProps({
    schedule: Object,
    tournaments: Object,
    session_types: Object,
});

const form = useForm({
    tournament_id: props.schedule.tournament_id || "",
    date: props.schedule.date || "",
    event_description: props.schedule.event_description || "",
    session_type_code: props.schedule.session_type_code || "",
    courts_available: props.schedule.courts_available || "",
    doors_open: formatShortTime(props.schedule.doors_open),
    start_time: formatShortTime(props.schedule.start_time),
    end_time: formatShortTime(props.schedule.end_time),
});

const submit = () => {
    form.clearErrors();
    form.put(route("schedules.update", props.schedule.id), {
        preserveScroll: true,
    });
};

const breadcrumbs = [
    { title: "Jadwal", href: route("schedules.index") },
    { title: "Ubah Jadwal", href: route("schedules.edit", props.schedule.id) },
];
</script>

<template>
    <Head title="Ubah Jadwal" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppMain>
            <div
                class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"
            >
                <h2 class="text-lg md:text-xl font-bold">Ubah Jadwal</h2>
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
                        <FieldLabel for="date">Tanggal</FieldLabel>
                        <Input
                            id="date"
                            type="date"
                            name="date"
                            placeholder="Masukkan tanggal"
                            autocomplete="off"
                            v-model="form.date"
                        />
                        <FieldError>
                            {{ form.errors.date }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="event_description">
                            Deskripsi
                        </FieldLabel>
                        <Input
                            id="event_description"
                            type="text"
                            name="event_description"
                            placeholder="Masukkan deskripsi"
                            autocomplete="off"
                            v-model="form.event_description"
                        />
                        <FieldError>
                            {{ form.errors.event_description }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="session_type_code">Sesi</FieldLabel>
                        <Select
                            v-model="form.session_type_code"
                            name="session_type_code"
                        >
                            <SelectTrigger id="session_type_code">
                                <SelectValue placeholder="Pilih sesi" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="sessionType in props.session_types"
                                    :key="sessionType.code"
                                    :value="sessionType.code"
                                >
                                    {{ sessionType.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>
                            {{ form.errors.session_type_code }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="courts_available">
                            Jumlah lapangan tersedia
                        </FieldLabel>
                        <Input
                            id="courts_available"
                            type="number"
                            name="courts_available"
                            placeholder="Masukkan jumlah lapangan tersedia"
                            autocomplete="off"
                            v-model="form.courts_available"
                        />
                        <FieldError>
                            {{ form.errors.courts_available }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="doors_open"
                            >Waktu pintu dibuka</FieldLabel
                        >
                        <Input
                            id="doors_open"
                            type="time"
                            name="doors_open"
                            placeholder="Masukkan waktu pintu dibuka"
                            autocomplete="off"
                            v-model="form.doors_open"
                        />
                        <FieldError>
                            {{ form.errors.doors_open }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="start_time">Waktu mulai</FieldLabel>
                        <Input
                            id="start_time"
                            type="time"
                            name="start_time"
                            placeholder="Masukkan waktu mulai"
                            autocomplete="off"
                            v-model="form.start_time"
                        />
                        <FieldError>
                            {{ form.errors.start_time }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="end_time">Waktu selesai</FieldLabel>
                        <Input
                            id="end_time"
                            type="time"
                            name="end_time"
                            placeholder="Masukkan waktu mulai"
                            autocomplete="off"
                            v-model="form.end_time"
                        />
                        <FieldError>
                            {{ form.errors.end_time }}
                        </FieldError>
                    </Field>
                </div>
                <Field orientation="horizontal">
                    <ButtonSubmit />
                    <ButtonCancel :href="route('schedules.index')" />
                </Field>
            </form>
        </AppMain>
    </AppLayout>
</template>

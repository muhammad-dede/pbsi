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
    event_categories: Object,
    rounds: Object,
});

const form = useForm({
    tournament_id: "",
    event_category_code: "",
    main_draw_size: "",
    qualifying_positions: "",
    max_qualifying_entries: "",
    prize_distributions: [
        {
            round_code: "",
            amount: "",
            is_per_pair: "0",
        },
    ],
});

const addPrizeDistribution = () => {
    form.prize_distributions.push({
        round_code: "",
        amount: "",
        is_per_pair: "0",
    });
};

const removePrizeDistribution = (index) => {
    form.prize_distributions.splice(index, 1);
};

const submit = () => {
    form.clearErrors();
    form.post(route("events.store"), {
        preserveScroll: true,
    });
};

const breadcrumbs = [
    { title: "Event", href: route("events.index") },
    { title: "Tambah Event", href: route("events.create") },
];
</script>

<template>
    <Head title="Tambah Event" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppMain>
            <div
                class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"
            >
                <h2 class="text-lg md:text-xl font-bold">Tambah Event</h2>
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
                                    v-for="value in props.tournaments"
                                    :key="value.id"
                                    :value="value.id"
                                >
                                    {{ value.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>{{ form.errors.tournament_id }}</FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="event_category_code">
                            Kategori
                        </FieldLabel>
                        <Select
                            v-model="form.event_category_code"
                            name="event_category_code"
                        >
                            <SelectTrigger id="event_category_code">
                                <SelectValue placeholder="Pilih Kategori" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem
                                    v-for="value in props.event_categories"
                                    :key="value.code"
                                    :value="value.code"
                                >
                                    {{ value.name }}
                                </SelectItem>
                            </SelectContent>
                        </Select>
                        <FieldError>
                            {{ form.errors.event_category_code }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="main_draw_size"
                            >Ukuran Undian Utama</FieldLabel
                        >
                        <Input
                            id="main_draw_size"
                            type="number"
                            placeholder="Masukkan ukuran undian utama"
                            autocomplete="off"
                            v-model="form.main_draw_size"
                        />
                        <FieldError>
                            {{ form.errors.main_draw_size }}
                        </FieldError>
                    </Field>
                    <Field>
                        <FieldLabel for="qualifying_positions"
                            >Posisi Kualifikasi</FieldLabel
                        >
                        <Input
                            id="qualifying_positions"
                            type="number"
                            placeholder="Masukkan posisi kualifikasi"
                            autocomplete="off"
                            v-model="form.qualifying_positions"
                        />
                        <FieldError>
                            {{ form.errors.qualifying_positions }}
                        </FieldError>
                    </Field>
                </div>
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="max_qualifying_entries"
                            >Maksimum Entri Kualifikasi</FieldLabel
                        >
                        <Input
                            id="max_qualifying_entries"
                            type="number"
                            placeholder="Masukkan maksimum entri kualifikasi"
                            autocomplete="off"
                            v-model="form.max_qualifying_entries"
                        />
                        <FieldError>
                            {{ form.errors.max_qualifying_entries }}
                        </FieldError>
                    </Field>
                </div>
                <div class="mb-6">
                    <h3 class="font-semibold text-lg mb-3">
                        Distribusi Hadiah
                    </h3>
                    <div
                        v-for="(item, index) in form.prize_distributions"
                        :key="index"
                        class="grid grid-cols-1 lg:grid-cols-3 gap-3 mb-3 p-3 border rounded-lg"
                    >
                        <Field>
                            <FieldLabel :for="`round_code_${index}`">
                                Round
                            </FieldLabel>
                            <Select
                                v-model="item.round_code"
                                :name="`round_code_${index}`"
                            >
                                <SelectTrigger :id="`round_code_${index}`">
                                    <SelectValue placeholder="Pilih Round" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem
                                        v-for="round in props.rounds"
                                        :key="round.code"
                                        :value="round.code"
                                    >
                                        {{ round.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <FieldError>
                                {{
                                    form.errors[
                                        `prize_distributions.${index}.round_code`
                                    ]
                                }}
                            </FieldError>
                        </Field>
                        <Field>
                            <FieldLabel :for="`amount_${index}`">
                                Amount
                            </FieldLabel>
                            <Input
                                :id="`amount_${index}`"
                                type="number"
                                placeholder="Masukkan jumlah"
                                v-model="item.amount"
                            />
                            <FieldError>
                                {{
                                    form.errors[
                                        `prize_distributions.${index}.amount`
                                    ]
                                }}
                            </FieldError>
                        </Field>
                        <Field>
                            <FieldLabel :for="`is_per_pair_${index}`">
                                Per Pasangan?
                            </FieldLabel>
                            <Select
                                v-model="item.is_per_pair"
                                :name="`is_per_pair_${index}`"
                            >
                                <SelectTrigger :id="`is_per_pair_${index}`">
                                    <SelectValue placeholder="Pilih" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="1">Ya</SelectItem>
                                    <SelectItem value="0">Tidak</SelectItem>
                                </SelectContent>
                            </Select>
                            <FieldError>
                                {{
                                    form.errors[
                                        `prize_distributions.${index}.is_per_pair`
                                    ]
                                }}
                            </FieldError>
                        </Field>
                        <div class="flex items-end">
                            <button
                                type="button"
                                class="px-2.5 py-1.5 text-sm bg-destructive text-white rounded-md"
                                @click="removePrizeDistribution(index)"
                                v-if="form.prize_distributions.length > 1"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>
                    <button
                        type="button"
                        class="px-2.5 py-1.5 bg-green-600 text-white text-sm rounded-md"
                        @click="addPrizeDistribution()"
                    >
                        + Tambah Distribusi Hadiah
                    </button>
                </div>
                <Field orientation="horizontal">
                    <ButtonSubmit />
                    <ButtonCancel :href="route('events.index')" />
                </Field>
            </form>
        </AppMain>
    </AppLayout>
</template>

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
    event: Object,
    tournaments: Object,
    event_categories: Object,
    rounds: Object,
});

const form = useForm({
    tournament_id: props.event?.tournament_id || "",
    event_category_code: props.event?.event_category_code || "",
    main_draw_size: props.event?.main_draw_size || "",
    qualifying_positions: props.event?.qualifying_positions || "",
    max_qualifying_entries: props.event?.max_qualifying_entries || "",

    prize_distributions: props.event?.prize_distributions?.length
        ? props.event.prize_distributions.map((pd) => ({
              id: pd.id || null,
              round_code: pd.round_code || "",
              amount: pd.amount || "",
              is_per_pair: pd.is_per_pair ? "1" : "0",
          }))
        : [
              {
                  id: null,
                  round_code: "",
                  amount: "",
                  is_per_pair: "0",
              },
          ],
});

const breadcrumbs = [
    { title: "Event", href: route("events.index") },
    { title: "Detail Event", href: route("events.show", props.event.id) },
];
</script>

<template>
    <Head title="Detail Event" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <AppMain>
            <div
                class="flex flex-col md:flex-row md:justify-between md:items-center gap-4"
            >
                <h2 class="text-lg md:text-xl font-bold">Detail Event</h2>
            </div>
            <form @submit.prevent="submit" class="w-full">
                <div class="grid lg:grid-cols-2 gap-3 mb-3">
                    <Field>
                        <FieldLabel for="tournament_id">Turnamen</FieldLabel>
                        <Select
                            v-model="form.tournament_id"
                            name="tournament_id"
                        >
                            <SelectTrigger id="tournament_id" disabled>
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
                    </Field>
                    <Field>
                        <FieldLabel for="event_category_code">
                            Kategori
                        </FieldLabel>
                        <Select
                            v-model="form.event_category_code"
                            name="event_category_code"
                        >
                            <SelectTrigger id="event_category_code" disabled>
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
                            disabled
                        />
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
                            disabled
                        />
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
                            disabled
                        />
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
                                <SelectTrigger
                                    :id="`round_code_${index}`"
                                    disabled
                                >
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
                                disabled
                            />
                        </Field>
                        <Field>
                            <FieldLabel :for="`is_per_pair_${index}`">
                                Per Pasangan?
                            </FieldLabel>
                            <Select
                                v-model="item.is_per_pair"
                                :name="`is_per_pair_${index}`"
                            >
                                <SelectTrigger
                                    :id="`is_per_pair_${index}`"
                                    disabled
                                >
                                    <SelectValue placeholder="Pilih" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="1">Ya</SelectItem>
                                    <SelectItem value="0">Tidak</SelectItem>
                                </SelectContent>
                            </Select>
                        </Field>
                    </div>
                </div>
                <Field orientation="horizontal">
                    <ButtonBack :href="route('events.index')" />
                </Field>
            </form>
        </AppMain>
    </AppLayout>
</template>

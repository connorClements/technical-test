<template>
    <div class="flex items-center justify-center flex-col h-100">
        <div style="height: 70vh; width: 70vw" class="shadow-lg">
            <l-map
                ref="map"
                v-model:zoom="zoom"
                :center="defaultCenter"
                class="rounded-lg"
            >
                <l-tile-layer
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    layer-type="base"
                    name="OpenStreetMap"
                ></l-tile-layer>
                <!-- Add markers for each turbine -->
                <l-marker
                    v-for="turbine in turbines"
                    :key="turbine.id"
                    :lat-lng="[turbine.latitude, turbine.longitude]"
                    @click="selectInspection(turbine)"
                >
                    <l-popup class="text-center">
                        <div class="text-base font-bold pb-1">
                            Turbine: {{ turbine.id }}. {{ turbine.name }}
                        </div>
                        <div class="text-base pb-2">
                            Coordinates: [{{ turbine.latitude }},
                            {{ turbine.longitude }}]
                        </div>
                        <button
                            @click="viewInspections(turbine)"
                            class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                        >
                            View inspections
                        </button>
                    </l-popup>
                    <l-icon
                        :icon-size="dynamicSize"
                        :icon-anchor="dynamicAnchor"
                        icon-url="/images/turbine.png"
                    >
                    </l-icon>
                </l-marker>
            </l-map>
        </div>
        <div
            id="inspectionsTable"
            v-if="selectedTurbine"
            class="w-full mt-8 p-8"
        >
            <h2 class="text-2xl font-semibold mb-4 text-slate-800 text-center">
                Inspections for Turbine: {{ selectedTurbine.id }}.
                {{ selectedTurbine.name }}
            </h2>
            <table
                class="table-auto border-collapse border border-slate-800 text-slate-700 w-full p-8 rounded-lg shadow-lg bg-slate-100"
            >
                <thead class="text-lg">
                    <tr>
                        <th class="border border-slate-300 px-4 py-2">
                            Component
                        </th>
                        <th class="border border-slate-300 px-4 py-2">Date</th>
                        <th class="border border-slate-300 px-4 py-2">Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="component in selectedTurbine.components"
                        :key="component.id"
                    >
                        <td class="border border-slate-300 text-lg px-4 py-2">
                            {{ component.name }}
                        </td>
                        <td class="border border-slate-300">
                            <div
                                v-for="(
                                    inspection, index
                                ) in component.inspections"
                                :key="inspection.id"
                                :class="{
                                    'border-b-2 border-slate-300':
                                        index !==
                                        component.inspections.length - 1,
                                    'py-2': true,
                                }"
                            >
                                {{ inspection.inspection_date }}
                            </div>
                        </td>
                        <td class="border border-slate-300">
                            <div
                                v-for="(
                                    inspection, index
                                ) in component.inspections"
                                :key="inspection.id"
                                :class="{
                                    'border-b-2 border-slate-300':
                                        index !==
                                        component.inspections.length - 1,
                                    'py-2': true,
                                }"
                            >
                                {{ inspection.score }}
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import "leaflet/dist/leaflet.css";
import {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
    LIcon,
} from "@vue-leaflet/vue-leaflet";
import L from "leaflet";

export default {
    props: {
        turbines: Array,
    },
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LPopup,
        LIcon,
    },
    data() {
        return {
            zoom: 2,
            defaultCenter: [47.41322, -1.219482],
            iconSize: 32,
            icon: L.icon({
                iconUrl: "/images/turbine.png",
                iconSize: [32, 37],
                iconAnchor: [16, 37],
            }),

            selectedTurbine: null,
        };
    },

    computed: {
        dynamicSize() {
            return [this.iconSize, this.iconSize * 1.15];
        },
        dynamicAnchor() {
            return [this.iconSize / 2, this.iconSize * 1.15];
        },
    },

    methods: {
        selectInspection(turbine) {
            console.log(turbine);
            this.selectedTurbine = turbine;
        },

        viewInspections() {
            // Scroll to the table with a smooth effect
            const table = document.getElementById("inspectionsTable");
            if (table) {
                table.scrollIntoView({ behavior: "smooth" });
            }
        },
    },
};
</script>

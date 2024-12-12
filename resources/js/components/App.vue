<template>
    <div
        class="dark:from-gray-900 dark:to-gray-700 bg-gradient-to-b from-slate-200 to-slate-100 min-h-screen"
    >
        <div class="flex flex-col items-center text-center">
            <img src="/images/cyberhawk-logo.png" class="pt-4 w-[200px]" />
            <div
                class="text-2xl text-center pt-2 text-gray-900 dark:text-slate-200"
            >
                Technical Task
            </div>
            <div
                class="text-lg text-center pb-2 text-gray-900 dark:text-slate-400"
            >
                Connor Clements
            </div>
        </div>

        <div class="h-100">
            <div class="shadow-lg h-[70vh] w-[70vw] mx-auto">
                <button
                    @click="addTurbine()"
                    class="bg-green-500 hover:bg-green-400 text-sm text-white font-bold p-2 border-b-2 border-green-700 hover:border-green-500 rounded my-2"
                >
                    <i class="fas fa-plus mr-1"></i>Add turbine
                </button>
                <l-map
                    ref="map"
                    v-model:zoom="zoom"
                    :center="defaultCenter"
                    class="rounded-lg"
                    :min-zoom="1"
                    :max-zoom="8"
                >
                    <l-tile-layer
                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                        layer-type="base"
                        name="OpenStreetMap"
                    ></l-tile-layer>
                    <l-marker
                        v-for="turbine in turbines"
                        :key="turbine.id"
                        :lat-lng="[turbine.latitude, turbine.longitude]"
                        @click="selectTurbine(turbine)"
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
                                class="bg-cyan-500 hover:bg-cyan-400 text-white font-bold py-2 px-4 border-b-4 border-cyan-700 hover:border-cyan-500 rounded mr-1"
                            >
                                <i class="far fa-eye mr-1"></i>View inspections
                            </button>
                            <button
                                onclick="delete_turbine_modal.showModal()"
                                class="bg-red-500 hover:bg-red-400 text-white font-bold py-2 px-4 border-b-4 border-red-700 hover:border-red-500 rounded"
                            >
                                <i class="far fa-trash-can mr-1"></i> Delete
                                turbine
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
            <div v-if="selectedTurbine" id="inspectionsTable" class="mt-8 p-8">
                <h2
                    class="text-2xl font-semibold my-4 text-slate-300 text-center"
                >
                    Inspections for Turbine: {{ selectedTurbine.id }}.
                    {{ selectedTurbine.name }}
                </h2>
                <button
                    @click="addComponent(selectedTurbine)"
                    class="bg-green-500 hover:bg-green-400 text-sm text-white font-bold p-2 border-b-2 border-green-700 hover:border-green-500 rounded my-2"
                >
                    <i class="fas fa-plus mr-1"></i> Add component
                </button>
                <div class="overflow-x-auto">
                    <table
                        class="relative w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th class="border border-slate-300 px-4 py-2">
                                    Component
                                </th>
                                <th class="border border-slate-300 px-4 py-2">
                                    Date
                                </th>
                                <th class="border border-slate-300 px-4 py-2">
                                    Score
                                </th>
                                <th class="border border-slate-300 px-4 py-2">
                                    Inspection Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="component in selectedTurbine.components"
                                :key="component.id"
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                            >
                                <td class="border border-slate-300 px-4 py-2">
                                    <div
                                        class="px-2 py-4 font-medium text-lg text-gray-900 whitespace-nowrap dark:text-white"
                                    >
                                        {{ component.name }}
                                    </div>
                                    <div>
                                        <button
                                            @click="addInspection(component)"
                                            class="bg-amber-500 hover:bg-amber-400 text-sm text-white font-bold p-2 border-b-2 border-amber-700 hover:border-amber-500 rounded m-1"
                                        >
                                            <i class="fas fa-plus mr-1"></i> Add
                                            inspection
                                        </button>
                                        <button
                                            @click="selectComponent(component)"
                                            class="bg-red-500 hover:bg-red-400 text-sm text-white font-bold p-2 border-b-2 border-red-700 hover:border-red-500 rounded m-1"
                                        >
                                            <i
                                                class="far fa-trash-can mr-1"
                                            ></i>
                                            Delete component
                                        </button>
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
                                                component.inspections.length -
                                                    1,
                                            'p-2': true,
                                        }"
                                        style="height: 64px"
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
                                                component.inspections.length -
                                                    1,
                                            'p-2': true,
                                        }"
                                        style="height: 64px"
                                    >
                                        {{ inspection.score }}
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
                                                component.inspections.length -
                                                    1,
                                            'p-2': true,
                                        }"
                                    >
                                        <div class="flex flex-row">
                                            <button
                                                @click="
                                                    selectInspection(inspection)
                                                "
                                                class="bg-red-500 hover:bg-red-400 text-sm text-white font-bold p-2 border-b-2 border-red-700 hover:border-red-500 rounded m-1"
                                            >
                                                <i
                                                    class="far fa-trash-can mr-1"
                                                ></i>
                                                Delete inspection
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <DeleteComponentModal
                :selected-component="selectedComponent"
                @update-turbines="updateTurbines"
            />
            <DeleteInspectionModal
                :selected-inspection="selectedInspection"
                @update-turbines="updateTurbines"
            />
            <DeleteTurbineModal
                :selected-turbine="selectedTurbine"
                @update-turbines="updateTurbines"
            />
            <AddInspectionModal
                :component="selectedComponent"
                @update-turbines="updateTurbines"
            />
            <AddTurbineModal @update-turbines="updateTurbines" />
            <AddComponentModal
                :turbine="selectedTurbine"
                @update-turbines="updateTurbines"
            />
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
import DeleteComponentModal from "./Modals/DeleteComponentModal.vue";
import DeleteInspectionModal from "./Modals/DeleteInspectionModal.vue";
import DeleteTurbineModal from "./Modals/DeleteTurbineModal.vue";
import AddComponentModal from "./Modals/AddComponentModal.vue";
import AddInspectionModal from "./Modals/AddInspectionModal.vue";
import AddTurbineModal from "./Modals/AddTurbineModal.vue";
import axios from "axios";

export default {
    components: {
        LMap,
        LTileLayer,
        LMarker,
        LPopup,
        LIcon,
        DeleteComponentModal,
        DeleteInspectionModal,
        DeleteTurbineModal,
        AddComponentModal,
        AddInspectionModal,
        AddTurbineModal,
    },
    data() {
        return {
            // leaflet data
            zoom: 2,
            defaultCenter: [47.41322, -1.219482],
            iconSize: 32,
            icon: L.icon({
                iconUrl: "/images/turbine.png",
                iconSize: [32, 37],
                iconAnchor: [16, 37],
            }),
            // selected turbine/id/component/inspection for showing/hiding parts of page
            selectedTurbine: null,
            selectedTurbineId: null,
            selectedComponent: null,
            selectedInspection: null,
            // turbines array
            turbines: [],
        };
    },

    created() {
        // on page creation, fetch turbine data
        this.fetchTurbines();
    },
    computed: {
        // icon size and anchor on map
        dynamicSize() {
            return [this.iconSize, this.iconSize * 1.15];
        },
        dynamicAnchor() {
            return [this.iconSize / 2, this.iconSize * 1.15];
        },
    },

    methods: {
        // get turbines (ensure they are empty and reload when fetching new data so component/incpection changes load through)
        fetchTurbines() {
            this.turbines = [];
            axios
                .get("/turbines")
                .then((resp) => {
                    this.turbines = resp.data.turbines;

                    // re-select turbine so table doesn't disappear at bottom on update/deletion of components/inspections
                    if (this.selectedTurbineId) {
                        const turbine = this.turbines.find(
                            (t) => t.id === this.selectedTurbineId
                        );
                        if (turbine) {
                            // reselect the turbine
                            this.selectedTurbine = turbine;
                        }
                    }
                })
                .catch((error) => {
                    console.error("Error fetching turbines:", error);
                });
        },

        updateTurbines(newTurbines) {
            // update the turbines data when the event is emitted
            this.fetchTurbines();
        },

        // select specific turbine on click - for table
        selectTurbine(turbine) {
            console.log(turbine);
            this.selectedTurbine = turbine;
            this.selectedTurbineId = turbine.id;
        },

        // select specific component on click - for modal
        selectComponent(component) {
            this.selectedComponent = component;
            document.getElementById("delete_component_modal").showModal();
        },

        // select specific component on click - for modal
        addInspection(component) {
            this.selectedComponent = component;
            document.getElementById("add_inspection_modal").showModal();
        },

        // select specific turbine on click - for modal
        addComponent(turbine) {
            this.selectedTurbine = turbine;
            document.getElementById("add_component_modal").showModal();
        },

        // show 'add turbine' modal
        addTurbine() {
            document.getElementById("add_turbine_modal").showModal();
        },

        // select inspection for deletion and show modal
        selectInspection(inspection) {
            this.selectedInspection = inspection;
            document.getElementById("delete_inspection_modal").showModal();
        },

        // show components/inspections table
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

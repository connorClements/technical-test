<template>
    <dialog id="add_turbine_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Add Turbine</h3>
            <p class="py-4">Enter details for the new turbine:</p>

            <form @submit.prevent="submitTurbine">
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Name</span>
                    </label>
                    <input
                        type="text"
                        v-model="name"
                        class="input input-bordered w-full"
                        required
                    />
                </div>
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Latitude</span>
                    </label>
                    <input
                        type="text"
                        v-model="latitude"
                        class="input input-bordered w-full"
                        required
                    />
                </div>
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Longitude</span>
                    </label>
                    <input
                        type="text"
                        v-model="longitude"
                        class="input input-bordered w-full"
                        required
                    />
                </div>

                <div class="modal-action">
                    <button
                        @click="submitTurbine()"
                        class="btn bg-green-500 text-white mr-1"
                    >
                        Add Turbine
                    </button>
                    <button @click="closeModal()" class="btn">Close</button>
                </div>
            </form>
        </div>
    </dialog>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import { router } from "@inertiajs/vue3";

export default {
    data() {
        return {
            name: "",
            latitude: "",
            longitude: "",
        };
    },
    methods: {
        submitTurbine() {
            const req = {
                name: this.name,
                latitude: this.latitude,
                longitude: this.longitude,
            };

            Inertia.post("/turbines", req, {
                onSuccess: (response) => {
                    router.reload({ only: ["turbines"] });

                    console.log(response);
                },
                onError: (error) => {
                    // Handle error (optional)
                    console.error("Error deleting inspection:", error);
                },
            });
        },

        closeModal() {
            const modal = document.getElementById("add_turbine_modal");
            modal.close();
        },
    },
};
</script>

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
                        type="submit"
                        class="btn bg-green-500 text-white mr-1"
                    >
                        <i class="fas fa-plus mr-1"></i> Add Turbine
                    </button>
                    <button @click="closeModal()" type="button" class="btn">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </dialog>
</template>

<script>
import axios from "axios";
import iziToast from "izitoast";

export default {
    components: {
        iziToast,
    },
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

            axios
                .post("/turbines", req)
                .then((response) => {
                    // trigger turbines update
                    this.$emit("updateTurbines", response.data.turbines);

                    // close modal
                    this.closeModal();

                    // alert showing turbine has been created
                    iziToast.show({
                        title: "Success",
                        color: "green",
                        position: "topCenter",
                        timeout: 3000,
                        message: response.data.message,
                    });
                })
                .catch((error) => {
                    // Handle error
                    console.error("Error submitting component:", error);
                });
        },

        // close modal
        closeModal() {
            const modal = document.getElementById("add_turbine_modal");
            modal.close();
        },
    },
};
</script>

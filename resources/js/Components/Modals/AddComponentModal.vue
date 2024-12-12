<template>
    <dialog id="add_component_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Add Component</h3>
            <p class="py-4">Enter details for the new component:</p>

            <form @submit.prevent="submitComponent">
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Component Name</span>
                    </label>
                    <input
                        type="text"
                        v-model="name"
                        class="input input-bordered w-full"
                        required
                    />
                </div>

                <div class="modal-action">
                    <button
                        type="submit"
                        class="btn bg-green-500 text-white mr-1"
                    >
                        <i class="fas fa-plus mr-1"></i> Add Component
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

    props: {
        turbine: Object,
    },
    data() {
        return {
            name: "",
        };
    },
    methods: {
        // submit new component as axios post request
        submitComponent() {
            const req = {
                turbine_id: this.turbine.id,
                name: this.name,
            };

            axios
                .post("/components", req)
                .then((response) => {
                    // emit turbines, which will trigger overall turbines update on parent
                    this.$emit("updateTurbines", response.data.turbines);

                    // empty fields
                    this.name = "";

                    // close modal
                    this.closeModal();

                    iziToast.show({
                        title: "Success",
                        color: "green",
                        position: "topCenter",
                        timeout: 3000,
                        message: response.data.message,
                    });

                    this.name = "";
                })
                .catch((error) => {
                    // Handle error
                    console.error("Error submitting component:", error);
                });
        },

        // close modal
        closeModal() {
            const modal = document.getElementById("add_component_modal");
            modal.close();
        },
    },
};
</script>

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
                        Add Component
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

export default {
    props: {
        turbine: Object, // The ID of the component to add the inspection for
    },
    data() {
        return {
            name: "",
        };
    },
    methods: {
        submitComponent() {
            const req = {
                turbine_id: this.turbine.id,
                name: this.name,
            };

            axios
                .post("/components", req)
                .then((response) => {
                    // Reload the turbine data or trigger any necessary state updates

                    this.$emit("updateTurbines", response.data.turbines);

                    const modal = document.getElementById(
                        "add_component_modal"
                    );
                    modal.close();

                    alert(response.data.message);
                })
                .catch((error) => {
                    // Handle error
                    console.error("Error submitting component:", error);
                });
        },

        closeModal() {
            const modal = document.getElementById("add_component_modal");
            modal.close();
        },
    },
};
</script>

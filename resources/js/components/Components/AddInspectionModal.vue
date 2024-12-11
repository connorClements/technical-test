<template>
    <dialog id="add_inspection_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Add Inspection</h3>
            <p class="py-4">Enter details for the new inspection:</p>

            <form @submit.prevent="submitInspection">
                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Inspection Date</span>
                    </label>
                    <input
                        type="date"
                        v-model="inspection_date"
                        class="input input-bordered w-full"
                        required
                    />
                </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text">Score</span>
                    </label>
                    <input
                        type="number"
                        v-model="score"
                        class="input input-bordered w-full"
                        min="0"
                        max="100"
                        required
                    />
                </div>

                <div class="modal-action">
                    <button
                        type="submit"
                        class="btn bg-green-500 text-white mr-1"
                    >
                        Add Inspection
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
        component: Object, // The ID of the component to add the inspection for
    },
    data() {
        return {
            inspection_date: "",
            score: "",
        };
    },
    methods: {
        submitInspection() {
            const req = {
                component_id: this.component.id,
                inspection_date: this.inspection_date,
                score: this.score,
            };

            axios
                .post("/inspections", req)
                .then((response) => {
                    // Reload the turbine data or trigger any necessary state updates
                    alert(response.data.message);

                    this.$emit("updateTurbines", response.data.turbines);

                    const modal = document.getElementById(
                        "add_inspection_modal"
                    );
                    modal.close();
                })
                .catch((error) => {
                    // Handle error
                    console.error("Error submitting component:", error);
                });
        },

        closeModal() {
            const modal = document.getElementById("add_inspection_modal");
            modal.close();
        },
    },
};
</script>

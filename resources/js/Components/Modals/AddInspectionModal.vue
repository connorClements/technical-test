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
                        v-model="inspectionDate"
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
                        min="1"
                        max="5"
                        required
                    />
                </div>

                <div class="modal-action">
                    <button
                        type="submit"
                        class="btn bg-green-500 text-white mr-1"
                    >
                        <i class="fas fa-plus mr-1"></i>Add Inspection
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
        component: Object, // The ID of the component to add the inspection for
    },
    data() {
        return {
            inspectionDate: "",
            score: "",
        };
    },
    methods: {
        // submit new inspection as POST
        submitInspection() {
            const req = {
                component_id: this.component.id,
                inspection_date: this.inspectionDate,
                score: this.score,
            };

            axios
                .post("/inspections", req)
                .then((response) => {
                    // emit turbines response to trigger update
                    this.$emit("updateTurbines", response.data.turbines);

                    // empty fields
                    this.inspectionDate = "";
                    this.score = "";
                    this.closeModal();

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
            const modal = document.getElementById("add_inspection_modal");
            modal.close();
        },
    },
};
</script>

<template>
    <dialog id="delete_inspection_modal" class="modal">
        <div class="modal-box">
            <h3 v-if="selectedInspection" class="text-lg font-bold">
                Are you sure you want to delete this inspection? - date:
                {{ selectedInspection.inspection_date }}, score:
                {{ selectedInspection.score }}
            </h3>
            <p class="py-4">Click 'Delete' to confirm, or 'Close' to cancel</p>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button
                        @click="deleteInspection(selectedInspection.id)"
                        class="btn bg-red-500 text-slate-50 mr-1"
                    >
                        Delete
                    </button>

                    <button class="btn">Close</button>
                </form>
            </div>
        </div>
    </dialog>
</template>
<script>
// import { router } from "@inertiajs/vue3";
import axios from "axios";

export default {
    props: {
        selectedInspection: Object,
    },

    methods: {
        // delete inspection on component
        deleteInspection(id) {
            axios
                .delete(`/inspections/${id}`)
                .then((response) => {
                    // emit to parent to get new turbine data
                    this.$emit("updateTurbines", response.data.turbines);

                    // close modal
                    const modal = document.getElementById(
                        "delete_inspection_modal"
                    );
                    modal.close();

                    // alert to show component has been deleted
                    alert(response.data.message);
                })
                .catch((error) => {
                    // Handle error
                    console.error("Error submitting component:", error);
                });
        },
    },
};
</script>

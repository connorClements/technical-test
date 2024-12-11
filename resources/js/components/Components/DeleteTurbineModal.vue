<template>
    <dialog v-if="selectedTurbine" id="delete_turbine_modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">
                Are you sure you want to delete this turbine? -
                {{ selectedTurbine.id }}. {{ selectedTurbine.name }}
            </h3>
            <p class="py-4">Click 'Delete' to confirm, or 'Close' to cancel</p>
            <div class="modal-action">
                <form method="dialog">
                    <button
                        @click="deleteTurbine(selectedTurbine.id)"
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
import axios from "axios";

export default {
    props: {
        selectedTurbine: Object,
    },

    methods: {
        // delete turbine
        deleteTurbine(id) {
            axios
                .delete(`/turbines/${id}`)
                .then((response) => {
                    // emit to parent to get new turbine data
                    this.$emit("updateTurbines", response.data.turbines);

                    // close modal
                    const modal = document.getElementById(
                        "delete_turbine_modal"
                    );
                    modal.close();

                    // alert to show turbine has been deleted
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

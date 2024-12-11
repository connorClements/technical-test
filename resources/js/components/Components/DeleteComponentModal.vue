<template>
    <dialog id="delete_component_modal" class="modal">
        <div class="modal-box">
            <h3 v-if="selectedComponent" class="text-lg font-bold">
                Are you sure you want to delete this component? -
                {{ selectedComponent.name }}
            </h3>
            <p class="py-4">Click 'Delete' to confirm, or 'Close' to cancel</p>
            <div class="modal-action">
                <form method="dialog">
                    <!-- if there is a button in form, it will close the modal -->
                    <button
                        @click="deleteComponent(selectedComponent.id)"
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
        selectedComponent: Object,
    },

    methods: {
        // delete component
        deleteComponent(id) {
            axios
                .delete(`/components/${id}`)
                .then((response) => {
                    // emit change to parent to update turbines
                    this.$emit("updateTurbines", response.data.turbines);

                    // close modal
                    const modal = document.getElementById(
                        "delete_component_modal"
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

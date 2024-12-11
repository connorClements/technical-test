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
                    <!-- if there is a button in form, it will close the modal -->
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
import { Inertia } from "@inertiajs/inertia";

export default {
    props: {
        selectedTurbine: Object,
    },

    methods: {
        deleteTurbine(id) {
            Inertia.delete(`/turbines/${id}`);
            alert("Turbine has been deleted");
        },
    },
};
</script>

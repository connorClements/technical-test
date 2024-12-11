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
import { Inertia } from "@inertiajs/inertia";
import { router } from "@inertiajs/vue3";

export default {
    props: {
        selectedComponent: Object,
    },

    methods: {
        deleteComponent(id) {
            Inertia.delete(`/components/${id}`, {
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
    },
};
</script>

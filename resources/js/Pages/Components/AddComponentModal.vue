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
                        @click="submitComponent()"
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
import { Inertia } from "@inertiajs/inertia";
import { router } from "@inertiajs/vue3";

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

            Inertia.post("/components", req, {
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

        closeModal() {
            const modal = document.getElementById("add_component_modal");
            modal.close();
        },
    },
};
</script>

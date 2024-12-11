import { createRouter, createWebHistory } from "vue-router";
import Turbines from "@/Pages/Turbines.vue"; // Adjust path if needed

const routes = [
    {
        path: "/",
        name: "Home",
        component: Turbines,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

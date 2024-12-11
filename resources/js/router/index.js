import { createRouter, createWebHistory } from "vue-router";
import App from "@/Components/App.vue"; // Adjust path if needed

const routes = [
    {
        path: "/",
        name: "Home",
        component: App,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

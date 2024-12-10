<template>
    <div class="bg-gradient-to-r from-slate-200 to-blue-200 min-h-screen">
        <div class="text-4xl text-center p-6 text-cyan-800">Turbine Map</div>
        <TurbineMap :turbines="turbines" />
    </div>
</template>

<script>
import TurbineMap from "./Components/TurbineMap.vue";

export default {
    props: {
        turbines: Array, // Receive turbines as a prop from the controller
    },
    components: {
        TurbineMap,
    },
};
</script>

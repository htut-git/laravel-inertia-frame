<template>
    <div>
        <NavBar></NavBar>
        <SideBar></SideBar>
        <div class="p-4 sm:ml-64 mt-14">
            <slot name="breadcrumbs"/>
            <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 ">
                <slot />
            </div>
        </div>

    </div>
</template>

<script setup>
import 'flowbite/dist/flowbite.min.css';
import { initFlowbite } from 'flowbite'
import NavBar from '@/Pages/Backend/Components/NavBar.vue';
import SideBar from '@/Pages/Backend/Components/SideBar.vue';
import { onMounted } from 'vue';
defineProps({
    title: String,
})
onMounted(()=>{
    initFlowbite();
})
</script>

<style lang="scss" scoped>
</style>

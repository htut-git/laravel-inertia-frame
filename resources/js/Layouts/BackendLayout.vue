<script setup>
import 'bootstrap/dist/css/bootstrap.css';
import '../../css/backend.css';
import NavBar from '@/Pages/Backend/Components/NavBar.vue';
import SideBar from '@/Pages/Backend/Components/SideBar.vue';
import Banner from '@/Components/Banner.vue';
defineProps({
    title: String,
})
</script>

<template>
    <div>
        <div class="wrapper">
            <SideBar></SideBar>
            <div class="main">
                <NavBar></NavBar>
                <main class="content">
                    <Banner/>
                    <div class="container-fluid p-0">
                        <slot />
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<style lang="scss" scoped>
</style>

<template>
    <div>
        <Head title="Role Create"></Head>
        <RoleForm type="create"/>
    </div>
</template>

<script>
export default {
    layout : BackendLayout
}
</script>

<script setup>
import BackendLayout from '@/Layouts/BackendLayout.vue';
import { Head } from '@inertiajs/vue3';
import RoleForm from './RoleForm.vue';

</script>

<style lang="scss" scoped>

</style>

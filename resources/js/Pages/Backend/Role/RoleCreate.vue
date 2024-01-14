<template>
    <BackendLayout>
        <template #breadcrumbs>
            <Breadcrumbs :home="{name:$t('roles'),href:route('admin.roles.index')}" />
        </template>

        <Head title="Role Create"></Head>
        <div class="mt-5">
            <RoleForm type="create" />
        </div>
    </BackendLayout>
</template>


<script setup>
import BackendLayout from '@/Layouts/BackendLayout.vue';
import { Head } from '@inertiajs/vue3';
import RoleForm from './RoleForm.vue';
import Breadcrumbs from '../Components/Breadcrumbs.vue';

</script>

<style lang="scss" scoped></style>

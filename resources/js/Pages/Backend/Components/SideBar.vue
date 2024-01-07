<template>
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="index.html">
                <span class="align-middle">AdminKit</span>
            </a>

            <ul class="sidebar-nav">
                <li class="sidebar-header">
                    Pages
                </li>

                <li :class="['sidebar-item', { 'active': $page.url.startsWith('/admin/dashboard') }]">
                    <Link class="sidebar-link" :href="route('admin.dashboard')">
                    <i class="fa-solid fa-chart-line"></i><span class="align-middle">Dashboard</span>
                    </Link>
                </li>

                <li :class="['sidebar-item', { 'active': $page.url.startsWith('/admin/user') }]">
                    <Link class="sidebar-link" :href="route('admin.users.index')">
                    <i class="fa-solid fa-users"></i> <span class="align-middle">Users</span>
                    </Link>
                </li>

                <li :class="['sidebar-item', { 'active': $page.url.startsWith('/admin/roles') }]">
                    <Link class="sidebar-link" :href="route('admin.roles.index')">
                    <i class="fa-solid fa-user-check"></i> <span class="align-middle">Roles</span>
                    </Link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted } from 'vue';
const page = usePage();
onMounted(() => {
});
</script>

<style lang="scss" scoped></style>

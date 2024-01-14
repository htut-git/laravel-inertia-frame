<template>
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <SideBarLink icon="fa-solid fa-chart-line" active="dashboard" :name="$t('dashboard')"
                    :href="route('admin.dashboard')" />
                <SideBarLink icon="fa-solid fa-users" active="users" :name="$t('users')"
                    :href="route('admin.users.index')" />
                <SideBarLink icon="fa-solid fa-user-check" active="roles" :name="$t('roles')"
                    :href="route('admin.roles.index')" />
                <li>
                    <a class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        href="/admin/log-viewer">
                        <i class="fa-solid fa-server"></i><span class="ms-3">{{ $t('logs') }}</span>
                    </a>
                </li>


            </ul>
        </div>
    </aside>
    <!-- <nav id="sidebar" class="sidebar js-sidebar">
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
                <li :class="['sidebar-item', { 'active': $page.url.startsWith('/admin/log-viewer') }]">
                    <a class="sidebar-link" href="/admin/log-viewer">
                        <i class="fa-solid fa-server"></i> <span class="align-middle">Logs</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav> -->
</template>

<script setup>
import SideBarLink from './SideBarLink.vue';
</script>

<style lang="scss" scoped></style>

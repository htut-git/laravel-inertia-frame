<template>
    <BackendLayout>

        <Head title="User Table"></Head>

        <div>
            <div
                class="flex mx-3 items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
                <div></div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input :value="$page.props.request?.search" @keypress.enter="searchUser" type="text"
                        id="table-search-users"
                        class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for users">
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{ $t('id') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ $t('name') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ $t('position') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ $t('status') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ $t('actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user) in $page.props.users.data" :key="user.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-6 py-3">
                                {{ user.id }}
                            </td>
                            <th scope="row"
                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full"
                                    :src="`https://ui-avatars.com/api/?size=40&background=random&name=${user.name}`"
                                    alt="Rounded avatar">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{ user.name }}</div>
                                    <div class="font-normal text-gray-500">{{ user.email }}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <span v-for="(role) in user.roles" :key="role.id" class='bg-blue-100 capitalize text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5
                    rounded dark:bg-blue-900 dark:text-blue-300'>{{ role.name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-2.5 w-2.5 rounded-full me-2" :class="[user.email_verified_at ? 'bg-green-500' : 'bg-red-500']"></div> {{ user.email_verified_at ? 'Active' : 'Not Active' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <!-- Modal toggle -->

                                <Link :href="route('admin.users.edit', user.id)"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit User</Link>

                            </td>
                        </tr>
                    </tbody>
                </table>
                <Paginations :links="$page.props.users" />
            </div>
        </div>
    </BackendLayout>
</template>

<script setup >
import { Head, router, Link } from '@inertiajs/vue3'
import BackendLayout from '@/Layouts/BackendLayout.vue';
import Paginations from '../Components/Paginations.vue';
const searchUser = (e) => {
    router.get(route('admin.users.index', { search: e.target.value }));
}
</script>

<style lang="scss"  scoped>
@import url("https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css");
</style>

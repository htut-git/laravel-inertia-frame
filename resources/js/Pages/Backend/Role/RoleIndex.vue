<template>
    <BackendLayout>

        <Head title="Role Table dt-button"></Head>
        <div>
            <div class="text-end my-5 ">
                <Link :href="route('admin.roles.create')"
                class="text-white bg-gradient-to-r    from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            <i class="fa-solid fa-plus"></i> {{ $tc('add new', { key: 'Role' }) }}
            </Link>
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
                                {{ $t('users') }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ $t('actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(role, index) in $page.props.roles" :key="index"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ role.id }}
                            </th>
                            <td class="px-6 py-4 capitalize ">
                                {{ role.name }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex -space-x-4 rtl:space-x-reverse">
                                    <img v-for="(user, index) in role.show_users" :key="index"
                                        class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800"
                                        :src="`https://ui-avatars.com/api/?size=40&background=random&name=${user.name}`"
                                        alt="">
                                    <span v-if="role.count_users - 3 > 0"
                                        class="flex items-center justify-center w-10 h-10 text-xs font-medium text-white bg-gray-700 border-2 border-white rounded-full hover:bg-gray-600 dark:border-gray-800"
                                        href="#">+{{ role.count_users }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <Link :href="route('admin.roles.edit', role.id)"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ $t('edit') }}
                                </Link>
                                <button v-if="role.count_users == 0" @click="deleteRole(role.id)" class="btn-danger ms-4">{{ $t('delete') }}</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </BackendLayout>
</template>

<script setup>
import BackendLayout from '@/Layouts/BackendLayout.vue';
import 'sweetalert2/src/sweetalert2.scss';
import { Head, Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2/dist/sweetalert2.js';

const deleteRole = async (id) => {
    const result = await Swal.fire({
        title: "Are you sure to delete this role?",
        showCancelButton: true,
        confirmButtonText: "Delete",
        confirmButtonColor: "#E8182E",
    })
    if (result.isConfirmed) {
        router.delete(route('admin.roles.destroy', id));
    }
};
</script>

<style lang="scss" scoped>
@import url("https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css");
</style>

<template>
    <BackendLayout>
        <Head title="Role Table"></Head>
        <div class=" my-5  text-end ">
            <Link :href="route('admin.roles.create')"
                class="text-white bg-gradient-to-r    from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
            <i class="fa-solid fa-plus"></i> {{ $tc('add new',{key:'Role'}) }}
            </Link>
        </div>
        <DataTable :key="pageKey" :columns="columns"
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" :options="dataTableOptions"
            :ajax="route('admin.roles-table')">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th>{{ $t('id') }}</th>
                    <th>{{ $t('name') }}</th>
                    <th>{{ $t('total users') }}</th>
                    <th >{{ $t('actions') }}</th>
                </tr>
            </thead>
        </DataTable>
    </BackendLayout>
</template>

<script setup>
import 'sweetalert2/src/sweetalert2.scss';
import $ from 'jquery';
import 'datatables.net-buttons/js/buttons.html5';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3'
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-responsive-dt';
import ActionsBtn from '../Helper/actionsBtn';
import jszip from 'jszip';
import { onUnmounted } from 'vue';
import { ref } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js'
DataTable.use(DataTablesCore);
DataTablesCore.Buttons.jszip(jszip);

const pageKey = ref(1);

const reloadTable = () => {
    pageKey.value += 1;
}

const columns = [
    { data: 'id' },
    { data: 'name' },
    { data: 'users_count_html', searchable: false, orderable: false },
    {
        data: 'actions', searchable: false, orderable: false,
        render(data, type, row) {
            if (row.id != 1) {
                return `${ActionsBtn.editBtn(row.id).html} ${row.users_count < 1 ? ActionsBtn.deleteBtn(row.id).html : ''}`
            };
            return '';
        }
    }
];

const dataTableOptions = {
    dom: 'Bflrtip',
    processing: true,
    serverSide: true,
    buttons: ['copy', 'csv', 'excel'],
    order: [[0, 'asc']],
    searching: true,
    columnDefs: [
        { orderable: false, targets: -1 }
    ],
    drawCallback: function (settings) {
        $(ActionsBtn.editBtn().class).click(function () {
            router.visit(route('admin.roles.edit', $(this).attr('data-id')));
        });
        $(ActionsBtn.deleteBtn().class).click(async function () {
            const result = await Swal.fire({
                title: "Are you sure to delete this role?",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#E8182E",
            })
            if (result.isConfirmed) {
                router.delete(route('admin.roles.destroy', $(this).attr('data-id')), {
                    onFinish: () => {
                        reloadTable();
                    }
                })
            }
        })
    }
};


onUnmounted(() => {
    $(ActionsBtn.editBtn().class).off('click')
})
</script>

<style lang="scss" scoped>
@import url("https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css");
</style>

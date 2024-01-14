<template>
    <BackendLayout >
        <Head title="User Table"></Head>
        <DataTable :columns="columns" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400" :options="dataTableOptions"
            :ajax="route('admin.users-table')">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th>{{ $t('id') }}</th>
                    <th>{{ $t('name') }}</th>
                    <th>{{ $t('email') }}</th>
                    <th>{{ $t('roles') }}</th>
                    <th>{{ $t('actions') }}</th>
                </tr>
            </thead>
        </DataTable>
    </BackendLayout>
</template>

<script setup >
import $ from 'jquery';
import 'datatables.net-buttons/js/buttons.html5';
import { Head, router } from '@inertiajs/vue3'
import BackendLayout from '@/Layouts/BackendLayout.vue';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-responsive-dt';
import ActionsBtn from '@/Pages/Backend/Helper/actionsBtn';
import jszip from 'jszip';
import { onUnmounted } from 'vue';
DataTable.use(DataTablesCore);
DataTablesCore.Buttons.jszip(jszip);
const columns = [
    { data: 'id' },
    { data: 'name' },
    { data: 'email' },
    { data: 'roles', name: 'roles.name' },
    {
        data: 'actions', searchable: false, orderable: false,
        render(data, type, row) {
            return ActionsBtn.editBtn(row.id).html;
        },
    }

]
const dataTableOptions = {
    dom: 'Bflrtip',
    processing: true,
    serverSide: true,
    order: [[0, 'asc']],
    searching: true,
    buttons: ['copy', 'csv', 'excel'],
    columnDefs: [
        { orderable: false, targets: -1 }
    ],
    drawCallback: function(settings) {
        $(ActionsBtn.editBtn().class).click(function(){
            router.visit(route('admin.users.edit',$(this).attr('data-id')));
        })
    }
};

onUnmounted(()=>{
    $(ActionsBtn.editBtn().class).off('click')
})
</script>

<style lang="scss"  scoped>
@import url("https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css");
</style>

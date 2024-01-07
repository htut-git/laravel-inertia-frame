<template>
    <div>

        <Head title="Role Table"></Head>
        <DataTable :columns="columns" class="table table-hover table-striped" :options="dataTableOptions"
            :ajax="route('admin.roles-table')">
            <thead>
                <tr>
                    <th>{{ $t('id') }}</th>
                    <th>{{ $t('name') }}</th>
                    <th>{{ $t('total users') }}</th>
                    <th>{{ $t('actions') }}</th>
                </tr>
            </thead>
        </DataTable>
    </div>
</template>

<script>
export default {
    layout: BackendLayout
}
</script>

<script setup>
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import { Head } from '@inertiajs/vue3'
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import ActionsBtn from '../Helper/actionsBtn';
import $ from 'jquery';
import { onUnmounted } from 'vue';
DataTable.use(DataTablesCore);

const columns = [
    { data: 'id' },
    { data: 'name' },
    { data: 'users_count',searchable:false,orderable:false},
    {
        data: 'actions', searchable: false, orderable: false,
        render(data, type, row) {
            return ActionsBtn.editBtn(row.id).html;
        }
    }
];

const dataTableOptions = {
    processing: true,
    serverSide: true,
    order: [[0, 'asc']],
    searching: true,
    columnDefs: [
        { orderable: false, targets: -1 }
    ],
    drawCallback: function (settings) {
        $(ActionsBtn.editBtn().class).click(function () {
            router.visit(route('admin.roles.edit', $(this).attr('data-id')));
        })
    }
};

onUnmounted(() => {
    $(ActionsBtn.editBtn().class).off('click')
})
</script>

<style lang="scss" scoped></style>

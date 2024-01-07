<template>
    <div class="container">

        <Head title="User Table"></Head>
        <DataTable :columns="columns" class="table table-hover table-striped" :options="dataTableOptions"
            :ajax="route('admin.users-table')">
            <thead>
                <tr>
                    <th>{{ $t('id') }}</th>
                    <th>{{ $t('name') }}</th>
                    <th>{{ $t('email') }}</th>
                    <th>{{ $t('roles') }}</th>
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

<script setup >
import $ from 'jquery';
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import { Head, router } from '@inertiajs/vue3'
import BackendLayout from '@/Layouts/BackendLayout.vue';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import ActionsBtn from '@/Pages/Backend/Helper/actionsBtn';
import { onUnmounted } from 'vue';
DataTable.use(DataTablesCore);
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
    processing: true,
    serverSide: true,
    order: [[0, 'asc']],
    searching: true,
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

<style lang="scss"  scoped></style>
@/Pages/Backend/Helper/actionsBtn

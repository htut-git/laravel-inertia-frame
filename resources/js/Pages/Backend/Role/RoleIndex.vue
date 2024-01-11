<template>
    <div class="card">
        <div class="card-header text-end ">
            <Link :href="route('admin.roles.create')" class="btn btn-success">
            <i class="fa-solid fa-plus"></i> {{ $t('new') }}
            </Link>
        </div>
        <div class="card-body">

            <Head title="Role Table"></Head>
            <DataTable v-if="tableStatus" :columns="columns" class="table table-hover table-striped"
                :options="dataTableOptions" :ajax="route('admin.roles-table')">
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
    </div>
</template>

<script>
export default {
    layout: BackendLayout
}
</script>

<script setup>
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';
import 'sweetalert2/src/sweetalert2.scss';

import $ from 'jquery';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.html5';
import BackendLayout from '@/Layouts/BackendLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3'
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import ActionsBtn from '../Helper/actionsBtn';
import jszip from 'jszip';
import { onUnmounted } from 'vue';
import { ref } from 'vue';
import Swal from 'sweetalert2/dist/sweetalert2.js'
DataTable.use(DataTablesCore);
DataTablesCore.Buttons.jszip(jszip);

const tableStatus = ref(true);

const reloadTable = () => {
    tableStatus.value = false;
    setTimeout(() => {
        tableStatus.value = true;
    }, 100);
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
    buttons: ['copy', 'csv', 'excel', 'colvis'],
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

<style lang="scss" scoped></style>

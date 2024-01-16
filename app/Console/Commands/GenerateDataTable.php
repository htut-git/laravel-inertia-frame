<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateDataTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-data-table {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create A Vue DataTable Component';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('filename');
        $filePath = resource_path("js/Pages/{$filename}.vue");

        if (file_exists($filePath)) {
            $this->error("The Vue file '{$filename}.vue' already exists!");
        }

        $vueContent = $this->generateDataBaseCode($filename);

        File::put($filePath, $vueContent);

        $this->info("Vue dataTable '{$filename}.vue' created successfully!");
    }

    private function generateDataBaseCode($filename)
    {
        return <<<VUE
            <template>
                <BackendLayout>
                    <Head title="$filename Table"></Head>
                    <DataTable :key="tableKey" :columns="columns" class="table table-hover table-striped" :options="dataTableOptions"
                        :ajax="route('admin.')">
                        <thead>
                            <tr>
                                <th>{{ \$t('id') }}</th>
                                <th>{{ \$t('actions') }}</th>
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

            const tableKey = ref(1);

            const reloadTable = () => {
                tableKey.value += 1;
            }

            const columns = [
                { data: 'id' },
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
                        router.visit(route('admin.*.edit', $(this).attr('data-id')));
                    })
                }
            };

            onUnmounted(()=>{
                $(ActionsBtn.editBtn().class).off('click')
            })
            </script>

            <style lang="scss" scoped>
            @import url("https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-1.13.8/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/datatables.min.css");
            </style>
    VUE;
    }
}

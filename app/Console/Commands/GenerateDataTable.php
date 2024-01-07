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
                <div>

                    <Head title="$filename Table"></Head>
                    <DataTable :columns="columns" class="table table-hover table-striped" :options="dataTableOptions"
                        :ajax="route('admin.')">
                        <thead>
                            <tr>
                                <th>{{ \$t('id') }}</th>
                                <th>{{ \$t('actions') }}</th>
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

            <style lang="scss" scoped></style>
    VUE;
    }
}

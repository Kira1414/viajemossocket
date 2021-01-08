<template>
	<div>
		<table class="table" id="autores-table" style="width:100%">
			<thead>
				<tr>
					<th v-for="(column, key) in columns" :key="key">{{column}}</th>
				</tr>
			</thead>
            <tbody></tbody>
			<tfoot>
				<tr>
					<td v-for="(column, key) in columns" :key="key">{{column}}</td>
				</tr>
			</tfoot>
		</table>
        <el-dialog
            title="¡Atención!"
            :visible.sync="dialogVisible"
            width="30%"
            >
            <span>Esta acción es permanente, ¿está seguro que desea continuar?</span>
            <span slot="footer" class="dialog-footer">
                <el-button @click="dialogVisible = false">Cancelar</el-button>
                <el-button type="primary" @click="deleteElement">Eliminar</el-button>
            </span>
        </el-dialog>
	</div>
</template>
<script>
    import EventBus from "../EventBus.vue"
    import 'datatables.net-colreorder-bs4/css/colReorder.bootstrap4.css'
    import 'datatables.net-buttons-bs4/css/buttons.bootstrap4.css'
    import 'datatables.net-bs4/css/dataTables.bootstrap4.css'
    import Notifications from 'vue-notification'
    Vue.use(Notifications)
    export default {
        name:'ListAutoresComponent',
        mounted() {
            this.$nextTick(() => {
                this.datatable = this.initTable()
            })

            EventBus.$on("create-autor", e => 
            {
                this.datatable.columns.adjust().draw();
            })
            EventBus.$on("update-autor", e => 
            {
                this.datatable.columns.adjust().draw();
            })
            EventBus.$on("delete-autor", e => 
            {
                this.datatable.columns.adjust().draw();
            })

        },
        data()
        {
            return {
                datatable: null,
                columns: ['Nombre', 'Sede', 'Acciones'],
                view: 'listar',
                dialogVisible: false,
                id: null
            }
        },
        methods:
        {
            initTable(){
                // Setup - add a text input to each footer cell
                let vm = this;

                let table = $('#autores-table').DataTable({
                    dom: "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'fr>><'row'<'col-sm-12't>><'row'<'col-sm-6'i><'col-sm-6'p>>",
                    iDisplayLength: 25,
                    scrollY: 560,
                    scrollX: true,
                    colReorder: true,
                    processing: true,
                    serverSide: true,
                    //stateSave: true,
                    order: [[0, "desc"]],
                    ajax: {
                        url: "/api/autores/list",
                        //headers: Header.getHeaders()
                    },
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: `<i class="far fa-file-excel" data-toggle="tooltip" data-placement="top" title="Exportar xls" aria-hidden="true"></i>`
                        },
                        {
                            extend: 'csvHtml5',
                            text: '<i class="fas fa-file-csv" data-toggle="tooltip" data-placement="top" title="Exportar csv" aria-hidden="true"></i>'

                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="far fa-file-pdf" data-toggle="tooltip" data-placement="top" title="Exportar pdf" aria-hidden="true"></i>'

                        },
                        {
                            extend: 'colvis',
                            text: '<i class="fas fa-columns" data-toggle="tooltip" data-placement="top" title="Ocultar/Mostrar columnas" aria-hidden="true"></i>'
                        },
                        {
                            text: `<i class="fas fa-sync" data-toggle="tooltip" data-placement="top" title="Refrescar" aria-hidden="true"></i>`,
                            action: function (e, dt, node, config) {
                                //$('.filters-table').selectpicker('deselectAll');
                                vm.datatable.columns.adjust().draw();
                            },
                        }

                    ],
                    columns: [
                        {"data": "nombre"},
                        {"data": "apellidos"},
                        {
                            "data": "id",
                            "render": function(value, display, obj)
                            {
                                return "<button class='btn btn-outline-primary edit'><i class='fas fa-edit'></i></button> <button class='btn btn-outline-danger delete'><i class='fas fa-times'></i></button>"
                            }
                        },
                    ],

                    initComplete: function (settings, json) {


                    },
                });

                $("#autores-table tbody").on("click",".edit", function(event)
                {
                    let data = table.row($(this).parents('tr')).data();
                    vm.edit(data)
                    event.stopPropagation();
                })
                $("#autores-table tbody").on("click",".delete", function(event)
                {
                    let data = table.row($(this).parents('tr')).data();
                    vm.delete(data)
                    event.stopPropagation();
                })
                return table
            },
            edit(data)
            {
                EventBus.$emit("subView", "editar")
                this.$nextTick(()=>{
                    EventBus.$emit("id", data.id)
                })
            },
            delete(data)
            {
                this.id = data.id                
                this.dialogVisible = true
            },
            deleteElement()
            {

                axios.delete(`/api/autores/delete/${this.id}`).then(res => {
                    this.dialogVisible = false
                    this.notify("Eliminado", "Registro eliminado", "warn")
                    this.datatable.columns.adjust().draw();
                }).catch(err => {
                    console.log(err)
                })                

            },
            notify(title, message, type)
            {
                this.$notify({
                    group: 'foo',
                    title: title,
                    text: message,
                    type: type
                });
            },
        }
    }
</script>

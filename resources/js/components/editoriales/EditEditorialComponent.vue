<template>
    <div class="row justify-content-center aligned">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">Modificar editorial <b>{{editorial.nombre}}</b></div>
                        <div class="col-md-3 text-right">
                            <a @click="closeView" class="btn btn-outline-primary"><i class="fas fa-times"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
					<form-editorial-component :errors="errors"></form-editorial-component>
					<button @click.prevent="editEditorial" type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    import FormEditorialComponent from "./FormEditorialComponent.vue"
    import Notifications from 'vue-notification'
    Vue.use(Notifications)
    export default {
		props:[],
		name:'EditEditorialComponent',
		components:
		{
			"form-editorial-component":FormEditorialComponent
		},
        mounted() {
            //this.$notify('text')
            
			EventBus.$on("id", id =>
			{
                this.id = id
            })
            
            EventBus.$on("nombre", nombre =>
			{
                this.editorial.nombre = nombre
            })
            
			EventBus.$on("sede", sede=>
			{
                this.editorial.sede = sede
            })

        },
        data()
        {
            return {
                id: null,
                editorial: {
                    nombre: null,
                    sede: null
                },
                errors: {},
            }
        },
        methods:
        {

            editEditorial()
            {
                axios.put(`/api/editoriales/update/${this.id}`,this.editorial).then(res => {
                    this.notify("Actualizado", "Se ha actualizado correctamente", "success")
                }).catch(err => {
                    this.errors = err.response.data.errors
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
            closeView()
            {
                EventBus.$emit("subView","listar")
            }
            
        }
    }
</script>
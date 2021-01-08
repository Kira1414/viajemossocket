<template>
    <div class="row justify-content-center aligned">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">Modificar Autor <b>{{autor.nombre}}</b></div>
                        <div class="col-md-3 text-right">
                            <a @click="closeView" class="btn btn-outline-primary"><i class="fas fa-times"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
					<form-autor-component :errors="errors"></form-autor-component>
					<button @click.prevent="editAutor" type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    import FormAutorComponent from "./FormAutorComponent.vue"
    import Notifications from 'vue-notification'
    Vue.use(Notifications)
    export default {
		props:[],
		name:'EditAutorComponent',
		components:
		{
			"form-autor-component":FormAutorComponent
		},
        mounted() {
            //this.$notify('text')
            
			EventBus.$on("id", id =>
			{
                this.id = id
            })
            
            EventBus.$on("nombre", nombre =>
			{
                this.autor.nombre = nombre
            })
            
			EventBus.$on("apellidos", apellidos=>
			{
                this.autor.apellidos = apellidos
			})

        },
        data()
        {
            return {
                id: null,
                autor: {
                    nombre: null,
                    apellidos: null
                },
                errors: {},
            }
        },
        methods:
        {

            editAutor()
            {
                axios.put(`/api/autores/update/${this.id}`,this.autor).then(res => {
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
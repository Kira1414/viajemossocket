<template>
    <div class="row justify-content-center aligned">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">Modificar libro <b>{{libro.titulo}}</b></div>
                        <div class="col-md-3 text-right">
                            <a @click="closeView" class="btn btn-outline-primary"><i class="fas fa-times"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
					<form-libro-component :errors="errors"></form-libro-component>
					<button @click.prevent="editlibro" type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    import FormLibroComponent from "./FormLibroComponent.vue"
    import Notifications from 'vue-notification'
    Vue.use(Notifications)
    export default {
		props:[],
		name:'EditLibroComponent',
		components:
		{
			"form-libro-component":FormLibroComponent
		},
        mounted() {
            //this.$notify('text')
            
			EventBus.$on("id", id =>
			{
                this.id = id
            })
            
            EventBus.$on("titulo", titulo =>
			{
                this.libro.titulo = titulo
            })
            
			EventBus.$on("editoriales_id", editoriales_id=>
			{
                this.libro.editoriales_id = editoriales_id
			})
            
            EventBus.$on("sinopsis", sinopsis=>
			{
                this.libro.sinopsis = sinopsis
            })
            
			EventBus.$on("n_paginas", n_paginas=>
			{
                this.libro.n_paginas = n_paginas
			})

        },
        data()
        {
            return {
                id: null,
                libro: {
                    titulo: null,
                    editoriales_id: null,
                    sinopsis: null,
                    n_paginas: null,
                },
                errors: {},
            }
        },
        methods:
        {

            editlibro()
            {
                axios.put(`/api/libros/update/${this.id}`,this.libro).then(res => {
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
<template>
    <div class="row justify-content-center aligned">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
					
                </div>
                <div class="card-body">
					<form-autor-component :errors="errors"></form-autor-component>
					<button @click.prevent="create" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    import FormAutorComponent from "./FormAutorComponent.vue"
    export default {
		props:[],
		name:'CreateAutorComponent',
		components:
		{
			"form-autor-component":FormAutorComponent
		},
        mounted() {
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
                autor: {
					nombre: null,
					apellidos: null
                },
                errors: {},
            }
        },
        methods:
        {
			create()
			{
				axios.post('/api/autores/create',this.autor).then(res => {
                    this.notify("Creado", "Se ha creado correctamente", "primary")
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
            }
        }
    }
</script>
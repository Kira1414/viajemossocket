<template>
    <div class="row justify-content-center aligned">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
					
                </div>
                <div class="card-body">
					<form-editorial-component :errors="errors"></form-editorial-component>
					<button @click.prevent="create" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    import FormEditorialComponent from "./FormEditorialComponent.vue"
    export default {
		props:[],
		name:'CreateEditorialComponent',
		components:
		{
			"form-editorial-component":FormEditorialComponent
		},
        mounted() {
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
                editorial: {
					nombre: null,
					sede: null
                },
                errors: {},
            }
        },
        methods:
        {
			create()
			{
				axios.post('/api/editoriales/create',this.editorial).then(res => {
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
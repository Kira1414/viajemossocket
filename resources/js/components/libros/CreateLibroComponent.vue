<template>
    <div class="row justify-content-center aligned">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
					
                </div>
                <div class="card-body">
					<form-libro-component :errors="errors"></form-libro-component>
					<button @click.prevent="create" type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    import FormLibroComponent from "./FormLibroComponent.vue"
    export default {
		props:[],
		name:'CreateLibroComponent',
		components:
		{
			"form-libro-component":FormLibroComponent
		},
        mounted() {
			EventBus.$on("titulo", titulo =>
			{
				this.libro.titulo = titulo
			})
			EventBus.$on("editoriales_id", editoriales_id =>
			{
				this.libro.editoriales_id = editoriales_id
			})
			EventBus.$on("sinopsis", sinopsis =>
			{
				this.libro.sinopsis = sinopsis
			})
			EventBus.$on("n_paginas", n_paginas =>
			{
				this.libro.n_paginas = n_paginas
			})
        },
        data()
        {
            return {
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
			create()
			{
				axios.post('/api/libros/create',this.libro).then(res => {
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
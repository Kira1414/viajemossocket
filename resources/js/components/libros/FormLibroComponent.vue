<template>
	<div>
		<form>
			<div class="form-group">
				<label for="titulo">Titulo</label>
				<input type="text" v-model="titulo" class="form-control" id="titulo" placeholder="titulo libro">
				<small v-if="errors.titulo" id="tituloError" class="form-text text-muted alert alert-danger">{{errors.titulo}}</small>
			</div>
			<div class="form-group">
				<label for="sinopsis">Sinopsis</label>
				<input type="text" v-model="sinopsis" class="form-control" id="sinopsis" placeholder="sinopsis libro">
				<small v-if="errors.sinopsis" id="sinopsisError" class="form-text text-muted alert alert-danger">{{errors.sinopsis}}</small>
			</div>
			<div class="form-group">
				<label for="n_paginas"># Paginas</label>
				<input type="text" v-model="n_paginas" class="form-control" id="n_paginas" placeholder="# paginas libro">
				<small v-if="errors.n_paginas" id="n_paginasError" class="form-text text-muted alert alert-danger">{{errors.n_paginas}}</small>
			</div>
			<div class="form-group">
				<label for="editorial">Editorial</label>
				<br>
				<el-select v-model="editoriales_id" id="editoriales_id" filterable placeholder="Select">
					<el-option
					v-for="item in options"
					:key="item.value"
					:label="item.label"
					:value="item.value">
					</el-option>
				</el-select>
				<small v-if="errors.editoriales_id" id="editorialError" class="form-text text-muted alert alert-danger">{{errors.editoriales_id}}</small>
			</div>
		</form>
	</div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    export default {
		props:["errors"],
        name:'LibrosComponent',
        mounted() {
			this.getEditoriales()
			EventBus.$on("id", id=>
			{
                this.id = id
                this.getLibro()
			})
			EventBus.$on("update-libro", e => 
            {
                if(e.isbn == this.id)
                {
					this.titulo = e.titulo
					this.editoriales_id = e.editoriales_id
					this.sinopsis = e.sinopsis
					this.n_paginas = e.n_paginas
                }
            })
        },
        data()
        {
            return {
				titulo: null,
				editoriales_id: null,
				sinopsis: null,
				n_paginas: null,
				options: []
            }
        },
        methods:
        {
			getLibro()
            {
                axios.get(`/api/libros/get/${this.id}`).then(res => {
                    this.titulo = res.data.titulo
					this.editoriales_id = res.data.editoriales_id
					this.sinopsis = res.data.sinopsis
					this.n_paginas = res.data.n_paginas
                }).catch(err => {
                    console.log(err)
                })
            },
			getEditoriales()
            {
                axios.get(`/api/editoriales/list`).then(res => {
					this.options = this.map(res.data.data)
                }).catch(err => {
                    console.log(err)
                })
			},
			map(arr)
			{

				return arr.map((obj)=>{
					return {label:obj.nombre, value: obj.id}
				})

			}
		},
		watch:
		{
			"titulo":function(newVal)
			{
				EventBus.$emit("titulo", newVal)
			},
			"editoriales_id":function(newVal)
			{
				EventBus.$emit("editoriales_id", newVal)
			},
			"sinopsis":function(newVal)
			{
				EventBus.$emit("sinopsis", newVal)
			},
			"n_paginas":function(newVal)
			{
				EventBus.$emit("n_paginas", newVal)
			}
		},
		beforeDestroy () {
            EventBus.$off('id')
        }
    }
</script>
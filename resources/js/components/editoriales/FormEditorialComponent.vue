<template>
	<div>
		<form>
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" v-model="nombre" class="form-control" id="nombre" placeholder="Nombre editorial">
				<small v-if="errors.nombre" id="nombreError" class="form-text text-muted alert alert-danger">{{errors.nombre}}</small>
			</div>
			<div class="form-group">
				<label for="sede">Sede</label>
				<input type="text" v-model="sede" class="form-control" id="sede" placeholder="Sede editorial">
				<small v-if="errors.sede" id="sedeError" class="form-text text-muted alert alert-danger">{{errors.sede}}</small>
			</div>
		</form>
	</div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    export default {
		props:["errors"],
        name:'EditorialesComponent',
        mounted() {

			EventBus.$on("id", id=>
			{
                this.id = id
                this.getEditorial()
			})
			EventBus.$on("update-editorial", e => 
            {
                if(e.id == this.id)
                {
                    this.nombre = e.nombre
                    this.sede = e.sede
                }
            })
        },
        data()
        {
            return {
				nombre: null,
				sede: null,
            }
        },
        methods:
        {
			getEditorial()
            {
                axios.get(`/api/editoriales/get/${this.id}`).then(res => {
                    this.nombre = res.data.nombre
					this.sede = res.data.sede
                }).catch(err => {
                    console.log(err)
                })
            }
		},
		watch:
		{
			"nombre":function(newVal)
			{
				EventBus.$emit("nombre", newVal)
			},
			"sede":function(newVal)
			{
				EventBus.$emit("sede", newVal)
			}
		},
		beforeDestroy () {
            EventBus.$off('id')
        }
    }
</script>
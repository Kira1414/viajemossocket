<template>
	<div>
		<form>
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" v-model="nombre" class="form-control" id="nombre" placeholder="Nombre autor">
				<small v-if="errors.nombre" id="nombreError" class="form-text text-muted alert alert-danger">{{errors.nombre}}</small>
			</div>
			<div class="form-group">
				<label for="apellidos">Apellidos</label>
				<input type="text" v-model="apellidos" class="form-control" id="apellidos" placeholder="Apellidos autor">
				<small v-if="errors.apellidos" id="apellidosError" class="form-text text-muted alert alert-danger">{{errors.apellidos}}</small>
			</div>
		</form>
	</div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    export default {
		props:["errors"],
        name:'AutoresComponent',
        mounted() {

			EventBus.$on("id", id=>
			{
                this.id = id
                this.getAutor()
			})
			
			EventBus.$on("update-autor", e => 
            {
                if(e.id == this.id)
                {
                    this.nombre = e.nombre
                    this.apellidos = e.apellidos
                }
            })
        },
        data()
        {
            return {
				nombre: null,
				apellidos: null,
            }
        },
        methods:
        {
			getAutor()
            {
                axios.get(`/api/autores/get/${this.id}`).then(res => {
                    this.nombre = res.data.nombre
					this.apellidos = res.data.apellidos
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
			"apellidos":function(newVal)
			{
				EventBus.$emit("apellidos", newVal)
			}
		},
		beforeDestroy () {
            EventBus.$off('id')
        }
    }
</script>
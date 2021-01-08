<template>
    <div class="row justify-content-center aligned">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a @click.prevent="changeView('listar')" class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Lista</a>
                            <a @click.prevent="changeView('crear')" class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Crear</a>
                        </div>
                    </nav>

                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div v-if="view == 'listar'" class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <list-libros-component v-if="subView == 'listar'"></list-libros-component>
                            <edit-libro-component v-if="subView == 'editar'"></edit-libro-component>
                        </div>
                        <div v-if="view == 'crear'" class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <create-libros-component></create-libros-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    import CreateLibroComponent from "./CreateLibroComponent.vue"
    import EditLibroComponent from "./EditLibroComponent.vue"
    import ListLibrosComponent from "./ListLibrosComponent.vue"
    export default {
        name:'LibrosComponent',
        components:
        {
            "create-libros-component":CreateLibroComponent,
            "edit-libro-component":EditLibroComponent,
            "list-libros-component":ListLibrosComponent,
        },
        mounted() {
            EventBus.$on("subView", subView => {
                this.subView = subView
            })

            Echo.channel('create-libro-channel').listen('.create-libro-event', (e) => {
                EventBus.$emit("create-libro", e)
            })
            
            Echo.channel('update-libro-channel').listen('.update-libro-event', (e) => {
                EventBus.$emit("update-libro", e)
            })
            Echo.channel('delete-libro-channel').listen('.delete-libro-event', (e) => {
                EventBus.$emit("delete-libro", e)
            })
        },
        data()
        {
            return {
                view: 'listar',
                subView: 'listar'
            }
        },
        methods:
        {
            changeView(view)
            {
                this.view = view
                this.subView = "listar"
            }
        }
    }
</script>
<style scoped>
.aligned{
    margin-right: 0.5%;
}
</style>
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
                            <list-autores-component v-if="subView == 'listar'"></list-autores-component>
                            <edit-autor-component v-if="subView == 'editar'"></edit-autor-component>
                        </div>
                        <div v-if="view == 'crear'" class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <create-autor-component></create-autor-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    import CreateAutorComponent from "./CreateAutorComponent.vue"
    import EditAutorComponent from "./EditAutorComponent.vue"
    import ListAutoresComponent from "./ListAutoresComponent.vue"
    export default {
        name:'autoresComponent',
        components:
        {
            "create-autor-component":CreateAutorComponent,
            "edit-autor-component":EditAutorComponent,
            "list-autores-component":ListAutoresComponent,
        },
        mounted() {
            EventBus.$on("subView", subView => {
                this.subView = subView
            })

            Echo.channel('create-autor-channel').listen('.create-autor-event', (e) => {
                EventBus.$emit("create-autor", e)
            })
            
            Echo.channel('update-autor-channel').listen('.update-autor-event', (e) => {
                EventBus.$emit("update-autor", e)
            })
            Echo.channel('delete-autor-channel').listen('.delete-autor-event', (e) => {
                EventBus.$emit("delete-autor", e)
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
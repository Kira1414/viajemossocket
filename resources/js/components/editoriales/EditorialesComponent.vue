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
                            <list-editoriales-component v-if="subView == 'listar'"></list-editoriales-component>
                            <edit-editorial-component v-if="subView == 'editar'"></edit-editorial-component>
                        </div>
                        <div v-if="view == 'crear'" class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <create-editorial-component></create-editorial-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EventBus from "../EventBus.vue"
    import CreateEditorialComponent from "./CreateEditorialComponent.vue"
    import EditEditorialComponent from "./EditEditorialComponent.vue"
    import ListEditorialesComponent from "./ListEditorialesComponent.vue"
    export default {
        name:'EditorialesComponent',
        components:
        {
            "create-editorial-component":CreateEditorialComponent,
            "edit-editorial-component":EditEditorialComponent,
            "list-editoriales-component":ListEditorialesComponent,
        },
        mounted() {
            EventBus.$on("subView", subView => {
                this.subView = subView
            })

            //Subscribe to the channel we specified in our Adonis Application
            /* let channel = pusher.subscribe('delete-editorial-channel')


            channel.bind('delete-editorial-event', (data) => {
                console.log(data)
            }) */
            
            Echo.channel('create-editorial-channel').listen('.create-editorial-event', (e) => {
                EventBus.$emit("create-editorial", e)
            })
            
            Echo.channel('update-editorial-channel').listen('.update-editorial-event', (e) => {
                EventBus.$emit("update-editorial", e)
            })
            Echo.channel('delete-editorial-channel').listen('.delete-editorial-event', (e) => {
                EventBus.$emit("delete-editorial", e)
            })
            //console.log(Echo)
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
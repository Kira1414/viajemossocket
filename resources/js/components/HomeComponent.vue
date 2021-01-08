<template>
    <div class="row">
        <notifications group="foo" />
        <div class="col-md-2">
            <div class="nav flex-column nav-pills bg-white" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a @click.prevent="changeView('editoriales')" class="nav-link active" id="editoriales-tab" data-toggle="pill" href="#editoriales" role="tab" aria-controls="editoriales" aria-selected="true">Editoriales</a>
                <a @click.prevent="changeView('autores')" class="nav-link" id="autores-tab" data-toggle="pill" href="#autores" role="tab" aria-controls="autores" aria-selected="false">Autores</a>
                <a @click.prevent="changeView('libros')" class="nav-link" id="libros-tab" data-toggle="pill" href="#libros" role="tab" aria-controls="libros" aria-selected="false">Libros</a>
            </div>
        </div>
        <div class="col-md-10">
            <div v-if="view == 'editoriales'" class="tab-pane active show" id="editoriales">
                <editoriales-component></editoriales-component>
            </div>
            <div v-if="view == 'autores'" class="tab-pane fade" id="autores">
                <autores-component></autores-component>
            </div>
            <div v-if="view == 'libros'" class="tab-pane fade" id="libros">
                <libros-component></libros-component>
            </div>
        </div>
    </div>
</template>

<script>
    import EditorialesComponent from './editoriales/EditorialesComponent.vue'
    import AutoresComponent from './autores/AutoresComponent.vue'
    import LibrosComponent from './libros/LibrosComponent.vue'

    export default {
        name:'HomeCompponent',
        components:
        {
            'editoriales-component': EditorialesComponent,
            'autores-component': AutoresComponent,
            'libros-component': LibrosComponent
        },
        data()
        {
            return{
                view: 'editoriales'
            }
        },
        mounted() {
            
            /* if (localStorage.viewHome) {
                $("#"+localStorage.viewHome).addClass("active")
                $("#"+localStorage.viewHome).addClass("show")
                $("#"+localStorage.viewHome+"-tab").click()
                $("#"+localStorage.viewHome+"-tab").addClass("active")
                this.view = localStorage.viewHome;
                console.log(this.view)
            } */
            //console.log('Home Component mounted.')
        },
        created()
        {
            
        },
        methods:
        {
            changeView(view)
            {
                //localStorage.viewHome = view
                this.view = view;
                //console.log(this.view)
            }
        }
    }
</script>

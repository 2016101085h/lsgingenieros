<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Cursos
                        <button type="button" @click="abrirModal('curso','registrar')" class="btn btn-secondary" >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="horas_academicas">Horas</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarCurso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarCurso(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    
                                    <th>Nombre</th>
                                    <th>Horas Académicas</th>
                                    <th>Tipo</th>
                                   
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="curso in arrayCurso" :key="curso.id">
                                    <td>
                                        <button type="button" @click="abrirModal('curso','actualizar',curso)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="curso.condicion">
                                            <button @click="desactivarCurso(curso.id)" type="button" class="btn btn-danger btn-sm" >
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                         <template v-else>
                                            <button @click="activarCurso(curso.id)" type="button" class="btn btn-info btn-sm" >
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    
                                    <td v-text="curso.nombre"></td>
                                    <td v-text="curso.horas_academicas"></td>
                                    <td v-text="curso.tipo"></td>
                                    
                                    <td>
                                        <div v-if="curso.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                </tr>
                               
                               
                                
                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link"  href="#" @click.prevent="cambiarpagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item " v-for="page in pagesNumber" :key="page" :class = "[page == isActived ? 'active' :'' ]">
                                    <a class="page-link" href="#" @click.prevent="cambiarpagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarpagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar': modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del Curso">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Horas Academicas</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="horas_academicas" class="form-control" placeholder="Ingrese las Horas Academicas">
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Grado Academico</label>
                                    <div class="col-md-9">
                                        <select v-model="tipo" class="form-control">
                                            <option value="1" disabled>Ingrese el tipo de curso</option>
                                            <option value="Curso de Especializacion">Curso de Especializacion</option>
                                            <option value="Paquete de Especializacion">Paquete de Especializacion</option>
                                          
                                        </select>                                    
                                    </div>
                                </div>
                                <div v-show="errorCurso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCurso" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" @click="registrarCurso()" class="btn btn-primary">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" @click="actualizarCurso()" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
           
            
        </main>
</template>

<script>
    export default {
        data(){
            return{
                curso_id:0,
                nombre: '',
                horas_academicas:'',
                tipo:'',
                arrayCurso: [],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorCurso:0,
                errorMostrarMsjCurso:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },
                offset:3,
                criterio:'nombre',
                buscar:''

            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //calcula los elemenos de la paginacion
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page-this.offset;
                if(from<1){
                    from=1;
                }
                var to = from+(this.offset*2);
                if(to>=this.pagination.last_page){
                    to=this.pagination.last_page;
                }
                var pagesArray=[];
                while(from <= to){

                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods:{
            listarCurso(page,buscar,criterio){
                let me=this;
                var url='/curso?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    // // handle success
                    // console.log(response);
                    me.arrayCurso=respuesta.cursos.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
            },
            cambiarpagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page= page;

                //Envia la peticion para visualizar la data de esa pagina
                me.listarCurso(page,buscar,criterio);
            },
            registrarCurso(){
                if(this.validarCurso()){
                    return;
                }
                let me=this;
                axios.post('curso/registrar',{
                    'nombre':this.nombre,
                    'horas_academicas':this.horas_academicas,
                    'tipo':this.tipo,
                }
                ).then(function (response){
                    me.cerrarModal();
                    me.listarCurso(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            actualizarCurso(){
                if(this.validarCurso()){
                    return;
                }
                let me=this;
                axios.put('curso/actualizar',{
                    'nombre':this.nombre,
                    'horas_academicas':this.horas_academicas,
                    'tipo':this.tipo,
                    'id':this.curso_id
                }
                ).then(function (response){
                    me.cerrarModal();
                    me.listarCurso(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            desactivarCurso(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Esta de seguro de desactivar esta Curso?',
                
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('curso/desactivar',{
                       
                        'id':id
                    }
                    ).then(function (response){
                        
                        me.listarCurso(1,'','nombre');
                          swalWithBootstrapButtons.fire(
                            'Desactivado!',
                            'El registro ha sido desactivado con exito.',
                            'success'
                            )
                    }).catch(function(error){
                        console.log(error);
                    });
                  
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                    )
                }
                }) 
            },
            activarCurso(id){
                
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Esta de seguro de activar esta Curso?',
                
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('curso/activar',{
                       
                        'id':id
                    }
                    ).then(function (response){
                        
                        me.listarCurso(1,'','nombre');
                          swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El registro ha sido activado con exito.',
                            'success'
                            )
                    }).catch(function(error){
                        console.log(error);
                    });
                  
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                    )
                }
                }) 
            },
            
            validarCurso(){
                this.errorCurso=0;
                this.errorMostrarMsjCurso=[];
                if(!this.nombre) this.errorMostrarMsjCurso.push('El nombre del Curso no puede estar vacia');
                if(this.errorMostrarMsjCurso.length) this.errorCurso=1;
                return this.errorCurso;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.horas_academicas='';
                this.tipo='';
            },
            abrirModal(modelo, accion, data =[]){
                switch(modelo){
                    case "curso":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Curso'
                                this.nombre='';
                                this.horas_academicas='';
                                this.tipo='1';
                                this.tipoAccion=1;
                                break
                            }
                            case 'actualizar':
                            {
                                // console.log(data)
                                this.modal=1;
                                this.tituloModal='Actualizar Curso';
                                this.tipoAccion=2;
                                this.nombre=data['nombre'];
                                this.horas_academicas=data['horas_academicas'];
                                this.tipo=data['tipo'];
                                this.curso_id=data['id'];
                                break;
                            }
                        }    
                    }
                }
            }
        },
        mounted() {
            this.listarCurso(1,this.buscar,this.criterio);
        }
    }
</script>
<style>
    .modal-content{
        width: 100%;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
        transition: all .5s ease-in-out !important;
    }
    .mostrar:hover{
        opacity: 2 !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red;
        font-weight: bold;
        
    }
</style>
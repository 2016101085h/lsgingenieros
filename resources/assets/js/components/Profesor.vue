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
                        <i class="fa fa-align-justify"></i> Profesores
                        <button type="button" @click="abrirModal('profesor','registrar')" class="btn btn-secondary" >
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="apellido">Apeliidos</option>
                                      <option value="grado_academico">Grado Academico</option>
                                     
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProfesor(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProfesor(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombres y Apellidos</th>
                                    <th>Correo Electronico</th>
                                    <th>Celular</th>
                                    <th>DNI</th>
                                    <th>Grado Academico</th>
                                    <th>Direccion</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="profesor in arrayProfesor" :key="profesor.id">
                                      <td>
                                        <button type="button" @click="abrirModal('profesor','actualizar',profesor)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="profesor.condicion">
                                            <button @click="desactivarProfesor(profesor.id)" type="button" class="btn btn-danger btn-sm" >
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                         <template v-else>
                                            <button @click="activarProfesor(profesor.id)" type="button" class="btn btn-info btn-sm" >
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    
                                    <td v-text="profesor.nombre + ' ' + profesor.apellido"></td>
                                    <td v-text="profesor.email"></td>
                                    <td v-text="profesor.celular"></td>
                                    <td v-text="profesor.dni"></td>
                                    <td v-text="profesor.grado_academico"></td>
                                    <td v-text="profesor.direccion"></td>
                                    
                                    <td>
                                        <div v-if="profesor.condicion">
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
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del Profesor">
                                        
                                    </div>
                                </div>
                                 <!-- <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Documento</label>
                                    <div class="col-md-9">
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="1" disabled>Ingrese su numero de Documento</option>
                                            <option value="DNI">DNI</option>
                                            <option value="RUC">RUC</option>
                                            <option value="PASS">PASS</option>
                                        </select>                                    
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellido </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido" class="form-control" placeholder="Ingrese el apellido del Profesor">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Correo electrónico</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="Ingrese la direccion de correo electrónico">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">DNI</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="dni" class="form-control" placeholder="Ingrese el Docuemnto de Indentidad">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Celular</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="celular" class="form-control" placeholder="Ingrese el Numero de Celular">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Grado Academico</label>
                                    <div class="col-md-9">
                                        <select v-model="grado_academico" class="form-control">
                                            <option value="1" disabled>Ingrese el Grado Academico</option>
                                        
                                            <option value="Titulado">Titulado</option>
                                            <option value="Magister">Magister</option>
                                        </select>                                    
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Ingrese la dirección ">
                                    </div>
                                </div>
                               
                                <div v-show="errorProfesor" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjProfesor" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" @click="registrarProfesor()" class="btn btn-primary">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" @click="actualizarProfesor()" class="btn btn-primary">Actualizar</button>
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
                profesor_id:0,
                nombre: '',
                apellido: '',
                email: '',
                direccion:'',
                celular:'',
                dni:'',
                grado_academico:'',
                arrayProfesor: [],
                modal:0,
                tituloModal:'',
                tipoAccion:0,
                errorProfesor:0,
                errorMostrarMsjProfesor:[],
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
            listarProfesor(page,buscar,criterio){
                let me=this;
                var url='/profesor?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    // // handle success
                    // console.log(response);
                    me.arrayProfesor=respuesta.profesors.data;
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
                me.listarProfesor(page,buscar,criterio);
            },
            registrarProfesor(){
                if(this.validarProfesor()){
                    return;
                }
                let me=this;
                axios.post('profesor/registrar',{
                    'nombre':this.nombre,
                    'apellido':this.apellido,
                    'email':this.email,
                    'celular':this.celular,
                    'dni':this.dni,
                    'grado_academico':this.grado_academico,
                    'direccion':this.direccion,
                    
                }
                ).then(function (response){
                    me.cerrarModal();
                    me.listarProfesor(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
            actualizarProfesor(){
                if(this.validarProfesor()){
                    return;
                }
                let me=this;
                axios.put('profesor/actualizar',{
                  
                    'id':this.profesor_id,
                     'nombre':this.nombre,
                    'apellido':this.apellido,
                    'email':this.email,
                    'dni':this.dni,
                    'grado_academico':this.grado_academico,
                    'celular':this.celular,
                    'direcion':this.direcion,
                }
                ).then(function (response){
                    me.cerrarModal();
                    me.listarProfesor(1,'','nombre');
                }).catch(function(error){
                    console.log(error);
                });
            },
              desactivarProfesor(id){
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Esta de seguro de desactivar esta categoria?',
                
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('profesor/desactivar',{
                       
                        'id':id
                    }
                    ).then(function (response){
                        
                        me.listarProfesor(1,'','nombre');
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
            activarProfesor(id){
                
               const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                title: 'Esta de seguro de activar esta categoria?',
                
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('profesor/activar',{
                       
                        'id':id
                    }
                    ).then(function (response){
                        
                        me.listarProfesor(1,'','nombre');
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
         
            validarProfesor(){
                this.errorProfesor=0;
                this.errorMostrarMsjProfesor=[];
                if(!this.nombre) this.errorMostrarMsjProfesor.push('El nombre del Profesor no puede estar vacia');
                if(!this.apellido) this.errorMostrarMsjProfesor.push('El apellido del Profesor no puede estar vacia');
                if(this.dni.length==0 || this.dni.length<8 || this.dni.length>8) this.errorMostrarMsjProfesor.push('El numero de DNI ingresado es incorrecto');
                if(this.errorMostrarMsjProfesor.length) this.errorProfesor=1;
                return this.errorProfesor;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.apellido='';
                this.email='';
                this.celular='';
                this.dni='';
                this.direccion='';
               
            },
            abrirModal(modelo, accion, data =[]){
                switch(modelo){
                    case "profesor":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Profesor'
                                this.nombre='';
                                this.apellido='';
                                this.email='';
                                this.dni='';
                                this.grado_academico='1';
                                this.direccion='';
                                this.celular='';
                               
                                this.tipoAccion=1;
                                break
                            }
                            case 'actualizar':
                            {
                                // console.log(data)
                                this.modal=1;
                                this.tituloModal='Actualizar Profesor';
                                this.tipoAccion=2;
                                this.profesor_id=data['id'];
                                this.nombre=data['nombre'];
                                this.apellido=data['apellido'];
                                this.email=data['email'];
                                this.dni=data['dni'];
                                this.grado_academico=data['grado_academico'];
                                this.celular=data['celular'];
                                this.direccion=data['direccion'];
                                
                                break;
                            }
                        }    
                    }
                }
            }
        },
        mounted() {
            this.listarProfesor(1,this.buscar,this.criterio);
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
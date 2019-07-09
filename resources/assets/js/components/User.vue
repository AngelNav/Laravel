<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Usuario(*)
                    <button type="button" @click="openModal('person','store')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterion">
                                    <option value="name">Nombre</option>
                                    <option value="document_type">Documento</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Teléfono</option>
                                </select>
                                <input type="text" v-model="search" @keyup.enter="listPerson(1, search, criterion)"
                                    class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listPerson(1, search, criterion)"
                                    class="btn btn-primary"><i class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>Número</th>
                                <th>Dirección</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="person in arrayPerson" :key="person.id">
                                <td>
                                    <button type="button" @click="openModal('person', 'update', person)"
                                        class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="person.condition">
                                        <button type="button" class="btn btn-danger btn-sm"
                                            @click="deactivateUser(person.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-info btn-sm"
                                            @click="activateUser(person.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="person.name"></td>
                                <td v-text="person.document_type"></td>
                                <td v-text="person.document_num"></td>
                                <td v-text="person.address"></td>
                                <td v-text="person.phone"></td>
                                <td v-text="person.email"></td>
                                <td v-text="person.user"></td>
                                <td v-text="person.rol"></td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#"
                                    @click.prevent="changePage(pagination.current_page - 1, search, criterion)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page"
                                :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePage(page, search, criterion)"
                                    v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#"
                                    @click.prevent="changePage(pagination.current_page + 1, search, criterion)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'show' : modal}" role="dialog" aria-labelledby="myModalLabel"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="modalTitle"></h4>
                        <button type="button" class="close" @click="closeModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="name" class="form-control"
                                        placeholder="Nombre de la persona">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Tipo Documento</label>
                                <div class="col-md-9">
                                    <select v-model="document_type" class="form-control">
                                        <option value="DNI">DNI</option>
                                        <option value="Pasaporte">Pasaporte</option>
                                        <option value="RUC">RUC</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Número de documento</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="document_num" class="form-control"
                                        placeholder="Número de documento">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Dirección</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="address" class="form-control" placeholder="Dirección">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Teléfono</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="phone" class="form-control" placeholder="Teléfono">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Rol (*)</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idrol">
                                            <option value="0">Seleccione un rol</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.name">

                                            </option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Usuario (*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="user" class="form-control" placeholder="Nombre de usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Password (*)</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Password de acceso">
                                    </div>
                                </div>

                            <div v-show="errorPerson" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorShowMsgPerson" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                        <button type="button" v-if="actionType==1" class="btn btn-primary"
                            @click="storePerson()">Guardar</button>
                        <button type="button" v-if="actionType==2" class="btn btn-primary"
                            @click="updatePerson()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
        <!-- Inicio del modal Eliminar -->

        <!-- Fin del modal Eliminar -->
    </main>
</template>

<script>
    export default {
        data() {
            return {
                person_id: 0,
                name: '',
                document_type: 'DNI',
                document_num: '',
                address: '',
                phone: '',
                email: '',
                user: '',
                password: '',
                idrol: 0,
                arrayPerson: [],
                arrayRol: [],
                modal: 0,
                modalTitle: '',
                actionType: 0,
                errorPerson: 0,
                errorShowMsgPerson: [],
                pagination: {
                    "total": 0,
                    "per_page": 0,
                    "current_page": 0,
                    "last_page": 0,
                    "from": 0,
                    "to": 0,
                },
                offset: 3,
                criterion: 'name',
                search: ''
            }
        },
        computed: {
            isActived: function () {
                return this.pagination.current_page;
            },
            //calcula los elementos de la paginación
            pagesNumber: function () {
                if (!this.pagination.to) {
                    return [];
                }

                var from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods: {
            listPerson(page, search, criterion) {
                let me = this;
                var url = '/user?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function (response) {
                    var varResponse = response.data;
                    me.arrayPerson = varResponse.people.data;
                    me.pagination = varResponse.pagination;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            selectRol(){
                let me = this;
                var url = '/rol/selectRol';
                axios.get(url).then(function (response) {
                    var varResponse = response.data;
                    me.arrayRol = varResponse.roles;
                })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            changePage(page, search, criterion) {
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listPerson(page, search, criterion);
            },
            storePerson() {
                if (this.validatePerson()) {
                    return;
                }

                let me = this;

                axios.post('/user/store', {
                    'name': this.name,
                    'document_type': this.document_type,
                    'document_num': this.document_num,
                    'address': this.address,
                    'phone': this.phone,
                    'email': this.email,
                    'user': this.user,
                    'password': this.password,
                    'idrol': this.idrol
                    
                }).then(function (response) {
                    me.closeModal();
                    me.listPerson(1, '', 'name');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            updatePerson() {
                if (this.validatePerson()) {
                    return;
                }

                let me = this;

                axios.put('/user/update', {
                    'name': this.name,
                    'document_type': this.document_type,
                    'document_num': this.document_num,
                    'address': this.address,
                    'phone': this.phone,
                    'email': this.email,
                    'user': this.user,
                    'password': this.password,
                    'idrol': this.idrol,
                    'id': this.person_id
                }).then(function (response) {
                    me.closeModal();
                    me.listPerson(1, '', 'name');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validatePerson() {
                this.errorPerson = 0;
                this.errorShowMsgPerson = [];

                if (!this.name) this.errorShowMsgPerson.push("El nombre de la persona no puede estar vacío.");
                if (!this.user) this.errorShowMsgPerson.push("El nombre de usuario no puede estar vacío.");
                if (!this.password) this.errorShowMsgPerson.push("El password no puede estar vacío.");
                if (this.idrol==0) this.errorShowMsgPerson.push("Debe seleccionar un rol para el usuario.");

                if (this.errorShowMsgPerson.length) this.errorPerson = 1;

                return this.errorPerson;
            },
            closeModal() {
                this.modal = 0;
                this.modalTitle = '';
                this.name = '';
                this.document_type = 'DNI';
                this.document_num = '';
                this.address = '';
                this.phone = '';
                this.email = '';
                this.user = '';
                this.password = '';
                this.idrol = 0;
                this.errorPerson = 0;
            },
            openModal(model, action, data = []) {
                this.selectRol();
                switch (model) {
                    case "person":
                        {
                            switch (action) {
                                case 'store':
                                    {
                                        this.modal = 1;
                                        this.modalTitle = 'Registrar Usuario';
                                        this.name = '';
                                        this.document_type = 'DNI';
                                        this.document_num = '';
                                        this.address = '';
                                        this.phone = '';
                                        this.email = '';
                                        this.user = '';
                                        this.password = '';
                                        this.idrol = 0;
                                        this.actionType = 1;
                                        break;
                                    }
                                case 'update':
                                    {
                                        this.modal = 1;
                                        this.modalTitle = 'Actualizar Proveedor';
                                        this.actionType = 2;
                                        this.person_id = data['id'];
                                        this.name = data['name'];
                                        this.document_type = data['document_type'];
                                        this.document_num = data['document_num'];
                                        this.address = data['address'];
                                        this.phone = data['phone'];
                                        this.email = data['email'];
                                        this.user = data['user'];
                                        this.password = data['password'];
                                        this.idrol = data['idrol'];
                                        break;
                                    }
                            }
                        }
                }
            },
            activateUser(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                    title: '¿Está seguro de activar este usuario?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.put('/user/activate', {
                            'id': id
                        }).then(function (response) {
                            me.listPerson(1, '', 'nombre');
                            swalWithBootstrapButtons.fire(
                                'Activado!',
                                'El registro ha sido activado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });

                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                })
            },
            deactivateUser(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons.fire({
                    title: '¿Está seguro de desactivar este usuario?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        let me = this;

                        axios.put('/user/deactivate', {
                            'id': id
                        }).then(function (response) {
                            me.listPerson(1, '', 'nombre');
                            swalWithBootstrapButtons.fire(
                                'Desactivado!',
                                'El registro ha sido desactivado con éxito.',
                                'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });

                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                })
            },
        },
        mounted() {
            this.listPerson(1, this.search, this.criterion);
        }
    }
</script>

<style>
    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }

    .show {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }

    .div-error {
        display: flex;
        justify-content: center;
    }

    .text-error {
        color: red !important;
        font-weight: bold;
    }
</style>
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
                    <i class="fa fa-align-justify"></i> Roles
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterion">
                                    <option value="name">Nombre</option>
                                    <option value="description">Descripción</option>
                                </select>
                                <input type="text" v-model="search" @keyup.enter="listRol(1, search, criterion)"
                                    class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listRol(1, search, criterion)" class="btn btn-primary"><i
                                        class="fa fa-search"></i>
                                    Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="rol in arrayRol" :key="rol.id">
                                <td v-text="rol.name"></td>
                                <td v-text="rol.description"></td>
                                <div v-if="rol.condition">
                                    <span class="badge badge-success">Activo</span>
                                </div>
                                <div v-else>
                                    <span class="badge badge-danger">Desactivado</span>
                                </div>
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
    </main>
</template>

<script>
    export default {
        data() {
            return {
                rol_id: 0,
                name: '',
                description: '',
                arrayRol: [],
                modal: 0,
                modalTitle: '',
                actionType: 0,
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
            listRol(page, search, criterion) {
                let me = this;
                var url = '/rol?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function (response) {
                    var varResponse = response.data;
                    me.arrayRol = varResponse.roles.data;
                    me.pagination = varResponse.pagination;
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
                me.listRol(page, search, criterion);
            }
        },
        mounted() {
            this.listRol(1, this.search, this.criterion);
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
<template>
    <div class="container-fluid">
        <div class="row text-center mb-3">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h1 class="display-4">Usuarios</h1>
                <button class="btn btn-primary rounded-circle " data-bs-toggle="modal"
                    data-bs-target="#modalCrearUsuario" @click="openCreateModal">+</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table  table-hover table-bordered">
                        <thead>
                            <th colspan="5">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Buscar..." v-model="searchTerm">
                                </div>
                            </th>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Correo</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Fecha de creacion</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in users.data" :key="index">
                                <td class="text-center">{{ item.name }}</td>
                                <td class="text-center">{{ item.email }}</td>
                                 <td class="text-center">{{ item.rol === 'Admon' ? 'Administrador' : 'Cliente' }}</td>
                                <td class="text-center">{{ item.created_at }}</td>
                                <td class="d-flex justify-content-center">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                        <button type="button" class="btn btn-sm btn-success" @click="editpassword(item)"  data-bs-toggle="modal" data-bs-target="#Modalcontraseña">
                                            <i  class="fas fa-lock"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning mx-2" @click="editUser(item)"  data-bs-toggle="modal" data-bs-target="#Modaleditar">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" @click="deleteUser(item.id)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <button @click="changePage(users.current_page - 1)" :disabled="users.current_page === 1"><i class="fas fa-arrow-left"></i></button>
                        <span>Página {{ users.current_page }} de {{ users.last_page }}</span>
                        <button @click="changePage(users.current_page + 1)" :disabled="users.current_page === users.last_page"><i class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>


        <!-- {{-- Modal crear Usuarios --}} -->
        <div class="modal fade" id="modalCrearUsuario" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crear Usuarios</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label>Nombre</label>
                            <input type="text" v-model="newUser.name" class="form-control" :class="{'is-invalid': error.name}">
                            <div class="invalid-feedback" v-if="error.name">{{ error.name }}</div>
                        </div>
                        <div class="form-group mb-2">
                            <label>Email</label>
                            <input type="text" v-model="newUser.email" class="form-control" :class="{'is-invalid': error.email}">
                            <div class="invalid-feedback" v-if="error.email">{{ error.email }}</div>
                        </div>
                        <div class="form-group mb-2">
                            <label>Contraseña</label>
                            <input type="text" v-model="newUser.password" class="form-control" :class="{'is-invalid': error.password}">
                            <div class="invalid-feedback" v-if="error.password">{{ error.password }}</div>
                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <select class="form-select" v-model="newUser.rol" :class="{'is-invalid': error.rol}">
                                <option value="">Seleccione una opción...</option>
                                <option value="Admon">Administrador</option>
                                <option value="Client">Cliente</option>
                            </select>
                            <div class="invalid-feedback" v-if="error.rol">{{ error.rol }}</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" @click="createUser">Registrar Usuario</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- {{-- Fin modal crear Usuarios --}} -->

        <!-- {{--  contraseña   --}} -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="modal fade" id="Modalcontraseña" tabindex="-1" wire:ignore.self>
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Editar Contraseña</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Contraseña</label>
                                        <input type="text" v-model="newUser.password" class="form-control" wire:model="passwordy">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" @click="updatepassword">Editar Contraseña</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- {{--  contraseña   --}} -->

        <!-- {{--  editar   --}} -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="modal fade" id="Modaleditar" tabindex="-1" aria-labelledby="ModaleditarLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Editar Usuario</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nombre Completo</label>
                                        <input type="text" class="form-control" v-model="newUser.name" >
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Correo</label>
                                        <input type="email" class="form-control" v-model="newUser.email">
                                    </div>
                                    <div class="form-group mb-2">
                                        <label>Rol</label>
                                        <select class="form-select" v-model="newUser.rol">
                                            <option value="">Seleccione una opción...</option>
                                            <option value="Admon">Administrador</option>
                                            <option value="Client">Cliente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" @click="updateUser">Editar
                                        Usuario</button>
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- {{--  editar   --}} -->

    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: {
                    data: [],
                    current_page: 1,
                    last_page: 1,
                },
                error: {
                    name: null,
                    email: null,
                    password: null,
                    rol: null,
                },
                newUser: {
                    name: '',
                    email: '',
                    password: '',
                    rol: ''
                },
                searchTerm: '', // Nueva propiedad para el texto de búsqueda
            };
        },
        watch: {
            // Observar cambios en el searchTerm y ejecutar el filtrado
            searchTerm(newTerm) {
                this.getUsers(1, newTerm); // Reinicia la página cuando se cambia el término de búsqueda
            }
        },
        mounted() {
            this.getUsers(this.users.current_page);
        },
        methods: {
            getUsers(page, searchTerm = '') {
            axios.get(`/consultarUser?page=${page}&search=${searchTerm}`)
                .then(res => {
                    this.users = res.data;
                })
                .catch(error => {
                    this.error = 'Error fetching user data: ' + error.message;
                    console.error(this.error);
                });
            },
            changePage(page) {
            if (page > 0 && page <= this.users.last_page) {
                this.getUsers(page, this.searchTerm); // Mantén el término de búsqueda al cambiar de página
            }
            },
            onSearch() {
                this.getUsers(this.users.current_page, this.searchTerm); // Filtrar cuando se busque
            },
            openCreateModal() {
                this.resetForm(); // Resetea el formulario al abrir el modal de crear
            },
            createUser() {
                axios.post('/createUser', this.newUser)
                .then(response => {
                    this.message = response.data.message; // Mensaje de éxito
                    this.getUsers(this.users.current_page); // Actualiza la lista de usuarios
                    this.resetForm(); // Reinicia el formulario

                    // Mostrar la alerta de éxito
                    Swal.fire({
                        title: '¡Éxito!',
                        text: response.data.message, // Mensaje desde Laravel
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });

                    this.clearErrors(); // Limpia los errores después de un registro exitoso
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        // Limpiar errores antes de asignar nuevos
                        this.clearErrors();
                        // Asignar errores a los campos correspondientes
                        for (const [key, value] of Object.entries(error.response.data.errors)) {
                            this.error[key] = value[0]; // Almacenar el primer mensaje de error para cada campo
                        }
                    } else {
                        this.error.general = 'Error creando usuario: ' + error.message;
                    }
                    // console.error(this.error);
                });
            },
            resetForm() {
                this.newUser = {
                    name: '',
                    email: '',
                    password: '',
                    rol: ''
                };
            },
            clearErrors() {
                this.error = {
                    name: null,
                    email: null,
                    password: null,
                    rol: null,
                };
            },
            editUser(user) {
                this.newUser = { ...user }; // Cargar datos del usuario
            },
            updateUser() {
                axios.put(`/editarUser/${this.newUser.id}`, this.newUser)
                .then(response => {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: response.data.message, // Mensaje desde Laravel
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                    
                    this.getUsers(this.users.current_page); // Actualiza la lista de usuarios
                    this.clearErrors(); // Limpia los errores
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.clearErrors();
                        for (const [key, value] of Object.entries(error.response.data.errors)) {
                            this.error[key] = value[0]; // Almacenar el primer mensaje de error para cada campo
                        }
                    } else {
                        this.error.general = 'Error actualizando usuario: ' + error.message;
                    }
                    // console.error(this.error);
                });
            },
            editpassword(user) {
                this.newUser = { ...user }; // Cargar datos del usuario
            },
            updatepassword() {
                axios.put(`/editarPassword/${this.newUser.id}`, this.newUser)
                .then(response => {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: response.data.message, // Mensaje desde Laravel
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    });
                    
                    this.getUsers(this.users.current_page); // Actualiza la lista de usuarios
                    this.clearErrors(); // Limpia los errores
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.clearErrors();
                        for (const [key, value] of Object.entries(error.response.data.errors)) {
                            this.error[key] = value[0]; // Almacenar el primer mensaje de error para cada campo
                        }
                    } else {
                        this.error.general = 'Error actualizando usuario: ' + error.message;
                    }
                    // console.error(this.error);
                });
            },
            deleteUser(id) {
                // Confirmación antes de eliminar
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Si el usuario confirma, procede a eliminar
                        axios.delete(`/eliminarUser/${id}`)
                            .then(response => {
                                Swal.fire(
                                    '¡Eliminado!',
                                    response.data.message, // Mensaje desde Laravel
                                    'success'
                                );
                                // Actualiza la lista de usuarios
                                this.getUsers(this.users.current_page);
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error',
                                    'No se pudo eliminar el usuario: ' + error.message,
                                    'error'
                                );
                                console.error('Error deleting user:', error);
                            });
                    }
                });
            }
        }
    }
</script>
<style scoped>
.pagination {
    margin-top: 20px;
}
</style>

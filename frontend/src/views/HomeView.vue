<script setup>
import { onMounted, ref, watch } from 'vue'
import { toast } from 'vue3-toastify';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Swal from 'sweetalert2/dist/sweetalert2.js'

import httpClient from '../services/http'

import Card from '@/components/Card/Card.vue';
import CardHeader from '@/components/Card/Header.vue';
import CardBody from '@/components/Card/Body.vue';
import CardFooter from '@/components/Card/Footer.vue';

import UserTableView from '@/views/Table/UserTableView.vue';
import BackSpaceReverse from '@/components/Icons/BackSpaceReverse.vue';
import ButtonsImportView from './Button/ButtonsImportView.vue';

const usuarios = ref([])
const dados = ref([])
const pesquisar = ref('')

const listarUsuarios = async (page = 1) => {
    await httpClient.get(`/user?page=${page}&search=${pesquisar.value}`).then((response) => {
        usuarios.value = response.data.usuarios.data
        dados.value = response.data.usuarios
    }).catch((error) => {
        console.log(error);
    })
}

const baixarArquivo = async (type) => {
    await httpClient.get(`/user-export/${type}`).then((response) => {
        let url = response.config.url;
        let baseURL = response.config.baseURL;
        window.location.href = baseURL + url;
        toast(`Arquivo ${type} foi baixado`, {
            autoClose: 2000,
            "theme": "auto",
            "type": "success",
            "dangerouslyHTMLString": true
        });
    }).catch((error) => {
        console.log(error);
    })
}

const apagarUsuario = async (id, i) => {
    Swal.fire({
        title: "Deseja apagar o usuário?",
        text: "Ação será realizada!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sim, apagar!"
    }).then(async (result) => {
        if (result.isConfirmed) {
            usuarios.value.splice(i, 1)
            if (id != undefined) {
                await httpClient.delete(`/user/${id}`).then((response) => {
                    Swal.fire({
                        title: "Ação realizada!",
                        text: response.data.msg,
                        icon: "success"
                    }).then(() => {
                        window.location.href = '/'
                    });
                }).catch((error) => {
                    Swal.fire(
                        'Falha!',
                        'Não foi possível realizar a operação.',
                        'Warning'
                    )
                })
            }
        }
    });
}

onMounted(async () => {
    await listarUsuarios()
})

watch(pesquisar, () => {
    listarUsuarios()
})
</script>

<template>
    <main>
        <div class="d-flex bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <router-link to="/usuario" type="button" class="btn btn-success">
                    CRIAR USUÁRIO
                    <BackSpaceReverse />
                </router-link>
            </div>
            <div v-if="usuarios.length > 0" class="ms-auto p-2 bd-highlight">
                <ButtonsImportView @baixar-arquivo="baixarArquivo" />
            </div>
        </div>
        <Card class="mt-3 mb-3">
            <template v-slot:card>
                <CardHeader>
                    <template v-slot:header>
                        <h5 class="card-title">Buscar Usuário</h5>
                    </template>
                </CardHeader>
                <CardBody>
                    <template v-slot:body>
                        <input type="text" placeholder="Pesquisar" v-model="pesquisar" class="form-control">
                    </template>
                </CardBody>
                <CardFooter>
                    <template v-slot:footer>
                        <div class="form-text">Digite <b>Nome</b>, <b>Cpf</b> ou <b>Email</b> .</div>
                    </template>
                </CardFooter>
            </template>
        </Card>

        <Card>
            <template v-slot:card>
                <CardHeader>
                    <template v-slot:header>
                        Usuários Cadastrados
                    </template>
                </CardHeader>
                <CardBody>
                    <template v-slot:body>
                        <template v-if="usuarios.length > 0">
                            <UserTableView :usuarios="usuarios" @apagar-usuario="apagarUsuario" />
                        </template>
                        <template v-else>
                            <p>Não existe usuários cadastrados</p>
                        </template>
                    </template>
                </CardBody>
                <CardFooter>
                    <template v-slot:footer>
                        <template v-if="usuarios.length > 0">
                            <Bootstrap5Pagination size="small" :data="dados" @pagination-change-page="listarUsuarios" />
                        </template>
                    </template>
                </CardFooter>
            </template>
        </Card>
    </main>
</template>

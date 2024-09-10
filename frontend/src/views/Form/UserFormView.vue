<script setup>
import httpClient from '../../services/http'
import { onMounted, ref } from "vue"
import { useRoute } from 'vue-router'
import { toast } from 'vue3-toastify'

import InputBase from '@/components/Input/InputBase.vue';
import Button from '@/components/Button/ButtonBase.vue';
import FloppyFill from '@/components/Icons/FloppyFill.vue';
import Backspace from '@/components/Icons/Backspace.vue';
import Card from '@/components/Card/Card.vue';
import Header from '@/components/Card/Header.vue';
import CardBody from '@/components/Card/Body.vue';
import CardFooter from '@/components/Card/Footer.vue';

const route = useRoute()

const edit = ref(false)
const nome = ref('')
const cpf = ref('')
const data_nascimento = ref('')
const telefone = ref('')
const email = ref('')
const cep = ref('')
const dadosCep = ref({
    cep: '',
    uf: '',
    bairro: '',
    logradouro: ''
})

const numeroValor = ref('')
const status = ref('')

//PARA O FOCUS DO INPUT
const numero = ref()

const errors = ref([])

const buscarCep = () => {

    if (cep.value.length == 9) {
        cep.value.replace('-', '')

        httpClient.get(`https://viacep.com.br/ws/${cep.value}/json/`)
            .then((response) => {
                if (response.data.erro) {
                    errors.value = ['Cep não localizado e/ou não é valido']
                    cep.value = ''
                    dadosCep.value = ''
                    setTimeout(() => {
                        errors.value = {}
                    }, 3000)
                } else {
                    dadosCep.value = response.data
                    numero.value.focus();
                }
            })
            .catch((error) => {
                alert(error)
                console.log(error)
            })
    }
}

const salvar = () => {
    if (route.params.id) {
        atualizarUsuario()
    } else {
        cadastrarUsuario()
    }
}

const cadastrarUsuario = async () => {
    const formData = new FormData()
    formData.append('nome', nome.value)
    formData.append('cpf', cpf.value.replace(/[^0-9]/g, ""))
    formData.append('data_nascimento', data_nascimento.value)
    formData.append('email', email.value)
    formData.append('telefone', telefone.value)
    formData.append('cep', dadosCep.value.cep)
    formData.append('estado', dadosCep.value.uf)
    formData.append('bairro', dadosCep.value.bairro)
    formData.append('endereco', dadosCep.value.logradouro)
    formData.append('numero', numeroValor.value)
    formData.append('status', status.value)

    httpClient.post('/user', formData).then((response) => {
        
        toast(response.data.msg, {
            autoClose: 2000,
            "theme": "auto",
            "type": "success",
            "dangerouslyHTMLString": true
        });
        
        nome.value = ''
        cpf.value = ''
        data_nascimento.value = ''
        email.value = ''
        telefone.value = ''
        dadosCep.value.cep = ''
        dadosCep.value.uf = ''
        dadosCep.value.bairro = ''
        dadosCep.value.logradouro = ''
        numeroValor.value = ''
        status.value = ''

    }).catch((error) => {
        errors.value = error.response.data.errors
        setTimeout(() => {
            errors.value = {}
        }, 3000)
    })

}

const atualizarUsuario = async () => {

    const formData = new FormData()
    formData.append('nome', nome.value)
    formData.append('cpf', cpf.value.replace(/[^0-9]/g, ""))
    formData.append('data_nascimento', data_nascimento.value)
    formData.append('email', email.value)
    formData.append('telefone', telefone.value)
    formData.append('cep', cep.value)
    formData.append('estado', dadosCep.value.uf)
    formData.append('bairro', dadosCep.value.bairro)
    formData.append('endereco', dadosCep.value.logradouro)
    formData.append('numero', numeroValor.value)
    formData.append('status', status.value)
    formData.append('_method', 'PUT')

    httpClient.post(`/user/${route.params.id}`, formData).then((response) => {
        toast(response.data.msg, {
            autoClose: 2000,
            "theme": "auto",
            "type": "success",
            "dangerouslyHTMLString": true
        });

    }).catch((error) => {
        errors.value = error.response.data.errors
        setTimeout(() => {
            errors.value = ''
        }, 3000)
    })

}

const buscaUsuario = async () => {
    httpClient.get(`/user/${route.params.id}`).then((response) => {

        nome.value = response.data.usuario.nome
        data_nascimento.value = response.data.usuario.data_nascimento
        cpf.value = response.data.usuario.cpf
        email.value = response.data.usuario.email
        telefone.value = response.data.usuario.telefone
        cep.value = response.data.usuario.cep
        dadosCep.value.uf = response.data.usuario.estado
        dadosCep.value.bairro = response.data.usuario.bairro
        dadosCep.value.logradouro = response.data.usuario.endereco
        numeroValor.value = response.data.usuario.numero
        status.value = response.data.usuario.status

    }).catch((error) => {
        errors.value = error.response?.data.errors
    })
}

onMounted(() => {
    if (route.params.id) {
        edit.value = true
        buscaUsuario()
    }
})
</script>
<template>
    <div class="row">
        <div class="col-md-12">
            <Card class="mt-4">
                <template v-slot:card>
                    <Header>
                        <template v-slot:header>
                            {{ edit === true ? "Editar Usuário" : "Cadastrar Usuário" }}
                        </template>
                    </Header>
                    <form @submit.prevent="salvar">
                        <CardBody class="row">
                            <template v-slot:body>
                                <InputBase label="nome" title="Nome" :error_input="errors?.nome">
                                    <template v-slot:input>
                                        <input type="text" name="nome" v-model="nome" placeholder="Digite um nome"
                                            class="form-control mb-2" :class="{ 'has-error': errors?.nome }">
                                    </template>
                                </InputBase>

                                <InputBase label="data_nascimento" title="DATA DE NASCIMENTO"
                                    :error_input="errors?.data_nascimento">
                                    <template v-slot:input>
                                        <input type="date" v-model="data_nascimento" class="form-control mb-2"
                                            :class="{ 'has-error': errors.data_nascimento }">
                                    </template>
                                </InputBase>

                                <InputBase label="cpf" title="CPF" :error_input="errors?.cpf">
                                    <template v-slot:input>
                                        <MaskInput v-model="cpf" mask="###.###.###-##" class="form-control mb-2"
                                            placeholder="999.999.999-99" :class="{ 'has-error': errors.cpf }" />
                                    </template>
                                </InputBase>

                                <InputBase label="email" title="EMAIL" :error_input="errors?.email">
                                    <template v-slot:input>
                                        <input type="email" v-model="email" placeholder="email@dominio.com"
                                            class="form-control mb-2" :class="{ 'has-error': errors.email }">
                                    </template>
                                </InputBase>

                                <InputBase label="telefone" title="TELEFONE" :error_input="errors?.telefone">
                                    <template v-slot:input>
                                        <MaskInput v-model="telefone" class="form-control mb-2" mask="(##) #####-####"
                                            placeholder="(99) 99999-9999" :class="{ 'has-error': errors.telefone }" />
                                    </template>
                                </InputBase>

                                <InputBase label="cep" title="CEP" :error_input="(errors?.cep || errors)">
                                    <template v-slot:input>
                                        <MaskInput v-model="cep" @keyup="buscarCep()" class="form-control mb-2"
                                            mask="#####-###" :class="{ 'has-error': errors.cep }"
                                            placeholder="99999-999" />
                                    </template>
                                </InputBase>

                                <InputBase label="estado" title="ESTADO" :error_input="errors?.estado">
                                    <template v-slot:input>
                                        <input type="text" readonly v-model="dadosCep.uf" placeholder="Estado"
                                            class="form-control mb-2" :class="{ 'has-error': errors.estado }">
                                    </template>
                                </InputBase>

                                <InputBase label="bairro" title="BAIRRO" :error_input="errors?.bairro">
                                    <template v-slot:input>
                                        <input type="text" readonly v-model="dadosCep.bairro" placeholder="Bairro"
                                            class="form-control mb-2" :class="{ 'has-error': errors.bairro }">
                                    </template>
                                </InputBase>

                                <InputBase label="bairro" title="ENDEREÇO" :error_input="errors?.endereco">
                                    <template v-slot:input>
                                        <input type="text" readonly v-model="dadosCep.logradouro" placeholder="Endereço"
                                            class="form-control mb-2" :class="{ 'has-error': errors.endereco }">
                                    </template>
                                </InputBase>

                                <InputBase label="numero" title="NÚMERO" :error_input="errors?.numero">
                                    <template v-slot:input>
                                        <input type="text" v-model="numeroValor" ref="numero" placeholder="Número"
                                            class="form-control mb-2" :class="{ 'has-error': errors.numero }">
                                    </template>
                                </InputBase>
                            </template>
                        </CardBody>

                        <CardFooter>
                            <template v-slot:footer>
                                <div class="d-grid gap-2 d-md-flex ">
                                    <router-link to="/" class="btn btn-warning">
                                        <Backspace />
                                        Voltar
                                    </router-link>
                                    <Button type="submit" class="btn btn-success">
                                        <template v-slot:icon>
                                            <FloppyFill />
                                            {{ edit === true
                                                ? "ATUALIZAR" : "CADASTRAR" }}
                                        </template>
                                    </Button>
                                </div>
                            </template>
                        </CardFooter>
                    </form>
                </template>
            </Card>
        </div>
    </div>
</template>

<style scoped>
.has-error {
    border: 1px #dc3545 solid;
}

.color-text-error {
    color: #dc3545;
}
</style>
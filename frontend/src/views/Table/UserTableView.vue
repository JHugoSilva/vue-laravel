<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router'

import Table from '@/components/Table/TableBase.vue';
import UserView from '@/views/Modal/UserModalView.vue';
import UserButtonActionsView from '@/views/Button/UserButtonActionsView.vue';

defineProps(['usuarios'])
const emit = defineEmits(['apagarUsuario'])

const router = useRouter()
const infoUsuario = ref()

const editarUsuario = (id) => {
    router.push(`/usuario/${id}`)
}

const visualizarUsuario = (usuario) => {
    infoUsuario.value = usuario;
}

const apagarUsuario = (id, index) => {
    emit('apagarUsuario', id, index)
}

</script>
<template>
    <div>
        <Table>
            <template v-slot:thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NOME</th>
                    <th scope="col">CPF</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">TELEFONE</th>
                    <th scope="col">AÇÕES</th>
                </tr>
            </template>
            <template v-slot:tbody>
                <tr v-for="(usuario, index) in usuarios" :key="index">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ usuario?.nome }}</td>
                    <td>{{ usuario?.cpf }}</td>
                    <td>{{ usuario?.email }}</td>
                    <td>{{ usuario?.telefone }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <UserButtonActionsView :usuario="usuario" @visualizar-usuario="visualizarUsuario"
                                @editar-usuario="editarUsuario" @apagar-usuario="apagarUsuario" />
                        </div>
                    </td>
                </tr>
            </template>
        </Table>
        <UserView :dados="infoUsuario" />
    </div>
</template>
<script setup>
import moment from "moment";
import Modal from '@/components/Modal/ModalBase.vue';
defineProps(['dados'])

const formatarDataPtBr = (value) => {
    return moment(value).format("DD/MM/YYYY");
}
</script>
<template>
    <Modal>
        <template v-slot:header>
            <h5 class="modal-title">Dados do Usuário</h5>          
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </template>
    
        <template v-slot:body>
            <ul class="list-group">
                <li class="list-group-item"><b>Id:</b> {{ dados?.id }}</li>
                <li class="list-group-item"><b>Nome:</b> {{ dados?.nome }}</li>
                <li class="list-group-item"><b>Cpf:</b> {{ dados?.cpf }}</li>
                <li class="list-group-item"><b>Data de Nascimento:</b> {{ formatarDataPtBr(dados?.data_nascimento) }}</li>
                <li class="list-group-item"><b>Email:</b> {{ dados?.email }}</li>
                <li class="list-group-item"><b>Telefone:</b> {{ dados?.telefone }}</li>
                <li class="list-group-item"><b>Cep:</b> {{ dados?.cep }}</li>
                <li class="list-group-item"><b>Estado:</b> {{ dados?.estado }}</li>
                <li class="list-group-item"><b>Bairro:</b> {{ dados?.bairro }}</li>
                <li class="list-group-item"><b>Endereço:</b> {{ dados?.endereco }}, <b>N°:</b>{{ dados?.numero }}</li>
                <li class="list-group-item"><b>Status:</b> {{ dados?.status }}</li>
            </ul>
        </template>
        <template v-slot:footer>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </template>
    </Modal>
</template>
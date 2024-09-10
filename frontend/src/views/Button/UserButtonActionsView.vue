<script setup>
import Button from '@/components/Button/ButtonBase.vue';
import EyeFill from '@/components/Icons/EyeFill.vue';
import PencilSquare from '@/components/Icons/PencilSquare.vue';
import Trash from '@/components/Icons/Trash.vue';

defineProps(['usuario'])
const emit = defineEmits(['visualizarUsuario', 'editarUsuario', 'apagarUsuario'])

const visualizarUsuario = (usuario) => {
    emit('visualizarUsuario', usuario)
}

const editarUsuario = (usuario) => {
    emit('editarUsuario', usuario)
}

const apagarUsuario = (usuario) => {
    emit('apagarUsuario', usuario)
}
</script>

<template>
    <div class="btn-group">
        <Button @click="visualizarUsuario(usuario)" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
            class="btn btn-sm btn-success">
            <template v-slot:icon>
                <EyeFill />
            </template>
        </Button>
        <Button @click="editarUsuario(usuario.id)" type="button" class="btn btn-sm btn-warning">
            <template v-slot:icon>
                <PencilSquare />
            </template>
        </Button>
        <Button @click="apagarUsuario(usuario.id, index)" type="button" class="btn btn-sm btn-danger">
            <template v-slot:icon>
                <Trash />
            </template>
        </Button>
    </div>
</template>
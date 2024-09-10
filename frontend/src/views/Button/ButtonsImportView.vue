<script setup>
import Button from '@/components/Button/ButtonBase.vue';
import FileEarmarkSpreadsheet from '@/components/Icons/FileEarmarkSpreadsheet.vue';
import FiletypeCsv from '@/components/Icons/FiletypeCsv.vue';
import FiletypePdf from '@/components/Icons/FiletypePdf.vue';

const emit = defineEmits(['baixarArquivo'])

const baixarArquivo =  (type) => {
    emit('baixarArquivo', type)
}

</script>

<template>
    <div class="btn-group">
        <Button title="XLS" @click="baixarArquivo('xls')">
            <template v-slot:icon>
              <FileEarmarkSpreadsheet/>
            </template>
          </Button>
    
          <Button title="CSV" class="btn btn-secondary" @click="baixarArquivo('csv')">
            <template v-slot:icon>
              <FiletypeCsv/>
            </template>
          </Button>
    
          <Button title="PDF" class="btn btn-info" @click="baixarArquivo('pdf')">
            <template v-slot:icon>
              <FiletypePdf/>
            </template>
          </Button>
    </div>
</template>
<template>
  <v-dialog v-model="localModel" max-width="800">
    <v-card class="pa-6 rounded-xl elevation-2 border overflow-y-auto " style="max-height: 90vh;">
      <div class="mb-4">
        {{ title }}
      </div>
      <form @submit.prevent="submitForm">
        <v-text-field
          v-model="form.title"
          label="Título del nodo"
          prepend-icon="mdi-format-title"
          class="mb-4"
        />

        <v-textarea
          v-model="form.message"
          label="Mensaje"
          prepend-icon="mdi-message-text-outline"
          class="mb-6"
          rows="4"
          auto-grow
          required
        />

        <v-card class="pa-4 mb-6 border rounded-lg">
          <div class="d-flex justify-space-between align-center mb-2">
            <h3 class="text-subtitle-1 font-weight-medium">Opciones</h3>
            <v-btn
              size="medium"
              prepend-icon="mdi-plus"
              class="elevation-0 pa-2"
              @click="addOption"
            ></v-btn>
          </div>

          <v-divider class="mb-4"></v-divider>

          <div v-for="(option, index) in form.options" :key="option._id" class="d-flex gap-4 mb-4 flex-wrap">
            <v-text-field v-model="option.text" label="Texto" class="flex-1" required />

            <v-select
              v-model="option.next_node"
              :items="nodes"
              item-title="title"
              item-value="id"
              label="Vincular a nodo"
              class="flex-1"
              required
            />

            <v-btn color="red" icon="mdi-delete" variant="plain" @click="removeOption(index)" />
          </div>
        </v-card>

        <v-card-actions class="d-flex justify-end">
          <v-btn variant="text" @click="closeDialog">Cancelar</v-btn>
          <v-btn @click="destroy" color="error" prepend-icon="mdi-alert">Eliminar</v-btn>
          <v-btn type="submit" color="primary" prepend-icon="mdi-content-save">Guardar</v-btn>
        </v-card-actions>

      </form>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { nodesSessionManager } from '@/stores/nodesSessionManager.js'

const props = defineProps({
  nodeId: String,
  modelValue: Boolean
})

const title = "Edit Node"

const emit = defineEmits(['update:modelValue'])
const router = useRouter()
const { nodes, loadNodes, loadNode, updateNode, deleteNode } = nodesSessionManager();

const form = ref({
  title: '',
  message: '',
  options: []
})

onMounted(async () => {
  await loadNodes()

  if (props.nodeId) {
    const data = await loadNode(props.nodeId)
    console.log(data)
    if (data) loadForm(data)
  }
})

const localModel = ref(props.modelValue)

watch(() => props.modelValue, val => localModel.value = val)
watch(localModel, val => emit('update:modelValue', val))

const closeDialog = () => {
  localModel.value = false
}

const addOption = () => {
  form.value.options.push({
    _id: crypto.randomUUID(),
    text: '',
    next_node: ''
  })
}

const removeOption = (index) => {
  form.value.options.splice(index, 1)
}

const submitForm = async () => {
  updateNode(props.nodeId, form.value)
  closeDialog()
}

async function loadForm(data) {
  form.value = {
    title: data.title,
    message: data.message,
    options: data.node_options?.map(opt => ({
      _id: crypto.randomUUID(),
      text: opt.text,
      next_node: opt.next_node
    })) || []
  }
}

async function destroy() {
  deleteNode(props.nodeId)
  router.go('/admin')
}
</script>
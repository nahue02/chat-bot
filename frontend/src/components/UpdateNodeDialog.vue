<template>
  <v-dialog v-model="localModel" max-width="800">
    <v-card class="pa-6 rounded-lg elevation-2 border overflow-y-auto " style="max-height: 90vh;">
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

        <v-card class="pa-4 mb-6 border" rounded="lg">
          <div class="d-flex justify-space-between align-center mb-2">
            <h3 class="text-subtitle-1 font-weight-medium">Opciones</h3>
            <v-btn
              size="small"
              color="primary"
              prepend-icon="mdi-plus"
              @click="addOption"
            >
              Agregar opción
            </v-btn>
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
          <v-btn @click="deleteNode" color="error" prepend-icon="mdi-alert">Eliminar</v-btn>
          <v-btn type="submit" color="primary" prepend-icon="mdi-content-save">Guardar</v-btn>
        </v-card-actions>

      </form>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { ref, watch, onMounted } from 'vue'
import api from '../services/api'
import { useRouter } from 'vue-router'

const title = "Edit Node"

const props = defineProps({
  nodeId: String,
  modelValue: Boolean
})

const emit = defineEmits(['update:modelValue'])

const router = useRouter()
const localModel = ref(props.modelValue)

watch(() => props.modelValue, val => localModel.value = val)
watch(localModel, val => emit('update:modelValue', val))
watch(
  () => props.nodeId,
  async (newId) => {
    if (!newId) return
    await loadNode(newId)
  },
  { immediate: true }
)

const closeDialog = () => {
  form.value = { title: '', message: '', options: [] }
  localModel.value = false
}

const form = ref({
  title: '',
  message: '',
  options: []
})

const nodes = ref([])
const errors = ref([])

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
  try {
    await api.put(`/nodes/update/${props.nodeId}`, form.value)
    closeDialog()
    router.go('/admin')
  } catch (error) {
    errors.value = error.response.data.errors
  }
}

onMounted(async () => {
  const allNodes = await api.get('/nodes/all')
  nodes.value = allNodes.data

  loadNode(props.nodeId)
})

async function loadNode(id) {
  const res = await api.get(`/nodes/${id}`)
  const data = res.data

  form.value = {
    title: data.title,
    message: data.message,
    options: data.options?.map(opt => ({
      _id: crypto.randomUUID(),
      text: opt.text,
      next_node: opt.next_node
    })) || []
  }
}

async function deleteNode() {
  await api.delete('nodes/delete/' + props.nodeId)
  router.go('/admin')
}
</script>
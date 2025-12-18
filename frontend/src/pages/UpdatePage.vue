<script setup>
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import api from '../services/api'

const router = useRouter()
const route = useRoute()
const nodeId = route.params.id

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
    await api.put(`/nodes/update/${nodeId}`, form.value)
    router.push('/admin')
  } catch (error) {
    errors.value = error.response.data.errors
  }
}

onMounted(async () => {
  const allNodes = await api.get('/nodes/all')
  nodes.value = allNodes.data

  const res = await api.get(`/nodes/${nodeId}`)
  const data = res.data

  form.value.title = data.title
  form.value.message = data.message

  form.value.options = data.options?.map(opt => ({
    _id: crypto.randomUUID(),
    text: opt.text,
    next_node: opt.next_node
  })) || []
})
</script>

<template>
  <div>
    <h1>Editar mensaje</h1>

    <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>

    <form @submit.prevent="submitForm">

      <div>
        <label>Título</label>
        <input v-model="form.title" type="text" />
      </div>

      <div>
        <label>Mensaje</label>
        <textarea v-model="form.message" required></textarea>
      </div>

      <div>
        <label>Opciones</label>

        <div v-for="(option, index) in form.options" :key="option._id">

          <input
            v-model="option.text"
            placeholder="Texto de la opción"
            type="text"
            required
          />

          <select v-model="option.next_node" required>
            <option disabled value="">Vincular al mensaje...</option>
            <option v-for="node in nodes" :key="node.id" :value="node.id">
              {{ node.id }} - {{ node.title }}
            </option>
          </select>

          <button type="button" @click="removeOption(index)">X</button>
        </div>

        <button type="button" @click="addOption">Agregar opción</button>
      </div>

      <button type="submit">Guardar cambios</button>
    </form>
  </div>
</template>

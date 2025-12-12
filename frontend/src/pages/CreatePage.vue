<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useRouter } from 'vue-router'

const router = useRouter()
const errors = ref([])

const form = ref({
  title: '',
  message: '',
  options: [],
})

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
    await api.post('/nodes/create', form.value)
    router.push('/admin')
  } catch (error) {
    errors.value = error.response.data.errors
  }
  
}

const nodes = ref([])
const nuevoId = ref([])

onMounted(async () => {
  const { data } = await api.get('nodes/all')
  nodes.value = data
  nuevoId.value = data.length + 1
})
</script>

<template>
  <div>
    <button @click="router.push('/admin')">Volver al panel</button>

    <h1>Create a message</h1>

    <p v-if="errors.title" class="error">{{ errors.title[0] }}</p>

    <form @submit.prevent="submitForm">
      <div>
        <label>Título</label>
        <input :placeholder="`Mensaje ${nuevoId}`" v-model="form.title" type="text"/>
      </div>

      <div>
        <label>Mensaje</label>
        <textarea v-model="form.message" required></textarea>
      </div>

      <div>
        <label>Opciones</label>

        <div v-for="(option, index) in form.options" :key="option._id">
          <input v-model="option.text" placeholder="texto" type="text" required/>

          <select required v-model="option.next_node">
            <option disabled value="">Vincular al mensaje...</option>
            <option v-for="node in nodes" :key="node.id" :value="node.id">
              {{ node.id }} {{ node.title }}
            </option>
          </select>

          <button type="button" @click="removeOption(index)">X</button>
        </div>

        <button type="button" @click="addOption">Agregar opción</button>
      </div>

      <button type="submit">Crear nodo</button>
    </form>
  </div>
</template>

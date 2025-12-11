<script setup>
  import { ref, onMounted } from 'vue'
  import api from '../services/api'
  import { useRouter } from 'vue-router'

  const router = useRouter()

  const form = ref({
    title: '',
    message: '',
    options: [],
  })

  // Agrega un bloque nuevo de opción
  const addOption = () => {
    form.value.options.push(
      { _id: crypto.randomUUID(), text: '', next_node: ''}
    )
  }

  const removeOption = (index) => {
    form.value.options.splice(index, 1)
  }

  const submitForm = async () => {
    console.log('Datos enviados:', form.value)
    await api.post('/nodes/create', form.value)
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
    
    <br>
    
    <h1>Create a message</h1>
    
    <br>

    <form @submit.prevent="submitForm">
      <!-- Título -->
      <div>
        <label >Título</label>
        <input :placeholder="`Mensaje ${nuevoId}`" v-model="form.title" type="text"/>
      </div>
      <!-- Mensaje -->
      <div>
        <label >Mensaje</label>
        <textarea v-model="form.message" type="text" required></textarea>
      </div>
      <!-- Opciones dinámicas -->
      <div>
        <label>Opciones</label>
        <div v-for="(option, index) in form.options" :key="option._id">
          <!-- Select -->
          <label>Opcion</label>
          <input v-model="option.text" placeholder="texto" type="text" required/>
          <select v-model="option.next_node">
            <option disabled value="">Vincular al mensaje...</option>
            <option v-for="node in nodes" :key="node.id" :value="node.id">{{node.id}} {{ node.title }}</option>
          </select>
          <!-- Botón eliminar -->
          <button type="button" @click="removeOption(index)">X</button>
        </div>
        <!-- Botón agregar opción -->
        <button type="button" @click="addOption">
            Agregar opción
        </button>
      </div>
      <button type="submit">
        Crear nodo
      </button>
    </form>
  </div>
</template>
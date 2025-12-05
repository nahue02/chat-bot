<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'

const form = ref({
  title: '',
  message: '',
  options: [],
})

// Agrega un bloque nuevo de opción
const addOption = () => {
  form.value.options.push({
    next_node: '',
  })
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

  form.value.title = 'Mensaje ' + nuevoId.value
  console.log(nuevoId.value)
})

</script>

<template>
    <form class="container" @submit.prevent="submitForm">
        <!-- Título -->
        <div class="mb-3">
            <label class="form-label">Título</label>
            <input class="form-control" v-model="form.title" type="text" required/>
        </div>

        <!-- Mensaje -->
        <div class="mb-3">
            <label class="form-label">Mensaje</label>
            <input class="form-control" v-model="form.message" type="text" required/>
        </div>

        <!-- Opciones dinámicas -->
        <div class="mb-3">
        <label class="form-label">Opciones</label>

        <div
            v-for="(option, index) in form.options"
            :key="index"
            class="d-flex gap-2 mb-2">
            <!-- Select -->
            <select class="form-control" v-model="option.next_node">
            <option disabled value="">Seleccionar nodo…</option>
            <option
                v-for="node in nodes"
                :key="node.id"
                :value="node.id"
            >
                {{ node.title }}
            </option>
            </select>

            <!-- Botón eliminar -->
            <button
                type="button"
                class="btn btn-danger"
                @click="removeOption(index)">
                X
            </button>
        </div>

            <!-- Botón agregar opción -->
            <button type="button" class="btn btn-secondary" @click="addOption">
                Agregar opción
            </button>
        </div>

        <button type="submit" class="btn btn-primary">
            Crear nodo
        </button>
    </form>
</template>
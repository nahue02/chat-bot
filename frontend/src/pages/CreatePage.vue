<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useRouter } from 'vue-router'
import TopBar from '@/components/TopBar.vue'

const router = useRouter()
const errors = ref([])
const title = "Create a new node"

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
  <v-container fluid class="pa-0 fill-height overflow-auto">
    <top-bar :title="title" />

    <v-container class="py-6">
      <v-alert
        v-if="errors.title"
        type="error"
        variant="tonal"
        class="mb-4"
      >
        {{ errors.title[0] }}
      </v-alert>

      <v-card class="pa-6 rounded-lg elevation-2 border">
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

          <v-card
            class="pa-4 mb-6 border"
            rounded="lg"
          >
            <div class="d-flex justify-space-between align-center mb-2">
              <h3 class="text-subtitle-1 font-weight-medium">Opciones</h3>
              <v-btn
                size="small"
                color="primary"
                prepend-icon="mdi-plus"
                @click="addOption"
              >Agregar opción</v-btn>
            </div>

            <v-divider class="mb-4"></v-divider>

            <span v-if="form.options.length === 0">No se agregaron opciones</span>

            <div
              v-for="(option, index) in form.options"
              :key="option._id"
              class="d-flex align-center gap-4 mb-4 flex-wrap"
            >
              <v-text-field
                v-model="option.text"
                label="Texto"
                class="flex-1"
                required
              />

              <v-select
                v-model="option.next_node"
                :items="nodes"
                item-title="title"
                item-value="id"
                label="Vincular a nodo"
                class="flex-1"
                required
              />

              <v-btn
                color="red"
                icon="mdi-delete"
                variant="tonal"
                @click="removeOption(index)"
              />
            </div>
          </v-card>

          <v-btn
            type="submit"
            color="primary"
            prepend-icon="mdi-content-save"
            block
          >
            Crear nodo
          </v-btn>
        </form>
      </v-card>
    </v-container>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useRouter } from 'vue-router'

const router = useRouter()
const nodes = ref([])

onMounted(async () => {
  const { data } = await api.get('nodes/all')
  nodes.value = data
  console.log(nodes.value)
})

const editNode = (node) => {
  console.log("Editar:", node)
  // acá navegas o abrís modal
}

const deleteNode = async (id) => {
  console.log("Eliminar:", id)
  await api.delete('nodes/delete/' + id)
}

</script>

<template>
    <div class="container">
      
        <h1>Admin Page</h1>
        <button @click="router.push('/')">
          Volver al chat
        </button>
        <button @click="router.push('/create')">
          Crear nuevo mensaje
        </button>
        <ul class="list-group">
            <li class="list-group-item">
                <div v-for="node in nodes" :key="node.id" class="card mb-3">
                  <div class="card-body d-flex justify-content-between align-items-start">

                    <!-- Título + pregunta -->
                    <div style="flex-grow: 1;">
                      <h5 class="card-title m-0 d-flex align-items-center">
                        {{ node.title }}

                        <!-- Botones -->
                        <button 
                          class="btn btn-sm btn-warning ms-3"
                          @click="editNode(node)"
                        >
                          Editar
                        </button>

                        <button 
                          class="btn btn-sm btn-danger ms-2"
                          @click="deleteNode(node.id)"
                        >
                          Eliminar
                        </button>
                      </h5>

                      <h6 class="card-subtitle mb-2 mt-2 text-body-secondary">
                        {{ node.message }}
                      </h6>
                    </div>

                  </div>

                  <!-- Opciones -->
                  <div class="card-footer">
                    <a 
                      v-for="option in node.options" 
                      :key="option" 
                      href="#" 
                      class="btn btn-primary btn-sm me-2"
                    >
                      {{ option }}
                    </a>
                  </div>
                </div>
            </li>
        </ul>
    </div>
</template>
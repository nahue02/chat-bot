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
    <div>
      <button @click="router.push('/')">
        Volver al chat
      </button>
      <button @click="router.push('/create')">
        Crear nuevo mensaje
      </button>
      
      <br>

      <h1>Admin Page</h1>

      <br>

      <ul>
        <li v-for="node in nodes" :key="node.id">
          <strong>{{ node.id }}:</strong> {{ node.title }}
          <button @click="editNode(node)">Editar</button>
          <button @click="deleteNode(node.id)">Eliminar</button>
          <br>
          <p>
            {{ node.message }}
          </p>
          <ul>
            <li v-for="option in node.options" :key="option.text">
              - {{ option.text }} (next message: {{ option.next_node }})
            </li>
          </ul>
          <hr>
        </li>
      </ul>
    </div>
</template>
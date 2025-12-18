<script setup>
  import { ref, onMounted } from 'vue'
  import api from '../services/api'
  import { useRouter } from 'vue-router'
  import Dialog from '@/components/Dialog.vue'

  const router = useRouter()
  const nodes = ref([])

  onMounted(async () => {
    const { data } = await api.get('nodes/all')
    nodes.value = data
    console.log(nodes.value)
  })

  const editNode = (id) => {
    router.push('/edit/' + id)
  }

  const deleteNode = async (id) => {
    await api.delete('nodes/delete/' + id)
  }

</script>

<template>
  <div>
    <h1>Panel de Administracion</h1>
    <v-list>
  <v-list-item
    v-for="node in nodes"
    :key="node.id"
    class="mb-4"
  >
    <v-card class="w-100">
      <v-card-title class="d-flex justify-space-between align-center">
        <div>
          <strong>{{ node.id }} - {{ node.title }}</strong>
        </div>

        <div>
          <v-btn
            size="small"
            variant="text"
            color="primary"
            @click="editNode(node.id)"
          >
            Editar
          </v-btn>

          <v-btn
            size="small"
            variant="text"
            color="error"
            @click="deleteNode(node.id)"
          >
            Eliminar
          </v-btn>
        </div>
      </v-card-title>

      <v-card-text>
        <p class="mb-2">
          {{ node.message }}
        </p>

        <v-list density="compact">
          <v-list-item
            v-for="option in node.options"
            :key="option.id"
          >
            • {{ option.text }}
            <span class="text-grey">
              (next: {{ option.next_node }})
            </span>
          </v-list-item>
        </v-list>
      </v-card-text>

      <v-divider />

      <v-card-actions>
      </v-card-actions>
    </v-card>
  </v-list-item>
</v-list>
    </div>
</template>
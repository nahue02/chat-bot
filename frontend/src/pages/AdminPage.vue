<script setup>
  import { ref, onMounted } from 'vue'
  import api from '../services/api'
  import { useRouter } from 'vue-router'
  import TopBar from '@/components/TopBar.vue'

  const router = useRouter()
  const nodes = ref([])
  const title = "Message Flow"


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
  <v-container fluid class="pa-0 fill-height overflow-auto">
    <top-bar :title=title />

    <v-card v-for="node in nodes" :key="node.id" variant="tonal" class="mt-4 ma-auto block">
        <v-card-title class="d-flex justify-space-between align-center">
          <span class="text-h5">{{ node.title }}</span>

          <v-menu>
            <template v-slot:activator="{ props }">
              <v-btn icon="mdi-dots-vertical" variant="text" v-bind="props"></v-btn>
            </template>

            <v-list>
              <v-list-item>
                <v-list-item-title @click="editNode(node.id)">Editar</v-list-item-title>
                <v-list-item-title @click="deleteNode(node.id)">Eliminar</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-card-title>
        <v-card-text>
            <p class="mb-2">
              {{ node.message }}
            </p>

            <v-divider></v-divider>
            
            <span class="text-h6">Opciones</span>
              <v-list>
                <v-list-item
                  v-for="option in node.options"
                  :key="option.id"
                >
                  {{ option.text }}
                  <span>
                    (next: {{ option.next_node }})
                  </span>
             </v-list-item>
           </v-list>
         </v-card-text>
      </v-card>
  </v-container>
</template>
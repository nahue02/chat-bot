<template>
  <v-container fluid class="pa-0 fill-height overflow-auto">
    <top-bar :title="title" />
    
    <VueFlow 
    :nodes="nodes" 
    :edges="edges"
    :default-edge-options="{ markerEnd: 'arrow' }"
    >
      <template #node-custom="{ data }">
        <v-card
        :color="color"
        :variant="cardVariant"
        class="mx-auto"
        width="300"
        >
          <v-card-item>
            <div>
              <div class="d-flex justify-end mb-1">
                <v-btn 
                @click="openEdit(data.id)" 
                density="compact" 
                variant="plain" 
                icon="mdi-text-box-edit"
                >
                </v-btn>
              </div>
              <div class="text-h6 mb-1">
                {{data.title}}
              </div>
              <div class="text-caption">
                {{data.message}}
              </div>
            </div>
          </v-card-item>
          <v-divider></v-divider>
          <v-card-actions class="d-flex flex-column align-start gap-2">
            <div v-if="data.options.length === 0" class="ma-auto">
              No hay opciones
            </div>
            <v-btn 
            v-for="option in data.options" 
            :key="option.id"
            @click="goToNode(option.next_node)"
            >
              {{ option.text }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </template>
      <Background />
    </VueFlow>
    
    <UpdateNodeDialog
    :nodeId="selectedId"
    v-model="showEditDialog"
    />
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useRouter } from 'vue-router'
import TopBar from '@/components/TopBar.vue'
import { VueFlow, useVueFlow } from '@vue-flow/core'
import '@vue-flow/core/dist/style.css'
import '@vue-flow/core/dist/theme-default.css';
import { Background } from '@vue-flow/background'
import UpdateNodeDialog from '@/components/UpdateNodeDialog.vue'

const router = useRouter()
const title = "Message Flow"

const showEditDialog = ref(false)
const selectedId = ref(null)

const openEdit = (id) => {
  selectedId.value = id
  showEditDialog.value = true
}

const nodes = ref([])
const edges = ref([])

const color = ref("indigo")
const cardVariant = ref("flat")

const { findNode, setCenter } = useVueFlow()

onMounted(async () => {
  const { data } = await api.get('nodes/all')

  nodes.value = data.map((n, index) => ({
    id: String(n.id),
    position: { x: 100, y: index * 200 },
    data: n,
    type: 'custom'
  }))

  edges.value = data.flatMap(n =>
    (n.options || [])
      .filter(opt => opt.next_node)
      .map(opt => ({
        id: `e${n.id}-${opt.next_node}`,
        source: String(n.id),
        target: String(opt.next_node),
        animated: true
      }))
  )
})

function goToNode(targetId) {
  const node = findNode(String(targetId))
  if (!node) return

  setCenter(node.position.x + 200, node.position.y + 180, { zoom: 1 })
}

const editNode = (id) => router.push('/edit/' + id)
const deleteNode = async (id) => await api.delete('nodes/delete/' + id)
</script>

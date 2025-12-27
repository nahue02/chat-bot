<template>
  <v-container fluid class="pa-0 fill-height overflow-auto">
    <top-bar :title="title" />
    
    <VueFlow 
    v-model:nodes="mappedNodes" 
    v-model:edges="edges"
    :default-edge-options="{ markerEnd: 'arrow' }"
    >
      <template #node-custom="{ id, data }">
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
                @click=openEdit(id)
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
      v-if="showEditDialog"
      :nodeId="selectedId"
      v-model="showEditDialog"
    />
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import TopBar from '@/components/TopBar.vue'
import { VueFlow, useVueFlow } from '@vue-flow/core'
import '@vue-flow/core/dist/style.css'
import '@vue-flow/core/dist/theme-default.css';
import { Background } from '@vue-flow/background'
import UpdateNodeDialog from '@/components/UpdateNodeDialog.vue'
import { useNodes } from '@/stores/useNodes.js'

const title = "Message Flow"
const color = ref("indigo")
const cardVariant = ref("flat")

const showEditDialog = ref(false)
const selectedId = ref(null)

const openEdit = (id) => {
  selectedId.value = id
  showEditDialog.value = true
}

const { nodes, loadNodes, updateNodePosition } = useNodes()

const edges = ref([])
const mappedNodes = ref([])

const { findNode, setCenter, onNodeDragStop } = useVueFlow()

onNodeDragStop(({ node }) => {
  updateNodePosition(node.id, node.position)
})

onMounted(async () => {
  await loadNodes(api)

  mappedNodes.value = nodes.value.map(node => ({
    id: String(node.id),
    data: { 
      title: node.title,
      message: node.message,
      options: node.options
    },
    type: 'custom',
    position: node.position
    ? node.position
    : node.positions?.length
      ? { x: node.positions[0].x, y: node.positions[0].y }
      : { x: 100, y: 100 },
  }))

  edges.value = mappedNodes.value.flatMap(n =>
    (n.data?.options || []).map(opt => ({
      id: `e${n.id}-${opt.next_node}`,
      source: String(n.id),
      target: String(opt.next_node)
    }))
  )
})


function goToNode(targetId) {
  const node = findNode(String(targetId))
  if (!node) return

  setCenter(node.position.x + 200, node.position.y + 180, { zoom: 1 })
}
</script>

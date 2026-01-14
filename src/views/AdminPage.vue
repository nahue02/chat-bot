<template>
  <v-container fluid class="pa-0 w-100 fill-height overflow-y-auto">
    <VueFlow 
    v-model:nodes="mappedNodes" 
    v-model:edges="edges"
    :default-edge-options="{ 
      type: 'smoothstep',
      markerEnd: 'arrow', 
      animated: true
    }"
    >
      <template #node-custom="{ id, data }">
        <v-card
        :color="color"
        :variant="cardVariant"
        class="mx-auto rounded-xl"
        width="300"
        >
          <v-card-item>
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
            <div class="text-caption" v-html="format(data.message)"></div>
          </v-card-item>
          <v-divider></v-divider>
          <v-card-actions class="d-flex flex-column align-start gap-2 pb-3">
            <div v-if="data.options.length === 0" class="ma-auto">
              No options
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
      <MiniMap
        :node-color="color"
      />
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
  import { VueFlow, useVueFlow } from '@vue-flow/core'
  import '@vue-flow/core/dist/style.css'
  import '@vue-flow/core/dist/theme-default.css';
  import { Background } from '@vue-flow/background'
  import UpdateNodeDialog from '@/components/admin/UpdateNodeDialog.vue'
  import { nodesSessionManager } from '@/stores/nodesSessionManager.js'
  import { MiniMap } from '@vue-flow/minimap'
  import '@vue-flow/minimap/dist/style.css'
  import { formatText } from '@/scripts/formatText'

  const format = formatText()

  const color = ref("primary")
  const cardVariant = ref("flat")

  const showEditDialog = ref(false)
  const selectedId = ref(null)

  const openEdit = (id) => {
    selectedId.value = id
    showEditDialog.value = true
  }

  const { nodes, loadNodes, updateNodePosition } = nodesSessionManager()

  const edges = ref([])
  const mappedNodes = ref([])

  const { findNode, setCenter, onNodeDragStop } = useVueFlow()

  onNodeDragStop(({ node }) => {
    updateNodePosition(node.id, node.position)
  })

  onMounted(async () => {
    await loadNodes()

    mappedNodes.value = nodes.value.map(node => ({
      id: String(node.id),
      data: { 
        title: node.title,
        message: node.message,
        options: node.node_options
      },
      type: 'custom',
      position: node.node_positions?.length > 0
    ? {
        x: Number(node.node_positions[0].x) || 100,
        y: Number(node.node_positions[0].y) || 100
      }
    : { x: 100, y: 100 },
    }))

    edges.value = mappedNodes.value.flatMap(sourceNode =>
      (sourceNode.data?.options || []).map(opt => {
        const targetNode = mappedNodes.value.find(
          n => String(n.id) === String(opt.next_node)
        )
      
        const isBackward =
          targetNode &&
          targetNode.position.y < sourceNode.position.y
      
        return {
          id: `e${sourceNode.id}-${opt.next_node}`,
          source: String(sourceNode.id),
          target: String(opt.next_node),
          type: 'smoothstep',
          class: isBackward ? 'edge-backward' : 'edge-forward'
        }
      })
    )
  })


  function goToNode(targetId) {
    const node = findNode(String(targetId))
    if (!node) return
    console.log(node.position)
    setCenter(node.position.x + 200, node.position.y + 180, { zoom: 1 })
  }
</script>

<style>
  .edge-backward {
    opacity: 0.15;
    stroke-dasharray: 4;
  }
</style>
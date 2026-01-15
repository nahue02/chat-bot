<template>
  <v-dialog v-model="localModel" max-width="900">
    <v-card class="pa-6 rounded-xl elevation-2 border overflow-y-auto" color="#09090b" style="max-height: 90vh;">
      <form @submit.prevent="submitForm">
          <div class="d-flex justify-space-between align-center">
            <div class="text-h6">
              Update Node
            </div>
            <div>
              <v-btn variant="plain" @click="closeDialog" icon="mdi-close"></v-btn>
            </div>
          </div>
          <div class="mt-8">
            <v-text-field v-model="form.title" variant="plain" label="Title"/>

            <v-textarea v-model="form.message" label="Text" variant="plain" placeholder="Use **text** to bold text" rows="4" auto-grow required/>

            <div class="border pa-5 mb-6 rounded-lg">
              <div class="d-flex justify-space-between align-center mb-4">
                <div class="text-subtitle-1 font-weight-medium">
                  Options
                </div>

                <v-btn variant="none" size="regular" prepend-icon="mdi-plus" class="elevation-0 pa-2" @click="addOption"
                ></v-btn>
              </div>
              <div v-if="form.options.length === 0">
                No options added yet
              </div>
              <div v-for="(option, index) in form.options" :key="option._id" class="slide-up">
                <div class="d-flex justify-space-between">
                  <div></div>

                  <v-btn icon="mdi-close" size="small" variant="plain" @click="removeOption(index)" />
                </div>
                
                <v-text-field v-model="option.text" label="Message" variant="outlined" required />
      
                <v-select v-model="option.next_node" :items="nodes" item-title="title" item-value="id" label="Next node" variant="outlined" required/>
              </div>
            </div>
    
            <v-card-actions class="d-flex justify-end">
              <v-btn @click="destroy" variant="tonal" color="primary">Delete Node</v-btn>
              <v-btn type="submit" >Save Changes</v-btn>
            </v-card-actions>
          </div>
        </form>
    </v-card>
  </v-dialog>
</template>
<script setup>
import { ref, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { nodesSessionManager } from '@/stores/nodesSessionManager.js'

const props = defineProps({
  nodeId: String,
  modelValue: Boolean
})


const emit = defineEmits(['update:modelValue'])
const router = useRouter()
const { nodes, loadNodes, loadNode, updateNode, deleteNode } = nodesSessionManager();

const form = ref({
  title: '',
  message: '',
  options: []
})

onMounted(async () => {
  await loadNodes()

  if (props.nodeId) {
    const data = await loadNode(props.nodeId)
    console.log(data)
    if (data) loadForm(data)
  }
})

const localModel = ref(props.modelValue)

watch(() => props.modelValue, val => localModel.value = val)
watch(localModel, val => emit('update:modelValue', val))

const closeDialog = () => {
  localModel.value = false
}

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
  updateNode(props.nodeId, form.value)
  closeDialog()
}

async function loadForm(data) {
  form.value = {
    title: data.title,
    message: data.message,
    options: data.node_options?.map(opt => ({
      _id: crypto.randomUUID(),
      text: opt.text,
      next_node: opt.next_node
    })) || []
  }
}

async function destroy() {
  console.log(props.nodeId)
  deleteNode(props.nodeId)
  router.go('/admin')
}
</script>

<style>
  .slide-up {
    animation: slideUp 0.3s ease-out forwards;
  }

  @keyframes slideUp {
    from {
      transform: translateY(20px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }
</style>
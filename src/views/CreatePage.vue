<template>
    <v-container>
      <div class="w-75 ma-auto">
        <div class="text-h5 mb-8 mt-5">
          Create a new Node
        </div>
        <div class="elevation-0 pt-2 overflow-y-auto" color="transparent">
          <form @submit.prevent="submitForm">
            <v-text-field v-model="form.title" variant="plain" label="Title"
            />
  
            <v-textarea v-model="form.message" label="Text" variant="plain" placeholder="Surround text with ** to bold." rows="4" auto-grow required
            />
  
            <div class="border pa-5 mb-6 rounded-lg">
              <div class="d-flex justify-space-between align-center mb-4">
                <div class="text-subtitle-1 font-weight-medium">
                  Options
                </div>

                <v-btn variant="none" size="regular" prepend-icon="mdi-plus" class="elevation-0 pa-2" @click="addOption">
                </v-btn>
              </div>

              <div v-if="form.options.length === 0">
                No options added yet
              </div>
              
              <div
                v-for="(option, index) in form.options"
                :key="option._id"
                class="slide-up"
              >
                <div class="d-flex justify-space-between">
                  <div></div>

                  <v-btn icon="mdi-close" size="small" variant="plain" @click="removeOption(index)" />
                </div>
                
                <v-text-field
                  v-model="option.text"
                  label="Message"
                  variant="outlined"
                  required
                />
                <v-select
                  v-model="option.next_node"
                  :items="nodes"
                  item-title="title"
                  item-value="id"
                  label="Next node"
                  variant="outlined"
                  required
                />
              </div>
            </div> 
            <div class="d-flex justify-end">
              <v-btn
                type="submit"
                color="primary"
              >
                Create
              </v-btn>
            </div>
          </form>
        </div>
      </div>
    </v-container>
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import { nodesSessionManager } from '@/stores/nodesSessionManager.js'
  import { useRouter } from 'vue-router'

  const router = useRouter()

  const { nodes, loadNodes, createNode } = nodesSessionManager()

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

  const submitForm = () => {
    createNode(form.value)
    router.push('/admin')
  }

  onMounted(() => {
    loadNodes()
  })
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
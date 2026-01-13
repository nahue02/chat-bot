<template>
  <v-container class="d-flex h-100 " >
    <v-container class="py-6">
      <v-alert
        v-if="errors.title"
        type="error"
        variant="tonal"
        class="mb-4"
      >
        {{ errors.title[0] }}
      </v-alert>

      <v-card class="pa-6 rounded-lg elevation-0 overflow-y-auto fill-height" color="transparent">
        <form @submit.prevent="submitForm">

          <v-text-field
            v-model="form.title"
            label="Title"
            prepend-icon="mdi-format-title"
            class="mb-4"
          />

          <v-textarea
            v-model="form.message"
            label="Text"
            placeholder="Use **text** to bold text"
            prepend-icon="mdi-message-text-outline"
            class="mb-6"
            rows="4"
            auto-grow
            required
          />

          <v-card
            class="pa-4 mb-6 border"
            rounded="lg"
            color="transparent"
          >
            <div class="d-flex justify-space-between align-center mb-2">
              <h3 class="text-subtitle-1 font-weight-medium">Options</h3>
              <v-btn
                size="medium"
                prepend-icon="mdi-plus"
                class="elevation-0 pa-2"
                @click="addOption"
              ></v-btn>
            </div>

            <v-divider class="mb-4"></v-divider>

            <span v-if="form.options.length === 0">No options added</span>

            <div
              v-for="(option, index) in form.options"
              :key="option._id"
              class="d-flex align-center gap-4 mb-4 flex-wrap"
            >
              <v-text-field
                v-model="option.text"
                label="Message"
                class="flex-1 mr-4"
                required
              />
              
              <v-select
                v-model="option.next_node"
                :items="nodes"
                item-title="title"
                item-value="id"
                label="Next node"
                class="flex-1 ml-2 mr-4"
                required
              />

              <v-btn
                color="red"
                icon="mdi-delete"
                variant="plain"
                @click="removeOption(index)"
              />
            </div>
          </v-card>

          <v-btn
            type="submit"
            color="primary"
            prepend-icon="mdi-content-save"
          >
            Create
          </v-btn>
        </form>
      </v-card>
    </v-container>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { nodesSessionManager } from '@/stores/nodesSessionManager.js'
import { useRouter } from 'vue-router'

const router = useRouter()
const title = "Create a new node"
const errors = ref([])

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

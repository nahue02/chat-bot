<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import ChatMessage from '@/components/ChatMessage.vue'
import ChatOption from '@/components/ChatOption.vue'
import ChatHistory from '@/components/ChatHistory.vue'

const messages = ref([])
const currentNode = ref(null)
const nodeHistory = ref([])

onMounted(async () => {
  const { data } = await api.get('chat/start')
  currentNode.value = data
  nodeHistory.value.push(data)
})

const selectOption = async (option) => {
  messages.value.push({ from: 'bot', text: currentNode.value.message })
  messages.value.push({ from: 'user', text: option.text })

  const { data } = await api.post('chat/next', {
    selected_option: option.next_node
  })

  currentNode.value = data
  nodeHistory.value.push(data)
}

</script>

<template>
  <div style="height: 100%; overflow: hidden;">
    <v-container fluid class="pa-0" style="height: 100%;">
      <v-row class="ma-0" style="height: 100%; min-height: 0;">
        <v-col cols="9" class="d-flex flex-column" style="min-height: 0;">
          <v-sheet class="pa-4 flex-grow-1" style="overflow-y: auto; min-height: 0;" rounded>
            <chat-message
              v-for="(msg, index) in messages"
              :key="index"
              :message="msg.text"
              :from="msg.from"
            />

            <div v-if="currentNode">
              <chat-message :message="currentNode.message" :from="bot" />
              <v-row class="mt-2 ml-12" dense style="column-gap: 1rem;">
                <v-col v-for="option in currentNode.options" :key="option.id" cols="auto" class="pa-0">
                  <chat-option @click="selectOption(option)" :text="option.text" />
                </v-col>
              </v-row>
            </div>
          </v-sheet>
        </v-col>

        <v-col cols="3" class="d-flex flex-column" style="min-height: 0;">
          <v-sheet class="pa-4 flex-grow-1" style="overflow-y: auto; min-height: 0;" rounded>
            <chat-history class="mt-4" :node-history="nodeHistory" />
          </v-sheet>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<template>
  <v-container fluid class="pa-0 h-100 overflow-hidden">
    <v-row class="ma-0 h-100">
      <v-col cols="9" class="d-flex flex-column h-100 pa-0">
        <div ref="chatContainer" class="flex-grow-1 overflow-y-auto pa-16">
            <div v-if="loading" class="d-flex justify-center align-center fill-height">
              <v-progress-circular indeterminate></v-progress-circular>
            </div>
            <div v-else class="d-flex flex-column justify-end" style="min-height: 100%;">
              <chat-message
                v-for="(msg, index) in messages"
                :key="index"
                :message="msg.text"
                :from="msg.from"
              />
              <div v-if="currentNode" class="mb-4">
                <chat-message :message="currentNode.message" from="bot" />
                <v-row class="mt-4 ml-16" dense style="column-gap: 1rem;">
                  <v-col v-for="option in currentNode.node_options" :key="option.id" cols="auto" class="pa-0">
                    <chat-option @click="selectOption(option)" :text="option.text" />
                  </v-col>
                </v-row>
              </div>
              <div ref="bottomAnchor"></div>
            </div>
        </div>
      </v-col>
      <v-col cols="3" class="d-flex flex-column h-100 border-s">
        <v-sheet class="flex-grow-1 overflow-y-auto" color="transparent">
          <chat-history :node-history="nodeHistory" />
        </v-sheet>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted, nextTick, watch } from 'vue'
import ChatMessage from '@/components/ChatMessage.vue'
import ChatOption from '@/components/ChatOption.vue'
import ChatHistory from '@/components/ChatHistory.vue'
import { nodesSessionManager } from '@/stores/nodesSessionManager.js' 
import { chatSessionManager } from '@/stores/chatSessionManager'

const { loadNodes, loadNode } = nodesSessionManager()
const { saveChatState, saveCurrentNode, saveMessageFlow, getChatState, getCurrentNode, getMessageFlow, } = chatSessionManager();

const messages = ref([])
const currentNode = ref(null)
const nodeHistory = ref([])

const loading = ref(true)

const bottomAnchor = ref(null)
const chatContainer = ref(null)

const scrollToBottom = () => {
  nextTick(() => {
    setTimeout(() => {
      if (bottomAnchor.value) {
        bottomAnchor.value.scrollIntoView({ 
          behavior: 'smooth', 
          block: 'end'
        });
      }
    }, 50)
  })
}

onMounted(async () => {
  const chatState = await getChatState()
  if ( chatState.length === 0 ) {
    await loadNodes()
    currentNode.value = await loadNode(1)
    
    nodeHistory.value.push({
      title: "Inicio",
      message: currentNode.value.message,
      from: "bot"
    })

    loading.value = false

    saveCurrentNode(currentNode.value)
    saveMessageFlow(nodeHistory.value)


    scrollToBottom()
  } else {
    loading.value = false

    messages.value = await getChatState()
    currentNode.value = await getCurrentNode()
    nodeHistory.value = await getMessageFlow()

    scrollToBottom()
  }
})

const selectOption = async (option) => {
  messages.value.push({ from: 'bot', text: currentNode.value.message })
  messages.value.push({ from: 'user', text: option.text })

  nodeHistory.value.push({
    message: option.text,
    from: "user"
  })

  currentNode.value = await loadNode(option.next_node)
  nodeHistory.value.push(currentNode.value)

  saveChatState(messages.value)
  saveCurrentNode(currentNode.value)
  saveMessageFlow(nodeHistory.value)

  scrollToBottom()
}

</script>

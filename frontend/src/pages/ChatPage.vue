<template>
  <v-container fluid class="pa-0 fill-height">
    <v-row class="ma-0 fill-height">
      <v-col cols="9" class="d-flex flex-column chat-col">
        <top-bar :title=title />
        <v-sheet class="pa-4 flex-grow-1 border" rounded>
          <chat-message
            v-for="(msg, index) in messages"
            :key="index"
            :message="msg.text"
            :from="msg.from"
          />
          <div v-if="currentNode">
            <chat-message :message="currentNode.message" from="bot" />
            <v-row class="mt-2 ml-12" dense style="column-gap: 1rem;">
              <v-col v-for="option in currentNode.options" :key="option.id" cols="auto" class="pa-0">
                <chat-option @click="selectOption(option)" :text="option.text" />
              </v-col>
            </v-row>
          </div>
        </v-sheet>
      </v-col>
      <v-col cols="3" class="d-flex flex-column chat-col">
        <v-sheet class="ps-3 pe-3 flex-grow-1 border" rounded>
          <chat-history :node-history="nodeHistory" />
        </v-sheet>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue'
import api from '../services/api'
import ChatMessage from '@/components/ChatMessage.vue'
import ChatOption from '@/components/ChatOption.vue'
import ChatHistory from '@/components/ChatHistory.vue'
import TopBar from '@/components/TopBar.vue'
import { useNodes } from '@/stores/useNodes.js' 
import { chatState } from '@/stores/chatState'

const { loadNodes, loadNode } = useNodes()
const { saveChatState, saveCurrentNode, saveMessageFlow, getChatState, getCurrentNode, getMessageFlow, } = chatState();

const messages = ref([])
const currentNode = ref(null)
const nodeHistory = ref([])

const title = "My Custom Chatbot"

onMounted(async () => {
  const chatState = await getChatState()
  if ( chatState.length === 0 ) {
    console.log("hola")
    await loadNodes(api)
    currentNode.value = await loadNode(1)
    nodeHistory.value.push({
      title: "Inicio",
      message: currentNode.value.message,
      from: "bot"
    })

    saveCurrentNode(currentNode.value)
    saveMessageFlow(nodeHistory.value)
  } else {
    messages.value = await getChatState()
    currentNode.value = await getCurrentNode()
    nodeHistory.value = await getMessageFlow()
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
}

</script>



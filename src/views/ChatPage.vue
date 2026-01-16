<template>
  <v-container class="h-100 overflow-y-auto">
    <v-btn
      class="position-fixed top-0 right-0 mt-15 mr-1 z-10"
      @click="showFlow = !showFlow"
    >
      <v-icon icon="mdi-page-layout-sidebar-right" />
    </v-btn>
    <div class="h-100 w-75 ma-auto">
      <v-row class="h-100 ma-0">
        <v-col :cols="showFlow ? 8 : 12" class="transition-all">
          <div class="h-100 ma-auto">
            <div v-if="loading" class="d-flex justify-center align-center fill-height">
              <v-progress-circular indeterminate></v-progress-circular>
            </div>
            <div v-else class="d-flex flex-column justify-end overflow-x-hidden" style="min-height: 90%;">
              <chat-message
                v-for="(msg, index) in messages"
                :key="index"
                :message="msg.text"
                :from="msg.from"
                class="slide-up"
              />
              <div v-if="currentNode" class="mb-10">
                <chat-message :message="currentNode.message" from="bot" class="slide-up"/>
                <v-row class="w-100 ps-14 mt-4 ga-4" dense >
                  <v-col v-for="option in currentNode.node_options" :key="option.id" cols="auto" class="pa-0">
                    <chat-option class="slide-up" @click="selectOption(option)" :text="option.text" />
                  </v-col>
                </v-row>
              </div>
              <div v-else class="mb-10">
                <chat-message from="bot" class="slide-up"/>
              </div>
              <div ref="bottomAnchor"></div>
            </div>
          </div>
        </v-col>
        <v-col v-if="showFlow" cols="4" class="border-s h-100 overflow-y-auto">
          <chat-history :node-history="nodeHistory" />
        </v-col>
      </v-row>
    </div>

  </v-container>
</template>

<script setup>
  import { ref, onMounted, nextTick, watch } from 'vue'
  import ChatMessage from '@/components/chat/ChatMessage.vue'
  import ChatOption from '@/components/chat/ChatOption.vue'
  import ChatHistory from '@/components/chat/ChatHistory.vue'
  import { nodesSessionManager } from '@/stores/nodesSessionManager.js' 
  import { chatSessionManager } from '@/stores/chatSessionManager'

  const { loadNodes, loadNode } = nodesSessionManager()
  const { saveChatState, saveCurrentNode, saveMessageFlow, getChatState, getCurrentNode, getMessageFlow, } = chatSessionManager();

  const messages = ref([])
  const currentNode = ref(null)
  const nodeHistory = ref([])

  const loading = ref(true)

  const bottomAnchor = ref(null)

  const showFlow = ref(false)


  const sleep = (ms) => new Promise(resolve => setTimeout(resolve, ms))

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

    currentNode.value = null

    await sleep(900)

    currentNode.value = await loadNode(option.next_node)
    nodeHistory.value.push(currentNode.value)

    saveChatState(messages.value)
    saveCurrentNode(currentNode.value)
    saveMessageFlow(nodeHistory.value)

    scrollToBottom()
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
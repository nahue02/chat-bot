<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useRouter } from 'vue-router'
import ChatMessage from '@/components/ChatMessage.vue'
import ChatOption from '@/components/ChatOption.vue'

const router = useRouter()

const messages = ref([])
const currentNode = ref(null)

onMounted(async () => {
  const { data } = await api.get('chat/start')
  currentNode.value = data
})

const selectOption = async (option) => {
  messages.value.push({ from: 'bot', text: currentNode.value.message })
  messages.value.push({ from: 'user', text: option.text })

  const { data } = await api.post('chat/next', {
    selected_option: option.next_node
  })

  currentNode.value = data
}

</script>

<template>
  <v-container>
  <chat-message 
    v-for="(msg, index) in messages" 
    :key="index" 
    :message="msg.text" 
    :from="msg.from"
  />
  <div v-if="currentNode">
    <chat-message 
      :message="currentNode.message" 
      :from="bot"
    />
    <chat-option v-for="option in currentNode.options" :key="option.id" @click="selectOption(option)" :text="option.text"></chat-option>
  </div>
</v-container>
</template>


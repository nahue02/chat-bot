<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'
import { useRouter } from 'vue-router'

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
  <div>
    <button @click="router.push('/admin')">
      Panel de Administracion
    </button>
    <div class="chat-container">
      <!-- Mensajes -->
      <div class="messages">
        <div
          v-for="(msg, index) in messages"
          :key="index"
          :class="['message', msg.from]"
        >
          {{ msg.text }}
        </div>
      </div>

      <div v-if="currentNode" class="current-message">
        <div class="message bot">{{ currentNode.message }}</div>

        <div class="options">
          <button
            v-for="option in currentNode.options"
            :key="option.id"
            @click="selectOption(option)"
          >
            {{ option.text }} {{ option.next_node }}
          </button>
        </div>
      </div>
    </div>
    </div>
</template>

<style>
.chat-container {
  width: 400px;
  margin: auto;
  font-family: sans-serif;
}

.messages {
  margin-bottom: 20px;
}

.message {
  padding: 8px 12px;
  border-radius: 8px;
  margin-bottom: 10px;
  max-width: 80%;
}

.message.bot {
  background: #e6e6e6;
  align-self: flex-start;
}

.message.user {
  background: #cce5ff;
  align-self: flex-end;
  margin-left: auto;
  text-align: right;
}

.options {
  margin-top: 15px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.options button {
  padding: 10px;
  border: none;
  background: #007bff;
  color: white;
  border-radius: 6px;
  cursor: pointer;
}

.options button:hover {
  background: #0056b3;
}
</style>
<template>
    <v-navigation-drawer
        class="h-screen position-fixed"
        :width="250"
        v-model="drawer"
        :rail="false"
        permanent
        color="transparent"
      >
        <v-list>
          <v-list-item
            :prepend-avatar=botAvatar
          >
          <!--
          <template v-slot:append>
            
            <v-btn
              icon="mdi-chevron-left"
              variant="text"
              @click.stop="rail = !rail"
            ></v-btn>
            
            </template>
            -->
          </v-list-item>
          <v-divider></v-divider>
        </v-list>
        
        <v-list density="compact" nav>
          <v-list-item prepend-icon="mdi-message" to="/">
            <v-list-item-title class="font-weight-semibold">
              Chatbot
            </v-list-item-title>
          </v-list-item>
          <v-list-item prepend-icon="mdi-sitemap" to="/admin">
            <v-list-item-title class="font-weight-semibold">
              Admin Panel
            </v-list-item-title>
          </v-list-item>
          <v-list-item prepend-icon="mdi-plus-box" to="/create">
            <v-list-item-title class="font-weight-semibold">
              Create Message
            </v-list-item-title>
          </v-list-item>
        </v-list>

      <template v-slot:append>
        <div class="ma-2 ">
          <v-btn href="https://www.linkedin.com/in/nahuel-palacio/" target="_blank" density="compact" variant="plain" icon="mdi-linkedin" ></v-btn>
          <v-btn href="https://github.com/nahue02/chat-bot" target="_blank" density="compact" variant="plain" icon="mdi-github" ></v-btn>
          <v-btn @click="reload" density="compact" variant="plain" icon="mdi-restart" ></v-btn>
        </div>
      </template>
      </v-navigation-drawer>
</template>

<script setup>
  import botAvatar from '@/assets/bot-avatar-3.jpg';
  import { ref } from 'vue'
  import { chatSessionManager } from '@/stores/chatSessionManager'
  import { nodesSessionManager } from '@/stores/nodesSessionManager';
  import { useRouter } from 'vue-router'

  const router = useRouter()
  
  const drawer = ref(true)
  const rail = ref(true)

  function reload() {
    const { clearAll } = nodesSessionManager()

    clearAll()
    router.go('/')
  }
</script>
<template>
    <v-navigation-drawer
        class="h-screen position-fixed"
        v-model="drawer"
        :rail="rail"
        permanent
        @click="rail = false"
      >
        <v-list>
          <v-list-item
            :prepend-avatar=botAvatar
          >
          <template v-slot:append>
              <v-btn
                icon="mdi-chevron-left"
                variant="text"
                @click.stop="rail = !rail"
              ></v-btn>
            </template>
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

      <!-- TODO() Dialog para editar imagen y nombre del bot y usuario. ademas de colores-->
      <template v-slot:append>
        <div class="pa-2">
          <v-btn @click="reload" density="compact" variant="plain" icon="mdi-restart" ></v-btn>
        </div>
      </template>
      </v-navigation-drawer>
</template>

<script setup>
  import botAvatar from '@/assets/bot-avatar.png';
  import { ref } from 'vue'
  import { chatState } from '@/stores/chatState'
  import { useNodes } from '@/stores/useNodes';
  import { useRouter } from 'vue-router'

  const router = useRouter()
  
  const drawer = ref(true)
  const rail = ref(true)

  function reload() {
    const { clearAll } = useNodes()

    clearAll()
    router.go('/')
  }
</script>
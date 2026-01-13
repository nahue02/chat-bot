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
            <div class="font-weight-regular">
              Yumibot
            </div>
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
          <v-list-item v-for="item in routesList" :key="item.id"
            :prepend-icon=item.icon 
            :to=item.route
            class="rounded-lg"
          > 
            <v-list-item-title class="font-weight-regular">
              {{ item.title }}
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

  const routesList = ref([
    {
      id: 1,
      title: "Chat",
      icon: "mdi-message-badge-outline",
      route: "/"
    },
    {
      id: 2,
      title: "Flowchart",
      icon: "mdi-sitemap-outline",
      route: "/admin"
    },
    {
      id: 3,
      title: "Create",
      icon: "mdi-message-plus-outline",
      route: "/create"
    },
  ])

  function reload() {
    const { clearAll } = nodesSessionManager()

    clearAll()
    router.go('/')
  }
</script>
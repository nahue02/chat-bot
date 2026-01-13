<template>
    <v-app-bar class="position-fixed" :elevation="0" density="compact" color="#09090b">
      <template v-slot:prepend>
        <v-btn v-for="item in routesList" :key="item.id" variant="tonal" size="small" :to="item.route" class="ms-3">
          <v-icon :icon="item.icon"></v-icon>
        </v-btn>
      </template>
      
      <v-menu>
        <template v-slot:activator="{ props }">
          <v-btn variant="tonal" v-bind="props">
            <v-icon icon="mdi-apple-keyboard-option"></v-icon>
          </v-btn>
        </template>
        <v-list class="mt-1">
          <v-list-item
            v-for="(item, index) in items"
            :key="index"
            :value="index"
            @click="item.onClick"
          >
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
</template>

<script setup>
  import { ref } from 'vue'
  import { nodesSessionManager } from '@/stores/nodesSessionManager';
  import { useRouter } from 'vue-router'

  const router = useRouter()
 
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
      title: "Create node",
      icon: "mdi-plus",
      route: "/create"
    }
  ])

  const items = ref([
    { title: 'About', onClick: "" },
    { title: 'Restart Settings', onClick: reload },
  ])

  function openAboutModal() {
    
  }

  function reload() {
    const { clearAll } = nodesSessionManager()

    clearAll()
    router.go('/')
  }
</script>
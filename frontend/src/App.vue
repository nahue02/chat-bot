<script setup>
  import NavigationDrawer from './components/NavigationDrawer.vue';
</script>

<template>
  <v-app>
    <v-layout style="height: 100vh;">
      <NavigationDrawer />

      <!-- MUY IMPORTANTE: que el main NO scrollee -->
      <v-main class="bg-blue-grey-lighten-5" style="overflow: hidden;">
        <!-- router-view con slot para meter class al componente real -->
        <router-view v-slot="{ Component }">
          <component :is="Component" style="height: 100%;" />
        </router-view>
      </v-main>
    </v-layout>
  </v-app>
</template>
<script setup>
  import NavigationDrawer from './components/NavigationDrawer.vue';
</script>

<template>
  <v-app>
    <v-layout style="height: 100vh;">
      <NavigationDrawer />

      <v-main class="overflow-y-auto">
        <router-view v-slot="{ Component }">
          <component :is="Component"/>
        </router-view>
      </v-main>
    </v-layout>
  </v-app>
</template>
<script setup>
  import NavigationDrawer from './components/NavigationDrawer.vue';
</script>

<template>
  <v-layout class="rounded rounded-md border" height="100%">
    <NavigationDrawer />
    <v-main class="d-flex align-center justify-center">
      <v-container>
        <router-view />
      </v-container>
    </v-main>
  </v-layout>
</template>

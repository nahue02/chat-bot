<script setup>
  import NavigationDrawer from './components/NavigationDrawer.vue';
  import TopBar from './components/TopBar.vue';
</script>

<template>
  <v-app>
    <v-layout>
      <TopBar />
      <v-main class="background-dark">
        <router-view v-slot="{ Component }">
          <component :is="Component"/>
        </router-view>
      </v-main>
    </v-layout>
  </v-app>
</template>

<style>
  .background-dark {
    background-color: #09090b;
  }
</style>
<script setup>
  import NavigationDrawer from './components/NavigationDrawer.vue';
</script>

<template>
  <v-app>
    <v-layout class="h-100 overflow-hidden">
      <NavigationDrawer/>

      <v-main>
        <router-view v-slot="{ Component }" class="background-dark">
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
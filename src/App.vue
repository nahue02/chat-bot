<script setup>
  import TopBar from './components/common/TopBar.vue';
</script>

<template>
  <v-app>
    <v-layout >
      <v-main class="dark-background ">
        <TopBar/>
        <router-view v-slot="{ Component }" class="w-100">
          <component :is="Component" />
        </router-view>
      </v-main>
    </v-layout>
  </v-app>
</template>

<style>
  .dark-background {
    background-color: #09090b;
  }
</style>
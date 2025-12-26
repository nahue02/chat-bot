<script setup>
  import NavigationDrawer from './components/NavigationDrawer.vue';
</script>

<template>
  <v-app>
    <v-layout>
      <NavigationDrawer/>

      <v-main>
        <router-view v-slot="{ Component }">
          <component :is="Component"/>
        </router-view>
      </v-main>
    </v-layout>
  </v-app>
</template>
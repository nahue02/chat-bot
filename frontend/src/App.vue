<script setup>
  import NavigationDrawer from './components/common/NavigationDrawer.vue';
  import TopBar from './components/common/TopBar.vue';
</script>

<template>
  <v-app>
    <v-layout>
      <TopBar />
      <v-main class="animated-background">
        <router-view v-slot="{ Component }">
          <component :is="Component" class="dark-background"/>
        </router-view>
      </v-main>
    </v-layout>
  </v-app>
</template>

<style>
.animated-background {
  background:
    radial-gradient(
      circle at 20% 20%,
      rgba(255, 23, 68, 0.18),
      transparent 40%
    ),
    radial-gradient(
      circle at 80% 80%,
      rgba(255, 23, 68, 0.12),
      transparent 45%
    ),
    linear-gradient(
      120deg,
      #09090b,
      #0f0f14,
      #09090b
    );

  background-size: 200% 200%;
  animation: gradientMove 30s linear infinite;
}

@keyframes gradientMove {
  0% {
    background-position: 0% 0%;
  }
  50% {
    background-position: 100% 100%;
  }
  100% {
    background-position: 0% 0%;
  }
}

.dark-background {
  background-color: #09090bcc;
}
</style>
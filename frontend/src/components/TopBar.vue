<template>
    <v-app-bar :elevation="0" class="border-b position-fixed">
      <v-app-bar-title>{{ title }}</v-app-bar-title>
    </v-app-bar>
</template>

<script setup>
  
  defineProps({
    title: {
        type: String,
        required: true
    }
  });
</script>
<template>
  <div class="mt-3 mb-3">
    <h4>Chat History</h4>
    <v-divider></v-divider>
    <v-timeline density="compact" >
      <v-timeline-item
        v-for="(node, index) in nodeHistory"
        :key="index"
        :dot-color="node.from === 'user' ?  'secondary' : 'primary'"
        size="x-small"
      >
        <div v-if="node.from === bot" class="text-caption mb-1">
          {{ node.title}}
        </div>

        <div class="text-body-2">
          {{ node.message }}
        </div>
      </v-timeline-item>
    </v-timeline>
  </div>
</template>

<script setup>
defineProps({
  nodeHistory: {
    type: Array,
    required: true
  }
})
</script>

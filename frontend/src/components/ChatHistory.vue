<template>
  <div>
    <h4>Chat History</h4>

    <v-timeline density="compact" >
      <v-timeline-item
        v-for="(node, index) in nodeHistory"
        :key="index"
        dot-color="primary"
        size="x-small"
      >
        <div class="text-caption mb-1">
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

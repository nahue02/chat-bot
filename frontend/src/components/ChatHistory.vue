<template>
  <div>
    <h4 class="mb-3">Chat History</h4>

    <v-timeline density="compact" align="start">
      <v-timeline-item
        v-for="(node, index) in nodeHistory"
        :key="index"
        dot-color="primary"
        size="x-small"
      >
        <div class="text-caption text-grey-darken-2 mb-1">
          Node {{ index + 1 }}
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

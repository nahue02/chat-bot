<template>
  <div>
    <h4 class="ms-3 me-3 mb-2">Node Flow</h4>
    <v-divider></v-divider>
    <v-timeline class="ms-3 me-3" density="compact" >
      <v-timeline-item
        v-for="(node, index) in nodeHistory"
        :key="index"
        :dot-color="node.from === 'user' ?  'primary' : 'white'"
        size="x-small"
      >
        <div v-if="node.from === bot" class="text-caption mb-1">
          {{ node.title}}
        </div>

        <div class="text-body-2 text-truncate-multiline" v-html="format(node.message)">
        </div>
      </v-timeline-item>
    </v-timeline>
  </div>
</template>

<script setup>
  import { formatText } from '@/scripts/formatText'

  const format = formatText()

  defineProps({
    nodeHistory: {
      type: Array,
      required: true
    }
  })
</script>

<style>
  .text-truncate-multiline {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
  }

</style>
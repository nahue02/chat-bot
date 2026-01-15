<template>
  <v-dialog
    :model-value="modelValue"
    max-width="500"
    @update:model-value="emit('update:modelValue', $event)"
  >
    <v-card color="#09090b" class="border rounded-xl pt-2 pb-2 ps-1 pe-1">
      <v-card-title class="text-h6">
        Customize
      </v-card-title>

      <v-card-text>
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <v-btn text @click="emit('update:modelValue', false)">
          Close
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
  const props = defineProps({
    modelValue: {
      type: Boolean,
      required: true
    }
  })
  
  const emit = defineEmits(['update:modelValue'])
</script>
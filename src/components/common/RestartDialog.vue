<template>
  <v-dialog
    :model-value="modelValue"
    max-width="500"
    @update:model-value="emit('update:modelValue', $event)"
  >
    <v-card color="#09090b" class="border rounded-xl pt-2 pb-2 ps-1 pe-1">
      <v-card-title class="text-h6">
        Are you sure you want to restart all the data?
      </v-card-title>

      <v-card-text>
        All the nodes you created or edited will be deleted. Continue?
      </v-card-text>

      <v-card-actions>
        <v-btn color="primary" text @click="reload">
          Do it
        </v-btn>
        <v-btn text @click="emit('update:modelValue', false)">
          Cancel
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
  import { nodesSessionManager } from '@/stores/nodesSessionManager';
  import { useRouter } from 'vue-router'
  
  const router = useRouter()
  
  const props = defineProps({
    modelValue: {
      type: Boolean,
      required: true
    }
  })

  const emit = defineEmits(['update:modelValue'])

  function reload() {
    const { clearAll } = nodesSessionManager()

    clearAll()
    router.go('/')
  }
</script>
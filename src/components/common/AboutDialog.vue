<template>
  <v-dialog
    :model-value="modelValue"
    max-width="500"
    @update:model-value="emit('update:modelValue', $event)"
  >
    <v-card color="#09090b" class="border rounded-xl pt-2 pb-2 ps-1 pe-1">
      <v-card-title class="text-h6 ma-auto">
        Chatbot Assistant
      </v-card-title>

      <v-card-text>
        This project started as a way to practice building conversational flows using a node-based system.
        It’s not trying to solve world peace — just exploring ideas, learning by doing, and having some fun with it.
        <br><br>
        The project is meant to explore and practice concepts like conversational UX, state management, and visual flow design — without overcomplicating things.
        <br><br>
        <strong>Source code</strong>
        <br>
        <a href="https://github.com/nahue02/chat-bot" target="_blank">View the project on GitHub</a>
        <br><br>
        (Some design choices may exist purely because they seemed like a good idea at the time.)
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <v-btn text @click="emit('update:modelValue', false)">
          Continue
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
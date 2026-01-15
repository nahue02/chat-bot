<template>
  <div
    class="d-flex"
    :class="props.from === 'bot' ? 'justify-start' : 'justify-end'"
  >
    <v-avatar
      v-if="props.from === 'bot'"
      class="mr-3"
      size="30"
      :image="botAvatar"
    />

    <v-sheet
      v-if="props.from === 'bot'"
      class="ps-4 pe-4 pa-3 rounded-xl"
      color="#121212"
      max-width="80%"
    >
      <div class="ma-0 text-body-2" v-html="format(message)"></div>
    </v-sheet>
    <v-sheet
      v-else
      class="ps-4 pe-4 pa-3 mt-8 mb-8 rounded-xl"
      color=primary
      max-width="80%"
    >
      <div class="ma-0 text-body-2" v-html="format(message)"></div>
    </v-sheet>
  </div>
</template>

<script setup>
  import { computed } from 'vue';
  import botAvatar from '@/assets/bot-avatar-3.jpg';
  import { formatText } from '@/scripts/formatText'

  const format = formatText()

  const props = defineProps({
      from: {
          type: String,
          required: false,
          default: 'bot'
      },
      message: {
          type: String,
          required: true,
          default:"..."
      }
  });
</script>
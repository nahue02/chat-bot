<template>
  <div
    class="d-flex"
    :class="props.from === 'bot' ? 'justify-start' : 'justify-end'"
  >
    <v-avatar
      v-if="props.from === 'bot'"
      class="mr-3"
      size="36"
      :image="avatar"
    />

    <v-sheet
      v-if="props.from === 'bot'"
      class="ps-4 pe-4 pa-3"
      :class="bubbleClass"
      color="#121212"
      max-width="90%"
    >
      <div class="ma-0" v-html="formatMessage(message)"></div>
    </v-sheet>
    <v-sheet
      v-else
      class="ps-4 pe-4 pa-3 mt-8 mb-8"
      :class="bubbleClass"
      color=primary
      max-width="90%"
    >
      <div class="ma-0" v-html="formatMessage(message)"></div>
    </v-sheet>
  </div>
</template>

<script setup>
    import { computed } from 'vue';
    import botAvatar from '@/assets/bot-avatar-3.jpg';
    import userAvatar from '@/assets/bot-avatar.png'

    const props = defineProps({
        from: {
            type: String,
            required: false,
            default: 'bot'
        },
        message: {
            type: String,
            required: true
        }
    });

  const bubbleClass = computed(() => {
    return props.from === 'bot'
      ? 'rounded-s-lg rounded-e-xl'
      : 'rounded-e-lg rounded-s-xl';
  });

    const avatar = computed(() => {
        if (props.from === 'bot') {
            return botAvatar;
        } else {
            return userAvatar;
        }
    });

    const formatMessage = (message) => {
      if (!message) return '';

      let formatted = message.replace(/\n/g, '<br>');
      formatted = formatted.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

      return formatted;
    }
</script>
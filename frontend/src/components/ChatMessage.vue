<template>
  <div class="d-flex mb-4 align-start">
    <v-avatar
      class="mr-3"
      size="36"
      :image="avatar"
    />

    <div class="flex-grow-1">
      <span class="font-weight-semibold">
        {{ username }}
      </span>

      <v-sheet
        class="pa-4 mt-1 rounded-be-lg rounded-te-lg rounded-bs-lg"
        :color="messageColor"
        max-width="80%"
      >
        <p class="ma-0">
          {{ message }}
        </p>
      </v-sheet>
    </div>
  </div>
</template>

<script setup>
    import { computed } from 'vue';
    import botAvatar from '@/assets/bot-avatar.png';

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

    const avatar = computed(() => {
        if (props.from === 'bot') {
            return botAvatar;
        } else {
            return "https://randomuser.me/api/portraits/women/85.jpg";
        }
    });

    const username = computed(() => {
        if (props.from === 'bot') {
            return "ChatBot";
        } else {
            return "Username";
        }
    });

    const messageColor = computed(() => {
        if (props.from === 'bot') {
            return "primary";
        } else {
            return "secondary";
        }
    });


</script>
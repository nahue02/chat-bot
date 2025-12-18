<template>
    <div class="mb-4">
      <div class="mb-2">
        <v-avatar class="mr-2" :image=avatar></v-avatar>
        <span class="font-weight-medium">{{username}}</span>
      </div>
      <v-sheet
          class="pa-4 rounded-be-lg rounded-te-lg rounded-bs-lg"
          :color=messageColor
          width="100%"
        >
        <p>
          {{ message }}
        </p>
      </v-sheet>
    </div>
</template>

<script setup>
    import { computed } from 'vue';

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
            return "https://randomuser.me/api/portraits/women/85.jpg";
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
            return "secondary";
        } else {
            return "primary";
        }
    });


</script>
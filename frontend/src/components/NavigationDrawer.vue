<template>
    <v-navigation-drawer
        permanent
        :width="300"
      >
        <v-list>
          <v-list-item
            :prepend-avatar=botAvatar
          >
            <v-list-item-title class="font-weight-semibold">
              Chatbot
            </v-list-item-title>
          </v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list density="compact" nav>
          <v-list-item prepend-icon="mdi-message-outline" to="/">
            <v-list-item-title class="font-weight-semibold text-grey-darken-3">
              Chatbot
            </v-list-item-title>
          </v-list-item>
          <v-list-item prepend-icon="mdi-sitemap-outline" to="/admin">
            <v-list-item-title class="font-weight-semibold text-grey-darken-3">
              Admin Panel
            </v-list-item-title>
          </v-list-item>
          <v-list-item prepend-icon="mdi-plus-box-outline" to="/create">
            <v-list-item-title class="font-weight-semibold text-grey-darken-3">
              Create Message
            </v-list-item-title>
          </v-list-item>
        </v-list>
      </v-navigation-drawer>
</template>

<script setup>
  import botAvatar from '@/assets/bot-avatar.png';

</script>
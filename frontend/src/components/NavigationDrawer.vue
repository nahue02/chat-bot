<template>
    <v-navigation-drawer
        permanent
      >
        <v-list>
          <v-list-item
            prepend-avatar="https://randomuser.me/api/portraits/women/85.jpg"
            subtitle="sandra_a88@gmailcom"
            title="Sandra Adams"
          ></v-list-item>
        </v-list>

        <v-divider></v-divider>

        <v-list density="compact" nav>
          <v-list-item prepend-icon="mdi-folder" to="/"  title="ChatBot"></v-list-item>
          <v-list-item prepend-icon="mdi-account-multiple" to="/admin" title="Admin Panel"></v-list-item>
          <v-list-item prepend-icon="mdi-star" to="/create" title="Create Message"></v-list-item>
        </v-list>
      </v-navigation-drawer>
</template>
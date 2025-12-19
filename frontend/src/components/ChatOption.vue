<template>
    <v-btn variant="border" class="pa-2 text-subtitle-1 bg-grey-lighten-5 border-sm" :text="text"/>
</template>

<script setup>
    defineProps({
        text: {
            type: String,
            required: true
        }
    });
</script>
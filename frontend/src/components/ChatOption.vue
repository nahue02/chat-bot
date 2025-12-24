<template>
    <v-btn variant="border" class="pa-2 text-subtitle-1 border-sm" :text="text"/>
</template>

<script setup>
    defineProps({
        text: {
            type: String,
            required: true
        }
    });
</script>
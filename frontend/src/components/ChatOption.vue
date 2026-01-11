<template>
    <v-btn variant="plain" class="pa-2 text-subtitle-1 option-button border rounded-lg" :text="text"/>
</template>

<script setup>
    defineProps({
        text: {
            type: String,
            required: true
        }
    });
</script>

<style>
    .option-button:hover {
        background-color: #FF1744;
        color:white;
    }
</style>
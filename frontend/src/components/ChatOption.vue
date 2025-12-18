<template>
    <v-btn variant="outlined" density="comfortable" class="text-subtitle-1" :text="text"/>
</template>

<script setup>
    defineProps({
        text: {
            type: String,
            required: true
        }
    });
</script>
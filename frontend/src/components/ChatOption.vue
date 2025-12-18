<template>
    <div>
        <v-btn class="mr-2 d-flex" variant="outlined" density="comfortable">
            {{ text }}
        </v-btn>
    </div>
</template>

<script setup>
    defineProps({
        text: {
            type: String,
            required: true
        }
    });
</script>
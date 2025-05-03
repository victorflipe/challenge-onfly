<script setup lang="ts">

interface Props {
    type?: 'success' | 'error' | 'warning'
    duration?: number
}


const props = withDefaults(defineProps<Props>) < {
    text: string,
    type:"success",
    duration:  2000
} >
</script>

<template>
    <VAlert v-if="visible" :type="type" :text="text" closable @click:close="visible = false" density="compact"
        class="mx-2 mt-2 position-absolute" />
</template>

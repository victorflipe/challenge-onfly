<script setup lang="ts">
import { useAuthStore } from '@/store/auth';

onMounted(()=>{
  const authStore = useAuthStore()
  authStore.loadToken()
})

</script>

<template>
  <VApp>
    <RouterView />
    <!-- <UpgradeToPro /> -->
  </VApp>
</template>

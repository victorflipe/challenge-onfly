<script setup lang="ts">
import FormTravelRequest from '@/components/FormTravelRequest.vue'
import { useAuthStore } from '@/store/auth';

</script>

<template>
  <VRow class="match-height">
    <VCol cols="12">
      <p class="text-2xl mb-6">
        New Travel Request
      </p>
      <VDivider />
    </VCol>
  </VRow>
  <VRow>
    <VCol class="12">
      <FormTravelRequest/>
    </VCol>
  </VRow>

</template>

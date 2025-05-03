<script setup lang="ts">
import AnalyticsAward from '@/views/dashboard/AnalyticsAward.vue'
import AnalyticsBarCharts from '@/views/dashboard/AnalyticsBarCharts.vue'
import AnalyticsDepositWithdraw from '@/views/dashboard/AnalyticsDepositWithdraw.vue'
import AnalyticsSalesByCountries from '@/views/dashboard/AnalyticsSalesByCountries.vue'
import AnalyticsTotalEarning from '@/views/dashboard/AnalyticsTotalEarning.vue'
import AnalyticsTotalProfitLineCharts from '@/views/dashboard/AnalyticsTotalProfitLineCharts.vue'
import AnalyticsTransactions from '@/views/dashboard/AnalyticsTransactions.vue'
import AnalyticsUserTable from '@/views/dashboard/AnalyticsUserTable.vue'
import AnalyticsWeeklyOverview from '@/views/dashboard/AnalyticsWeeklyOverview.vue'
import CardStatisticsVertical from '@core/components/cards/CardStatisticsVertical.vue'

</script>



<template>
  <VRow class="match-height">
    <VCol class="12">
      <p class="text-2xl mb-6">
        My Travel Requests
      </p>
      <VBtn color="primary" @click="refInputEl?.click()">
        <VIcon icon="ri-upload-cloud-line" class="d-sm-none" />
        <span class="d-none d-sm-block">New Travel Request</span>
      </VBtn>
    </VCol>
  </VRow>
  <VRow class="match-height">
    <VCol cols="12">
      <AnalyticsUserTable />
    </VCol>
  </VRow>
</template>

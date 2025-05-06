<script lang="ts" setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue'
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue'
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue'
</script>

<template>
  <VerticalNavLink
    :item="{
      title: 'List All Requests',
      icon: 'ri-calendar-event-line',
      to: '/dashboard',
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'New Request',
      icon: 'ri-add-circle-line',
      to: '/new-travel-request',
    }"
  />

</template>

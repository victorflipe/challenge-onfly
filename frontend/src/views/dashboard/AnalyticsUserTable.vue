<script setup lang="ts">
import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar5 from '@images/avatars/avatar-5.png'
import avatar6 from '@images/avatars/avatar-6.png'
import avatar7 from '@images/avatars/avatar-7.png'
import avatar8 from '@images/avatars/avatar-8.png'

const headers = [
  { title: 'Requester Name', key: 'requester' },
  { title: 'Destination', key: 'destination' },
  { title: 'Departure Date', key: 'departure' },
  { title: 'Return Date', key: 'return' },
  { title: 'Status', key: 'status' },
]

const userData = [
  {
    id: 1,
    requester: 'Galasasen Slixby',
    destination: 'El Salvador',
    departure: "2025-05-11",
    return: "2025-05-19",
    status: 'requested',
    avatar: avatar1,
  },
  {
    id: 2,
    requester: 'Galasasen Slixby',
    destination: 'El Salvador',
    departure: "2025-05-11",
    return: "2025-05-19",
    status: 'approved',
    avatar: avatar2,
  },
  {
    id: 2,
    requester: 'Marjory Sicely',
    destination: 'El Salvador',
    departure: "2025-05-11",
    return: "2025-05-19",
    status: 'canceled',
    avatar: avatar2,
  },
  
]

const resolveUserRoleVariant = (role: string) => {
  const roleLowerCase = role.toLowerCase()

  if (roleLowerCase === 'subscriber')
    return { color: 'success', icon: 'ri-user-line' }
  if (roleLowerCase === 'author')
    return { color: 'error', icon: 'ri-computer-line' }
  if (roleLowerCase === 'maintainer')
    return { color: 'info', icon: 'ri-pie-chart-line' }
  if (roleLowerCase === 'editor')
    return { color: 'warning', icon: 'ri-edit-box-line' }
  if (roleLowerCase === 'admin')
    return { color: 'primary', icon: 'ri-vip-crown-line' }

  return { color: 'success', icon: 'ri-user-line' }
}

const resolveUserStatusVariant = (stat: string) => {
  const statLowerCase = stat.toLowerCase()
  if (statLowerCase === 'requested')
    return 'warning'
  if (statLowerCase === 'approved')
    return 'success'
  if (statLowerCase === 'canceled')
    return 'secondary'

  return 'primary'
}
</script>

<template>
  <VCard>
    <VDataTable
      :headers="headers"
      :items="userData"
      item-value="id"
      :sticky="true"
      class="text-no-wrap"
    >
      <!-- User -->
      <template #item.username="{ item }">
        <div class="d-flex align-center gap-x-4">
          <VAvatar
            size="34"
            :variant="!item.avatar ? 'tonal' : undefined"
            :color="!item.avatar ? resolveUserRoleVariant(item.role).color : undefined"
          >
            <VImg
              v-if="item.avatar"
              :src="item.avatar"
            />
          </VAvatar>

          <div class="d-flex flex-column">
            <h6 class="text-h6 font-weight-medium user-list-name">
              {{ item.requester }}
            </h6>

            <span class="text-sm text-medium-emphasis">@{{ item.requester }}</span>
          </div>
        </div>
      </template>
      <!-- Role -->
      <!-- <template #item.role="{ item }">
        <div class="d-flex gap-4">
          <VIcon
            :icon="resolveUserRoleVariant(item.role).icon"
            :color="resolveUserRoleVariant(item.role).color"
            size="22"
          />
          <div class="text-capitalize text-high-emphasis">
            {{ item.role }}
          </div>
        </div>
      </template> -->
      <!-- Plan -->
      <!-- <template #item.plan="{ item }">
        <span class="text-capitalize text-high-emphasis">{{ item.currentPlan }}</span>
      </template> -->
      <!-- Status -->
      <template #item.status="{ item }">
        <VChip
          :color="resolveUserStatusVariant(item.status)"
          size="small"
          class="text-capitalize"
        >
          {{ item.status }}
        </VChip>
      </template>

      <template #bottom />
    </VDataTable>
  </VCard>
</template>

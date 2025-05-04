<script setup lang="ts">
import axiosInstance from '@/plugins/axios'
import { getRequests, updateStatus } from '@/services/travelRequestsService'
import { formatDate } from '@/utils/dateFormatter'
import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar5 from '@images/avatars/avatar-5.png'
import avatar6 from '@images/avatars/avatar-6.png'
import avatar7 from '@images/avatars/avatar-7.png'
import avatar8 from '@images/avatars/avatar-8.png'

const headers = [
  { title: 'Requester Name', key: 'requester_name' },
  { title: 'Destination', key: 'destination' },
  { title: 'Departure Date', key: 'departure_date' },
  { title: 'Return Date', key: 'return_date' },
  { title: 'Status', key: 'status' },
  { title: 'See Details', key: 'details' }
]

const props = defineProps<{ items: any[] }>()

const selectedItem = ref<any | null>(null)
const dialog = ref(false)
const dialogCancel = ref(false)
const dialogApprove = ref(false)
const isLoading = ref(true)
const errorMessage = ref('')
const showError = ref(false)
const color = ref('')
const timeout = ref(2000)

const emit = defineEmits<{
    (e: "updateData", value: boolean): void
}>()

function handleFetchData() {
    emit('updateData', true)
}


function handleChildError(message: string) {
  // console.log('message: ', message)
  errorMessage.value = message
  showError.value = message != ""
  
  color.value = "error"

  setTimeout(() => {
    showError.value = false
    dialog.value = false
    handleFetchData()
    
  }, 2000)
}


const onUpdateStatus = async (status: string) => {
  console.log('Vai cancelar', selectedItem.value.id)
  console.log(status === "canceled")
  try {
    if (!selectedItem.value) return
    await updateStatus(selectedItem.value.id, status)

    status === "canceled" ? dialogCancel.value = false : dialogApprove.value = false

  } catch (error: any) {
    console.log('erro: ', error.response?.data?.message)
    errorMessage.value = error.response?.data?.message
    showError.value = true
  }
}

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

const openDialog = (item: any) => {
  selectedItem.value = item
  dialog.value = true
}

</script>

<template>

  <VSnackbar v-model="showError" location="top" :color="color" variant="elevated" :timeout="timeout">
    {{ errorMessage }}

    <template v-slot:actions>
      <v-btn color="blue" variant="text" @click="showError = false">
        Close
      </v-btn>
    </template>
  </VSnackbar>

  <VDialog v-model="dialog" persistent max-width="50%">
    <VCard>
      <VCardTitle class="d-flex align-center">
        <span> Travel Request Details</span>
        <VBtn text="Close" variant="text" class="ms-auto" @click="dialog = false" />
      </VCardTitle>

      <FormTravelRequest v-if="selectedItem" :item="selectedItem" @errorMessage="handleChildError" />

    </VCard>
  </VDialog>

  <VCard>
    <VDataTable :headers="headers" :items="props.items" item-value="id" :sticky="true" class="text-no-wrap">

      <template #item.departure_date="{ item }">
        {{ formatDate(item.departure_date) }}
      </template>


      <template #item.return_date="{ item }">
        {{ formatDate(item.return_date) }}
      </template>

      <template #item.status="{ item }">
        <VChip :color="resolveUserStatusVariant(item.status)" size="small" class="text-capitalize">
          {{ item.status }}
        </VChip>
      </template>

      <template #item.details="{ item }">
        <VBtn color="primary" @click="openDialog(item)">
          Edit
        </VBtn>

      </template>

      <template #bottom />
    </VDataTable>
  </VCard>
</template>

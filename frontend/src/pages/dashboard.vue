<script setup lang="ts">
import ListTravelRequests from '@/views/dashboard/ListTravelRequestsTable.vue'
import { getRequests } from '@/services/travelRequestsService'

const statusOptions = ["all", "requested", "canceled", "approved"]
const requests = ref([])
const errorMessage = ref('')
const showError = ref(false)
const isLoading = ref(true)
const selectedStatus = ref<string | null>("all")
// const updateData

// Páginação
const currentPage = ref(1)
const totalPages = ref(0)

onMounted(async () => {
  try {
    await fetchData(currentPage.value)
  } catch (error: any) {
    errorMessage.value = error.response?.data?.message || 'Erro ao buscar requisição'
    showError.value = true
  } finally {
    isLoading.value = false
  }
})

const filteredRequests = computed(() => {
  if (!selectedStatus.value || selectedStatus.value === "all") return requests.value
  return requests.value.filter(item => item.status === selectedStatus.value)
})

const fetchData = async (page: number) => {
  isLoading.value = true
  const response = await getRequests(page)  // Passa a página como parâmetro
  requests.value = response.data.data  // Dados da página
  totalPages.value = response.data.last_page  // Total de páginas
  currentPage.value = response.data.current_page  // Página atual
}

const goToPage = (page: number) => {
  console.log('Current page: ', page)
  if (page > 0 && page <= totalPages.value) {
    fetchData(page)
  }
}

</script>

<template>
  <VRow class="match-height">

    <VCol class="12">
      <p class="text-2xl mb-6">
        My Travel Requests
      </p>
      <VDivider />
    </VCol>

    <VCol cols="12" class="">
      <VRow>
        <VCol cols="6">
          <VBtn color="primary" to="new-travel-request">
            <!-- <VIcon icon="ri-upload-cloud-line" class="" /> -->
            <span class="">New Travel Request</span>
          </VBtn>
        </VCol>
        <VCol cols="6" class="d-flex justify-end">
          <VSelect label="Filter by Status" v-model="selectedStatus" :items="statusOptions" variant="outlined"
            style="width:150px" />
        </VCol>
      </VRow>
    </VCol>
  </VRow>

  <VRow class="match-height">
    <VCol cols="12">
      <ListTravelRequests :items="filteredRequests" @updateData="fetchData"/>
    </VCol>
  </VRow>

  <VRow class="d-flex justify-center mt-4">
    <VBtn @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" v-if="totalPages > 1">Previous
    </VBtn>
    <span>{{ currentPage }} / {{ totalPages }}</span>
    <VBtn @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" v-if="totalPages > 1">
      Next
    </VBtn>
  </VRow>
</template>

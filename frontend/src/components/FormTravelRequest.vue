<script lang="ts" setup>
import avatar1 from '@images/avatars/avatar-1.png'
import { ref } from 'vue'
// import { VForm } from 'vuetify/components'
import { VDateInput } from 'vuetify/labs/VDateInput'


const travel_request = {
    // avatarImg: avatar1,
    requester_name: '',
    destination: '',
    departure_date: new Date(),
    return_date: new Date()
}

const form = ref({
  requester_name: '',
  destination: '',
  departure_date: new Date(),
  return_date: new Date(),
  remember: false,
})


const formRef = ref<VForm | null>(null)
const showError = ref(false)
const errorMessage = ref('')

const returnDateRules = [
  (v: Date | null) => !!v || 'Data de retorno é obrigatória',
  (v: Date | null) =>
    !v || v < accountDataLocal.value.departure_date ||
    'Data de retorno deve ser posterior à data de partida'
]

const destinationRules = [
    (v: string) => !!v || 'Destination deve ser preenchido'
]


const departureDate = ref<Date | null>(null)
const minDate = ref(new Date()) // isso deve ser um objeto Date

const accountDataLocal = ref(structuredClone(travel_request))

const resetForm = () => {
    accountDataLocal.value = structuredClone(travel_request)
}

const onSubmit = async () => {
    console.log(accountDataLocal)
    console.log(travel_request)

    showError.value = false
    errorMessage.value = ''

  const { valid } = await formRef.value!.validate()

  if (!valid) {
    errorMessage.value = 'Corrija os erros do formulário'
    showError.value = true
    return
  }

  try {

    const payload = {
        user_id: '1',
        destination: form.value.destination,
        departure_date: form.value.departure_date,
        return_date: form.value.return_date
    }

    console.log(payload)

  }catch(error: any) {
    console.log(error)
  }
}

</script>

<template>
    <VRow class="match-height">
        <VCol cols="12">
            <VCard>

                <VCardText>
                    <!-- 👉 Form -->
                    <VForm ref="formRef" @submit.prevent="onSubmit" class="mt-6">
                        <VRow>
                            <!-- 👉 First Name -->
                            <VCol cols="12">
                                <VTextField v-model="accountDataLocal.requester_name" disabled placeholder="John"
                                    label="Requester Name" />
                            </VCol>

                            <!-- 👉 Address -->
                            <VCol cols="12">
                                <VTextField v-model="accountDataLocal.destination" label="Destination"
                                    placeholder="123 Main St, New York, NY 10001" />
                            </VCol>

                            <VCol cols="6">
                                <VDateInput v-model="accountDataLocal.departure_date" label="Departure Date" 
                                    :min="minDate" locale="pt-BR" />
                            </VCol>

                            <VCol cols="6">
                                <VDateInput v-model="accountDataLocal.return_date" label="Return Date" :min="minDate" :rules="returnDateRules"
                                    locale="pt-BR" />
                                <!-- prepend-icon="mdi-calendar" -->
                            </VCol>

                            <VCol cols="12" class="d-flex flex-wrap gap-4">
                                <VBtn type="submit">Submit</VBtn>

                                <VBtn color="secondary" variant="outlined" type="reset" @click.prevent="resetForm">
                                    Reset
                                </VBtn>
                            </VCol>
                        </VRow>
                    </VForm>
                </VCardText>
            </VCard>
        </VCol>

    </VRow>
</template>

<script lang="ts" setup>
import { registerRequest, updateStatus } from '@/services/travelRequestsService'
import { useAuthStore } from '@/store/auth'
import { formatDate, onlyDate } from '@/utils/dateFormatter'
import avatar1 from '@images/avatars/avatar-1.png'
import { ref } from 'vue'
import { VForm } from 'vuetify/components'
// import { VForm } from 'vuetify/components'
import { VDateInput } from 'vuetify/labs/VDateInput'

interface TravelRequest {
    id: number,
    requester_name: string,
    destination: string,
    departure_date: string,
    return_date: string,
    status: string
}

const itemsStatus = ["requested", "approved", "canceled"]
const props = defineProps<{
    item?: TravelRequest
}>()

const authUser = useAuthStore()

const form = ref({
    requester_name: authUser.user?.name,
    destination: '',
    departure_date: new Date(),
    return_date: new Date(),
    status: 'requested'
})

const formRef = ref<VForm | null>(null)
const showError = ref(false)
const errorMessage = ref('')
const router = useRouter()
const color = ref('success')
const timeout = ref(2000)

const returnDateRules = [
    (v: Date | null) => !!v || 'Data de retorno é obrigatória',
    (v: Date | null) => {
        const returnDate = onlyDate(new Date(v))
        const departureDate = onlyDate(form.value.departure_date)
        return !v || returnDate >= departureDate ||
            'Data de retorno deve ser igual ou posterior à data de partida'

    }
]

const destinationRules = [
    (v: string) => !!v || 'Destination is required'
]

const minDate = ref(new Date())

const emit = defineEmits<{
    (e: "errorMessage", value: string): void
}>()

function handleError(message: string) {
    emit('errorMessage', message)
}


const resetForm = () => {
    if (props.item) {
        form.value.requester_name = props.item.requester_name,
            form.value.destination = props.item.destination,
            form.value.departure_date = new Date(props.item.departure_date),
            form.value.return_date = new Date(props.item.return_date)
        form.value.status = props.item.status
    } else {
        form.value.requester_name = authUser.user?.name || ''
        form.value.destination = ''
        form.value.departure_date = new Date()
        form.value.return_date = new Date()
        form.value.status = "requested"
    }
}

function showSuccess(message: string) {
    color.value = "success"
    showError.value = true
    errorMessage.value = message
    handleError(errorMessage.value || 'Fix forms errors')
}

function showErrorMessage(message: string) {
    color.value = "error"
    showError.value = true
    errorMessage.value = message
}


const onSubmit = async () => {

    errorMessage.value = ''

    const { valid } = await formRef.value!.validate()

    if (!valid) {
        color.value = "error"
        showError.value = true
        errorMessage.value = "Fix form errors"
        return
    }

    try {
        const payload = {
            requester_name: form.value.requester_name,
            destination: form.value.destination,
            departure_date: form.value.departure_date,
            return_date: form.value.return_date,
            status: form.value.status
        }

        const currentItem = props.item
        const isUpdating = currentItem && ["approved", "canceled"].includes(payload.status)

        if (isUpdating) {
            await updateStatus(currentItem.id, payload.status)
            showSuccess("Register updated successfully")
        } else {
            await registerRequest(payload)
            showSuccess("Register saved successfully")
        }
        // console.log('Timeout: ', timeout.value)

        setTimeout(() => {
            showError.value = false
            // console.log(showError.value)
            router.push({ name: 'dashboard' })
        }, timeout.value)

        // console.log(showError.value)

    } catch (error: any) {
        if (props.item) {
            handleError(error.response?.data?.message || 'Fix forms errors')
        } else {
            showErrorMessage("Fix form errors")
        }
    }
}

onMounted(() => {
    if (props.item) {
        // console.log('Props: ', props.item)
        form.value.requester_name = props.item.requester_name
        form.value.destination = props.item.destination
        form.value.departure_date = new Date(formatDate(props.item.departure_date))
        form.value.return_date = new Date(formatDate(props.item.return_date))
        form.value.status = props.item.status
        // console.log('form: ', form.value)
    }
})

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

    <VRow class="match-height">
        <VCol cols="12">
            <VCard>

                <VCardText>
                    <!-- 👉 Form -->
                    <VForm ref="formRef" @submit.prevent="onSubmit" class="mt-6" validate-on="submit">
                        <VRow>
                            <!-- 👉 First Name -->
                            <VCol cols="12">
                                <VTextField v-model="form.requester_name" disabled placeholder="John"
                                    label="Requester Name" />
                            </VCol>

                            <!-- 👉 Address -->
                            <VCol cols="6">
                                <VTextField v-model="form.destination" label="Destination"
                                    placeholder="123 Main St, New York, NY 10001" :rules="destinationRules" />
                            </VCol>

                            <VCol cols="6">
                                <VCombobox label="Status" :items="itemsStatus" v-model="form.status" variant="outlined"
                                    :disabled="!props.item" />
                            </VCol>

                            <VCol cols="6">
                                <VDateInput v-model="form.departure_date" label="Departure Date" :min="minDate"
                                    variant="outlined" locale="en-US" />
                            </VCol>

                            <VCol cols="6">
                                <VDateInput v-model="form.return_date" label="Return Date" :min="minDate"
                                    :rules="returnDateRules" variant="outlined" locale="en-US" />
                                <!-- prepend-icon="mdi-calendar" -->
                            </VCol>

                            <VCol cols="12" class="d-flex flex-wrap gap-4">
                                <VBtn type="submit">
                                    Submit
                                </VBtn>

                                <!-- <VBtn color="secondary" variant="outlined" v-if="props.item">
                                    Cancelar
                                </VBtn> -->

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

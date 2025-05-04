<script setup lang="ts">
import { useTheme } from 'vuetify'
import AuthProvider from '@/views/pages/authentication/AuthProvider.vue'

import logo from '@images/logo.svg?raw'
import authV1MaskDark from '@images/pages/auth-v1-mask-dark.png'
import authV1MaskLight from '@images/pages/auth-v1-mask-light.png'
import authV1Tree2 from '@images/pages/auth-v1-tree-2.png'
import authV1Tree from '@images/pages/auth-v1-tree.png'
import { registerUser } from '@/services/userService'
import { useAuthStore } from '@/store/auth'

const form = ref({
  username: '',
  email: '',
  password: '',
  confirmPassword: ''
})

const formRef = ref<VForm | null>(null)

const authStore = useAuthStore()
const router = useRouter()
const showError = ref(false)
const errorMessage = ref('')

// const showTimedAlert = (message: string, duration = 3000) => {
//   errorMessage.value = message
//   showError.value = true

//   setTimeout(() => {
//     showError.value = false
//   }, duration)
// }

const vuetifyTheme = useTheme()

const authThemeMask = computed(() => {
  return vuetifyTheme.global.name.value === 'light'
    ? authV1MaskLight
    : authV1MaskDark
})

const isPasswordVisible = ref(false)

const userNameRules = [
  (v: string) => !!v || 'Username is required'
]

const emailRules = [
  (v: string) => !!v || 'Email is required',
  (v: string) => /.+@.+\..+/.test(v) || 'Email must be valid',
]

const passwordRules = [
  (v: string) => !!v || 'Password is required',
  (v: string) => v.length >= 6 || 'Password must be at least 6 characters',
]

const confirmPasswordRules = [
  (v: string) => !!v || 'Confirmation is required',
  (v: string) => v === form.value.password || 'Passwords must match',
]

const onSubmit = async () => {
  showError.value = false
  errorMessage.value = ''

  const { valid } = await formRef.value!.validate()

  if (!valid) {
    errorMessage.value = 'Corrija os erros do formulário'
    showError.value = true
    return
  }

  if (form.value.password !== form.value.confirmPassword) {
    errorMessage.value = 'As senhas não conferem.'
    showError.value = true
    return
  }

  try{

    const payload = {
      name: form.value.username,
      email: form.value.email,
      password: form.value.password,
      password_confirmation: form.value.confirmPassword
    }

    await authStore.register(payload)

    router.push({name:'dashboard'})

  }catch(error: any){
    errorMessage.value = error.response?.data?.message || 'Erro ao cadastrar usuário'
    showError.value = true
  }

}

</script>

<template>
  <!-- eslint-disable vue/no-v-html -->

  <VAlert v-if="showError" density="compact" class="mx-2 mt-2 position-absolute" block max-width="400" title="Campos inválidos" color="warning" type="warning" border="start"
    :text="errorMessage" closable></VAlert>

  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard class="auth-card pa-4 pt-7" max-width="448">

      <VCardItem class="justify-center">
        <RouterLink to="/" class="d-flex align-center gap-3">
          <!-- eslint-disable vue/no-v-html -->
          <div class="d-flex" v-html="logo" />
          <h2 class="font-weight-medium text-2xl text-uppercase">
            Materio
          </h2>
        </RouterLink>
      </VCardItem>

      <VCardText class="pt-2">
        <h4 class="text-h4 mb-1">
          Adventure starts here 🚀
        </h4>
        <p class="mb-0">
          Make your app management easy and fun!
        </p>
      </VCardText>

      <VCardText>
        <VForm ref="formRef" @submit.prevent="onSubmit">
          <VRow>
            <!-- Username -->
            <VCol cols="12">
              <VTextField variant="outlined" v-model="form.username" label="Username" placeholder="Johndoe"
                :rules="userNameRules" required />
            </VCol>
            <!-- email -->
            <VCol cols="12">
              <VTextField variant="outlined" v-model="form.email" label="Email" placeholder="johndoe@email.com"
                type="email" :rules="emailRules" required />
            </VCol>

            <!-- password -->
            <VCol cols="12">
              <VTextField variant="outlined" v-model="form.password" label="Password" placeholder="·········"
                :type="isPasswordVisible ? 'text' : 'password'" autocomplete="password"
                :append-inner-icon="isPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible" :rules="passwordRules" required />
            </VCol>

            <!-- confirm password -->
            <VCol cols="12">
              <VTextField variant="outlined" v-model="form.confirmPassword" label="Confirm Password"
                placeholder="············" :type="isPasswordVisible ? 'text' : 'password'" autocomplete="password"
                :append-inner-icon="isPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible" required :rules="confirmPasswordRules" />
            </VCol>

            <VCol cols="12">
              <VBtn block type="submit">
                Sign up
              </VBtn>
            </VCol>

            <!-- login instead -->
            <VCol cols="12" class="text-center text-base">
              <span>Already have an account?</span>
              <RouterLink class="text-primary ms-2" to="login">
                Sign in instead
              </RouterLink>
            </VCol>

          </VRow>
        </VForm>
      </VCardText>
    </VCard>

    <VImg class="auth-footer-start-tree d-none d-md-block" :src="authV1Tree" :width="250" />

    <VImg :src="authV1Tree2" class="auth-footer-end-tree d-none d-md-block" :width="350" />

    <!-- bg img -->
    <VImg class="auth-footer-mask d-none d-md-block" :src="authThemeMask" />

  </div>
</template>

<style lang="scss">
@use "@core/scss/template/pages/page-auth";
</style>

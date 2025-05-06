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
  (v: string) => v === form.value.password || 'Password must match',
]

const onSubmit = async () => {
  showError.value = false
  errorMessage.value = ''

  const { valid } = await formRef.value!.validate()

  if (!valid) {
    errorMessage.value = 'Verify form errors'
    showError.value = true
    return
  }

  // if (form.value.password !== form.value.confirmPassword) {
  //   errorMessage.value = 'As senhas não conferem.'
  //   showError.value = true
  //   return
  // }

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
    errorMessage.value = 'Error registering user'
    showError.value = true
  }

}

</script>

<template>
  <!-- eslint-disable vue/no-v-html -->

  <VSnackbar v-model="showError" location="top" :color="color" variant="elevated" :timeout="timeout">
        {{ errorMessage }}
        <template v-slot:actions>
            <v-btn color="blue" variant="text" @click="showError = false">
                Close
            </v-btn>
        </template>
    </VSnackbar>

  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard class="auth-card pa-4 pt-7" max-width="448">

      <VCardItem class="justify-center">
        <RouterLink to="/" class="d-flex align-center gap-3">
          <!-- eslint-disable vue/no-v-html -->
          <div class="d-flex" v-html="logo" />
        </RouterLink>
      </VCardItem>

      <VCardText class="pt-2 text-center">
        <h4 class="text-h4 mb-1">
          Register Now 🚀
        </h4>
        <p class="mb-0">
          Register and schedule your travel
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

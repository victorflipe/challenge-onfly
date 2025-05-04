<script setup lang="ts">
import { useTheme } from 'vuetify'
import { useRouter } from 'vue-router'
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '@/store/auth'
import AuthProvider from '@/views/pages/authentication/AuthProvider.vue'

import logo from '@images/logo.svg?raw'
import authV1MaskDark from '@images/pages/auth-v1-mask-dark.png'
import authV1MaskLight from '@images/pages/auth-v1-mask-light.png'
import authV1Tree2 from '@images/pages/auth-v1-tree-2.png'
import authV1Tree from '@images/pages/auth-v1-tree.png'
import { VForm } from 'vuetify/components'
import axiosInstance from '@/plugins/axios'

const form = ref({
  email: '',
  password: '',
  remember: false,
})

const formRef = ref<VForm | null>(null)
const showError = ref(false)
const errorMessage = ref('')
const isPasswordVisible = ref(false)

const vuetifyTheme = useTheme()
const authStore = useAuthStore()
const router = useRouter()

const authThemeMask = computed(() => {
  return vuetifyTheme.global.name.value === 'light' ? authV1MaskLight : authV1MaskDark
})

const emailRules = [
  (v: string) => !!v || 'Email é obrigatório',
  (v: string) => /.+@.+\..+/.test(v) || 'Email inválido',
]

const passwordRules = [
  (v: string) => !!v || 'Senha é obrigatória',
  (v: string) => v.length >= 6 || 'Senha deve ter pelo menos 6 caracteres',
]

const onSubmit = async () => {

  // await axiosInstance.get('/sanctum/csrf-cookie')

  showError.value = false
  errorMessage.value = ''

  const { valid } = await formRef.value!.validate()
  if (!valid) {
    errorMessage.value = 'Corrija os erros do formulário'
    showError.value = true
    return
  }

  try {
    await authStore.login({
      email: form.value.email,
      password: form.value.password,
    })
    
    router.push({ name: 'dashboard' })
  } catch (error: any) {
    errorMessage.value = error.response?.data?.message || 'Erro ao efetuar login'
    showError.value = true
  }
}

onMounted(() => {
  // authStore.loadToken()
})
</script>

<template>
  <VAlert
    v-if="showError"
    density="compact"
    class="mx-2 mt-2 position-absolute"
    block
    max-width="400"
    title="Campos inválidos"
    color="warning"
    type="warning"
    border="start"
    :text="errorMessage"
    closable
  />

  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard class="auth-card pa-4 pt-7" max-width="448">
      <VCardItem class="justify-center">
        <RouterLink to="/" class="d-flex align-center gap-3">
          <div class="d-flex" v-html="logo" />
        </RouterLink>
      </VCardItem>

      <VCardText class="pt-2">
        <h4 class="text-h4 mb-1">Welcome to TravelReqApp! 👋🏻</h4>
        <p class="mb-0">Please sign-in to your account and schedule your travel...</p>
      </VCardText>

      <VCardText>
        <VForm ref="formRef" @submit.prevent="onSubmit">
          <VRow>
            <VCol cols="12">
              <VTextField
                v-model="form.email"
                placeholder="johndoe@email.com"
                label="Email"
                type="email"
                :rules="emailRules"
              />
            </VCol>

            <VCol cols="12">
              <VTextField
                v-model="form.password"
                label="Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                autocomplete="password"
                :append-inner-icon="isPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
                :rules="passwordRules"
              />

              <div class="d-flex align-center justify-space-between flex-wrap my-6">
                <VCheckbox v-model="form.remember" label="Remember me" />
                <a class="text-primary" href="#">Forgot Password?</a>
              </div>

              <VBtn block type="submit">Login</VBtn>
            </VCol>

            <VCol cols="12" class="text-center text-base">
              <span>New on our platform?</span>
              <RouterLink class="text-primary ms-2" to="/register">Create an account</RouterLink>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>

    <VImg class="auth-footer-start-tree d-none d-md-block" :src="authV1Tree" :width="250" />
    <VImg :src="authV1Tree2" class="auth-footer-end-tree d-none d-md-block" :width="350" />
    <VImg class="auth-footer-mask d-none d-md-block" :src="authThemeMask" />
  </div>
</template>

<style lang="scss">
@use "@core/scss/template/pages/page-auth";
</style>

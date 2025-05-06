<script setup lang="ts">
import avatar1 from '@images/avatars/avatar-1.png'
import { useAuthStore } from '@/store/auth'
import { useRouter } from 'vue-router'


const authStore = useAuthStore()
const router = useRouter()
const user = ref({})

const onLogout = async() => {
  authStore.logout()
  router.push({name: 'login'})
}

watch(() => authStore.user, (newUser) => {
  if (newUser) {
    user.value = {
      name: newUser.name,
      role: newUser.is_admin ? 'Admin' : 'User'
    }
  }
}, { immediate: true })

</script>

<template>
  <VBadge
    dot
    location="bottom right"
    offset-x="3"
    offset-y="3"
    color="success"
    bordered
  >
    <VAvatar
      class="cursor-pointer"
      color="primary"
      variant="tonal"
    >
      <VImg :src="avatar1" />

      <!-- SECTION Menu -->
      <VMenu
        activator="parent"
        width="230"
        location="bottom end"
        offset="14px"
      >
        <VList>
          <!-- 👉 User Avatar & Name -->
          <VListItem>
            <template #prepend>
              <VListItemAction start>
                <VBadge
                  dot
                  location="bottom right"
                  offset-x="3"
                  offset-y="3"
                  color="success"
                >
                  <VAvatar
                    color="primary"
                    variant="tonal"
                  >
                    <VImg :src="avatar1" />
                  </VAvatar>
                </VBadge>
              </VListItemAction>
            </template>

            <VListItemTitle class="font-weight-semibold">
              {{ authStore.user?.name }}
            </VListItemTitle>
            <!-- <VListItemSubtitle v-if="authStore.user?.is_admin">Admin</VListItemSubtitle> -->
            <VListItemSubtitle>{{ user.role }}</VListItemSubtitle>
          </VListItem>
        
          <VDivider class="my-2" />

          <VListItem link>
            <template #prepend>
              <VIcon
                class="me-2"
                icon="ri-logout-box-r-line"
                size="22"
              />
            </template>

            <VListItemTitle @click="onLogout">Logout</VListItemTitle>
          </VListItem>
        </VList>
      </VMenu>
      <!-- !SECTION -->
    </VAvatar>
  </VBadge>
</template>

<script lang="ts" setup>
const isCurrentPasswordVisible = ref(false)
const isNewPasswordVisible = ref(false)
const isConfirmPasswordVisible = ref(false)
const currentPassword = ref('12345678')
const newPassword = ref('87654321')
const confirmPassword = ref('87654321')

const passwordRequirements = [
  'Minimum 6 characters long - the more, the better',
  'At least one lowercase character',
  'At least one number, symbol, or whitespace character',
]

// const serverKeys = [
//   {
//     name: 'Server Key 1',
//     key: '23eaf7f0-f4f7-495e-8b86-fad3261282ac',
//     createdOn: '28 Apr 2021, 18:20 GTM+4:10',
//     permission: 'Full Access',
//   },
//   {
//     name: 'Server Key 2',
//     key: 'bb98e571-a2e2-4de8-90a9-2e231b5e99',
//     createdOn: '12 Feb 2021, 10:30 GTM+2:30',
//     permission: 'Read Only',
//   },
//   {
//     name: 'Server Key 3',
//     key: '2e915e59-3105-47f2-8838-6e46bf83b711',
//     createdOn: '28 Dec 2020, 12:21 GTM+4:10',
//     permission: 'Full Access',
//   },
// ]

// const recentDevicesHeaders = [
//   { title: 'BROWSER', key: 'browser' },
//   { title: 'DEVICE', key: 'device' },
//   { title: 'LOCATION', key: 'location' },
//   { title: 'RECENT ACTIVITY', key: 'recentActivity' },
// ]

// const recentDevices = [
//   {
//     browser: 'Chrome on Windows',
//     device: 'HP Spectre 360',
//     location: 'New York, NY',
//     recentActivity: '28 Apr 2022, 18:20',
//     deviceIcon: { icon: 'ri-macbook-line', color: 'primary' },
//   },
//   {
//     browser: 'Chrome on iPhone',
//     device: 'iPhone 12x',
//     location: 'Los Angeles, CA',
//     recentActivity: '20 Apr 2022, 10:20',
//     deviceIcon: { icon: 'ri-android-line', color: 'error' },
//   },
//   {
//     browser: 'Chrome on Android',
//     device: 'Oneplus 9 Pro',
//     location: 'San Francisco, CA',
//     recentActivity: '16 Apr 2022, 04:20',
//     deviceIcon: { icon: 'ri-smartphone-line', color: 'success' },
//   },
//   {
//     browser: 'Chrome on macOS',
//     device: 'Apple iMac',
//     location: 'New York, NY',
//     recentActivity: '28 Apr 2022, 18:20',
//     deviceIcon: { icon: 'ri-mac-line', color: 'secondary' },
//   },
//   {
//     browser: 'Chrome on Windows',
//     device: 'HP Spectre 360',
//     location: 'Los Angeles, CA',
//     recentActivity: '20 Apr 2022, 10:20',
//     deviceIcon: { icon: 'ri-macbook-line', color: 'primary' },
//   },
//   {
//     browser: 'Chrome on Android',
//     device: 'Oneplus 9 Pro',
//     location: 'San Francisco, CA',
//     recentActivity: '16 Apr 2022, 04:20',
//     deviceIcon: { icon: 'ri-android-line', color: 'success' },
//   },
// ]
</script>

<template>
  <VRow>
    <!-- SECTION: Change Password -->
    <VCol cols="12">
      <VCard title="Change Password">
        <VForm>
          <VCardText>
            <!-- 👉 Current Password -->
            <VRow class="mb-3">
              <VCol
                cols="12"
                md="6"
              >
                <!-- 👉 current password -->
                <VTextField
                  v-model="currentPassword"
                  :type="isCurrentPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isCurrentPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                  autocomplete="on"
                  label="Current Password"
                  placeholder="············"
                  @click:append-inner="isCurrentPasswordVisible = !isCurrentPasswordVisible"
                />
              </VCol>
            </VRow>

            <!-- 👉 New Password -->
            <VRow>
              <VCol
                cols="12"
                md="6"
              >
                <!-- 👉 new password -->
                <VTextField
                  v-model="newPassword"
                  :type="isNewPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isNewPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                  label="New Password"
                  autocomplete="on"
                  placeholder="············"
                  @click:append-inner="isNewPasswordVisible = !isNewPasswordVisible"
                />
              </VCol>

              <VCol
                cols="12"
                md="6"
              >
                <!-- 👉 confirm password -->
                <VTextField
                  v-model="confirmPassword"
                  :type="isConfirmPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isConfirmPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                  autocomplete="on"
                  label="Confirm New Password"
                  placeholder="············"
                  @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible"
                />
              </VCol>
            </VRow>
          </VCardText>

          <!-- 👉 Password Requirements -->
          <VCardText>
            <p class="text-base font-weight-medium mt-2">
              Password Requirements:
            </p>

            <ul class="d-flex flex-column gap-y-3">
              <li
                v-for="item in passwordRequirements"
                :key="item"
                class="d-flex"
              >
                <div>
                  <VIcon
                    size="7"
                    icon="ri-checkbox-blank-circle-fill"
                    class="me-3"
                  />
                </div>
                <span class="font-weight-medium">{{ item }}</span>
              </li>
            </ul>
          </VCardText>

          <!-- 👉 Action Buttons -->
          <VCardText class="d-flex flex-wrap gap-4">
            <VBtn>Save changes</VBtn>

            <VBtn
              type="reset"
              color="secondary"
              variant="outlined"
            >
              Reset
            </VBtn>
          </VCardText>
        </VForm>
      </VCard>
    </VCol>
    <!-- !SECTION -->

  </VRow>
</template>

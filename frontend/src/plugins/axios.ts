import { useAuthStore } from '@/store/auth'
import axios from 'axios'

const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
  },
  withCredentials: true,
  // withXSRFToken: true
})

axiosInstance.interceptors.request.use(config => {
  const authStore = useAuthStore()
  // console.log(authStore)
  if (authStore.token) {
    // console.log('object');
    config.headers.Authorization = `Bearer ${authStore.token}`
  }
  return config
})

export default axiosInstance

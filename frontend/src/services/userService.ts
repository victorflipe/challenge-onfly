import axiosInstance from "@/plugins/axios"

interface RegisterPayload{
    name: string,
    email: string,
    password: string
}

interface LoginPayload{
    email: string,
    password: string
}

export const registerUser = async(payload: RegisterPayload) => {
    const response = await axiosInstance.post('/register', payload)
    return response.data
}

export const loginUser = async(payload: LoginPayload) => {
    await axiosInstance.get('/sanctum/csrf-cookie');
    const response = await axiosInstance.post('/login', payload)
    console.log(response)
    return response.data
}

export const getUser = async() => {
    const response = await axiosInstance.get('/user')
    console.log(response)
    return response
}

import axiosInstance from "@/plugins/axios"

interface RequestPayload{
    requester_name?: string,
    destination: string,
    departure_date: Date,
    return_date: Date,
    status: string
}

export const registerRequest = async(payload: RequestPayload) => {
    const response = await axiosInstance.post('/travel-requests', payload)
    console.log(response)
    return response.data
}

export const getRequests = async(page = 1) => {
    const response = await axiosInstance.get(`/travel-requests?page=${page}`)
    // console.log(response.data)
    return response.data
}

export const updateStatus = async(id: number, status: string) => {
    const response = await axiosInstance.patch(`/travel-requests/${id}/status`,{status:status})
    return response.data
}
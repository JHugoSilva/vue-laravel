import axios from "axios";

const http = axios.create({
    baseURL: 'http://localhost:8000/api'
})

const httpClient = {
    get(endpoint) {
        return http.get(endpoint)
    },
    post(endpoint, data) {
        return http.post(endpoint, data)
    },
    delete(endpoint) {
        return http.delete(endpoint)
    }
}

export default httpClient

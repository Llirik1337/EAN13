import axios from 'axios'

const req = axios.create({
    baseUrl: BASE_URL
})
export default req;
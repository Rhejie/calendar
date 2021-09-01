import axios from 'axios'

export default {
    getEvents() {
        return axios.get('/calendar/get-events');
    },
    saveEvent(data) {
        return axios.post('/calendar/add-event', data)
    }
}

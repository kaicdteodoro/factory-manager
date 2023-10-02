import router from "../plugins/router/index.js";
import {useAlertStore, useAuthStore} from "../plugins/pinia.js";

const error = (response) => {
    useAlertStore().set(response.data.message, 'error');
    if (response.status === 401) {
        useAuthStore().unset();
        return router.push({name: 'login'});
    }
    return undefined;
}

const sanctum = async (callback) => await axios.get('/sanctum/csrf-cookie').then(async () => await callback());

export class Service {
    async get(route, data = {}) {
        return await sanctum(async () => await axios.get(`api/${route}`, {params: data})
            .then(({data}) => data.data)
            .catch(({response}) => error(response))
        )
    }

    async post(route, data = {}) {
        return await sanctum(async () => await axios.post(`api/${route}`, data)
            .then(({data}) => data.data)
            .catch(({response}) => error(response))
        )
    }

    async delete(route) {
        return await sanctum(async () => await axios.delete(`api/${route}`)
            .then(({data}) => data.data)
            .catch(({response}) => error(response))
        )
    }
}

import {Service} from "./service.js";
import router from "../plugins/router/index.js";
import {useAlertStore, useAuthStore} from "../plugins/pinia.js";


class Main extends Service {
    async login(email, password) {
        let data = await this.post('login', {email: email, password: password});
        if (data.username) {
            useAuthStore().set(data.username);
            return router.push({name: 'home'});
        }
    }

    async logout() {
        await this.post('logout').then(() => {
            useAuthStore().unset();
            return router.push({name: "login"});
        });

    }

    async samples() {
        return await this.get('samples/values');
    }

    async numbers() {
        return await this.get('orders/numbers');
    }

    async status() {
        return await this.get('orders/status');
    }

    async chartMonth() {
        return  await this.get('orders/chart/month');
    }

    async sample(id, data = {}) {
        let message = '';
        let success = false;
        let url = id ? `samples/${id}` : 'samples';

        if (id && Object.keys(data).length === 0) {
            success = await this.delete(url);
            message = 'deletado';
        } else {
            success = await this.post(url, {code: data.code, name: data.name, value: data.value});
            message = id ? 'atulizado' : 'criado';
        }

        if (success) {
            useAlertStore().set(`Modelo ${message} com sucesso`, 'success');
        }
    }

    async order(id, data = {}) {
        let message = '';
        let success = false;
        let url = id ? `orders/${id}` : 'orders';

        if (id && Object.keys(data).length === 0) {
            success = await this.delete(url);
            message = 'deletado';
        } else {
            success = await this.post(url, {
                sample_id: data.sample_id,
                order_status_id: data.order_status_id,
                observation: data.observation,
                quantities: data.quantities
            });
            message = id ? 'atulizado' : 'criado';
        }
console.log(success);
        if (success) {
            useAlertStore().set(`Pedido ${message} com sucesso`, 'success');
        }
    }
}

export default new Main();

import {Service} from "./service.js";


class DataTable extends Service {
    async orders(page, perPage) {
        let data = await this.get('orders', {page: page, perPage: perPage});
        return {items: data?.data ?? [], total: data?.total ?? 0};
    }

    async samples(page, perPage) {
        let data = await this.get('samples', {page: page, perPage: perPage});
        return {items: data?.data ?? [], total: data?.total ?? 0};
    }
}

export default new DataTable();

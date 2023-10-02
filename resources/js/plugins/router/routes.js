export const routes = [
    {
        name: 'home',
        icon: 'mdi-chart-box-outline',
        path: '/',
        component: () => import('../../components/Home.vue'),
        meta: {
            title: 'Home'
        }
    },
    {
        name: 'orders',
        icon: 'mdi-order-bool-descending',
        path: '/orders',
        component: () => import('../../components/orders/DataTableOrder.vue'),
        meta: {
            title: 'Orders'
        }
    },
    {
        name: 'samples',
        icon: 'mdi-book-open',
        path: '/samples',
        component: () => import('../../components/samples/ListSamples.vue'),
        meta: {
            title: 'Samples'
        }
    },
];

export const authRoutes = [
    {
        name: 'login',
        path: '/login',
        component: () => import('../../components/Login.vue'),
        meta: {
            middleware: "guest",
            title: 'Login'
        }
    },
];

export default [...routes, ...authRoutes];

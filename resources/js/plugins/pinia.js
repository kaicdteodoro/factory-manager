import {useStorage} from "@vueuse/core";
import {createPinia, defineStore} from "pinia";

export default createPinia();

export const useAuthStore = defineStore('auth', {
    state: () => ({
        username: useStorage('username', null)
    }),
    getters: {
        authenticated: (state) => !!state.username,
    },
    actions: {
        set(username) {
            this.username = username;
        },
        unset() {
            this.username = null;
        }
    },
});
export const useAlertStore = defineStore('alert', {
    state: () => ({
        type: undefined,
        message: undefined,
    }),
    actions: {
        set(message, type = 'success') {
            this.type = type;
            this.message = message;
        },
        unset() {
            this.type = undefined;
            this.message = undefined;
        }
    },
});

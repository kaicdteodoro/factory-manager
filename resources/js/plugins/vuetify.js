/**
 * plugins/vuetify.js
 *
 * Framework documentation: https://vuetifyjs.com`
 */

// Styles
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';

// Vuetify
import { createVuetify } from 'vuetify';

// Components
import { VBtn } from 'vuetify/components';
import { VDataTableServer } from 'vuetify/labs/VDataTable';

export default createVuetify({
    components: {
        VDataTableServer
    },
    aliases: {
        VBtnAlt: VBtn,
    },
    // https://vuetifyjs.com/features/global-configuration/
    // https://vuetifyjs.com/features/theme/
    theme: {
        defaultTheme: 'dark',
        themes: {
            dark: {
                dark: true,
                colors: {
                    primary: '#1697f6',
                },
            },
        },
    },
})

/**
 * plugins/index.js
 *
 * Automatically included in `./src/main.js`
 */

import pinia from './pinia.js';
import vuetify from './vuetify';
import router from './router/index.js';
import { loadFonts } from './webfontloader';

export function registerPlugins (app) {
    app.use(pinia);
    app.use(router);
    app.use(vuetify);

    loadFonts().then();
}

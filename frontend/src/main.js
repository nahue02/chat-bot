import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import "@mdi/font/css/materialdesignicons.css";
import colors from "vuetify/util/colors";

const vuetify = createVuetify({
  components,
  directives,
  theme: {
    defaultTheme: "dark",
    themes: {
      dark: {
        dark: true,
        colors: {
          primary: colors.red.accent3,
          secondary: colors.red.accent2,
        },
      },
      light: {
        dark: false,
        colors: {
          primary: colors.red.accent3,
          secondary: colors.red.accent2,
        },
      },
    },
  },
});

createApp(App).use(router).use(vuetify).mount("#app");

/* 
  Colores:
  amarillo: f4eac7
  rosado: dd8c95
*/

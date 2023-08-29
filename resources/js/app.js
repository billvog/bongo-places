import "./bootstrap";

import { createApp } from "vue/dist/vue.esm-bundler";
import EditPhotosComponent from "./components/EditPhotosComponent.vue";

const app = createApp({});

app.component("edit-photos-component", EditPhotosComponent);

app.mount("#app");

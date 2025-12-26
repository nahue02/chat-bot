import { createRouter, createWebHistory } from "vue-router";
import ChatPage from "./pages/ChatPage.vue";
import AdminPage from "./pages/AdminPage.vue";
import CreatePage from "./pages/CreatePage.vue";
import UpdatePage from "./components/UpdateNodeDialog.vue";

const routes = [
  { path: "/", component: ChatPage },
  { path: "/admin", component: AdminPage },
  { path: "/create", component: CreatePage },
  { path: "/edit/:id", component: UpdatePage },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;

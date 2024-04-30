import annonceRoutes from "@/router/FrontRoutes/annonce.js";

export default [
  {
    path: "/",
    name: "homeView",
    component: () => import("@/views/FrontOffice/HomeView.vue"),
  },
  {
    path: "/chat",
    name: "chatView",
    component: () => import("@/views/FrontOffice/Chat/usersChatView.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/chat/:id",
    name: "chatWithView",
    component: () => import("@/views/FrontOffice/Chat/chatView.vue"),
    meta: { requiresAuth: true },
    props: true,
  },
  ...annonceRoutes,
];

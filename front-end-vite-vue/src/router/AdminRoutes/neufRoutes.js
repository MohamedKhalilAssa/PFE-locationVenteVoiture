export default [
  {
    path: "neuf",
    name: "neufView",
    component: () => import("@/views/BackOffice/AdminViews/Neuf/NeufView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
];

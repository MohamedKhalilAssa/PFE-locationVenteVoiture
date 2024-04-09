export default [
  {
    path: "vente",
    name: "venteView",
    component: () =>
      import("@/views/BackOffice/AdminViews/Actions/VenteView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
];

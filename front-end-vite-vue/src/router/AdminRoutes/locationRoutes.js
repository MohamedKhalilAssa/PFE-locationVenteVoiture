export default [
  {
    path: "location",
    name: "locationView",
    component: () =>
      import("@/views/BackOffice/AdminViews/Actions/LocationView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
];

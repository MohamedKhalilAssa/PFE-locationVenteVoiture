export default [
  {
    path: "occasion",
    name: "occasionView",
    component: () =>
      import("@/views/BackOffice/AdminViews/Occasion/OccasionView.vue"),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
];

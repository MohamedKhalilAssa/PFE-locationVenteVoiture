export default [
  {
    path: "couleurs",
    name: "couleursView",
    component: () =>
      import(
        "@/views/BackOffice/AdminViews/attributsVoitures/Couleur/CouleurView.vue"
      ),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
];

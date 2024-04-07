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
  {
    path: "couleurs/ajouter",
    name: "ajouterCouleur",
    component: () =>
      import(
        "@/views/BackOffice/AdminViews/attributsVoitures/Couleur/CreateCouleursView.vue"
      ),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "couleurs/modifier/:id",
    name: "modifierCouleur",
    component: () =>
      import(
        "@/views/BackOffice/AdminViews/attributsVoitures/Couleur/EditCouleursView.vue"
      ),
    meta: { requiresAuth: true, requiresAdmin: true },
    props: true,
  },
];

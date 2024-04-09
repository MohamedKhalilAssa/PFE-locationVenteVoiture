export default [
  {
    path: "villes",
    name: "villesView",
    component: () =>
      import(
        "@/views/BackOffice/AdminViews/attributsVoitures/Ville/VilleView.vue"
      ),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "villes/ajouter",
    name: "ajouterVille",
    component: () =>
      import(
        "@/views/BackOffice/AdminViews/attributsVoitures/Ville/CreateVillesView.vue"
      ),
    meta: { requiresAuth: true, requiresAdmin: true },
  },
  {
    path: "ville/modifier/:id",
    name: "modifierVille",
    component: () =>
      import(
        "@/views/BackOffice/AdminViews/attributsVoitures//Ville/EditVillesView.vue"
      ),
    meta: { requiresAuth: true, requiresAdmin: true },
    props: true,
  },
];

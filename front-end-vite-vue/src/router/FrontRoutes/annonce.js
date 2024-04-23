export default [
  // affichage
  {
    path: "/neuf",
    name: "neufFrontView",
    component: () => import("@/views/FrontOffice/Neuf/NeufListingsView.vue"),
  },
  {
    path: "/occasion",
    name: "occasionFrontView",
    component: () =>
      import("@/views/FrontOffice/Occasion/OccasionListingsView.vue"),
  },
  {
    path: "/location",
    name: "locationFrontView",
    component: () =>
      import("@/views/FrontOffice/Location/LocationListingsView.vue"),
  },
  //   details
  {
    path: "/annonce/:id",
    name: "detailsAnnonceFront",
    component: () =>
      import("@/views/FrontOffice/Annonces/DetailsAnnonceView.vue"),
    props: true,
  },
  //   annonce
  {
    path: "/annonce",
    name: "ajouterAnnonceFront",
    component: () =>
      import("@/views/FrontOffice/Annonces/CreateAnnonceView.vue"),
    meta: { requiresAuth: true },
  },
];

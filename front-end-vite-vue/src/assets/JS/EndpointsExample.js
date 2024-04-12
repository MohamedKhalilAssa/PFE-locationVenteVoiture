const baseURL = "http://URL"; // to be changed if the backend is hosted somewhere else

export default {
  // Users
  user__get_all_or_add: baseURL + "/api/users",
  user__paginate: baseURL + "/api/users/pagination?page=",
  user__get_or_update_or_delete: baseURL + "/api/users/",
  user__get_total: baseURL + "/api/users/total",
  user__get_online_admin: baseURL + "/api/users/admin/online",
  // Marques
  marque__get_all_or_add: baseURL + "/api/marque",
  marque__get_or_update_or_delete: baseURL + "/api/marque/",
  marque__paginate: baseURL + "/api/marque/pagination?page=",
  // Modeles
  modele__get_all_or_add: baseURL + "/api/modele",
  modele__get_by_marque: baseURL + "/api/modele/marque/",
  modele__get_or_update_or_delete: baseURL + "/api/modele/",
  modele__paginate: baseURL + "/api/modele/pagination?page=",
  // Couleurs
  couleur__get_all_or_add: baseURL + "/api/couleur",
  couleur__get_or_update_or_delete: baseURL + "/api/couleur/",
  couleur__paginate: baseURL + "/api/couleur/pagination?page=",
  // Villes
  ville__get_all_or_add: baseURL + "/api/ville",
  ville__get_or_update_or_delete: baseURL + "/api/ville/",
  ville__paginate: baseURL + "/api/ville/pagination?page=",
  // Annonces
  annonce__create_occasion: baseURL + "/api/annonce/occasion/store",
  // Config Endpoints
  config__get_csrf_token: baseURL + "/sanctum/csrf-cookie",
  config__login: baseURL + "/login",
  config__logout: baseURL + "/logout",
  config__register: baseURL + "/register",
  config__get_authenticated_user: baseURL + "/api/user",
  // analytics
  analytics__get_visitors: baseURL + "/api/analytics/visitors",
  analytics__get_or_update_or_delete: baseURL + "/api/analytics/",
  analytics__get_paginate: baseURL + "/api/analytics/pagination?page=",
  // general getters
  getStorage: baseURL + "/storage/",
};

const baseURL = "http://192.168.1.3:8000"; // to be changed if the backend is hosted somewhere else

export default {
  // Users
  getAllOrAddUser: baseURL + "/api/users",
  userPaginate: baseURL + "/api/users/pagination?page=",
  getOrUpdateOrDeleteUser: baseURL + "/api/users/",
  // Marques
  getAllOrAddMarque: baseURL + "/api/marque",
  getOrUpdateOrDeleteMarque: baseURL + "/api/marque/",
  MarquePagination: baseURL + "/api/marque/pagination?page=",
  //   Modeles
  getAllOrAddModele: baseURL + "/api/modele",
  getModelesByMarque: baseURL + "/api/modele/marque/",
  getOrUpdateOrDeleteModele: baseURL + "/api/modele/",
  ModelePagination: baseURL + "/api/modele/pagination?page=",
  //   couleurs
  getAllOrAddCouleurs: baseURL + "/api/couleur",
  //   villes
  getAllOrAddVille: baseURL + "/api/ville",
  getOrUpdateOrDeleteVille: baseURL + "/api/ville/",
  VillePagination: baseURL + "/api/ville/pagination?page=",
  // config endpoints
  getCSRFToken: baseURL + "/sanctum/csrf-cookie",
  login: baseURL + "/login",
  logout: baseURL + "/logout",
  register: baseURL + "/register",
  getAuthenticatedUser: baseURL + "/api/user",
};

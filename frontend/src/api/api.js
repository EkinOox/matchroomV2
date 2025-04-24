import axios from "axios";

// Création d'une instance Axios
const api = axios.create({
  baseURL: "http://localhost:8000/api",
});

// Intercepteur pour ajouter le token dans les headers
api.interceptors.request.use((config) => {
  const token = sessionStorage.getItem("token");
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

export default api;

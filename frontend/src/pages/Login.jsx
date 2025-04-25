import React, { useState } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { AnimatedGridPattern } from "@/components/magicui/animated-grid-pattern";
import { InteractiveHoverButton } from "@/components/magicui/interactive-hover-button";


export default function Login({ onLoginSuccess }) {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const handleLogin = async (e) => {
    e.preventDefault();
    setError("");

    try {
      const response = await axios.post("http://localhost:8000/api/login", {
        email,
        password,
      });

      const { token } = response.data;

      // Stocker le token en sessionStorage
      localStorage.setItem("token", token);

      if (onLoginSuccess) {
        onLoginSuccess(token); // callback si besoin
      }

      navigate("/match");
    } catch (err) {
      console.error("Erreur de connexion :", err);
      setError("Identifiants incorrects. Veuillez réessayer.");
    }
  };

  return (
    <div className="w-full relative h-screen overflow-hidden flex flex-col justify-center items-center">
      <AnimatedGridPattern />
      <div className="w-4/5 md:w-4/12 p-8 bg-white z-50 border rounded-lg shadow">
        <h2 className="text-4xl font-bold mb-6">Connexion</h2>
        <span className="font-bold tracking-tight">Veuillez vous authentifier afin d'avoir accès à la recherche d'hotels</span>
        <form onSubmit={handleLogin} className="flex flex-col mt-6 gap-6">
          <input
            type="email"
            placeholder="Email"
            className="px-4 py-2 border rounded-lg"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            required
          />
          <input
            type="password"
            placeholder="Mot de passe"
            className="px-4 py-2 border rounded-lg"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
          {error && <div className="text-red-500 text-sm">{error}</div>}
          <InteractiveHoverButton type="submit">
            Se connecter
          </InteractiveHoverButton>
        </form>
      </div>
    </div>
  );
}

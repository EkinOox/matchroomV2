import { Modal } from "@mui/material";
import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { jwtDecode } from "jwt-decode";

function Navbar() {
  const token = localStorage.getItem("token");
  const navigate = useNavigate();
  const [isLogoutOpen, setIsLogoutModalOpen] = useState(false);
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

  let isHotelier = false;
  if (token) {
    try {
      const decoded = jwtDecode(token);
      isHotelier = decoded?.roles?.includes("ROLE_HOTELIER");
    } catch (e) {
      console.error("Token invalide :", e);
    }
  }

  const handleLogout = () => {
    localStorage.removeItem("token");
    setIsLogoutModalOpen(true);
    setIsMobileMenuOpen(false); // Fermer le menu mobile
  };

  const handleReturn = () => {
    if (location.pathname === "/") {
      setIsLogoutModalOpen(false);
    } else {
      navigate("/");
    }
  };

  return (
    <nav className="bg-white shadow-md px-6 py-4 flex items-center justify-between relative">
      <h1 className="text-2xl font-bold text-black">Matchroom</h1>

      {/* 🧭 Desktop Menu */}
      <div className="hidden md:flex space-x-6 text-lg font-medium items-center">
        <Link to="/" className="text-black hover:text-blue-main">Accueil</Link>
        <Link to="/match" className="text-black hover:text-blue-main">Matchs</Link>
        <Link to="/negociations" className="text-black hover:text-blue-main">Vos Négociations</Link>
        {isHotelier && (
          <Link to="/admin" className="text-black hover:text-blue-main">Administration</Link>
        )}
        {!token ? (
          <Link to="/login" className="text-black hover:text-blue-main">Connexion</Link>
        ) : (
          <button onClick={handleLogout} className="text-black hover:text-blue-main">Déconnexion</button>
        )}
      </div>

      {/* 🍔 Burger Menu Button */}
      <button
        className="md:hidden text-3xl text-black focus:outline-none"
        onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
      >
        ☰
      </button>

      {/* 📱 Mobile Menu */}
      {isMobileMenuOpen && (
        <div className="absolute top-16 left-0 w-full bg-white flex flex-col items-start px-6 py-4 space-y-4 shadow-md z-50 md:hidden">
          <Link to="/" onClick={() => setIsMobileMenuOpen(false)} className="text-black hover:text-blue-main">Accueil</Link>
          <Link to="/match" onClick={() => setIsMobileMenuOpen(false)} className="text-black hover:text-blue-main">Matchs</Link>
          <Link to="/negociations" onClick={() => setIsMobileMenuOpen(false)} className="text-black hover:text-blue-main">Vos Négociations</Link>
          {isHotelier && (
            <Link to="/admin" onClick={() => setIsMobileMenuOpen(false)} className="text-black hover:text-blue-main">Administration</Link>
          )}
          {!token ? (
            <Link to="/login" onClick={() => setIsMobileMenuOpen(false)} className="text-black hover:text-blue-main">Connexion</Link>
          ) : (
            <button onClick={handleLogout} className="text-black hover:text-blue-main">Déconnexion</button>
          )}
        </div>
      )}

      {/* 🧾 Modal de déconnexion */}
      <Modal
        open={isLogoutOpen}
        onClose={() => setIsLogoutModalOpen(false)}
        sx={{
          display: "flex",
          justifyContent: "center",
          alignItems: "center",
          backgroundColor: "rgba(0, 0, 0, 0.5)",
          backdropFilter: "blur(5px)",
        }}
      >
        <div className="bg-white flex flex-col p-16 gap-4 rounded-lg shadow-lg text-center">
          <h2 className="text-3xl font-bold">Déconnexion</h2>
          <span>Vous vous êtes déconnecté avec succès</span>
          <button
            onClick={handleReturn}
            className="w-full py-3 bg-blue-main text-white font-semibold rounded-lg shadow-md hover:bg-blue-900 transition cursor-pointer"
          >
            Retour à l'accueil
          </button>
        </div>
      </Modal>
    </nav>
  );
}

export default Navbar;

import { Modal, Menu, MenuItem } from "@mui/material";
import { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { jwtDecode } from "jwt-decode";

function Navbar() {
  const token = localStorage.getItem("token");
  const navigate = useNavigate();
  const [isLogoutOpen, setIsLogoutModalOpen] = useState(false);
  const [anchorEl, setAnchorEl] = useState(null);
  const open = Boolean(anchorEl);

  // Decode le token uniquement s'il existe
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
  };

  const handleProfileHover = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleCloseMenu = () => {
    setAnchorEl(null);
  };

  const handleReturn = () => {
    if (location.pathname === "/") {
      setIsLogoutModalOpen(false);
    } else {
      navigate("/");
    }
  };

  return (
    <nav className="flex items-center justify-between px-8 py-4 bg-white shadow-md rounded-lg">
      <h1 className="text-2xl font-bold text-black">Matchroom</h1>
      <div className="space-x-8 text-lg font-medium">
        <Link
          to="/"
          className="text-black hover:text-blue-main transition-colors duration-200"
        >
          Accueil
        </Link>
        <Link
          to="/match"
          className="text-black hover:text-blue-main transition-colors duration-200"
        >
          Matches
        </Link>
        <Link
          to="/negociations"
          className="text-black hover:text-blue-main transition-colors duration-200"
        >
          Vos Négociations
        </Link>

        {/* ✅ Lien Administration uniquement pour ROLE_HOTELIER */}
        {isHotelier && (
          <Link
            to="/admin"
            className="text-black hover:text-blue-main transition-colors duration-200"
          >
            Administration
          </Link>
        )}

        {!token ? (
          <Link
            to="/login"
            className="text-black hover:text-blue-main transition-colors duration-200"
          >
            Connexion
          </Link>
        ) : (
          <Link
            onClick={() => {
              handleLogout();
              handleCloseMenu();
            }}
          >
            Déconnexion
          </Link>
        )}
      </div>

      <Modal
        open={isLogoutOpen}
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

import { Modal, Menu, MenuItem } from '@mui/material';
import { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import jwt_decode from "jwt-decode";

function Navbar() {
  // Vérifier si le token est présent dans le localStorage
  const token = localStorage.getItem('token');
  const navigate = useNavigate();
  const [isLogoutOpen, setIsLogoutModalOpen] = useState(false);
  const [anchorEl, setAnchorEl] = useState(null); // Pour gérer l'ouverture du menu
  const open = Boolean(anchorEl);

  const handleLogout = () => {
    localStorage.removeItem('token');
    const decoded = jwt_decode(token);
    console.log(decoded);
    
    setIsLogoutModalOpen(true);
  };

  const handleProfileHover = (event) => {
    setAnchorEl(event.currentTarget); // Ouvre le menu au hover
  };

  const handleCloseMenu = () => {
    setAnchorEl(null); // Ferme le menu
  };

  return (
    <nav className="flex items-center justify-between px-8 py-4 bg-white shadow-md">
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

        {/* Afficher le lien Login uniquement si le token est absent */}
        {!token ? (
          <Link
            to="/login"
            className="text-black hover:text-blue-main transition-colors duration-200"
          >
            Connexion
          </Link>
        ) : (
          <div
            onMouseEnter={handleProfileHover} // Ouvre le menu au hover
            onMouseLeave={handleCloseMenu}     // Ferme le menu au sortir du conteneur
          >
            <button
              className="text-black hover:text-blue-main transition-colors duration-200"
            >
              Mon Compte
            </button>
            <Menu
              anchorEl={anchorEl}
              open={open}
              onClose={handleCloseMenu}
              MenuListProps={{
                'aria-labelledby': 'basic-button',
              }}
              onMouseLeave={handleCloseMenu} // Ferme le menu au sortir du menu
            >
              <MenuItem component={Link} to="/profil" onClick={handleCloseMenu}>
                Profil
              </MenuItem>
              <MenuItem onClick={() => { handleLogout(); handleCloseMenu(); }}>
                Déconnexion
              </MenuItem>
            </Menu>
          </div>
        )}
      </div>

      <Modal
        open={isLogoutOpen}
        onClose={() => setIsLogoutModalOpen(false)}
        sx={{
          display: 'flex',
          justifyContent: 'center',
          alignItems: 'center',
          backgroundColor: 'rgba(0, 0, 0, 0.5)',
          backdropFilter: 'blur(5px)',
        }}
      >
        <div className="bg-white flex flex-col p-16 gap-4 rounded-lg shadow-lg text-center">
          <h2 className="text-3xl font-bold">Déconnexion</h2>
          <span>Vous vous êtes déconnecté avec succès</span>
          <Link
            className="w-full py-3 bg-blue-main text-white font-semibold rounded-lg shadow-md hover:bg-blue-900 transition cursor-pointer"
            to="/"
          >
            Retour à l'accueil
          </Link>
        </div>
      </Modal>
    </nav>
  );
}

export default Navbar;

import { Link, useNavigate } from 'react-router-dom';

function Navbar() {
  // Vérifier si le token est présent dans le localStorage
  const token = localStorage.getItem('token');
  const navigate = useNavigate();

  const handleLogout = () => {
    if (localStorage.getItem("token")) {
      localStorage.removeItem("token");
      navigate("/")
    }    
  }

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
          <button onClick={handleLogout} className="text-black hover:text-blue-main transition-colors duration-200">
            Deconnexion
          </button>
        )}
      </div>
    </nav>
  );
}

export default Navbar;

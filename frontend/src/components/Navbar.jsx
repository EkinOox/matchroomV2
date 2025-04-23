import { Link } from 'react-router-dom'
import '../assets/css/Navbar.css';

function Navbar() {
  return (
    <nav className="navbar">
      <h1 className="logo">Matchroom</h1>
      <div className="nav-links">
        <Link to="/">Accueil</Link>
        <Link to="/matches">Matches</Link>
        <Link to="/negociations">Vos Négociations</Link>
      </div>
    </nav>
  )
}

export default Navbar

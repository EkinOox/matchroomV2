import { Link } from 'react-router-dom'

function Footer() {
    return (
        <nav className="flex items-center justify-center gap-16 px-8 py-10 bg-white shadow-md">
            <Link
                to="/conditions-général"
                className="text-black hover:text-blue-main transition-colors duration-200"
            >
                Condition Général d'utilisation
            </Link>
            <Link
                to="/politique-confidentialite"
                className="text-black hover:text-blue-main transition-colors duration-200"
            >
                Politique de confidentialité
            </Link>
        </nav>
    )
}

export default Footer;

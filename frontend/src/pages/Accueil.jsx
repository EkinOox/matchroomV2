import { Box } from "@mui/material";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import { Ripple } from "@/components/magicui/ripple";

const Accueil = () => {
  return (
    <div className="min-h-screen bg-[#F8F8F8]">
      <Navbar />
      <div className="px-4 sm:px-8 md:px-16 lg:px-24 xl:px-32 py-16 flex flex-col md:flex-row gap-16">
        <div className="w-full md:w-6/12 flex flex-col gap-8">
          <h2 className="text-4xl md:text-5xl font-bold text-black">
            Découvrez l'expérience Matchroom !
          </h2>
          <p className="text-base md:text-lg font-medium text-gray-700">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum.
          </p>
        </div>

        <img
          className="w-full md:w-6/12 rounded-lg object-cover"
          src="/accueil-room.webp"
          alt="Chambre d'hôtel"
        />
      </div>

      <div className="p-16 flex flex-col items-center gap-16 text-center">
        <h2 className="text-5xl font-bold text-black">
          Cherchez. Négociez. Réservez.
        </h2>

        <div className="relative w-full flex justify-center items-center">
          {/* Ripple en arrière-plan */}
          <div className="absolute z-1 flex h-[800px] w-full flex-col items-center justify-center rounded-lg">
            <Ripple />
          </div>

          {/* Image au-dessus de Ripple */}
          <img
            className="relative z-10 w-8/12 max-w-3xl rounded-lg"
            src="/accueil-computer.svg"
            alt="Illustration ordinateur"
          />
        </div>
      </div>

      <div className="px-16 pb-16 flex justify-center flex-row flex-wrap gap-20">
        {[
          {
            title: "Le prix public officiel",
            text: "Le prix officiel présent sur MatchRoom est le prix pratiqué par l'hôtel sur les dates que vous avez cherchées. Ce prix est le point de départ de votre négociation réussie. Très peu de chances de gagner une négociation en proposant 10€ sur un prix initial à 100€.",
          },
          {
            title: "Offre trop basse",
            text: "Vous avez fait une offre trop basse et à un prix jugé déraisonnable par l'Hôtel. S'il ne contre-propose rien, la négociation s'arrête ici. De plus, vous ne pourrez plus voir cet hôtel sur ces dates pendant 24 heures !",
          },
          {
            title: "Contre-proposition",
            text: "Vous avez fait une offre de prix, l'hôtel ne l'a pas acceptée mais vous contre-propose un autre prix. À vous désormais d'accepter ou de refuser. Il n'y a pas de 2ème contre-proposition possible.",
          },
          {
            title: "Quand Négocier",
            text: "Les négociations sont ouvertes sans limite de temps : vous pouvez chercher une date dans 3 jours ou dans 6 mois. Les Hôtels connaissent déjà leurs périodes de basse saison. Les jeux sont ouverts !",
          },
        ].map((item, idx) => (
          <div key={idx} className="text-center w-[400px]">
            <h3 className="text-2xl font-semibold text-black mb-2">
              {item.title}
            </h3>
            <p className="text-gray-700">{item.text}</p>
          </div>
        ))}
      </div>
      <Footer />
    </div>
  );
};

export default Accueil;

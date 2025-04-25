import { Box } from "@mui/material";
import Navbar from "../components/Navbar";
import Footer from "../components/Footer";
import { Ripple } from "@/components/magicui/ripple";
import { Marquee } from "@/components/magicui/marquee";
import { InteractiveHoverButton } from "@/components/magicui/interactive-hover-button";

import { cn } from "@/lib/utils";

// Données des avis
const reviews = [
  {
    name: "Felix Zeltner",
    username: "",
    body: "À la recherche d'un hôtel pour une nuit, j'ai réussi à obtenir un tarif avantageux.",
    img: "https://avatar.vercel.sh/james",
  },
  {
    name: "Alice Johnson",
    username: "",
    body: "Lors d'un voyage d'affaires, j'avais besoin d'un hôtel agréable à un prix raisonnable, et Matchroom a parfaitement répondu à mes attentes.",
    img: "https://avatar.vercel.sh/jenny",
  },
  {
    name: "Darryl Duncan",
    username: "",
    body: "La plateforme idéale pour réserver des hôtels : je ne manque jamais une occasion lors de mes voyages.",
    img: "https://avatar.vercel.sh/jane",
  },
  {
    name: "Sophie Laurent",
    username: "",
    body: "En quelques clics, j'ai trouvé une chambre confortable pour le week-end. Je recommande vivement.",
    img: "https://avatar.vercel.sh/john",
  },
  {
    name: "Marco Rinaldi",
    username: "",
    body: "Service rapide et intuitif. L'interface est simple et les résultats sont pertinents.",
    img: "https://avatar.vercel.sh/jill",
  },
  {
    name: "Clara Nguyen",
    username: "",
    body: "Matchroom m'a permis d’économiser sur mon séjour sans sacrifier la qualité. Génial !",
    img: "https://avatar.vercel.sh/jack",
  },
  {
    name: "Léo Dubois",
    username: "",
    body: "Une vraie pépite pour les voyageurs fréquents. Je l'utilise pour tous mes déplacements.",
    img: "https://avatar.vercel.sh/paul",
  },
];

// Composant individuel pour un avis
const ReviewCard = ({ img, name, username, body }) => (
  <figure
    className={cn(
      "relative h-full w-64 cursor-pointer overflow-hidden rounded-xl border p-4",
      "border-gray-950/[.1] bg-gray-950/[.01] hover:bg-gray-950/[.05]",
      "dark:border-gray-50/[.1] dark:bg-gray-50/[.10] dark:hover:bg-gray-50/[.15]"
    )}
  >
    <div className="flex items-center gap-2">
      <img
        className="rounded-full"
        width="32"
        height="32"
        alt={name}
        src={img}
      />
      <div>
        <figcaption className="text-sm font-medium dark:text-white">
          {name}
        </figcaption>
        <p className="text-xs font-medium dark:text-white/40">{username}</p>
      </div>
    </div>
    <blockquote className="mt-2 text-sm">{body}</blockquote>
  </figure>
);

const Accueil = () => {
  const firstRow = reviews.slice(0, reviews.length / 2);
  const secondRow = reviews.slice(reviews.length / 2);

  const infos = [
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
  ];

  return (
    <div className="min-h-screen bg-gray-100">
      <Navbar />

      <section className="px-6 md:px-20 py-20 flex flex-col md:flex-row gap-16 bg-gray-100">
        <div className="w-full md:w-6/12 flex flex-col justify-center gap-6">
          <h2 className="text-4xl md:text-5xl font-extrabold text-gray-800 leading-tight drop-shadow-sm">
            L’expérience MatchRoom : Négociez votre chambre au meilleur prix
          </h2>
          <p className="text-md md:text-lg text-gray-600 leading-relaxed">
            MatchRoom est la première plateforme où tout le monde est gagnant :
            vous profitez de tarifs sur-mesure, les hôteliers remplissent leurs
            chambres vides.
          </p>
          <div className="bg-white shadow-neumorphism p-6 rounded-xl">
            <p className="text-gray-700 font-medium">
              ✨ Négociez directement avec les hôteliers <br />
              ✨ Accédez à des offres uniques, introuvables ailleurs <br />✨
              Réservez en toute confiance : mêmes chambres, même qualité de
              service
            </p>
          </div>
          <p className="text-md md:text-lg text-gray-600 leading-relaxed">
            Grâce à notre système innovant, vous avez le pouvoir de négocier vos
            séjours selon vos envies et votre budget. Essayez MatchRoom, et
            découvrez une nouvelle manière de réserver vos hôtels.
          </p>
        </div>

        <div className="w-full md:w-6/12 flex justify-center items-center">
          <div className="rounded-3xl bg-gray-100 shadow-neumorphism-inner p-2">
            <img
              className="w-full rounded-2xl object-cover shadow-lg"
              src="/accueil-room.webp"
              alt="Chambre d'hôtel"
            />
          </div>
        </div>
      </section>

      {/* Section avec Ripple */}
      <section className="p-16 flex flex-col items-center gap-16 text-center">
        <h2 className="text-5xl font-bold text-black">
          Cherchez. Négociez. Réservez.
        </h2>
        <div className="relative w-full flex justify-center items-center">
          <div className="absolute z-1 flex h-[800px] w-full items-center justify-center">
            <Ripple />
          </div>
          <img
            className="relative z-10 w-8/12 max-w-3xl rounded-lg"
            src="/accueil-computer.svg"
            alt="Illustration ordinateur"
          />
        </div>
        <InteractiveHoverButton to="/match">Commencer à Matcher !</InteractiveHoverButton>
      </section>

      {/* Section des avis */}
      <section className="relative w-full bg-gray-50 py-16 px-4 sm:px-8">
        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-12">
          Ce que pensent nos utilisateurs
        </h2>
        <div className="relative flex flex-col gap-8">
          <Marquee pauseOnHover className="[--duration:20s]">
            {firstRow.map((review) => (
              <ReviewCard key={review.username} {...review} />
            ))}
          </Marquee>
          <Marquee reverse pauseOnHover className="[--duration:20s]">
            {secondRow.map((review) => (
              <ReviewCard key={review.username} {...review} />
            ))}
          </Marquee>
          {/* Fading edges */}
          <div className="pointer-events-none absolute inset-y-0 left-0 w-1/4 bg-gradient-to-r from-gray-50 to-transparent"></div>
          <div className="pointer-events-none absolute inset-y-0 right-0 w-1/4 bg-gradient-to-l from-gray-50 to-transparent"></div>
        </div>
      </section>

      {/* Séparateur visuel moderne */}
      <div className="w-full h-24 bg-gradient-to-b from-gray-200 to-white" />

      {/* Section infos MatchRoom */}
      <section className="bg-white py-20 px-6 sm:px-12 md:px-24">
        <h2 className="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-16">
          Pourquoi choisir MatchRoom ?
        </h2>
        <div className="flex justify-center flex-wrap gap-16">
          {infos.map((item, idx) => (
            <div
              key={idx}
              className="bg-gray-100 shadow-neumorphism p-8 rounded-xl w-full max-w-md text-center"
            >
              <h3 className="text-2xl font-semibold text-gray-800 mb-4">
                {item.title}
              </h3>
              <p className="text-gray-600">{item.text}</p>
            </div>
          ))}
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Accueil;

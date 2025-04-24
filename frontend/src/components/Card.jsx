import React, { useState, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import RoomModal from "./RoomModal";
import NegociationModal from "./NegociationModal";

const fakeData = {
  imageUrl: "https://www.hotelescenter.es/wp-content/blogs.dir/1601/files/home//header-home-mb.jpg",
  name: "Hotel Aquabella",
  price: 290,
  description:
    "Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
  attribute: ["Piscine", "Lit simple", "Wifi", "Climatisation", "Restaurant"],
};

const hotelList = [
  {
    name: "Hôtel Aquabella",
    imageUrl: "https://www.hotelescenter.es/wp-content/blogs.dir/1601/files/home//header-home-mb.jpg",
    price: "150€/nuit",
    adresse: "2 Rue des Étuves, 13100 Aix-en-Provence",
  },
  {
    name: "Villa Serena",
    imageUrl: "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/32/5a/76/escale-oceania-aix-en.jpg?w=1200&h=-1&s=1",
    price: "220€/nuit",
    adresse: "270 Av. Calendal, 13600 La Ciotat",
  },
  {
    name: "Résidence Soleil",
    imageUrl: "https://media.istockphoto.com/id/104731717/fr/photo/centre-de-vill%C3%A9giature-de-luxe.jpg?s=612x612&w=0&k=20&c=qn-Ugr3N5J_JBKZttni3vimlfBOd52jWG3FouENXye0=",
    price: "95€/nuit",
    adresse: "4 rue du château d’eau 11120 Ginestas",
  },
  {
    name: "Le Palais Bleu",
    imageUrl: "https://img.freepik.com/photos-gratuite/belle-piscine-exterieure-luxe-dans-hotel-complexe_74190-7433.jpg?semt=ais_hybrid&w=740",
    price: "310€/nuit",
    adresse: "12 Rue Richebourg, 25000 Besançon",
  },
];

export default function Card({ onSwipe, searchData, geocodeAddress }) {
  const [cards, setCards] = useState(hotelList);
  const [swipeDirection, setSwipeDirection] = useState(null);
  const [isAnimating, setIsAnimating] = useState(false);
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [isModalNegoOpen, setIsModalNegoOpen] = useState(false);

  useEffect(() => {
    if (cards.length > 0 && onSwipe) {
      // onSwipe est appelé avec la première carte (cards[0]) dès le premier rendu
      onSwipe(cards[0]);
    }
  }, [cards, onSwipe]); // Déclenché à chaque mise à jour de "cards"

  const handleSwipe = (direction) => {
    if (cards.length === 0 || isAnimating) return;

    setSwipeDirection(direction);
    setIsAnimating(true);

    // Callback externe (optionnel)
    if (cards.length > 0 && onSwipe) {
      onSwipe(cards[0]);
    }

    setTimeout(() => {
      setCards((prev) => prev.slice(1));
      setSwipeDirection(null);
      setIsAnimating(false);
    }, 300);
  };


  return (
    <div className="relative w-full h-[85vh] max-w-md mx-auto flex items-center justify-center overflow-hidden">
      <AnimatePresence>
        {cards.length > 0 &&
          cards.map((hotel, index) =>
            index === 0 ? (
              <motion.div
                key={hotel.name}
                drag="x"
                dragConstraints={{ left: 0, right: 0 }}
                onDragEnd={(e, info) => {
                  if (info.offset.x > 100) {
                    setIsModalNegoOpen(true);
                  } else if (info.offset.x < -100) {
                    handleSwipe("left");
                  }
                }}
                initial={{ scale: 0.95, opacity: 0 }}
                animate={{ scale: 1, opacity: 1 }}
                exit={{
                  x: swipeDirection === "left" ? -1000 : 1000,
                  opacity: 0,
                  transition: { duration: 0.2 },
                }}
                className="absolute w-full h-full rounded-2xl shadow-lg overflow-hidden flex flex-col justify-between text-white"
                style={{
                  backgroundImage: `url(${hotel.imageUrl})`,
                  backgroundSize: "cover",
                  backgroundPosition: "center",
                }}
              >
                {/* Bouton infos (modale) */}
                <div
                  className="absolute top-4 right-4 w-10 h-10 rounded-full bg-white text-black font-bold text-md flex items-center justify-center z-10 cursor-pointer hover:bg-blue-500"
                  onClick={() => setIsModalOpen(true)}
                >
                  i
                </div>
                <RoomModal
                  isOpen={isModalOpen}
                  onClose={() => setIsModalOpen(false)}
                  data={fakeData}
                />
                
                <NegociationModal
                  isOpen={isModalNegoOpen}
                  onClose={() => setIsModalNegoOpen(false)}
                  data={fakeData}
                />

                {/* Boutons swipe */}
                <div className="flex justify-center gap-6 w-full absolute z-20 bottom-[120px]">
                  <button
                    onClick={() => handleSwipe("left")}
                    className="bg-red-500 hover:bg-red-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
                  >
                    &#10006;
                  </button>
                  <button
                    onClick={() => {
                      setIsModalNegoOpen(true);
                    }}
                    className="bg-green-500 hover:bg-green-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
                  >
                    &#10084;
                  </button>
                </div>

                {/* Infos hôtel */}
                <div className="flex flex-col justify-center h-36 relative z-10 p-4 bg-black/60 backdrop-blur-md rounded-t-2xl mt-auto">
                  <h3 className="text-2xl font-semibold text-center">
                    {hotel.name}
                  </h3>
                  <p className="text-center text-gray-200">{hotel.price}</p>
                </div>
              </motion.div>
            ) : null
          )}
      </AnimatePresence>

      {cards.length === 0 && (
        <div className="absolute text-center text-gray-600">
          Aucun autre bien à afficher 👋
        </div>
      )}
    </div>
  );
}

import React, { useState, useRef, useEffect } from "react";
import TinderCard from "react-tinder-card";

export default function Card({ onSwipe, geocodeAddress }) {
  const peopleList = [
    {
      name: "Hôtel Aquabella",
      imageUrl:
        "https://www.hotelescenter.es/wp-content/blogs.dir/1601/files/home//header-home-mb.jpg",
      price: "150€/nuit",
      adresse: "2 Rue des Étuves, 13100 Aix-en-Provence",
    },
    {
      name: "Villa Serena",
      imageUrl:
        "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/32/5a/76/escale-oceania-aix-en.jpg?w=1200&h=-1&s=1",
      price: "220€/nuit",
      adresse: "270 Av. Calendal, 13600 La Ciotat",
    },
    {
      name: "Résidence Soleil",
      imageUrl:
        "https://media.istockphoto.com/id/104731717/fr/photo/centre-de-vill%C3%A9giature-de-luxe.jpg?s=612x612&w=0&k=20&c=qn-Ugr3N5J_JBKZttni3vimlfBOd52jWG3FouENXye0=",
      price: "95€/nuit",
      adresse: "4 rue du château d’eau 11120 Ginestas",
    },
    {
      name: "Le Palais Bleu",
      imageUrl:
        "https://img.freepik.com/photos-gratuite/belle-piscine-exterieure-luxe-dans-hotel-complexe_74190-7433.jpg?semt=ais_hybrid&w=740",
      price: "310€/nuit",
      adresse: "12 Rue Richebourg, 25000 Besançon",
    },
  ];

  const [currentIndex, setCurrentIndex] = useState(0);
  const tinderCardRef = useRef();

  const currentCard = peopleList[currentIndex];

  const swiped = (direction, name) => {
    console.log(`Swipe ${direction} sur ${name}`);
    onSwipe(currentCard);
  };

  const outOfFrame = (name) => {
    console.log(`${name} a quitté l'écran`);
    setTimeout(() => {
      setCurrentIndex((prevIndex) =>
        prevIndex < peopleList.length - 1 ? prevIndex + 1 : prevIndex
      );
    }, 100);
  };

  // Effectuer le géocodage dès le changement de la carte courante
  useEffect(() => {
    if (currentCard && currentCard.adresse) {
      geocodeAddress(currentCard.adresse);
    }
  }, [currentCard, geocodeAddress]);

  return (
    <div className="relative w-full h-[85vh] max-w-md mx-auto flex items-center justify-center">
      {currentCard ? (
        <TinderCard
          ref={tinderCardRef}
          key={currentCard.name}
          className="swipe absolute w-full h-full"
          preventSwipe={["up", "down"]}
          onSwipe={(dir) => swiped(dir, currentCard.name)}
          onCardLeftScreen={() => outOfFrame(currentCard.name)}
        >
          <div
            className="relative text-white rounded-2xl overflow-hidden shadow-lg w-full h-full flex flex-col justify-between"
            style={{
              backgroundImage: `url(${currentCard.imageUrl})`,
              backgroundSize: "cover",
              backgroundPosition: "center",
            }}
          >
            <div className="absolute top-4 right-4 bg-blue-main text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm cursor-pointer shadow-md z-10">
              i
            </div>

            <div className="flex justify-center gap-6 w-full absolute z-20 bottom-[120px]">
              <button
                onClick={() => tinderCardRef.current.swipe("left")}
                className="bg-red-500 hover:bg-red-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
              >
                &#10006;
              </button>
              <button
                onClick={() => tinderCardRef.current.swipe("right")}
                className="bg-green-spotify hover:bg-green-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
              >
                &#10084;
              </button>
            </div>

            <div className="flex flex-col justify-center h-36 relative z-10 p-4 bg-black/60 backdrop-blur-md rounded-t-2xl mt-auto">
              <h3 className="text-2xl font-semibold text-center">
                {currentCard.name}
              </h3>
              <p className="text-center text-gray-200">{currentCard.price}</p>
            </div>
          </div>
        </TinderCard>
      ) : (
        <div className="text-center text-gray-600">
          Aucun autre bien à afficher 👀
        </div>
      )}
    </div>
  );
}

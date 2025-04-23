import React, { useState, useRef } from "react";
import TinderCard from "react-tinder-card";

export default function Card() {
  const peopleList = [
    {
      name: "Hôtel Aquabella",
      imageUrl:
        "https://www.hotelescenter.es/wp-content/blogs.dir/1601/files/home//header-home-mb.jpg",
      price: "150€/nuit",
    },
    {
      name: "Villa Serena",
      imageUrl:
        "https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/32/5a/76/escale-oceania-aix-en.jpg?w=1200&h=-1&s=1",
      price: "220€/nuit",
    },
    {
      name: "Résidence Soleil",
      imageUrl:
        "https://media.istockphoto.com/id/104731717/fr/photo/centre-de-vill%C3%A9giature-de-luxe.jpg?s=612x612&w=0&k=20&c=qn-Ugr3N5J_JBKZttni3vimlfBOd52jWG3FouENXye0=",
      price: "95€/nuit",
    },
    {
      name: "Le Palais Bleu",
      imageUrl:
        "https://img.freepik.com/photos-gratuite/belle-piscine-exterieure-luxe-dans-hotel-complexe_74190-7433.jpg?semt=ais_hybrid&w=740",
      price: "310€/nuit",
    },
  ];

  const [currentIndex, setCurrentIndex] = useState(0);
  const currentCard = peopleList[currentIndex];
  const tinderCardRef = useRef(null);

  const swiped = (direction, name) => {
    console.log(`Swipe ${direction} sur ${name}`);
  };

  const outOfFrame = (name) => {
    console.log(`${name} a quitté l'écran`);
    setTimeout(() => {
      setCurrentIndex((prevIndex) => prevIndex + 1);
    }, 100); // délai très court pour une transition fluide
  };

  // Fonction pour effectuer le swipe à gauche
  const handleLeftSwipe = () => {
    tinderCardRef.current.swipe("left");
  };

  // Fonction pour effectuer le swipe à droite
  const handleRightSwipe = () => {
    tinderCardRef.current.swipe("right");
  };

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
            {/* Icône info */}
            <div className="absolute top-4 right-4 bg-blue-main text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm cursor-pointer shadow-md z-10">
              i
            </div>

            {/* Boutons de swipe */}
            <div className="flex justify-center gap-6 w-full absolute z-20 bottom-[120px]">
              <button
                onClick={handleLeftSwipe}
                className="bg-red-500 hover:bg-red-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
              >
                &#10006;
              </button>
              <button
                onClick={handleRightSwipe}
                className="bg-green-spotify hover:bg-green-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
              >
                &#10084;
              </button>
            </div>

            {/* Détails */}
            <div className="flex flex-col justify-center h-36 relative z-1O p-4 bg-black/60 backdrop-blur-md rounded-t-2xl mt-auto">
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

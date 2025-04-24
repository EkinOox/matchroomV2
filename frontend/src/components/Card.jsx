import React, { useState, useRef, useMemo } from "react";
import TinderCard from "react-tinder-card";
import { motion, AnimatePresence } from "framer-motion";

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

  const [currentIndex, setCurrentIndex] = useState(peopleList.length - 1);

  const cardRefs = useMemo(
    () => Array(peopleList.length).fill(0).map(() => React.createRef()),
    []
  );

  const swiped = (direction, name, index) => {
    console.log(`Swipe ${direction} sur ${name}`);
    setCurrentIndex(index - 1);
  };

  const outOfFrame = (name) => {
    console.log(`${name} a quitté l'écran`);
  };

  const swipe = async (dir) => {
    if (currentIndex >= 0 && cardRefs[currentIndex].current) {
      await cardRefs[currentIndex].current.swipe(dir);
    }
  };

  return (
    <div className="relative w-full h-[85vh] max-w-md mx-auto flex items-center justify-center overflow-hidden">
      <AnimatePresence>
        {peopleList.map((person, index) => (
          index === currentIndex && (
            <TinderCard
              ref={cardRefs[index]}
              key={person.name}
              className="swipe absolute w-full h-full"
              preventSwipe={["up", "down"]}
              onSwipe={(dir) => swiped(dir, person.name, index)}
              onCardLeftScreen={() => outOfFrame(person.name)}
            >
              <motion.div
                key={person.name}
                initial={{ scale: 0.95, opacity: 0 }}
                animate={{ scale: 1, opacity: 1 }}
                exit={{ scale: 0.7, opacity: 0 }}
                transition={{ duration: 0.3 }}
                className="relative text-white rounded-2xl overflow-hidden shadow-lg w-full h-full flex flex-col justify-between"
                style={{
                  backgroundImage: `url(${person.imageUrl})`,
                  backgroundSize: "cover",
                  backgroundPosition: "center",
                }}
                drag="x"
                dragConstraints={{ left: 0, right: 0 }}
                dragElastic={0.2}
                whileDrag={{ rotate: (event, info) => info.offset.x / 20 }}
              >
                {/* Icône info */}
                <div className="absolute top-4 right-4 bg-blue-main text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm cursor-pointer shadow-md z-10">
                  i
                </div>

                {/* Boutons de swipe */}
                <div className="flex justify-center gap-6 w-full absolute z-20 bottom-[120px]">
                  <button
                    onClick={() => swipe("left")}
                    className="bg-red-500 hover:bg-red-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
                  >
                    &#10006;
                  </button>
                  <button
                    onClick={() => swipe("right")}
                    className="bg-green-spotify hover:bg-green-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
                  >
                    &#10084;
                  </button>
                </div>

                {/* Détails */}
                <div className="flex flex-col justify-center h-36 relative z-10 p-4 bg-black/60 backdrop-blur-md rounded-t-2xl mt-auto">
                  <h3 className="text-2xl font-semibold text-center">
                    {person.name}
                  </h3>
                  <p className="text-center text-gray-200">{person.price}</p>
                </div>
              </motion.div>
            </TinderCard>
          )
        ))}
      </AnimatePresence>

      {currentIndex < 0 && (
        <div className="absolute text-center text-gray-600">
          Aucun autre bien à afficher 👀
        </div>
      )}
    </div>
  );
}
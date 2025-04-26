import React, { useState, useEffect } from "react";
import { motion, AnimatePresence } from "framer-motion";
import RoomModal from "./RoomModal";
import NegociationModal from "./NegociationModal";
import FavoriteIcon from "@mui/icons-material/Favorite";
import CloseIcon from "@mui/icons-material/Close";

export default function Card({ onSwipe, searchData, onNoHotels }) {
  const [cards, setCards] = useState([]);
  const [swipeDirection, setSwipeDirection] = useState(null);
  const [isAnimating, setIsAnimating] = useState(false);
  const [isRoomModalOpen, setIsRoomModalOpen] = useState(false);
  const [isNegotiationModalOpen, setIsNegotiationModalOpen] = useState(false);

  useEffect(() => {
    if (!searchData?.roomInfo) return;

    const formatted = searchData.roomInfo.map((room) => ({
      ...room,
      price: room.price || "Prix non disponible",
      imageUrl:
        room.folderImage ||
        "https://media.istockphoto.com/id/104731717/fr/photo/centre-de-vill%C3%A9giature-de-luxe.jpg?s=612x612&w=0&k=20&c=qn-Ugr3N5J_JBKZttni3vimlfBOd52jWG3FouENXye0=",
    }));

    setCards(formatted);
  }, [searchData]);

  useEffect(() => {
    if (cards.length > 0 && onSwipe) {
      onSwipe(cards[0]);
    }
  }, [cards, onSwipe]);

  useEffect(() => {
    if (cards.length === 0 && onNoHotels) {
      onNoHotels(true);
    } else if (cards.length > 0 && onNoHotels) {
      onNoHotels(false);
    }
  }, [cards, onNoHotels]);

  const handleSwipe = (direction) => {
    if (!cards.length || isAnimating) return;

    setSwipeDirection(direction);
    setIsAnimating(true);

    if (direction) {
      onSwipe(cards[0]);
    }

    setTimeout(() => {
      setCards((prev) => prev.slice(1));
      setSwipeDirection(null);
      setIsAnimating(false);
    }, 300);
  };

  return (
    <div className="relative w-[40vh] md:w-[50vh] h-[50vh] max-w-full md:max-w-md mx-auto flex items-center justify-center overflow-hidden">
      <AnimatePresence>
        {cards.length > 0 &&
          cards.slice(0, 1).map((hotel) => (
            <motion.div
              key={hotel.name}
              drag="x"
              dragConstraints={{ left: 0, right: 0 }}
              onDragEnd={(e, info) => {
                if (info.offset.x > 100) setIsNegotiationModalOpen(true);
                else if (info.offset.x < -100) handleSwipe("left");
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
              <button
                className="absolute top-2 right-2 w-10 h-10 rounded-full bg-[#e0e0e0] text-black font-bold text-md flex items-center justify-center z-10
    shadow-[2px_2px_15px_#bebebe,-4px_-4px_15px_#ffffff]
    hover:shadow-[inset_4px_4px_8px_#bebebe,inset_-4px_-4px_8px_#ffffff]
    transition-all duration-300 ease-in-out"
                onClick={() => setIsRoomModalOpen(true)}
              >
                i
              </button>

              <RoomModal
                isOpen={isRoomModalOpen}
                onClose={() => setIsRoomModalOpen(false)}
                data={hotel}
              />

              <NegociationModal
                isOpen={isNegotiationModalOpen}
                onClose={() => setIsNegotiationModalOpen(false)}
                data={hotel}
                searchData={searchData}
                handleSwipe={handleSwipe}
              />

              <div className="flex justify-center gap-6 w-full absolute z-20 bottom-[120px]">
                <button
                  onClick={() => handleSwipe("left")}
                  className="flex justify-center items-center bg-red-500 hover:bg-red-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
                >
                  <CloseIcon />
                </button>
                <button
                  onClick={() => setIsNegotiationModalOpen(true)}
                  className="flex justify-center items-center bg-green-500 hover:bg-green-600 text-white rounded-full w-12 h-12 text-2xl shadow-md"
                >
                  <FavoriteIcon />
                </button>
              </div>

              <div className="flex flex-col justify-center h-36 relative z-10 p-4 bg-black/30 backdrop-blur-md rounded-t-2xl mt-auto">
                <h3 className="text-2xl font-semibold text-center">
                  {hotel.name}
                </h3>
                <p className="text-center text-gray-200">
                  {hotel.price} € / Nuits
                </p>
              </div>
            </motion.div>
          ))}
      </AnimatePresence>

      {cards.length === 0 && (
        <div className="absolute text-center text-gray-600">
          Aucun autre bien à afficher 🫢
        </div>
      )}
    </div>
  );
}

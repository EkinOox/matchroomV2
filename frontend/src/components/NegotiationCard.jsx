import React, { useState } from "react";
import RoomModal from "./RoomModal";

const NegotiationCard = ({ negotiation, onUpdate }) => {
  const getStatusStyle = (status) => {
    switch (status) {
      case "accepted":
        return { backgroundColor: "#d4edda" };
      case "refused":
        return { backgroundColor: "#f8d7da" };
      case "counter":
        return { backgroundColor: "#fff3cd" };
      case "confirmed":
        return { backgroundColor: "#93c5fd" };
      default:
        return { backgroundColor: "#f0f0f0" };
    }
  };

  const startDate = new Date(negotiation.startDate).toLocaleDateString("fr-FR");
  const endDate = new Date(negotiation.endDate).toLocaleDateString("fr-FR");

  const handleChange = (e) => {
    const updatedNego = { ...negotiation, status: e.target.value };
    onUpdate(updatedNego);
  };

  const [isRoomModalOpen, setIsRoomModalOpen] = useState(false);

  return (
    <div
      className="flex flex-col md:flex-row items-center bg-gray-100 p-4 rounded-xl shadow-sm"
      style={{ ...getStatusStyle(negotiation.status) }}
    >
      {/* Image + bouton dans un conteneur relatif */}
      <div className="relative mr-4">
        <img
          src={negotiation.room.folderImage}
          alt=""
          className="w-60 h-40 object-cover rounded-lg filter brightness-90"
        />
        <button
          className="absolute top-2 right-2 w-10 h-10 rounded-full bg-[#e0e0e0] text-black font-bold text-md flex items-center justify-center z-10
    shadow-[2px_2px_15px_#bebebe,-4px_-4px_15px_#ffffff]
    hover:shadow-[inset_4px_4px_8px_#bebebe,inset_-4px_-4px_8px_#ffffff]
    transition-all duration-300 ease-in-out"
          onClick={() => setIsRoomModalOpen(true)}
        >
          i
        </button>
      </div>

      <RoomModal
        isOpen={isRoomModalOpen}
        onClose={() => setIsRoomModalOpen(false)}
        data={negotiation.room}
      />

      <div className="flex-1">
        <h3 className="font-bold text-lg text-gray-800">
          {negotiation.room.name} - {negotiation.proposedPrice}€/nuits
        </h3>
        <p className="text-sm text-gray-800">
          💶 Prix initial : {negotiation.room.price}€/nuits
        </p>
        <p className="text-sm text-gray-800">
          📅 Dates du séjour : {startDate} - {endDate}
        </p>
      </div>

      {negotiation.status === "counter" && (
        <div className="flex flex-col gap-1 justify-center items-center">
          <p className="text-lg font-bold text-gray-800">
            Contre offre : {negotiation.counterOffer}€/nuits
          </p>
          <button
            className="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 w-[200px]"
            value="confirmed"
            onClick={handleChange}
          >
            Accepter
          </button>
          <button
            className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 w-[200px]"
            value="refused"
            onClick={handleChange}
          >
            Refuser
          </button>
        </div>
      )}

      {negotiation.status === "accepted" && (
        <div className="flex flex-col gap-1 justify-center items-center">
          <button
            className="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 w-[200px]"
            value="confirmed"
            onClick={handleChange}
          >
            Accepter
          </button>
          <button
            className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 w-[200px]"
            value="refused"
            onClick={handleChange}
          >
            Refuser
          </button>
        </div>
      )}
    </div>
  );
};

export default NegotiationCard;

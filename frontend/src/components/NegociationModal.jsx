import React, { useEffect, useState } from "react";
import { Modal, Box } from "@mui/material";
import confetti from "canvas-confetti";


const NegociationModal = ({ isOpen, onClose, data, searchData }) => {
  const [offer, setOffer] = useState(null);

  const handleSubmit = async (e) => {
    e.preventDefault();
    if (!offer || offer.trim() === "") {
      alert("Veuillez entrer une offre valide.");
      return;
    }

    const token = localStorage.getItem("token");
    const offerNumber = Number(offer);

    const response = await fetch("http://localhost:8000/api/negociations", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify({
        room: String(data.id),
        proposedPrice: offerNumber,
        startDate: searchData.dateDebut,
        endDate: searchData.dateFin
      }),
    });

    const responseData = await response.json();
    console.log(responseData);

    if (!response.ok) {
      throw new Error("Erreur lors de la soumission de l'offre.");
    }

    console.log("Offre soumise :", offer);
    const canvas = document.getElementById('confetti-canvas');
    const myConfetti = confetti.create(canvas, {
      resize: true,
      useWorker: true,
    });

    myConfetti({
      particleCount: 150,
      spread: 170,
      origin: { y: 0.6 },
    });
  }

  return (
    <Modal
      open={isOpen}
      onClose={onClose}
      sx={{
        display: "flex",
        justifyContent: "center",
        alignItems: "center",
        backgroundColor: "rgba(0, 0, 0, 0.5)",
        backdropFilter: "blur(5px)",
      }}
    >
      <Box
        className="absolute bg-white rounded-lg shadow-xl flex p-6 gap-6 flex-col md:flex-row"
        sx={{
          width: "50%",
          height: "50vh",
          overflowY: "auto",
        }}
      >
        <div className="relative w-full md:w-1/2 rounded-xl overflow-hidden">
          <img
            src={data.imageUrl}
            alt={data.name}
            className="w-full h-full object-cover"
          />
          <div className="absolute bottom-0 left-0 w-full bg-black/75 text-white p-4">
            <h3 className="font-bold text-lg">{data.name}</h3>
            <p className="text-sm">Prix initial : {data.price} € / nuits</p>
          </div>
        </div>

        <div className="w-full md:w-1/2 flex flex-col justify-center gap-4">
          <input
            type="number"
            onChange={(e) => setOffer(e.target.value)}
            style={{
              boxShadow: "0px 4px 4px rgba(0, 0, 0, 0.25)",
            }}
            placeholder="Entrez votre offre..."
            className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
            required
          />
          <div className="flex flex-row gap-4">
            <button
              onClick={onClose}
              className="w-full py-3 bg-blue-main text-white font-semibold rounded-lg shadow-md hover:bg-blue-900 transition"
            >
              Annuler
            </button>
            <input
              type="submit"
              className="w-full py-3 bg-blue-main text-white font-semibold rounded-lg shadow-md hover:bg-blue-900 transition cursor-pointer"
              value="Envoyer"
              onClick={handleSubmit}
            />
          </div>
        </div>
      </Box>
    </Modal>
  );
};

export default NegociationModal;

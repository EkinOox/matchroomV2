import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom"; // Import de useNavigate
import Filters from "./Filters";

export default function SearchForm({ onSearch }) {
  const [input, setInput] = useState("");
  const [travelers, setTravelers] = useState("");
  const [startDate, setStartDate] = useState(""); // Date de début
  const [endDate, setEndDate] = useState(""); // Date de fin
  const [selectedCriteria, setSelectedCriteria] = useState([]);
  const [error, setError] = useState("");
  const [result, setResult] = useState(null);
  const navigate = useNavigate(); // Hook pour la redirection

  // Vérifier le token dès que le composant est monté
  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      navigate("/login"); // Redirection vers la page de login si aucun token
    }
  }, [navigate]); // Exécuter uniquement lors du montage du composant

  const handleToggleCriterion = (criterion) => {
    setSelectedCriteria((prev) =>
      prev.includes(criterion)
        ? prev.filter((c) => c !== criterion)
        : [...prev, criterion]
    );
  };

  // Fonction pour récupérer les coordonnées depuis une adresse (via Google Maps API)
  const fetchCoordinates = async (address) => {
    const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(
      address
    )}&key=AIzaSyCeQmOns_lk-EoLjb3JhoLs3hkrxzNl8dc&format=json&limit=1`;

    const response = await fetch(url);
    const data = await response.json();

    if (!data.results || data.results.length === 0) {
      throw new Error("Adresse non trouvée.");
    }

    const location = data.results[0].geometry.location;

    return {
      latitude: location.lat,
      longitude: location.lng,
    };
  };

  // Fonction de validation des dates
  const validateDates = () => {
    const today = new Date().toISOString().split("T")[0];
    if (startDate && startDate < today) {
      setError("La date de début ne peut pas être antérieure à aujourd'hui.");
      return false;
    }
    if (endDate && startDate >= endDate) {
      setError("La date de début doit précéder la date de fin.");
      return false;
    }
    setError("");
    return true;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    // Vérification du token (avant de procéder à la recherche)
    const token = localStorage.getItem("token");
    if (!token) {
      navigate("/login"); // Redirection vers la page de login si aucun token
      return;
    }

    if (
      input.trim() !== "" &&
      travelers > 0 &&
      selectedCriteria.length > 0 &&
      validateDates()
    ) {
      try {
        const { latitude, longitude } = await fetchCoordinates(input);

        console.log("Coordonnées récupérées :", result);

        // Requête locale pour obtenir les résultats (optionnel si déjà fait côté parent)
        const response = await fetch("http://localhost:8000/api/rooms/search", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
          },
          body: JSON.stringify({
            longitude: longitude,
            latitude: latitude,
            NbVoyageur: parseInt(travelers, 10),
            critere: selectedCriteria,
          }),
        });

        if (!response.ok) {
          throw new Error("Erreur lors de la recherche.");
        }

        const data = await response.json();
        setResult(data);
        setError("");

        onSearch({
          lat: latitude,
          lng: longitude,
          travelers: travelers,
          criteria: selectedCriteria,
          result: data.member,
          dateDebut: startDate,
          dateFin: endDate
        });
      } catch (err) {
        setError(err.message);
      }
    } else {
      setError(
        "Tous les champs doivent être remplis et les dates doivent être valides."
      );
    }
  };

  useEffect(() => {
    if (result !== null) {
      console.log("Résultat mis à jour :", result);
    }
  }, [result]);

  return (
    <form
      className="w-full max-w-3xl mx-auto p-6 flex flex-col gap-4"
      onSubmit={handleSubmit}
    >
      <label>Adresse de destination :</label>
      <input
        type="text"
        placeholder="Entrez une adresse..."
        value={input}
        onChange={(e) => setInput(e.target.value)}
        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
        required
      />

      <label>Nombre de Voyageurs :</label>
      <input
        type="number"
        placeholder="Nombre de voyageurs..."
        value={travelers}
        onChange={(e) => setTravelers(e.target.value)}
        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
        required
      />
      <div className="flex gap-4">
        <div className="flex-col w-full">
          <label>Date de début :</label>
          <input
            type="date"
            value={startDate}
            onChange={(e) => setStartDate(e.target.value)}
            className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
            required
          />
        </div>
        <div className="flex-col w-full">
          <label>Date de fin :</label>
          <input
            type="date"
            value={endDate}
            onChange={(e) => setEndDate(e.target.value)}
            className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
            required
          />
        </div>
      </div>
      {error && <div className="text-red-600 text-sm mt-2">{error}</div>}

      <Filters
        selectedCriteria={selectedCriteria}
        onToggle={handleToggleCriterion}
      />

      <input
        type="submit"
        className="w-full py-3 bg-blue-main text-white font-semibold rounded-lg shadow-md hover:bg-blue-900 transition cursor-pointer"
        value="Rechercher"
      />
    </form>
  );
}

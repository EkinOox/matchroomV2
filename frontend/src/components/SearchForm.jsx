import React, { useState } from "react";
import Filters from "./Filters";

export default function SearchForm({ onSearch }) {
  const [input, setInput] = useState("");
  const [travelers, setTravelers] = useState("");
  const [startDate, setStartDate] = useState("");
  const [endDate, setEndDate] = useState("");
  const [selectedCriteria, setSelectedCriteria] = useState([]);
  const [error, setError] = useState("");

  const handleToggleCriterion = (criterion) => {
    setSelectedCriteria((prev) =>
      prev.includes(criterion)
        ? prev.filter((c) => c !== criterion)
        : [...prev, criterion]
    );
  };

  const validateDates = () => {
    const today = new Date().toISOString().split("T")[0]; // Date au format yyyy-mm-dd
    if (startDate < today) {
      setError(
        "La date de début ne peut pas être antérieure à la date actuelle."
      );
      return false;
    }
    if (endDate && startDate >= endDate) {
      setError("La date de début doit être inférieure à la date de fin.");
      return false;
    }
    setError("");
    return true;
  };

  const handleSubmit = (e) => {
    e.preventDefault();

    if (input.trim() !== "" && validateDates()) {
      onSearch({
        address: input,
        travelers,
        startDate,
        endDate,
        criteria: selectedCriteria,
      });
    }
  };

  return (
    <form
      className="w-full max-w-3xl mx-auto p-6 flex flex-col gap-4"
      onSubmit={handleSubmit}
    >
    <label> Adresse de destination :</label>
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
      <div className="flex flex-col sm:flex-row gap-4">
        <div className="flex flex-col w-full">
          <label>Date de Début</label>
          <input
            type="date"
            value={startDate}
            onChange={(e) => setStartDate(e.target.value)}
            className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
            required
          />
        </div>
        <div className="flex flex-col w-full">
        <label>Date de Fin</label>
          <input
            type="date"
            value={endDate}
            onChange={(e) => setEndDate(e.target.value)}
            className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
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

import React, { useState } from "react";
import Filters from "./Filters";

export default function SearchForm({ onSearch }) {
  const [input, setInput] = useState('');
  const [travelers, setTravelers] = useState('');
  const [startDate, setStartDate] = useState('');
  const [endDate, setEndDate] = useState('');
  const [selectedCriteria, setSelectedCriteria] = useState([]);

  const handleToggleCriterion = (criterion) => {
    setSelectedCriteria((prev) =>
      prev.includes(criterion)
        ? prev.filter((c) => c !== criterion)
        : [...prev, criterion]
    );
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    if (input.trim() !== '') {
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
      <input
        type="text"
        placeholder="Entrez une adresse..."
        value={input}
        onChange={(e) => setInput(e.target.value)}
        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
        required
      />
      <input
        type="number"
        placeholder="Nombre de voyageurs..."
        value={travelers}
        onChange={(e) => setTravelers(e.target.value)}
        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
        required
      />
      <div className="flex flex-col sm:flex-row gap-4">
        <input
          type="date"
          value={startDate}
          onChange={(e) => setStartDate(e.target.value)}
          className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
          required
        />
        <input
          type="date"
          value={endDate}
          onChange={(e) => setEndDate(e.target.value)}
          className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
          required
        />
      </div>
      <Filters selectedCriteria={selectedCriteria} onToggle={handleToggleCriterion} />
      <input
        type="submit"
        className="w-full py-3 bg-blue-main text-white font-semibold rounded-lg shadow-md hover:bg-blue-900 transition cursor-pointer"
        value="Rechercher"
      />
    </form>
  );
}

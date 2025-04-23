// src/components/SearchForm.jsx
import React from "react";
import Filters from "./Filters";

export default function SearchForm() {
  const inputShadow = {
    boxShadow: '0px 4px 4px rgba(0, 0, 0, 0.25)',
  };

  return (
    <form
      className="w-full max-w-3xl mx-auto p-6 flex flex-col gap-4"
      method="POST"
      action={"/search"}
    >
      <input
        type="text"
        placeholder="Entrez une adresse..."
        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
        style={inputShadow}
        required
      />
      <input
        type="number"
        placeholder="Nombre de voyageur..."
        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
        style={inputShadow}
        required
      />
      <div className="flex flex-col sm:flex-row gap-4">
        <input
          type="date"
          className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
          style={inputShadow}
          required
        />
        <input
          type="date"
          className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
          style={inputShadow}
          required
        />
      </div>
      <Filters />
      <input
        type="submit"
        className="w-full py-3 bg-blue-main text-white font-semibold rounded-lg shadow-md hover:bg-blue-900 transition"
        value="Rechercher"
      />
    </form>
  );
}

// src/components/SearchForm.jsx
import React from 'react';

export default function SearchForm() {
  return (
    <form className="w-full max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md flex flex-col gap-4">
      <input
        type="text"
        placeholder="Entrez une adresse..."
        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
      />
      <input
        type="number"
        placeholder="Combien de personne..."
        className="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
      />
      <div className="flex flex-col sm:flex-row gap-4">
        <input
          type="date"
          className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
        />
        <input
          type="date"
          className="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-main"
        />
      </div>
    </form>
  );
}

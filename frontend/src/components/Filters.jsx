// src/components/Filters.jsx
import React from 'react';

const criteria = ['Piscine', 'Restaurant', 'Wifi', 'Climatisation', 'Lit simple', 'Lit double'];

export default function Filters() {
  return (
    <div className="bg-white p-4 rounded-xl shadow-md w-full max-w-3xl mx-auto">
      <h3 className="text-lg font-semibold text-blue-main mb-4">Vos critères :</h3>
      <div className="flex flex-wrap gap-3">
        {criteria.map((crit, idx) => (
          <button
            key={idx}
            className="px-4 py-2 rounded-full border border-blue-main text-blue-main hover:bg-blue-main hover:text-white transition duration-200"
          >
            {crit}
          </button>
        ))}
      </div>
    </div>
  );
}

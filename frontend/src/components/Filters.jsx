// src/components/Filters.jsx
import React from 'react';

const criteria = ['Piscine', 'Restaurant', 'Wifi', 'Climatisation', 'Lit simple', 'Lit double'];

export default function Filters() {
  return (
    <div className="p-4 rounded-xl w-full max-w-3xl mx-auto">
      <h3 className="text-3xl font-semibold text-blue-main mb-4">Vos critères :</h3>
      <div className="flex flex-wrap gap-3">
        {criteria.map((crit, idx) => (
          <button
            key={idx}
            className="px-4 py-2 rounded-lg border border-blue-main text-blue-main hover:bg-blue-main hover:text-white transition duration-200"
          >
            {crit}
          </button>
        ))}
      </div>
    </div>
  );
}

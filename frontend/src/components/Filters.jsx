// src/components/Filters.jsx
import React from 'react';

const criteriaList = ['Piscine', 'Restaurant', 'Wifi', 'Climatisation', 'Lit simple', 'Lit double'];

export default function Filters({ selectedCriteria, onToggle }) {
  return (
    <div className="p-4 rounded-xl w-full max-w-3xl mx-auto">
      <h3 className="text-3xl font-semibold text-blue-main mb-4">Vos critères :</h3>
      <div className="flex flex-wrap gap-3">
        {criteriaList.map((crit, idx) => {
          const isSelected = selectedCriteria.includes(crit.toLowerCase());
          return (
            <button
              key={idx}
              type="button"
              className={`px-4 py-2 rounded-lg border transition duration-200
                ${isSelected
                  ? 'bg-blue-main text-white border-blue-main'
                  : 'border-blue-main text-blue-main hover:bg-blue-main hover:text-white'}
              `}
              onClick={() => onToggle(crit.toLowerCase())}
            >
              {crit}
            </button>
          );
        })}
      </div>
    </div>
  );
}

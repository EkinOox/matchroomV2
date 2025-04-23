// src/components/Card.jsx
import React from 'react';

export default function Card() {
  return (
    <div className="relative bg-white rounded-2xl overflow-hidden shadow-lg w-full max-w-md">
      <img
        src="https://via.placeholder.com/500x300"
        alt="hotel"
        className="w-full h-60 object-cover"
      />

      {/* Icône info */}
      <div className="absolute top-4 right-4 bg-blue-main text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm cursor-pointer shadow-md">
        i
      </div>

      {/* Détails */}
      <div className="p-4 flex flex-col items-center gap-2">
        {/* Boutons */}
        <div className="flex justify-center gap-6 my-2">
          <button className="bg-red-500 hover:bg-red-600 text-white rounded-full w-12 h-12 text-2xl shadow-md">
            &#10006;
          </button>
          <button className="bg-green-500 hover:bg-green-600 text-white rounded-full w-12 h-12 text-2xl shadow-md">
            &#10084;
          </button>
        </div>

        <h3 className="text-xl font-semibold text-blue-main">Hôtel Aquabella</h3>
        <p className="text-gray-700">150€/nuit</p>
      </div>
    </div>
  );
}

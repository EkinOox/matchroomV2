// src/components/Card.jsx
import React from 'react';

export default function Card() {
  return (
    <div
      className="relative bg-blue-main text-white rounded-2xl overflow-hidden shadow-lg w-full max-w-md h-full flex flex-col justify-between"
      style={{
        backgroundImage: 'url("https://www.hotelescenter.es/wp-content/blogs.dir/1601/files/home//header-home-mb.jpg")',
        backgroundSize: 'cover',
        backgroundPosition: 'center',
      }}
    >
      {/* Icône info */}
      <div className="absolute top-4 right-4 bg-blue-main text-white rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm cursor-pointer shadow-md">
        i
      </div>
      <div className="flex justify-center gap-6 w-full absolute z-10 bottom-[105px] ">
          <button className="bg-red-500 hover:bg-red-600 text-white rounded-full w-12 h-12 text-2xl shadow-md">
            &#10006;
          </button>
          <button className="bg-green-spotify hover:bg-green-600 text-white rounded-full w-12 h-12 text-2xl shadow-md">
            &#10084;
          </button>
        </div>
      {/* Détails */}
      <div className="flex flex-col justify-center content-center h-32 relative z-1 p-4 bg-black/50 backdrop-blur-sm rounded-t-2xl mt-auto">
        {/* Boutons */}
      

        <h3 className="text-xl font-semibold text-white text-center">Hôtel Aquabella</h3>
        <p className="text-center text-gray-200">150€/nuit</p>
      </div>
    </div>
  );
}

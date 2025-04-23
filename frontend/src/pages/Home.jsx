// src/pages/Home.jsx
import React from 'react';
import Navbar from '../components/Navbar';
import Card from '../components/CardV2';
import SearchForm from '../components/SearchForm';
import Map from '../components/map/Map';

export default function Home() {
  return (
    <div className="min-h-screen bg-[#F8F8F8]">
      <Navbar />

      <div className="flex flex-col lg:flex-row gap-6 px-6 py-8 max-w-7xl mx-auto">
        {/* Partie gauche : HotelCard */}
        <div className="flex-1">
          <Card />
        </div>

        {/* Partie droite : SearchForm + Filters + Bouton + Map */}
        <div className="flex-1 space-y-6">
          <SearchForm />
          <Map />
        </div>
      </div>
    </div>
  );
}

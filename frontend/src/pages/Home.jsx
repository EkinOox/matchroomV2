import React from 'react';
import Navbar from '../components/Navbar.jsx';
import HotelCard from '../components/HotelCard.jsx';
import SearchForm from '../components/SearchForm.jsx';
import Filters from '../components/Filters.jsx';
import Map from '../components/Map.jsx';

export default function Home() {
  return (
    <div className="home-page">
      <Navbar />
      <div className="main-content">
        <HotelCard />
        <div className="right-panel">
          <SearchForm />
          <Filters />
          <button className="search-btn">Rechercher</button>
          <Map />
        </div>
      </div>
    </div>
  );
}
import React from 'react';
import Navbar from '../../components/Navbar';
import HotelCard from '../../components/HotelCard';
import SearchForm from '../../components/SearchForm';
import Filters from '../../components/Filters';
import Map from '../../components/Map';
import '../assets/css/Home.css';

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
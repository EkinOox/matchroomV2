// src/pages/Home.jsx
import React, { useState, useEffect } from "react";
import Navbar from "../components/Navbar";
import Card from "../components/Card";
import SearchForm from "../components/SearchForm";
import Map from "../components/map/Map";

const geocodeAddress = async (address) => {
  const res = await fetch(
    `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(
      address
    )}&key=AIzaSyCeQmOns_lk-EoLjb3JhoLs3hkrxzNl8dc`
  );
  const data = await res.json();
  if (data.status === "OK") {
    return data.results[0].geometry.location;
  } else {
    console.error("Erreur de géocodage :", data.status);
    return null;
  }
};

export default function Home() {
  const [searchData, setSearchData] = useState(null);
  const [userCoords, setUserCoords] = useState(null);
  const [selectedHotel, setSelectedHotel] = useState(null);
  const [hotelCoords, setHotelCoords] = useState(null);
  const [searchDone, setSearchDone] = useState(false);

  const handleSearch = async (formData) => {
    const coords = await geocodeAddress(formData.address);

    if (!coords) {
      console.error("Impossible de récupérer les coordonnées GPS");
      return;
    }

    const fullSearchData = {
      address: formData.address,
      longitude: coords.lng.toString(),
      latitude: coords.lat.toString(),
      NbVoyageur: parseInt(formData.travelers, 10),
      dateDebut: new Date(formData.startDate).toLocaleDateString("fr-FR"),
      dateFin: new Date(formData.endDate).toLocaleDateString("fr-FR"),
      critere: formData.criteria, // 💥 récupérés dynamiquement
    };

    console.log("✅ Données JSON prêtes à être envoyées :", fullSearchData);

    setSearchData(fullSearchData);
    setSearchDone(true);
  };

  useEffect(() => {
    if (searchData?.address) {
      geocodeAddress(searchData.address).then((coords) => {
        console.log("✅ Coordonnées utilisateur :", coords);
        setUserCoords(coords);
      });
    }
  }, [searchData]);
  

  useEffect(() => {
    if (selectedHotel?.adresse) {
      geocodeAddress(selectedHotel.adresse).then(setHotelCoords);
    }
  }, [selectedHotel]);

  return (
    <div className="min-h-screen bg-[#F8F8F8]">
      <Navbar />

      <div className="flex flex-col lg:flex-row gap-6 px-6 py-8 max-w-7xl mx-auto">
        {/* Partie gauche : soit image de base, soit cartes à swiper */}
        <div className="flex-1 z-10 flex items-center justify-center">
          {searchDone ? (
            <Card
            onSwipe={(hotel) => {
              setSelectedHotel(hotel);
            }}
              searchData={searchData}
              geocodeAddress={geocodeAddress}
            />
          ) : (
            <img
              src="https://app-staging.matchroom.io/images/search_header_banner.png"
              alt="Voyagez avec nous"
              className="rounded-xl shadow-md w-full max-w-[40rem]"
            />
          )}
        </div>

        {/* Partie droite : formulaire + carte */}
        <div className="flex-1 space-y-6">
          <SearchForm onSearch={handleSearch} />
          <Map origin={userCoords} destination={hotelCoords} />
        </div>
      </div>
    </div>
  );
}

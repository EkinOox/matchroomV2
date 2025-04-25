import React, { useState } from "react";
import Navbar from "../components/Navbar";
import Card from "../components/Card";
import SearchForm from "../components/SearchForm";
import Map from "../components/map/Map";
import { Globe } from "../components/magicui/globe";

export default function Home() {
  const [formData, setFormData] = useState(null); // Données brutes du formulaire
  const [searchData, setSearchData] = useState(null); // Données de recherche à envoyer à l'API
  const [userCoords, setUserCoords] = useState(null); // Coordonnées de l'utilisateur
  const [hotelCoords, setHotelCoords] = useState(null); // Coordonnées de l'hôtel
  const [selectedHotel, setSelectedHotel] = useState(null); // Hôtel sélectionné
  const [searchDone, setSearchDone] = useState(false); // Indicateur de recherche terminée
  const [hasHotels, setHasHotels] = useState(true); // Indicateur de présence d'hôtels

  // Fonction appelée depuis SearchForm
  const handleSearch = async (formData) => {
    if (!formData) return;

    const coords = {
      lat: parseFloat(formData.lat),
      lng: parseFloat(formData.lng),
    };

    const Hotelcoords = {
      lat: parseFloat(formData.result[0]?.hotel.latitude),
      lng: parseFloat(formData.result[0]?.hotel.longitude),
    };

    setUserCoords(coords);
    setHotelCoords(Hotelcoords);

    const fullSearchData = {
      longitude: coords.lng.toString(),
      latitude: coords.lat.toString(),
      NbVoyageur: parseInt(formData.travelers, 10),
      critere: formData.criteria,
      roomInfo: formData.result,
      dateDebut: formData.dateDebut,
      dateFin: formData.dateFin
    };

    setSearchData(fullSearchData);
    setSearchDone(true);
  };

  // Quand on sélectionne un autre hôtel
  const handleHotelSelection = (hotel) => {
    if (selectedHotel?.hotel?.name === hotel?.hotel?.name) return; // Éviter la sélection de l'hôtel déjà sélectionné

    const hotelCoords = {
      lat: parseFloat(hotel.hotel.latitude),
      lng: parseFloat(hotel.hotel.longitude),
    };
    
    setSelectedHotel(hotel);
    setHotelCoords(hotelCoords);
  };

  const handleNoHotels = (noHotels) => {
    setHasHotels(!noHotels); // Mise à jour de l'état en fonction de la présence d'hôtels
  };
  
  return (
    <div className="min-h-screen bg-[#F8F8F8]">
      <Navbar />

      <div className="flex flex-col lg:flex-row gap-6 px-6 py-8 max-w-7xl mx-auto">
        <div className="flex-1 flex-col z-10 flex items-center justify-center">
          {searchDone ? (
            <>
              <Card
                onSwipe={(hotel) => handleHotelSelection(hotel)}
                searchData={searchData}
                onNoHotels={handleNoHotels}
              />
              {/* Affiche la carte uniquement si un hôtel est sélectionné ou si des hôtels sont disponibles */}
              {hasHotels && (
                <Map origin={userCoords} destination={hotelCoords} />
              )}
            </>
          ) : (
            <div className="relative w-full h-[100vh] max-w-md mx-auto flex items-center justify-center overflow-hidden">
              <div className="absolute inset-0 flex items-center justify-center">
                <Globe />
              </div>
              <div className="absolute inset-0 bg-gradient-to-t from-[#F8F8F8] to-transparent opacity-50" />
              <h1 className="text-2xl font-bold text-center text-gray-800 z-20">
                Matchez avec votre prochaine destination grâce à MatchRoom !
              </h1>
            </div>
          )}
        </div>

        <div className="flex-1 space-y-6">
          <SearchForm onSearch={handleSearch} />
        </div>
      </div>
    </div>
  );
}

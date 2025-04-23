import Navbar from '../components/Navbar';
import { useEffect, useState } from 'react';
import Tabs from '../components/Tabs';
import HotelCard from '../components/HotelCard';
import { fetchHotels } from '../api/hotels';

const Negotiations = () => {
  const [status, setStatus] = useState('pending');
  const [hotels, setHotels] = useState([]);

  useEffect(() => {
    fetchHotels(status)
      .then(setHotels)
      .catch(console.error);
  }, [status]);

  return (
    <div className="min-h-screen bg-[#F8F8F8]">
      <Navbar />
    <div className="min-h-screen bg-gray-100 flex justify-center items-start py-12 px-4">
      <div className="w-full max-w-4xl bg-white rounded-2xl shadow-md p-6">
        {/* En-tête */}
        <div className="flex justify-between items-center mb-6">
          <h1 className="text-2xl font-bold text-gray-800">Négociations</h1>
          <span className="text-sm text-gray-500">Menu</span>
        </div>

        {/* Onglets */}
        <Tabs active={status} onChange={setStatus} />

        {/* Liste des hôtels */}
        <div className="mt-6 space-y-6">
          {hotels.length > 0 ? (
            hotels.map((hotel) => (
              <HotelCard
                key={hotel.id}
                name={hotel.name}
                price={hotel.price}
                imageUrl={hotel.imageUrl}
              />
            ))
          ) : (
            <p className="text-center text-gray-500">Aucun hôtel pour cet onglet.</p>
          )}
        </div>
      </div>
    </div>
    </div>
  );
};

export default Negotiations;

import Navbar from '../components/Navbar';
import { useEffect, useState } from 'react';
import Tabs from '../components/NegotiationTabs';
import { fetchHotels } from '../api/hotels';
import NegotiationCard from '../components/NegotiationCard';
import NegotiationTabs from '../components/NegotiationTabs';

const Negotiations = () => {
  const [status, setStatus] = useState('pending');
  const [negociations, setNegociations] = useState([]);

  const negociationSet = [
    {
      id: 1,
      status: 'pending',
      proposed_price: 120,
      counter_offer: 0,
      room: {
        name: "Room 1",
        price: 150,
        folder_image: "",
        capacity: 2
      }
    },
    {
      id: 2,
      status: 'pending',
      proposed_price: 100,
      counter_offer: 0,
      room: {
        name: "Room 2",
        price: 200,
        folder_image: "",
        capacity: 1
      }
    },
    {
      id: 3,
      status: 'approved',
      proposed_price: 95,
      counter_offer: 0,
      room: {
        name: "Room 3",
        price: 100,
        folder_image: "",
        capacity: 4
      }
    },
    {
      id: 4,
      status: 'approved',
      proposed_price: 180,
      counter_offer: 0,
      room: {
        name: "Room 4",
        price: 195,
        folder_image: "",
        capacity: 1
      }
    },
    {
      id: 5,
      status: 'rejected',
      proposed_price: 45,
      counter_offer: 0,
      room: {
        name: "Room 5",
        price: 100,
        folder_image: "",
        capacity: 1
      }
    },
    {
      id: 6,
      status: 'rejected',
      proposed_price: 80,
      counter_offer: 0,
      room: {
        name: "Room 6",
        price: 100,
        folder_image: "",
        capacity: 2
      }
    },
    {
      id: 7,
      status: 'challenged',
      proposed_price: 100,
      counter_offer: 150,
      room: {
        name: "Room 7",
        price: 200,
        folder_image: "",
        capacity: 3
      }
    },
  ]

  useEffect(() => {
    /*fetchHotels(status)
      .then(setHotels)
      .catch(console.error);
    */
    setNegociations(negociationSet.filter(nego => nego.status === status));
  }, [status]);

  return (
    <div className="min-h-screen bg-[#F8F8F8]">
      <Navbar />
    <div className="min-h-screen bg-gray-100 flex justify-center items-start py-12 px-4">
      <div className="w-full max-w-4xl bg-white rounded-2xl shadow-md p-6">
        {/* En-tête */}
        <div className="flex justify-center items-center mb-6">
          <h1 className="text-2xl font-bold text-gray-800">Négociations</h1>
        </div>

        {/* Onglets */}
        <NegotiationTabs active={status} onChange={setStatus} />

        {/* Liste des hôtels */}
        <div className="mt-6 space-y-6">
          {negociations.length > 0 ? (
            negociations.map((nego) => (
              <NegotiationCard
                key={nego.id}
                negotiation={nego}
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

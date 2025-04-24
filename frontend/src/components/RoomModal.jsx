import React from 'react';
import HotelIcon from '@mui/icons-material/Hotel';
import PoolIcon from '@mui/icons-material/Pool';
import RestaurantIcon from '@mui/icons-material/Restaurant';
import NetworkWifiIcon from '@mui/icons-material/NetworkWifi';
import BedIcon from '@mui/icons-material/Bed';
import HvacIcon from '@mui/icons-material/Hvac';

const iconMap = {
    'Piscine': <PoolIcon />,
    'Restaurant': <RestaurantIcon />,
    'Wifi': <NetworkWifiIcon />,
    'Lit simple': <BedIcon />,
    'Climatisation': <HvacIcon />,
    'Lit double': <HotelIcon />,
  };

const RoomModal = ({ isOpen, onClose, data }) => {
  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div className="bg-white w-8/12 h-4/6 p-12 rounded-lg shadow-lg relative flex">
        <div className="relative bg-gray-100 w-6/12 rounded-xl shadow-sm overflow-hidden">
          <img
            src={data.imageUrl}
            alt={data.name}
            className="w-full h-full object-cover"
          />
          <div className="absolute bottom-0 left-0 w-full bg-black/75 text-white p-8">
            <h3 className="font-bold text-lg tracking-tight">{data.name}</h3>
            <p className="font-bold text-sm tracking-tight">Prix initial : {data.price} € / nuits</p>
          </div>
        </div>

        <div className="w-6/12 px-6 font-bold tracking-tight overflow-y-auto">
          <p className="mb-6">{data.description}</p>
          <div className="space-y-3">
          {data.attribute.map((attr, index) => (
              <div key={index} className="flex items-center gap-3">
                {iconMap[attr] || <HotelIcon />} {/* Fallback */}
                <span className="text-gray-800">{attr}</span>
              </div>
            ))}
          </div>
        </div>

        {/* Bouton de fermeture */}
        <button
          onClick={onClose}
          className="absolute top-4 right-8 text-gray-500 hover:text-black text-2xl"
        >
          &times;
        </button>
      </div>
    </div>
  );
};

export default RoomModal;

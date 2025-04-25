import React from 'react';
import HotelIcon from '@mui/icons-material/Hotel';
import PoolIcon from '@mui/icons-material/Pool';
import RestaurantIcon from '@mui/icons-material/Restaurant';
import NetworkWifiIcon from '@mui/icons-material/NetworkWifi';
import BedIcon from '@mui/icons-material/Bed';
import HvacIcon from '@mui/icons-material/Hvac';
import { Modal, Box } from '@mui/material';

const iconMap = {
  'Piscine': <PoolIcon />,
  'Restaurant': <RestaurantIcon />,
  'Wi-Fi': <NetworkWifiIcon />,
  'Lit simple': <BedIcon />,
  'Climatisation': <HvacIcon />,
  'Lit double': <HotelIcon />,
};

const RoomModal = ({ isOpen, onClose, data }) => {
  console.log("RoomModal data:", data);

  return (
    <Modal 
      open={isOpen} 
      onClose={onClose} 
      sx={{
        backgroundColor: 'rgba(0, 0, 0, 0.5)',
        backdropFilter: 'blur(5px)',
      }}
    >
      <Box
        className="absolute top-1/2 left-1/2 bg-white rounded-lg shadow-xl flex p-6 gap-6 flex-col md:flex-row"
        style={{
          transform: 'translate(-50%, -50%)',
          width: '80%',
          height: "80vh",
          overflowY: 'auto'
        }}
      >
        <div className="relative w-full md:w-1/2 rounded-xl overflow-hidden">
          <img
            src={data.imageUrl}
            alt={data.name}
            className="w-full h-full object-cover"
          />
          <div className="absolute bottom-0 left-0 w-full bg-black/75 text-white p-4">
            <h3 className="font-bold text-lg">{data.name}</h3>
            <p className="text-sm">Prix initial : {data.price} € / nuits</p>
          </div>
        </div>

        <div className="w-full md:w-1/2 flex flex-col gap-4">
          <p>{data.description}</p>
          <div className="space-y-3">
            {data.features.map((feature, index) => (
              <div key={index} className="flex items-center gap-3">
                {iconMap[feature.name] || <HotelIcon />} {/* Affichage de l'ic�ne */}
                <span className="text-gray-800">{feature.name}</span> {/* Affichage du nom */}
              </div>
            ))}
          </div>
        </div>

        <button
          onClick={onClose}
          className="absolute top-4 right-6 text-gray-500 hover:text-black text-2xl"
        >
          &times;
        </button>
      </Box>
    </Modal>
  );
};

export default RoomModal;

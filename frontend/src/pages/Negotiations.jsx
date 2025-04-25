import Navbar from '../components/Navbar';
import { useEffect, useState } from 'react';
import NegotiationCard from '../components/NegotiationCard';
import { Box, FormControl, InputLabel, MenuItem, Select } from '@mui/material';
import { useNavigate } from 'react-router-dom';
import { DatePicker, LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import 'dayjs/locale/fr'

const Negotiations = () => {
  const [negociations, setNegociations] = useState([]);
  const [filteredNego, setFilteredNego] = useState([]);
  const [filterStatus, setFilterStatus] = useState('all');
  const [startDate, setStartDate] = useState(null);
  const [endDate, setEndDate] = useState(null);
  const navigate = useNavigate();

  const negociationSet = [
    {
      id: 1,
      proposedPrice: 150,
      counterOffer: 100,
      status: "counter",
      createdAt: "2025-04-25T09:52:28+00:00",
      room: {
        id: 1,
        name: "Chambre 1",
        description: "Description de la chambre 1 à Hôtel Aquabella & Spa Aix en Provence",
        price: 110,
        folderImage: "image1.jpg",
        capacity: 3
      },
      startDate: "2025-04-23T00:00:00+00:00",
      endDate: "2025-04-30T00:00:00+00:00"
    },
    {
      id: 4,
      proposedPrice: 180,
      status: "accepted",
      createdAt: "2025-04-25T09:52:28+00:00",
      room: {
        id: 4,
        name: "Chambre 4",
        description: "Description de la chambre 4 à Hôtel Aquabella & Spa Aix en Provence",
        price: 140,
        folderImage: "image4.jpg",
        capacity: 2
      },
      startDate: "2025-04-25T00:00:00+00:00",
      endDate: "2025-04-30T00:00:00+00:00"
    },
    {
      id: 7,
      proposedPrice: 210,
      status: "pending",
      createdAt: "2025-04-25T09:52:28+00:00",
      room: {
        id: 7,
        name: "Chambre 2",
        description: "Description de la chambre 2 à Hôtel Adagio",
        price: 120,
        folderImage: "image2.jpg",
        capacity: 2
      },
      startDate: "2025-04-25T00:00:00+00:00",
      endDate: "2025-04-30T00:00:00+00:00"
    },
    {
      id: 10,
      proposedPrice: 240,
      status: "pending",
      createdAt: "2025-04-25T09:52:28+00:00",
      room: {
        id: 10,
        name: "Chambre 5",
        description: "Description de la chambre 5 à Hôtel Adagio",
        price: 150,
        folderImage: "image5.jpg",
        capacity: 3
      },
      startDate: "2025-04-25T00:00:00+00:00",
      endDate: "2025-04-30T00:00:00+00:00"
    },
    {
      id: 13,
      proposedPrice: 270,
      status: "rejected",
      createdAt: "2025-04-25T09:52:28+00:00",
      room: {
        id: 13,
        name: "Chambre 3",
        description: "Description de la chambre 3 à L'Escapade Aixoise",
        price: 130,
        folderImage: "image3.jpg",
        capacity: 3
      },
      startDate: "2025-04-25T00:00:00+00:00",
      endDate: "2025-04-30T00:00:00+00:00"
    }
  ];

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (!token) {
      navigate("/login");
      return;
    }

    fetch('http://localhost:8000/api/my/negociations', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
      .then((response) => {
        if (!response.ok) throw new Error("Unauthorized");
        return response.json();
      })
      .then((data) => {
        if (Array.isArray(data.member)) {
          setNegociations(data.member);
        } else {
          console.error("Format inattendu :", data);
          setNegociations([]);
        }
      })
      .catch((error) => {
        console.error("Erreur API, fallback aux données locales :", error);
        setNegociations(negociationSet);
      });    
  }, []);

  useEffect(() => {
    const filtered = Array.isArray(negociations)
      ? negociations.filter((nego) => {
          return (
            (filterStatus === 'all' || nego.status === filterStatus) &&
            (!startDate || new Date(nego.startDate) >= startDate) &&
            (!endDate || new Date(nego.endDate) <= endDate)
          );
        })
      : [];

    setFilteredNego(filtered);
  }, [filterStatus, startDate, endDate, negociations]);

  return (
    <div className="min-h-screen bg-[#F8F8F8]">
      <Navbar />
      <div className="min-h-screen bg-gray-100 flex justify-center items-start py-12 px-4">
        <div className="w-full max-w-4xl bg-white rounded-2xl shadow-md p-6">
          <div className="flex justify-center items-center mb-6">
            <h1 className="text-2xl font-bold text-gray-800">Négociations</h1>
          </div>

          <Box className="flex flex-row justify-between gap-2">
            <FormControl fullWidth>
              <InputLabel>Statut</InputLabel>
              <Select
                value={filterStatus}
                label="Statut"
                onChange={(e) => setFilterStatus(e.target.value)}
              >
                <MenuItem value={"all"}>Toutes</MenuItem>
                <MenuItem value={"accepted"}>Approuvée</MenuItem>
                <MenuItem value={"refused"}>Rejetée</MenuItem>
                <MenuItem value={"pending"}>En attente</MenuItem>
                <MenuItem value={"counter"}>Contre offre</MenuItem>
              </Select>
            </FormControl>

            <LocalizationProvider dateAdapter={AdapterDayjs} adapterLocale="fr">
              <DatePicker
                label="Début du séjour"
                value={startDate}
                onChange={(newValue) => setStartDate(newValue ? newValue.toDate() : null)}
              />
              <DatePicker
                label="Fin du séjour"
                value={endDate}
                onChange={(newValue) => setEndDate(newValue ? newValue.toDate() : null)}
              />
            </LocalizationProvider>
          </Box>

          <div className="mt-6 space-y-6">
            {filteredNego.length > 0 ? (
              filteredNego.map((nego) => (
                <NegotiationCard
                  key={nego.id || `${nego.room?.id}-${nego.status}`} // Clé fallback unique
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

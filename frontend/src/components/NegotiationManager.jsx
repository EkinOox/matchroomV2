import { useEffect, useState } from 'react';

const NegotiationManager = () => {
  const [negos, setNegotiatedRooms] = useState([]);
  const [loading, setLoading] = useState(true);
  const [counterOffers, setCounterOffers] = useState({});

  const token = localStorage.getItem('token');

  const fetchNegotiations = () => {
    fetch('http://localhost:8000/api/hotelier/rooms/negotiations', {
      method: 'GET',
      headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
      },
    })
      .then((res) => {
        if (!res.ok) throw new Error('Erreur récupération chambres négociées');
        return res.json();
      })
      .then((data) => {
        setNegotiatedRooms(data);
      })
      .catch((err) => {
        console.error('Erreur hôtelier négo :', err);
      })
      .finally(() => {
        setLoading(false);
      });
  };

  useEffect(() => {
    fetchNegotiations();
  }, []);

  const handleCounterOfferChange = (roomId, value) => {
    setCounterOffers({ ...counterOffers, [roomId]: value });
  };

  const handleSendCounterOffer = async (roomId) => {
    const price = counterOffers[roomId];
    if (!price || isNaN(price)) {
      alert('Veuillez entrer une contre-offre valide.');
      return;
    }

    try {
      const res = await fetch(`http://localhost:8000/api/negociations/${roomId}`, {
        method: 'PATCH',
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/ld+json',
          'Content-Type': 'application/merge-patch+json',
        },
        body: JSON.stringify({ counterOffer: Number(price) }),
      });

      if (!res.ok) throw new Error("Erreur lors de l'envoi de la contre-offre");
      alert('Contre-offre envoyée avec succès !');
      fetchNegotiations(); // refresh data
    } catch (error) {
      console.error('Erreur envoi contre-offre :', error);
    }
  };

  const handleStatusUpdate = async (roomId, status) => {
    try {
      const res = await fetch(`http://localhost:8000/api/negociations/${roomId}`, {
        method: 'PATCH',
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/ld+json',
          'Content-Type': 'application/merge-patch+json',
        },
        body: JSON.stringify({ status }),
      });

      if (!res.ok) throw new Error("Erreur lors du changement de statut");
      alert(`Offre ${status === 'accepted' ? 'acceptée' : 'refusée'} !`);
      fetchNegotiations();
    } catch (error) {
      console.error("Erreur changement de statut :", error);
    }
  };

  return (
    <div className="max-w-6xl mx-auto p-6">
      <h2 className="text-3xl font-bold text-neutral-800 mb-6">Chambres en négociation</h2>

      {loading ? (
        <p className="text-gray-500">Chargement...</p>
      ) : negos.length === 0 ? (
        <p className="text-gray-500">Aucune négociation en cours.</p>
      ) : (
        <div className="grid gap-6">
          {negos.map((room) => (
            <div
              key={room.id}
              className="bg-white border border-gray-200 shadow-md rounded-xl p-6 transition hover:shadow-lg"
            >
              <div className="flex flex-col gap-4">
                <div>
                  <h3 className="text-xl font-semibold text-neutral-900">{room.name}</h3>
                  <p className="text-gray-600 mb-2">{room.description}</p>
                  <ul className="text-sm text-gray-700 space-y-1">
                    <li>💶 Prix de base : <strong>{room.price} €</strong></li>
                    <li>🤝 Prix proposé : <strong>{room.proposedPrice} €</strong></li>
                    <li>📊 Contre-offre actuelle : <strong>{room.counterOffer ?? 'Aucune'}</strong></li>
                    <li>📌 Statut : <span className="capitalize">{room.status}</span></li>
                    <li>🕒 Réponse attendue : {new Date(room.responseTime).toLocaleString()}</li>
                  </ul>
                </div>

                <div className="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                  <input
                    type="number"
                    value={counterOffers[room.id] || ''}
                    onChange={(e) => handleCounterOfferChange(room.id, e.target.value)}
                    placeholder="Contre-offre (€)"
                    className="w-full sm:w-1/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-600"
                  />
                  <button
                    onClick={() => handleSendCounterOffer(room.id)}
                    className="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition"
                  >
                    Envoyer
                  </button>
                  <button
                    onClick={() => handleStatusUpdate(room.id, 'accepted')}
                    className="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition"
                  >
                    Accepter
                  </button>
                  <button
                    onClick={() => handleStatusUpdate(room.id, 'refused')}
                    className="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition"
                  >
                    Refuser
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
};

export default NegotiationManager;

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
        const array = Array.isArray(data) ? data : data.member;
        setNegotiatedRooms(array || []);
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

  const handleCounterOfferChange = (idNegociation, value) => {
    setCounterOffers({ ...counterOffers, [idNegociation]: value });
  };

  const updateStatus = async (idNegociation, patchData, successMessage) => {
    try {
      const res = await fetch(`http://localhost:8000/api/negociations/${idNegociation}/update_status`, {
        method: 'PATCH',
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/ld+json',
          'Content-Type': 'application/merge-patch+json',
        },
        body: JSON.stringify(patchData),
      });

      if (!res.ok) throw new Error("Erreur lors de la mise à jour");
      alert(successMessage);
      fetchNegotiations();
    } catch (error) {
      console.error("Erreur mise à jour :", error);
    }
  };

  const handleSendCounterOffer = (idNegociation) => {
    const value = counterOffers[idNegociation];
    if (!value || isNaN(value)) {
      alert("Veuillez entrer une contre-offre valide.");
      return;
    }

    updateStatus(
      idNegociation,
      { counterOffer: Number(value), status: 'counter' },
      'Contre-offre envoyée avec succès !'
    );
  };

  const handleStatusUpdate = (idNegociation, status) => {
    const messages = {
      accepted: "Offre acceptée !",
      refused: "Offre refusée.",
    };

    updateStatus(idNegociation, { status }, messages[status]);
  };

  return (
    <div className="max-w-6xl mx-auto p-6">
      <h2 className="text-3xl font-bold text-neutral-800 mb-6">Chambres en négociation</h2>

      {loading ? (
        <p className="text-gray-500">Chargement...</p>
      ) : negos.length === 0 ? (
        <p className="text-gray-500">Aucune négociation en attente.</p>
      ) : (
        <div className="grid gap-6">
          {negos.map((negotiation) => (
            <div
              key={negotiation.idNegociation}
              className="bg-white border border-gray-200 shadow-md rounded-xl p-6 transition hover:shadow-lg"
            >
              <div className="flex flex-col gap-4">
                <div>
                  <h3 className="text-xl font-semibold text-neutral-900">{negotiation.name}</h3>
                  <p className="text-gray-600 mb-2">{negotiation.description}</p>
                  <ul className="text-sm text-gray-700 space-y-1">
                    <li>💶 Prix de base : <strong>{negotiation.price} €</strong></li>
                    <li>🤝 Prix proposé : <strong>{negotiation.proposedPrice} €</strong></li>
                    <li>📊 Contre-offre actuelle : <strong>{negotiation.counterOffer ?? 'Aucune'}</strong></li>
                    <li>📌 Statut : <span className="capitalize">{negotiation.status}</span></li>
                    <li>🕒 Réponse attendue : {negotiation.responseTime ? new Date(negotiation.responseTime).toLocaleString() : 'Non spécifiée'}</li>
                  </ul>
                </div>

                <div className="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                  <input
                    type="number"
                    value={counterOffers[negotiation.idNegociation] || ''}
                    onChange={(e) => handleCounterOfferChange(negotiation.idNegociation, e.target.value)}
                    placeholder="Contre-offre (€)"
                    className="w-full sm:w-1/3 px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-neutral-800"
                  />
                  <button
                    onClick={() => handleSendCounterOffer(negotiation.idNegociation)}
                    className="bg-gray-800 text-white px-4 py-2 rounded-lg hover:bg-gray-900 transition"
                  >
                    Envoyer
                  </button>
                  <button
                    onClick={() => handleStatusUpdate(negotiation.idNegociation, 'accepted')}
                    className="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition"
                  >
                    Accepter
                  </button>
                  <button
                    onClick={() => handleStatusUpdate(negotiation.idNegociation, 'refused')}
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

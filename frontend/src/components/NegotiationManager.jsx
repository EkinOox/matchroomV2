import { useState } from 'react';
import OfferModal from '../components/OfferModal';

const fakeNegotiations = [
  {
    id: 1,
    publicPrice: 200,
    offerPrice: 120,
    requestedPrice: 150,
    client: 'Client A',
    expiresIn: '2h 59m',
  },
  {
    id: 2,
    publicPrice: 180,
    offerPrice: 100,
    requestedPrice: null,
    client: 'Client B',
    expiresIn: '1h 45m',
  },
];

const NegotiationManager = () => {
  const [modalOpen, setModalOpen] = useState(false);
  const [selectedOffer, setSelectedOffer] = useState(null);

  // 💡 Ajout des seuils locaux
  const [acceptThreshold, setAcceptThreshold] = useState(75);
  const [rejectThreshold, setRejectThreshold] = useState(50);

  const handleChallenge = (negotiation) => {
    setSelectedOffer(negotiation);
    setModalOpen(true);
  };

  const handleValidate = (counterOffer) => {
    console.log(`Contre-offre : ${counterOffer} € pour ${selectedOffer.client}`);
    // tu peux ici ajouter une logique selon les seuils
    setModalOpen(false);
    setSelectedOffer(null);
  };

  return (
    <div>
      <h2 className="text-xl font-semibold mb-6">Seuil</h2>

      {/* 🎯 Bloc Seuils */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 bg-gray-100 p-6 rounded-xl shadow">
        <div>
          <label className="block font-semibold text-gray-700 mb-1">Seuil d’Acceptation (%)</label>
          <input
            type="number"
            value={acceptThreshold}
            onChange={(e) => setAcceptThreshold(Number(e.target.value))}
            className="w-full border border-gray-300 p-2 rounded"
          />
        </div>
        <div>
          <label className="block font-semibold text-gray-700 mb-1">Seuil de Refus (%)</label>
          <input
            type="number"
            value={rejectThreshold}
            onChange={(e) => setRejectThreshold(Number(e.target.value))}
            className="w-full border border-gray-300 p-2 rounded"
          />
        </div>
      </div>

      {/* 🔁 Négociations */}
      {fakeNegotiations.length === 0 ? (
        <p className="text-gray-500 text-center">Aucune négociation en cours.</p>
      ) : (
        <div className="space-y-4">
          {fakeNegotiations.map((neg) => (
            <div key={neg.id} className="bg-gray-100 p-4 rounded shadow flex justify-between items-center">
              <div>
                <p className="font-semibold text-gray-800">
                  {neg.client} - Offre : {neg.offerPrice} € / Prix public : {neg.publicPrice} €
                </p>
                <p className="text-sm text-gray-500">Expire dans {neg.expiresIn}</p>
              </div>
              <div className="flex gap-2">
                <button
                  onClick={() => handleChallenge(neg)}
                  className="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
                >
                  Contre offre
                </button>
                <button className="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Accepter</button>
                <button className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Refuser</button>
              </div>
            </div>
          ))}
        </div>
      )}

      {/* 🧩 Modale avec seuils passés en props */}
      <OfferModal
        isOpen={modalOpen}
        onClose={() => setModalOpen(false)}
        onValidate={handleValidate}
        offerPrice={selectedOffer?.offerPrice}
        acceptThreshold={acceptThreshold}
        rejectThreshold={rejectThreshold}
      />
    </div>
  );
};

export default NegotiationManager;

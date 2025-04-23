import { useState } from 'react';

const OfferModal = ({ isOpen, onClose, onValidate, offerPrice }) => {
  const [counterOffer, setCounterOffer] = useState('');

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div className="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h2 className="text-lg font-bold mb-4">Nouvelle offre</h2>

        <p className="mb-2 text-gray-700">Offre actuelle : <strong>{offerPrice} €</strong></p>

        <input
          type="number"
          className="w-full border border-gray-300 p-2 rounded mb-4"
          placeholder="Votre contre-offre (€)"
          value={counterOffer}
          onChange={(e) => setCounterOffer(e.target.value)}
        />

        <div className="flex justify-end gap-3">
          <button
            onClick={onClose}
            className="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 text-sm"
          >
            Annuler
          </button>
          <button
            onClick={() => {
              onValidate(counterOffer);
              setCounterOffer('');
            }}
            className="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
          >
            Valider
          </button>
        </div>
      </div>
    </div>
  );
};

export default OfferModal;

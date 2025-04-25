import React, { useEffect, useState } from 'react';

export default function CrudManager() {
  const [items, setItems] = useState([]);
  const [features, setFeatures] = useState([]);
  const [showForm, setShowForm] = useState(false);
  const [formData, setFormData] = useState({
    name: '',
    description: '',
    price: '',
    folderImage: '',
    capacity: '',
    acceptanceThreshold: '',
    refusalThreshold: '',
    features: [],
  });

  const token = localStorage.getItem('token');

  const fetchRooms = () => {
    fetch('http://localhost:8000/api/hotelier/rooms', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
      .then((response) => {
        if (!response.ok) throw new Error('Erreur lors de la récupération des données');
        return response.json();
      })
      .then((data) => setItems(data.member))
      .catch((error) => console.error('Erreur API:', error));
  };

  const fetchFeatures = () => {
    fetch('http://localhost:8000/api/features', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
      .then((res) => res.json())
      .then((data) => setFeatures(data.member))
      .catch((err) => console.error('Erreur chargement features', err));
  };

  useEffect(() => {
    fetchRooms();
    fetchFeatures();
  }, []);

  const handleDelete = async (roomId) => {
    const confirmDelete = window.confirm("Voulez-vous vraiment supprimer cette chambre ?");
    if (!confirmDelete) return;

    try {
      await fetch(`http://localhost:8000/api/hotelier/rooms/${roomId}`, {
        method: 'DELETE',
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      setItems((prev) => prev.filter((room) => room.id !== roomId));
    } catch (error) {
      console.error('Erreur lors de la suppression :', error);
    }
  };

  const handleFormChange = (field, value) => {
    setFormData({ ...formData, [field]: value });
  };

  const toggleFeature = (id) => {
    setFormData((prev) => ({
      ...prev,
      features: prev.features.includes(id)
        ? prev.features.filter((f) => f !== id)
        : [...prev.features, id],
    }));
  };

  const handleFormSubmit = async (e) => {
    e.preventDefault();

    try {
      const res = await fetch('http://localhost:8000/api/hotelier/rooms', {
        method: 'POST',
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: 'application/ld+json',
          'Content-Type': 'application/ld+json',
        },
        body: JSON.stringify({
          ...formData,
          price: Number(formData.price),
          capacity: Number(formData.capacity),
          acceptanceThreshold: Number(formData.acceptanceThreshold),
          refusalThreshold: Number(formData.refusalThreshold),
          features: formData.features.map((id) => `/api/features/${id}`),
        }),
      });

      if (!res.ok) throw new Error("Erreur lors de la création de la chambre");
      alert('Chambre créée avec succès !');
      setFormData({
        name: '',
        description: '',
        price: '',
        folderImage: '',
        capacity: '',
        acceptanceThreshold: '',
        refusalThreshold: '',
        features: [],
      });
      setShowForm(false);
      fetchRooms();
    } catch (err) {
      console.error('Erreur création chambre :', err);
    }
  };

  return (
    <div className="max-w-5xl mx-auto px-6 py-10">
      <div className="flex justify-between items-center mb-8">
        <h2 className="text-3xl font-bold text-neutral-900">Chambres de l'hôtel</h2>
        <button
          onClick={() => setShowForm(!showForm)}
          className="bg-blue-700 text-white px-4 py-2 rounded hover:bg-blue-800"
        >
          {showForm ? 'Fermer le formulaire' : 'Ajouter une chambre'}
        </button>
      </div>

      {/* Formulaire de création */}
      {showForm && (
        <div className="bg-white border border-gray-200 shadow rounded-xl p-6 mb-10">
          <form onSubmit={handleFormSubmit} className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" placeholder="Nom" required value={formData.name} onChange={(e) => handleFormChange('name', e.target.value)} className="p-2 border rounded" />
            <input type="number" placeholder="Prix (€)" required value={formData.price} onChange={(e) => handleFormChange('price', e.target.value)} className="p-2 border rounded" />
            <input type="text" placeholder="Image (dossier)" value={formData.folderImage} onChange={(e) => handleFormChange('folderImage', e.target.value)} className="p-2 border rounded" />
            <input type="number" placeholder="Capacité" required value={formData.capacity} onChange={(e) => handleFormChange('capacity', e.target.value)} className="p-2 border rounded" />
            <input type="number" placeholder="Seuil d'acceptation (%)" required value={formData.acceptanceThreshold} onChange={(e) => handleFormChange('acceptanceThreshold', e.target.value)} className="p-2 border rounded" />
            <input type="number" placeholder="Seuil de refus (%)" required value={formData.refusalThreshold} onChange={(e) => handleFormChange('refusalThreshold', e.target.value)} className="p-2 border rounded" />
            <textarea placeholder="Description" required value={formData.description} onChange={(e) => handleFormChange('description', e.target.value)} className="col-span-1 md:col-span-2 p-2 border rounded" />

            <div className="col-span-1 md:col-span-2">
              <p className="font-medium mb-2">Caractéristiques :</p>
              <div className="flex flex-wrap gap-2">
                {features.map((f) => (
                  <label key={f.id} className="flex items-center gap-2 text-sm bg-gray-100 px-3 py-1 rounded-full border border-gray-300 cursor-pointer">
                    <input
                      type="checkbox"
                      checked={formData.features.includes(f.id)}
                      onChange={() => toggleFeature(f.id)}
                      className="accent-neutral-800"
                    />
                    {f.name}
                  </label>
                ))}
              </div>
            </div>

            <button type="submit" className="col-span-1 md:col-span-2 bg-blue-700 text-white px-6 py-2 rounded hover:bg-blue-800 transition">
              Créer la chambre
            </button>
          </form>
        </div>
      )}

      {/* Liste des chambres */}
      {items.length === 0 ? (
        <p className="text-center text-gray-500">Aucune chambre disponible.</p>
      ) : (
        <div className="grid gap-6">
          {items.map((room) => (
            <div key={room.id} className="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
              <div className="flex justify-between items-start">
                <div className="flex-1">
                  <h3 className="text-xl font-semibold text-neutral-900 mb-1">{room.name}</h3>
                  <p className="text-gray-700 mb-2">{room.description}</p>

                  <div className="text-sm text-gray-600 space-y-1">
                    <p>💶 <strong>Prix :</strong> {room.price} €</p>
                    <p>🛏️ <strong>Capacité :</strong> {room.capacity}</p>
                    <p>✅ <strong>Accepté à partir de :</strong> {room.acceptanceThreshold} %</p>
                    <p>❌ <strong>Refusé à partir de :</strong> {room.refusalThreshold} %</p>
                    <p>📅 <strong>Créée le :</strong> {new Date(room.createdAt).toLocaleDateString()}</p>
                  </div>

                  {room.features?.length > 0 && (
                    <div className="mt-3">
                      <p className="text-sm font-medium text-gray-700 mb-1">🔧 Caractéristiques :</p>
                      <ul className="flex flex-wrap gap-2">
                        {room.features.map((f) => (
                          <li key={f.id} className="text-xs bg-gray-100 px-3 py-1 rounded-full border border-gray-300">
                            {f.name}
                          </li>
                        ))}
                      </ul>
                    </div>
                  )}
                </div>

                <div>
                  <button onClick={() => handleDelete(room.id)} className="text-sm px-4 py-2 bg-red-100 text-red-600 rounded hover:bg-red-200 font-medium">
                    Supprimer
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

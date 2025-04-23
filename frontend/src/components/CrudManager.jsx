import { useState } from 'react';

const CrudManager = () => {
  const [items, setItems] = useState([]);
  const [newName, setNewName] = useState('');

  const addItem = () => {
    if (newName.trim()) {
      setItems([...items, { id: Date.now(), name: newName }]);
      setNewName('');
    }
  };

  const deleteItem = (id) => {
    setItems(items.filter(item => item.id !== id));
  };

  return (
    <div>
      <h2 className="text-xl font-semibold mb-4">Gérer les Hôtels</h2>

      <div className="flex gap-4 mb-4">
        <input
          type="text"
          placeholder="Nom de l’hôtel"
          value={newName}
          onChange={(e) => setNewName(e.target.value)}
          className="border p-2 rounded w-full"
        />
        <button
          onClick={addItem}
          className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Ajouter
        </button>
      </div>

      <table className="w-full text-sm border border-gray-300">
        <thead className="bg-gray-100">
          <tr>
            <th className="text-left p-2 border-b">Nom</th>
            <th className="p-2 border-b">Actions</th>
          </tr>
        </thead>
        <tbody>
          {items.map((hotel) => (
            <tr key={hotel.id} className="border-t">
              <td className="p-2">{hotel.name}</td>
              <td className="p-2 text-center">
                <button
                  onClick={() => deleteItem(hotel.id)}
                  className="text-red-600 hover:underline"
                >
                  Supprimer
                </button>
              </td>
            </tr>
          ))}
          {items.length === 0 && (
            <tr>
              <td colSpan="2" className="p-4 text-center text-gray-500">
                Aucun hôtel pour l’instant.
              </td>
            </tr>
          )}
        </tbody>
      </table>
    </div>
  );
};

export default CrudManager;

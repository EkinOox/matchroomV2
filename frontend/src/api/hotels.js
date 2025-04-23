export const fetchHotels = async (status = 'pending') => {
    const res = await fetch(`http://localhost:3000/hotels?status=${status}`);
    if (!res.ok) throw new Error('Erreur de chargement des hôtels');
    return res.json();
  };
  
const NegotiationCard = ({ negotiation, onUpdate }) => {
  // Set background color based on status
  const getStatusStyle = status => {
    switch (status) {
      case 'accepted':
        return { backgroundColor: '#d4edda' }; // green-ish
      case 'refused':
        return { backgroundColor: '#f8d7da' }; // red-ish
      case 'counter':
        return { backgroundColor: '#fff3cd' }; // yellow-ish
      case 'confirmed':
        return { backgroundColor: '#93c5fd' }; // blue-ish
      default:
        return { backgroundColor: '#f0f0f0' }; // default/gray
    }
  };

  const startDate = new Date(negotiation.startDate).toLocaleDateString("fr-FR");
  const endDate = new Date(negotiation.endDate).toLocaleDateString("fr-FR");

  const handleChange = (e) => {
    console.log(e.target.value);
    const updatedNego = {...negotiation, status: e.target.value};
    onUpdate(updatedNego);
  }

  return (
    <div className="flex items-center bg-gray-100 p-4 rounded-xl shadow-sm" style={{ ...getStatusStyle(negotiation.status) }}>
      <img
        src={"https://app-staging.matchroom.io/images/search_header_banner.png"}
        alt={""}
        className="w-20 h-20 object-cover rounded-lg mr-4"
      />
      <div className="flex-1">
        <h3 className="font-bold text-lg text-gray-800">{negotiation.room.name} - {negotiation.proposedPrice}€/nuits</h3>
        <p className="text-sm text-gray-800">💶 Prix initial : {negotiation.room.price}€/nuits</p>
        <p className="text-sm text-gray-800">📅 Dates du séjour : {startDate} - {endDate}</p>
      </div>
      {negotiation.status === "counter" && (
        <div className="flex flex-col gap-1 justify-center items-center">
          <p className="text-lg font-bold text-gray-800">Contre offre : {negotiation.counterOffer}€/nuits</p>
          <button className="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 w-[200px]" value="confirmed" onClick={handleChange}>Accepter</button>
          <button className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 w-[200px]" value="refused" onClick={handleChange}>Refuser</button>
        </div>
      )}
      {negotiation.status === "accepted" && (
        <div className="flex flex-col gap-1 justify-center items-center">
          <button className="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 w-[200px]" value="confirmed" onClick={handleChange}>Accepter</button>
          <button className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 w-[200px]" value="refused" onClick={handleChange}>Refuser</button>
        </div>
      )}
    </div>
  );
};

export default NegotiationCard;
  
const NegotiationCard = ({ negotiation }) => {
  // Set background color based on status
  const getStatusStyle = status => {
    switch (status) {
      case 'accepted':
        return { backgroundColor: '#d4edda' }; // green-ish
      case 'refused':
        return { backgroundColor: '#f8d7da' }; // red-ish
      case 'counter':
        return { backgroundColor: '#fff3cd' }; // yellow-ish
      default:
        return { backgroundColor: '#f0f0f0' }; // default/gray
    }
  };

  const startDate = new Date(negotiation.startDate).toLocaleDateString("fr-FR");
  const endDate = new Date(negotiation.endDate).toLocaleDateString("fr-FR");

  return (
    <div className="flex items-center bg-gray-100 p-4 rounded-xl shadow-sm" style={{ ...getStatusStyle(negotiation.status) }}>
      <img
        src={"https://app-staging.matchroom.io/images/search_header_banner.png"}
        alt={""}
        className="w-20 h-20 object-cover rounded-lg mr-4"
      />
      <div className="flex-1">
        <h3 className="font-bold text-lg text-gray-800">{negotiation.room.name} - {negotiation.proposedPrice}€/nuits</h3>
        <p className="text-sm text-gray-800">Prix initial : {negotiation.room.price}€/nuits</p>
        <p className="text-sm text-gray-800">Dates du séjour : {startDate} - {endDate}</p>
      </div>
      {negotiation.status === "counter" && (
        <div className="flex flex-col gap-1">
          <p className="text-lg font-bold text-gray-800">Contre offre : {negotiation.counterOffer}€/nuits</p>
          <button className="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Accepter</button>
          <button className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Refuser</button>
        </div>
      )}
    </div>
  );
};

export default NegotiationCard;
  
const NegotiationCard = ({ negotiation }) => {
  // Set background color based on status
    const getStatusStyle = status => {
      switch (status) {
        case 'approved':
          return { backgroundColor: '#d4edda' }; // green-ish
        case 'rejected':
          return { backgroundColor: '#f8d7da' }; // red-ish
        case 'challenged':
          return { backgroundColor: '#fff3cd' }; // yellow-ish
        default:
          return { backgroundColor: '#f0f0f0' }; // default/gray
      }
    };

    return (
      <div className="flex items-center bg-gray-100 p-4 rounded-xl shadow-sm" style={{ ...getStatusStyle(negotiation.status) }}>
        <img
          src={"https://app-staging.matchroom.io/images/search_header_banner.png"}
          alt={""}
          className="w-20 h-20 object-cover rounded-lg mr-4"
        />
        <div className="flex-1">
          <h3 className="font-bold text-lg text-gray-800">{negotiation.room.name}</h3>
          <p className="text-sm text-gray-600">Prix initial : {negotiation.room.price} € / nuits</p>
          <p className="text-sm text-gray-600">Prix négocié : {negotiation.proposed_price} € / nuits</p>
        </div>
        {negotiation.status === "challenged" && (
          <div className="flex flex-col gap-1">
            <p className="text-lg font-bold text-gray-800">Contre offre : {negotiation.counter_offer} € / nuits</p>
            <button className="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Accepter</button>
            <button className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Refuser</button>
          </div>
        )}
      </div>
    );
  };
  
  export default NegotiationCard;
  
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
    return (
      <div>
        <h2 className="text-xl font-semibold mb-4">Négociations en cours</h2>
  
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
                  <button className="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Challenger</button>
                  <button className="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Accepter</button>
                  <button className="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Refuser</button>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    );
  };
  
  export default NegotiationManager;
  
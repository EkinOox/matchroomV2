const NegotiationTabs = ({ active, onChange }) => {
    const tabs = [
      { label: 'VALIDÉ', value: 'approved' },
      { label: 'EN ATTENTE', value: 'pending' },
      { label: 'REFUSÉE', value: 'rejected' },
      { label: 'CONTRE OFFRE', value: 'challenged'}
    ];
  
    return (
      <div className="flex justify-center gap-2">
        {tabs.map((tab) => (
          <button
            key={tab.value}
            onClick={() => onChange(tab.value)}
            className={`px-4 py-2 text-sm font-semibold rounded-full transition duration-200
              ${active === tab.value
                ? 'bg-gray-800 text-white'
                : 'bg-gray-200 text-gray-700 hover:bg-gray-300'
              }`}
          >
            {tab.label}
          </button>
        ))}
      </div>
    );
  };
  
  export default NegotiationTabs;
  
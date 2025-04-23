const AdminTabs = ({ active, onChange }) => {
    const tabs = [
      { label: 'CRUD', value: 'crud' },
      { label: 'Négociations', value: 'negotiations' },
    ];
  
    return (
      <div className="flex gap-4">
        {tabs.map((tab) => (
          <button
            key={tab.value}
            onClick={() => onChange(tab.value)}
            className={`px-4 py-2 font-semibold rounded ${
              active === tab.value
                ? 'bg-blue-600 text-white'
                : 'bg-gray-200 text-gray-800'
            }`}
          >
            {tab.label}
          </button>
        ))}
      </div>
    );
  };
  
  export default AdminTabs;
  
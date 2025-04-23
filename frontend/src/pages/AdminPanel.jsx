import { useState } from 'react';
import AdminTabs from '../components/AdminTabs';
import CrudManager from '../components/CrudManager';
import NegotiationManager from '../components/NegotiationManager';

const AdminPanel = () => {
  const [activeTab, setActiveTab] = useState('crud');

  return (
    <div className="min-h-screen bg-gray-100 p-8">
      <div className="max-w-6xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 className="text-2xl font-bold mb-6">Panneau d’administration</h1>

        <AdminTabs active={activeTab} onChange={setActiveTab} />

        <div className="mt-8">
          {activeTab === 'crud' ? <CrudManager /> : <NegotiationManager />}
        </div>
      </div>
    </div>
  );
};

export default AdminPanel;

import React, { useEffect, useState } from 'react';
import axios from 'axios';

export default function Filters({ selectedCriteria, onToggle }) {
  const [features, setFeatures] = useState([]);

  useEffect(() => {
    const fetchFeatures = async () => {
      try {
        const response = await axios.get('http://localhost:8000/api/features');
        setFeatures(response.data.member);
      } catch (error) {
        console.error('Erreur lors de la récupération des features', error);
      }
    };

    fetchFeatures();
  }, []);

  return (
    <div className="p-4 rounded-xl w-full max-w-3xl mx-auto">
      <h3 className="text-3xl font-semibold text-blue-main mb-4">Vos critères :</h3>
      <div className="flex flex-wrap gap-3">
        {features.map((feature) => {
          const isSelected = selectedCriteria.includes(feature.id);
          return (
            <button
              key={feature.id}
              type="button"
              className={`px-4 py-2 rounded-lg border transition duration-200
                ${isSelected
                  ? 'bg-blue-main text-white border-blue-main'
                  : 'border-blue-main text-blue-main hover:bg-blue-main hover:text-white'}
              `}
              onClick={() => onToggle(feature.id)}
            >
              {feature.name}
            </button>
          );
        })}
      </div>
    </div>
  );
}

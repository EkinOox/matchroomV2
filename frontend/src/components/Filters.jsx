import React from 'react';
import '../assets/css/Filters.css';

const criteria = ['Piscine', 'Restaurant', 'Wifi', 'Climatisation', 'Lit simple', 'Lit double'];

export default function Filters() {
  return (
    <div className="filters">
      <h3>Vos critères :</h3>
      <div className="criteria-list">
        {criteria.map((crit, idx) => (
          <button key={idx} className="crit-button">{crit}</button>
        ))}
      </div>
    </div>
  );
}
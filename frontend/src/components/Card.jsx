import React from 'react';
import '../assets/css/Navbar.css';

export default function Card() {
  return (
    <div className="hotel-card">
      <img src="https://via.placeholder.com/500x300" alt="hotel" className="hotel-img" />
      <div className="info-icon">i</div>
      <div className="hotel-details">
        <div className="hotel-actions">
          <button className="btn-no">&#10006;</button>
          <button className="btn-yes">&#10084;</button>
        </div>
        <h3>Hôtel Aquabella</h3>
        <p>150€/nuit</p>
      </div>
    </div>
  );
}
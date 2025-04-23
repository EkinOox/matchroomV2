import React from 'react';
import '../assets/css/SearchForm.css';

export default function SearchForm() {
  return (
    <form className="search-form">
      <input type="text" placeholder="Entrez une adresse..." />
      <input type="number" placeholder="Combien de personne..." />
      <div className="date-fields">
        <input type="date" />
        <input type="date" />
      </div>
    </form>
  );
}
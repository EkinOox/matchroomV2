# 🛏️ Match Room – Repenser la réservation hôtelière façon Tinder 💘

> Projet réalisé dans le cadre d’un hackathon, porté par Pierre & Vacances, encadré par Stéphane CASTELLANI (Product Owner).

## 🎯 Objectif

**Match Room** révolutionne l'expérience de réservation touristique en la rendant fun, intuitive, et gamifiée.  
Fini les interfaces froides de Booking & co. Ici, on swipe, on match, on négocie — comme sur une app de rencontre.

---

## 🧠 Concepts clés

- 🔥 Swipes pour matcher avec la chambre idéale (ambiance, budget, localisation…)
- 🎮 Gamification (badges, défis, mini-jeux)
- 💬 Système de **négociation dynamique** entre client & hôteliers
- 🌐 Ouverture à terme aux **locations LMNP**
- 🤖 Moteur de recommandations basé sur les préférences utilisateurs

---

## 🖥️ Tech Stack

| Frontend | Backend       | Base de données | Autres        |
|----------|---------------|------------------|----------------|
| React    | Node          | MySQL            | Docker |

---

## 🧱 Modèle de données (extraits)

- `User`, `Role`, `User_Preference`, `Badge`
- `Accommodation` (hébergement : hôtel ou LMNP)
- `Room` (chambres proposées)
- `Swipe` (interaction type Tinder)
- `Negotiation` (marchandage 2.0)
- `Room_Characteristic` (services, ambiance…)

---

## 🚀 Fonctionnalités principales

### 🎯 Matching & swipe
- Swipe gauche/droite sur des chambres selon préférences
- Animation fluide & responsive

### 💰 Négociation
- Propose ton prix
- Hôte peut accepter, refuser ou contre-proposer
- Système simple, gamifié, en temps réel

### 🧬 Recommandations
- Moteur basé sur préférences utilisateurs
- Ambiance, prix, localisation, services souhaités

### 🏆 Gamification
- Badges à débloquer
- Historique de swipes, favoris, challenges
- Quiz, XP, interactions sociales en option

---

## 📁 Arborescence (exemple)

```bash
📦 match-room/
├── frontend/
│   ├── public/
│   └── src/
│       ├── components/
│       ├── pages/
│       └── services/
├── backend/
│   └── src/
│       ├── Entity/
│       ├── Controller/
│       ├── Repository/
│       └── Service/
├── database/
│   └── schema.dbml
└── README.md

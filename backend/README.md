# ✅ Liste des tâches restantes pour l'entité User

## **1️⃣ Finaliser et tester les requêtes sur User**
- [x] Vérifier que toutes les routes sont fonctionnelles :
  - `POST /user` (création d'un utilisateur)
  - `GET /user/{id}` (récupération d'un utilisateur)
  - `PATCH /user/{id}` (mise à jour d'un utilisateur)
  - `GET /admin/users` (liste des utilisateurs pour les admins)
  - `POST /admin/user` (création d'un utilisateur par un admin)
  - `PATCH /admin/user/{id}` (mise à jour d'un utilisateur par un admin)
  - `DELETE /admin/user/{id}` (suppression d'un utilisateur par un admin)
- [x] Tester chaque route avec des cas d'utilisation réels (succès, erreurs, permissions).
- [ ] Ajouter des tests fonctionnels pour chaque route.

---

## **2️⃣ Implémenter le renvoi du lien de vérification d'email** ✅ _(Déjà fait)_
- [x] Ajouter une route pour renvoyer un lien de vérification si le lien initial a expiré :
  - Exemple : `POST /user/resend-verification-email`
- [x] Vérifier que l'utilisateur existe et n'est pas déjà vérifié.
- [x] Générer un nouveau token de vérification.
- [x] Envoyer un nouvel email avec le lien de vérification.
- [x] Gérer l'expiration du token.

---

## **3️⃣ Implémenter le reset de mot de passe** 🔥 _(En cours)_
- [x] Route pour demander un reset de mot de passe :
  - Exemple : `POST /user/request-password-reset`
  - [x] Vérifier que l'email existe.
  - [x] Générer un token de réinitialisation.
  - [ x Envoyer un email avec un lien de réinitialisation.
- [x] Route pour réinitialiser le mot de passe :
  - Exemple : `POST /user/reset-password`
  - [x] Valider le token de réinitialisation.
  - [x] Mettre à jour le mot de passe de l'utilisateur.
  - [x] Invalider le token après utilisation.
- [x] Expiration du token :
  - [x] Le token doit avoir une durée de validité (ex: 15 min).

---

## **4️⃣ Documenter l'API**
- [ ] Ajouter des descriptions et des exemples :
  - [ ] Utiliser des annotations OpenAPI pour documenter chaque route.
  - [ ] Fournir des exemples de requêtes et de réponses.
- [ ] Créer une documentation utilisateur :
  - [ ] Expliquer comment utiliser chaque route.
  - [ ] Fournir des exemples d'utilisation avec Postman ou cURL.

---

## **5️⃣ Ajouter des tests**
- [ ] **Tests unitaires** :
  - [ ] Tester les méthodes de l'entité `User` (`setEmail`, `setPassword`...).
- [ ] **Tests fonctionnels** :
  - [ ] Tester chaque route de l'API (`POST /user`, `PATCH /user/{id}`, `DELETE /admin/user/{id}`, etc.).
- [ ] **Tests d'intégration** :
  - [ ] Tester l'interaction entre les différentes parties de l'application.

---

## **6️⃣ Optimiser les performances**
- [ ] **Indexer les champs fréquemment utilisés** :
  - [ ] Ajouter des index sur `email`, `pseudo`, et `deletedAt` pour améliorer les performances.
- [ ] **Limiter les requêtes inutiles** :
  - [ ] Utiliser la pagination pour les listes d'utilisateurs.
  - [ ] Ne renvoyer que les champs nécessaires dans les réponses API.

---

## **7️⃣ Gérer les erreurs et les retours d'API**
- [ ] Standardiser les retours d'erreur :
  - [ ] Utiliser des codes HTTP appropriés (`200`, `400`, `401`, `403`, `404`, `500`).
  - [ ] Renvoyer des messages d'erreur clairs et utiles.
- [ ] Gestion des exceptions :
  - [ ] Intercepter les exceptions et les transformer en réponses JSON structurées.

---

## **8️⃣ Ajouter des fonctionnalités supplémentaires (optionnel)**
- [ ] **Authentification à deux facteurs (2FA)** :
  - [ ] Ajouter une option pour activer la 2FA (via SMS ou Google Authenticator).
- [ ] **Gestion des sessions** :
  - [ ] Permettre aux utilisateurs de se déconnecter à distance (ex: gestion des tokens JWT en base de données).

---

# **🛠️ Priorité actuelle : Implémenter le reset de mot de passe 🔥**
1. ✅ Créer la route `POST /user/request-password-reset` (envoi de l'email avec un token).
2. ✅ Créer la route `POST /user/reset-password` (réinitialisation du mot de passe).
3. ✅ Ajouter un système d’expiration du token (ex: 1 heure).
4. ✅ Sécuriser le process (ex: rate-limiting pour éviter le spam).
5. ✅ Tester avec Insomnia/Postman.

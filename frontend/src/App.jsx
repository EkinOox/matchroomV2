import { BrowserRouter as Router, Routes, Route } from 'react-router-dom'
import Match from './pages/Match'
import Negotiations from './pages/Negotiations'
import AdminPanel from './pages/AdminPanel';
import Accueil from './pages/Accueil';
import Login from './pages/Login';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Accueil />} />
        <Route path="/match" element={<Match />} />
        <Route path="/negociations" element={<Negotiations />} />
        <Route path="/admin" element={<AdminPanel />} />
        <Route path="/login" element={<Login />} />
      </Routes>
    </Router>
  )
}

export default App

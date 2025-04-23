import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import Negotiations from './pages/Negotiations';
import AdminPanel from './pages/AdminPanel';

function App() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Navigate to="/negotiations" />} />
        <Route path="/negotiations" element={<Negotiations />} />
        <Route path="/admin" element={<AdminPanel />} />
      </Routes>
    </Router>
  );
}

export default App;

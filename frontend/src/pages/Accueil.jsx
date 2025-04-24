import { Box } from "@mui/material";
import Navbar from "../components/Navbar";

const Accueil = () => {
    return (
        <div className="min-h-screen bg-[#F8F8F8]">
            <Navbar />
            <Box
                className=" bg-white rounded-lg shadow-xl flex p-6 gap-6 mx-4 mt-4"
                style={{
                    maxHeight: '80%',
                }}
            >
                <h2 className="text-4xl font-bold text-black">
                    Découvrez l'expérience Matchroom !
                </h2>
            </Box>
        </div>
    );
}

export default Accueil;
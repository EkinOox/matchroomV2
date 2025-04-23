const HotelCard = ({ name, price, imageUrl }) => {
    return (
      <div className="flex items-center bg-gray-100 p-4 rounded-xl shadow-sm">
        <img
          src={imageUrl}
          alt={name}
          className="w-20 h-20 object-cover rounded-lg mr-4"
        />
        <div className="flex-1">
          <h3 className="font-bold text-lg text-gray-800">{name}</h3>
          <p className="text-sm text-gray-600">Prix initial : {price} € / nuits</p>
        </div>
        <div className="text-xl text-gray-500">💬</div>
      </div>
    );
  };
  
  export default HotelCard;
  
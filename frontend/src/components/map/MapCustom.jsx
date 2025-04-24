import {APIProvider, Map, Marker} from '@vis.gl/react-google-maps';

import {RoutesApi} from './route-api';
import Route from './Route';

const apiClient = new RoutesApi('AIzaSyCeQmOns_lk-EoLjb3JhoLs3hkrxzNl8dc');

// const routeOrigin = {lng: 9.9004303, lat: 53.588241};
// const routeDestination = {lng: 13.43765, lat: 52.52967};

const appearance = {
  walkingPolylineColor: '#000',
  defaultPolylineColor: '#7c7c7c',
  stepMarkerFillColor: '#333333',
  stepMarkerBorderColor: '#000000'
};

const routeOptions = {
  travelMode: 'TRANSIT',
  computeAlternativeRoutes: false,
  units: 'METRIC'
};

const mapOptions = {
  mapId: '87e65626f9acac8c',
  defaultCenter: {lat: 22, lng: 0},
  defaultZoom: 3,
  gestureHandling: 'greedy',
  disableDefaultUI: true
};

const MapCustom = ({ origin, destination }) => {
  return (
    <APIProvider apiKey={"AIzaSyCeQmOns_lk-EoLjb3JhoLs3hkrxzNl8dc"}>
      <Map
        style={{ width: '100%', height: '30vh' }} {...mapOptions}
        defaultCenter={origin}
        defaultZoom={10}
        gestureHandling="greedy"
        disableDefaultUI={true}
        mapId="87e65626f9acac8c"
      >
        <Marker position={origin} />
        <Marker position={destination} />
        <Route
          apiClient={apiClient}
          origin={origin}
          destination={destination}
          routeOptions={routeOptions}
          appearance={appearance}
        />
      </Map>
    </APIProvider>
  );
};


export default MapCustom;



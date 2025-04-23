import {APIProvider, Map, Marker} from '@vis.gl/react-google-maps';

import {RoutesApi} from './route-api';
import Route from './Route';

const apiClient = new RoutesApi('AIzaSyCeQmOns_lk-EoLjb3JhoLs3hkrxzNl8dc');

const routeOrigin = {lng: 9.9004303, lat: 53.588241};
const routeDestination = {lng: 13.43765, lat: 52.52967};

const timestamp = Math.ceil(Date.now() / 86_400_000) * 86_400_000 + 900_000; // demain a 00h15
const departureTime = new Date(timestamp).toISOString();

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
  disableDefaultUI: false
};

const MapCustom = () => {
    return(
        <APIProvider apiKey={"AIzaSyCeQmOns_lk-EoLjb3JhoLs3hkrxzNl8dc"}>
        <Map style={{width: '80vw', height: '80vh'}} {...mapOptions}>
            <Marker position={{lat: 43.53107833862305, lng: 5.445037841796875}} />
            <Route
            apiClient={apiClient}
            origin={routeOrigin}
            destination={routeDestination}
            routeOptions={routeOptions}
            appearance={appearance}
            />
            <div>{departureTime}</div>
        </Map>
        </APIProvider>
    )
}

export default MapCustom;



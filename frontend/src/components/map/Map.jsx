// Map.jsx
import {
  APIProvider,
  Map,
  AdvancedMarker
} from "@vis.gl/react-google-maps";
import { RoutesApi } from "./route-api";
import Route from "./Route";

const apiClient = new RoutesApi("AIzaSyCeQmOns_lk-EoLjb3JhoLs3hkrxzNl8dc");

const mapOptions = {
  mapId: "87e65626f9acac8c",
  defaultZoom: 10,
  gestureHandling: "greedy",
  disableDefaultUI: true,
};

export default function MapCustom({ origin, destination }) {
  return (
    <APIProvider apiKey="AIzaSyCeQmOns_lk-EoLjb3JhoLs3hkrxzNl8dc">
      {origin && destination && (
        <Map
          style={{ width: "100%", height: "30vh" }}
          defaultCenter={destination}
          {...mapOptions}
        >
           <AdvancedMarker position={origin} zIndex={1000}/>
          
          <AdvancedMarker position={destination} zIndex={1000}>
            <img src="/custom-marker.svg" width={32} height={32} />
          </AdvancedMarker>
          
          <Route
            apiClient={apiClient}
            origin={origin}
            destination={destination}
            routeOptions={{
              travelMode: "TRANSIT",
              computeAlternativeRoutes: false,
              units: "METRIC",
            }}
            appearance={{
              walkingPolylineColor: "#000",
              defaultPolylineColor: "#7c7c7c",
              stepMarkerFillColor: "#333333",
              stepMarkerBorderColor: "#000000",
            }}
          />
        </Map>
      )}
    </APIProvider>
  );
}

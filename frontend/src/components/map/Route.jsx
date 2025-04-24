import React, { useEffect, useState } from 'react';
import {
  AdvancedMarker,
  AdvancedMarkerAnchorPoint,
  useMap
} from '@vis.gl/react-google-maps';

import { Polyline } from './Polyline';

const defaultAppearance = {
  walkingPolylineColor: '#000000',
  defaultPolylineColor: '#9a1e45',
  stepMarkerFillColor: '#333333',
  stepMarkerBorderColor: '#000000'
};

const Route = (props) => {
  const { apiClient, origin, destination, routeOptions } = props;
  const [route, setRoute] = useState(null);
  const map = useMap();

  useEffect(() => {
    if (!map) return;

    apiClient.computeRoutes(origin, destination, routeOptions).then(res => {
      const [route] = res.routes;
      setRoute(route);

      const { high, low } = route.viewport;
      const bounds = {
        north: high.latitude,
        south: low.latitude,
        east: high.longitude,
        west: low.longitude
      };

      map.fitBounds(bounds);
    });
  }, [origin, destination, routeOptions]);

  if (!route) return null;

  const routeSteps = route.legs[0].steps;
  const appearance = { ...defaultAppearance, ...props.appearance };

  const polylines = routeSteps.map((step, index) => {
    const isWalking = step.travelMode === 'WALK';
    const color = isWalking
      ? appearance.walkingPolylineColor
      : (step?.transitDetails?.transitLine?.color ?? appearance.defaultPolylineColor);

    return (
      <Polyline
        key={`${index}-polyline`}
        encodedPath={step.polyline.encodedPolyline}
        strokeWeight={isWalking ? 4 : 6}
        strokeColor={color}
      />
    );
  });

  const stepMarkerStyle = {
    backgroundColor: appearance.stepMarkerFillColor,
    borderColor: appearance.stepMarkerBorderColor,
    width: 8,
    height: 8,
    border: '1px solid',
    borderRadius: '50%'
  };

  const stepMarkers = routeSteps.slice(1).map((step, index) => {
    const position = {
      lat: step.startLocation.latLng.latitude,
      lng: step.startLocation.latLng.longitude
    };

    return (
      <AdvancedMarker
        key={`${index}-start`}
        anchorPoint={AdvancedMarkerAnchorPoint.CENTER}
        position={position}
      >
        <div style={stepMarkerStyle} />
      </AdvancedMarker>
    );
  });

  return (
    <>
      {polylines}
      {stepMarkers}
    </>
  );
};

export default React.memo(Route);

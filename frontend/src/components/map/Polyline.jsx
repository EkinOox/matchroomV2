import React, { useState, useEffect } from 'react';
import { useMap, useMapsLibrary } from '@vis.gl/react-google-maps';

export const Polyline = (props) => {
  const { encodedPath, ...polylineOptions } = props;

  const map = useMap();
  const geometryLibrary = useMapsLibrary('geometry');
  const mapsLibrary = useMapsLibrary('maps');

  const [polyline, setPolyline] = useState(null);

  useEffect(() => {
    if (!mapsLibrary) return;

    setPolyline(new mapsLibrary.Polyline());
  }, [mapsLibrary]);

  useEffect(() => {
    if (!polyline) return;

    polyline.setOptions(polylineOptions);
  }, [polyline, polylineOptions]);

  useEffect(() => {
    if (!encodedPath || !geometryLibrary || !polyline) return;

    polyline.setPath(geometryLibrary.encoding.decodePath(encodedPath));
  }, [polyline, encodedPath, geometryLibrary]);

  useEffect(() => {
    if (!map || !polyline) return;

    polyline.setMap(map);

    return () => polyline.setMap(null);
  }, [map, polyline]);

  return <></>;
};

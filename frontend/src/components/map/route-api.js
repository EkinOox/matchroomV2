const fields = ['routes.viewport', 'routes.legs', 'routes.polylineDetails'];

const ROUTES_API_ENDPOINT =
  'https://routes.googleapis.com/directions/v2:computeRoutes';

export class RoutesApi {
  constructor(apiKey) {
    this.apiKey = apiKey;
  }

  async computeRoutes(from, to, options) {
    const routeRequest = {
      origin: {
        location: { latLng: { longitude: from.lng, latitude: from.lat } }
      },
      destination: {
        location: { latLng: { longitude: to.lng, latitude: to.lat } }
      },
      ...options
    };

    const url = new URL(ROUTES_API_ENDPOINT);
    url.searchParams.set('fields', fields.join(','));

    const response = await fetch(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Goog-Api-Key': this.apiKey
      },
      body: JSON.stringify(routeRequest)
    });

    if (!response.ok) {
      throw new Error(
        `Request failed with status: ${response.status} - ${response.statusText}`
      );
    }

    return await response.json();
  }
}

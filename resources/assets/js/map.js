import GoogleMapsLoader from 'google-maps';

GoogleMapsLoader.KEY = 'AIzaSyD9AealJxpVSbpAREuECRLjdN45iCITeUo';

jQuery('.GoogleMap').each((i, map) => {
  const options = jQuery(map).data();
  GoogleMapsLoader.load((google)=> new google.maps.Map(map, options));
});

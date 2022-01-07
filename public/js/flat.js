let input = document.getElementById("city_autocomplete")
let options = {
    types: ['geocode'],
    componentRestrictions: {country: 'fr'}
};
new google.maps.places.Autocomplete(input, options);


function initialize() {
    var input = document.getElementById('city_autocomplete');
    var autocomplete = new google.maps.places.Autocomplete(input);
      google.maps.event.addListener(autocomplete, 'place_changed', function () {
          var place = autocomplete.getPlace();
          document.getElementById('zipcode').value = place.geometry.location.lng();
          document.getElementById('city').value = place.formatted_address;
          console.log(place);
      });
  }
  google.maps.event.addDomListener(window, 'load', initialize);
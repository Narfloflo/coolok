// Autosuggest & Autocomplet Api Google places
function initialize() {
    let input = document.getElementById('city_autocomplete');
    let options = {
        types: ['geocode'],
        componentRestrictions: {country: 'fr'}
    };

    let autocomplete = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        let place = autocomplete.getPlace();
        let zipcode = place.address_components[place.address_components.length - 1].long_name;
        let city = place.address_components[2].long_name;
        document.getElementById('city').value = city;  
        document.getElementById('zipcode').value = zipcode;           
        });
}
google.maps.event.addDomListener(window, 'load', initialize);
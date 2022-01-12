// Autosuggest Api Google places
function initialize() {
    let input = document.getElementById('city_autocomplete');
    let options = {
        types: ['(cities)'],
        componentRestrictions: {country: 'fr'}
    };

    let autocomplete = new google.maps.places.Autocomplete(input, options);
    google.maps.event.addListener(autocomplete, 'place_changed', function () {
        let place = autocomplete.getPlace();
        let city = place.address_components[0].long_name;
        document.getElementById('edit_account_city').value = city;       
        });
}
google.maps.event.addDomListener(window, 'load', initialize);

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('weather-panel', require('./components/WeatherPanel.vue'));
Vue.component('radar-panel', require('./components/RadarPanel.vue'));

const App = window.App = new Vue({
    el: '#app',
    data: {
        location_search: 'Louisville, KY',
        cors_proxy: 'https://cors-anywhere.herokuapp.com/',
        geocode_api_key: 'AIzaSyCy-f-Mnb0jJjkxdQEFeJ4Vl2gmBeRhEGA',
        weather_api_key: '1ecd65cf261cab9e7bc3b040e30e6c78'
    },
    methods: {
        fetchLatLng() {
            axios.get(this.buildGeocodeUrl()).then(response => {
                info = {
                    formatted_address: response.data.results[0].formatted_address,
                    location: response.data.results[0].geometry.location,
                };

                Event.fire('location:found', info);
            }).catch(errors => {
                Materialize.toast('There was an error fetching this location.', 5000);
            });
        },
        buildGeocodeUrl() {
            return this.cors_proxy +
                'https://maps.googleapis.com/maps/api/geocode/json?address=' +
                this.location_search +
                '&key=' +
                this.geocode_api_key;
        }
    },
    created() {
        this.fetchLatLng();
    }
});
<template>
    <div v-if="weather" class="weather-panel">
        <!-- Currently -->
        <h4>{{ formatted_address }}</h4>
        <div class="current-temperature--wrapper">
            <span class="current-temperature">{{ Math.floor(weather.currently.temperature) + deg }}</span>
            <canvas class="init-skycons" id="big_icon" :icon-source="weather.currently.icon" width="100" height="100"></canvas>
        </div>
        <p class="current-summary">{{ weather.currently.summary }}</p>
        <p class="current-wind">Wind: {{ windDirection(weather.currently.windBearing) }}, {{ Math.floor(weather.currently.windSpeed) }}mph</p>

        <!-- Forecast -->
        <div class="daily-forecast--wrapper">
            <!-- Current Day -->
            <div class="daily-forecast">
                <h5 class="daily-forecast__day">Today</h5>
                <div class="daily-forecast__skycon--wrapper">
                    <canvas class="init-skycons" id="'daily-forecast__skycon--today" :icon-source="weather.daily.data[0].icon" width="50" height="50"></canvas>
                </div>
                <span class="daily-forecast__temperature--low">L: {{ Math.floor(weather.daily.data[0].temperatureMin) + deg }}</span>
                <span class="daily-forecast__temperature--high">H: {{ Math.floor(weather.daily.data[0].temperatureMax) + deg }}</span>
            </div>
            <!-- Projected Week -->
            <div v-for="(item, index) in sevenDayForecast" class="daily-forecast">
                <h5 class="daily-forecast__day">{{ getReadableDay(item.time) }}</h5>
                <div class="daily-forecast__skycon--wrapper">
                    <canvas class="init-skycons" :id="'daily-forecast__skycon--' + index" :icon-source="item.icon" width="50" height="50"></canvas>
                </div>
                <span class="daily-forecast__temperature--low">L: {{ Math.floor(item.temperatureMin) + deg }}</span>
                <span class="daily-forecast__temperature--high">H: {{ Math.floor(item.temperatureMax) + deg }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                formatted_address: 'The middle of nowhere',
                location: {},
                weather: ''
            }
        },
        computed: {
            deg() {
                return String.fromCharCode('176');
            },
            sevenDayForecast() {
                var short_array = this.weather.daily.data;
                short_array.shift();
                return short_array;
            }
        },
        methods: {
            fetchWeatherData(response) {
                this.formatted_address = response.formatted_address;
                this.location = response.location;
                axios.get(this.buildWeatherApiUrl()).then(response => {
                    this.weather = response.data;
                }).catch(errors => {
                    Materialize.toast('Error fetching weather: ' + errors, 5000);
                });
            },
            buildWeatherApiUrl() {
                return this.$parent.cors_proxy + 'https://api.darksky.net/forecast/' +
                       this.$parent.weather_api_key + '/' +
                       this.location.lat + ',' + this.location.lng
            },
            initSkycons() {
                document.querySelectorAll('.init-skycons').forEach(element => {
                    skycons.set(element.getAttribute('id'), element.getAttribute('icon-source'));
                });

                skycons.play();
            },
            windDirection(bearing) {
                var windDirections = {
                    0: 'North',
                    1: 'North East',
                    2: 'East',
                    3: 'South East',
                    4: 'South',
                    5: 'South West',
                    6: 'West',
                    7: 'North West',
                    8: 'North'
                };

                var quad = Math.floor(Math.floor(bearing) / 40);
                return windDirections[quad];
            },
            getReadableDay(timestamp) {
                var date = new Date(timestamp * 1000);
                return date.toString().split(' ')[0];
            },
            parentMethods() {
                return this.$parent.$options.methods;
            }
        },
        updated() {
            this.initSkycons();
        },
        created() {
            Event.listen('location:found', this.fetchWeatherData);
        }
    }
</script>
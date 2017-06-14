<template>
    <div id="map"></div>
</template>

<script>
    export default {
        data() {
            return {
                // Some data
            }
        },
        methods: {
            initMap(response) {
                // Instantiate google maps instance with basemap at coordinates
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 7,
                    center: {lat: response.location.lat, lng: response.location.lng},
                    mapTypeId: google.maps.MapTypeId.HYBRID
                });
                var marker = new google.maps.Marker({
                    position: {lat: response.location.lat, lng: response.location.lng},
                    map: map,
                    title: 'You be Hurr'
                });

                // Weather layer source via tile server API
                var tileNEX = new google.maps.ImageMapType({
                    getTileUrl: function(tile, zoom) {
                        // Append (new Date()).getTime() to prevent browser caching of returned images
                        return "http://mesonet.agron.iastate.edu/cache/tile.py/1.0.0/nexrad-n0q-900913/" +
                                zoom + "/" + tile.x + "/" + tile.y +".png?"+ (new Date()).getTime();
                    },
                    tileSize: new google.maps.Size(256, 256),
                    opacity:0.50,
                    name : 'NEXRAD',
                    isPng: true
                });

                // Apply tile to basemap
                map.overlayMapTypes.setAt("0",tileNEX);
            }
        },
        created() {
            Event.listen('location:found', this.initMap);
            Event.listen('map:refresh', this.initMap)
        }
    }
</script>
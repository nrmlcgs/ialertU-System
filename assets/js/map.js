var map;
var selectedMarker;
var routingControl;
let mapstartL = 13.2265;
let mapstartLo = 120.5947;
var locationsArray = [];
var newlocationsArray = [];
var complete_location = [];
let startplace;
var intervalId;
var isMapLoaded = false;

function openStreetMap() {
    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    });
    osm.addTo(map);
    osm.on('load', function () {
        if (!isMapLoaded) {
            $('.loader').hide();
            intervalId = setInterval(reloadmapcon, 2000);
            isMapLoaded = true; // Set the flag to true after the initial load
        }
    });
}
function addRipple(marker) {
    var ripple = L.divIcon({
        className: 'ripple',
        iconSize: [100, 100],
        iconAnchor: [50, 50],
        html: '<div class="circle"></div>'
    });
    L.marker(marker.getLatLng(), { icon: ripple }).addTo(map);
 
    marker.on('click', function () {
        var locationData = marker.options.locationData;
        showDetails(locationData);
    });
}
function playRippleSound() {
    // Get the audio element
    var audio = document.getElementById('rippleAudio');

    // Check if the audio element is supported
    if (audio && typeof audio.play === 'function') {
        // Play the audio
        audio.play();
    }
}
function addMarkers(locations) {
    for (var i = 0; i < locations.length; i++) {
        let a = "";
        var redIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });
        var marker = L.marker([locations[i].lat, locations[i].lng], { icon: redIcon }).addTo(map);
        addRipple(marker);

        marker.on('popupclose', function (e) {
            document.getElementById('emerID').style.display = 'none'
        });
        if (locations[i].brgy !== undefined) {
            a = locations[i].brgy;
        } else {
            a = locations[i].area

        }
        marker.bindPopup('<b>' + locations[i].title + '</b><br>' + a);
        marker.options.locationData = locations[i];
    }
}
function addRoutingControl(loc) {
    try {
        routingControl.setWaypoints([]);
        routingControl.remove();
    } catch (error) {

    }

    var waypoints = [
        L.latLng(mapstartL, mapstartLo)
    ];
    if (loc !== undefined) {
        waypoints.push(L.latLng(loc[0], loc[1]));
    }

    routingControl = L.Routing.control({
        waypoints: waypoints,
        routeWhileDragging: false
    }).addTo(map);
    var startMarker = L.marker(waypoints[0]).addTo(map);
    startMarker.bindPopup(startplace).openPopup();

    var customButton = L.DomUtil.create('button', 't-remove');
    customButton.innerHTML = 'x';

    var routingContainer = map.getContainer().querySelector('.leaflet-routing-container');
    routingContainer.insertAdjacentHTML('afterbegin', customButton.outerHTML);

    var updateButtonPosition = function () {
        var point = map.latLngToContainerPoint(routingControl.getWaypoints()[0].latLng);
        L.DomUtil.setPosition(customButton, point, false);
    };

    updateButtonPosition();
    let elements = document.getElementsByClassName('t-remove');
    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', function (e) {
            routingControl.remove();
        });
    }
}
function mapconfig(locations) {
    if (localStorage.getItem('o') == 0) {
        mapstartL = 13.2265;
        mapstartLo = 120.5947;
        startplace = '<b>Starting Point:</b><br>Occidental Mindoro<br>Mamburao, Municipal Hall';
    } else {
        startplace = '<b>Starting Point:</b><br>Occidental Mindoro<br>Mamburao, Fire Station';
        mapstartL = 13.219744;
        mapstartLo = 120.600341;
    }
    map = L.map('dashmap').setView([mapstartL, mapstartLo], 12);
    openStreetMap();
    addMarkers(locations);
    map.setZoom(16);
    L.easyButton('fa-globe', function () {
        toggleFullScreen(); // Call the full-screen function
    }).addTo(map);

    // Full-screen function
    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen();
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        }
    }
}
function updateMarkers(newLocations) {
    map.eachLayer(function (layer) {
        if (layer instanceof L.Marker) {
            map.removeLayer(layer);
        }
    });
    addMarkers(newLocations);
}
function respondMark(targetLat, targetLng, targetID) {

    if (complete_location.length == 0) {
        complete_location = newlocationsArray
    } else {
        let filtercomplete_location = newlocationsArray.filter(item1 => !complete_location.some(item2 => item2.id === item1.id));
        complete_location = complete_location.concat(filtercomplete_location);
        newlocationsArray = [];
    }
    $.ajax({
        type: "POST",
        url: `/ialertu/Controllers/Accident.php?f=ues`,
        data: { id: targetID, },
        success: function (data) {
            if (data == 'responded') {
                var indexToRemoveC = complete_location.findIndex(item => item.id === targetID);
                if (indexToRemoveC !== -1) {
                    complete_location.splice(indexToRemoveC, 1);

                }
                updateMarkers(complete_location);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Unknown Report! Please reload the page."
                });
            }
        }
    });
    updateMarkers(complete_location);

}
function isEqual(obj1, obj2) {
    return Object.keys(obj1).every(key => obj2.hasOwnProperty(key) && obj1[key] === obj2[key]);
}

function reloadmapcon() {
    $.ajax({
        url: `/ialertu/Controllers/Accident.php?f=ger`,
        dataType: 'JSON',
        success: function (response) {
            let temparray = [];
            let filternewlocationsArray = [];
            for (let i = 0; i < response.length; i++) {
                var myObject = {
                    id: response[i]['id'],
                    lat: response[i]['lat'],
                    lng: response[i]['lon'],
                    vnum: response[i]['num'],
                    pic: response[i]['picture'],
                    type: response[i]['type'],
                    uID: response[i]['uID'],
                    o: response[i]['o'],
                    est: response[i]['est'],
                    col: response[i]['col'],
                };
                temparray.push(myObject);
            }

            if (locationsArray.length == 0) {
                locationsArray = temparray
                filternewlocationsArray = temparray
            } else {
                filternewlocationsArray = temparray.filter(item1 => !locationsArray.some(item2 => item2.id === item1.id));
                locationsArray = locationsArray.concat(filternewlocationsArray);
            }


            let newData = [];
            var promises = [];
            for (let i = 0; i < filternewlocationsArray.length; i++) {
                // Create a promise for each AJAX request
                var promise = $.ajax({
                    url: `https://nominatim.openstreetmap.org/reverse?lat=${filternewlocationsArray[i].lat}&lon=${filternewlocationsArray[i].lng}&format=json`,
                    success: function (response) {
                        let faddress = response.address;
                        newData.push({
                            lat: filternewlocationsArray[i].lat,
                            lng: filternewlocationsArray[i].lng,
                            title: faddress.road == undefined ? 'unknown' : faddress.road,
                            area: faddress.neighbourhood,
                            brgy: faddress.quarter,
                            id: filternewlocationsArray[i].id,
                            vnum: filternewlocationsArray[i].vnum,
                            pic: filternewlocationsArray[i].pic,
                            type: filternewlocationsArray[i].type,
                            uID: filternewlocationsArray[i].uID,
                            o: filternewlocationsArray[i]['o'],
                            est: filternewlocationsArray[i]['est'],
                            col: filternewlocationsArray[i]['col'],
                        });
                    },
                    error: function (xhr, status, error) {
                    }
                });
                promises.push(promise);
            }
            $.when.apply($, promises).then(function () {
                if (newlocationsArray.length == 0) {
                    if (newData.length !== 0) {
                        newlocationsArray = newData;
                        addMarkers(newData);
                    }
                } else {
                    let finalfiltereddata = newData.filter(item1 => !newlocationsArray.some(item2 => item2.id === item1.id));
                    if (finalfiltereddata.length > 0) {
                        for (let i = 0; i < finalfiltereddata.length; i++) {
                            newlocationsArray.push(finalfiltereddata[i])
                        }
                        addMarkers(finalfiltereddata);
                    }
                }

            });
        },
        error: function (xhr, status, error) {
            // Handle the error if the AJAX request fails
            console.error("Error in AJAX request:", error);
        }
    });
}
function showDetails(locationData) {

    let a, b, loca, locb, attch, barangay = "";
    if (locationData.o == 0) {
        a = 'Incident:';
        b = 'Number of Victims:';
        loca = locationData.type;
        locb = locationData.vnum;
    } else {
        a = 'Building:';
        b = 'Fire Color:';
        loca = locationData.est;
        locb = locationData.col;
    }
    if (locationData.pic == "") {
        attch = "default.png";
    } else {
        attch = locationData.pic;
    }
    if (locationData.brgy !== undefined) {
        barangay = `
        <p class="m-0">
        <span class="fw-semibold">Barangay</span><br>
      <p class="px-2">${locationData.brgy}</p>
      </p>
        `;
    }
    document.getElementById('emerID').style.display = 'block';
    document.getElementById('infoDiv').innerHTML = `
                    <p class="fs-6 c-pointer" onclick="addRoutingControl([${locationData.lat},${locationData.lng}])" >
                      <i class="fa-solid fa-route me-3" style="color:#409abf"></i>Go to location
                    </p>
                    <p class="fs-6 c-pointer" onclick="respondMark(${locationData.lat},${locationData.lng},${locationData.id})">
                      <i class="text-success fa-solid fa-truck-pickup me-2"></i> Respond
                    </p>
                    <p class="m-0">
                      <span class="fw-semibold">Street:</span><br>
                      <p class="px-2">${locationData.title}</p>
                    </p>

                    <p class="m-0">
                      <span class="fw-semibold">Area</span><br>
                    <p class="px-2">${locationData.area}</p>
                    </p>

                  ${barangay}

                    <p class="m-0">
                      <span class="fw-semibold">${a}</span><br>
                    <p class="px-2">${loca}</p>
                    </p>

                    <p class="m-0">
                      <span class="fw-semibold">${b}</span><br>
                      <p class="px-2">${locb}</p>
                    </p>

                    <p class="m-0">
                      <span class="fw-semibold">Attachment:</span><br>
                      <p class="px-2"><img src="/ialertu/uploads/${attch}" alt="" width="150" height="150"></p>
                    </p>
                    <hr>
    `;
}


<div class="modal fade" id="ajaxModel2" role="dialog" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="formInput2" name="formInput2" action="">
                @csrf
                <input type="hidden" name="id2" id="formId2">
                <input type="hidden" id="_method2" name="_method" value="">
                <div class="modal-header">
                    <h5 class="modal-title"> <label id="headForm2"></label> Absensi </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 mb-2" id="pemberitahuannya">
                        <button style="width:100%" type="button" class="btn btn-danger btn-icon icon-left">
                            <i class="fas fa-bell"></i> Anda tidak berada di lokasi kerja <span class="badge badge-transparent"></span>
                        </button>
                    </div>
                    <div id="map" class="my-4" style="height: 400px;"></div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('jsScriptAjax')
<script type="text/javascript">
    let lat, long;

    function absenForm(lats, longs) {
        $('#formInput2').trigger("reset");
        $("#headForm2").empty();
        $("#headForm2").append("Form ");
        $('#saveBtn2').show();
        $('#formId2').val('');
        $('#ajaxModel2').modal('show');
        $('#_method2').val('POST');
        $("#form-surat-sakit").hide();
        $("#sakitBtn").hide();
        lat = lats;
        long = longs;
        jalan();
    }

    function jalan() {

        const image =
            "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
        const beachMarker = new google.maps.Marker({
            position: {
                lat: myLatLng.lat,
                lng: myLatLng.lng
            },
            map,
            icon: image,
        });

        const cityCircle = new google.maps.Circle({
            strokeColor: "#1a66ff",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#e6eeff",
            fillOpacity: 0.35,
            map,
            center: myLatLng,
            radius: 50,
        });

        const options = {
            enableHighAccuracy: true,
            timeout: 1000,
        };

        const pos = {
            lat: lat,
            lng: long,
        };
        let distan = getDistance(lat, long)

        console.log(distan + " Meter")
        if (distan >= 100) {
            $("#alasannya").show();
            $("#pemberitahuannya").show();
        } else {
            $("#alasannya").hide();
            $("#pemberitahuannya").hide();
        }
        infoWindow.setPosition(pos);
        infoWindow.setContent("Location found.");
        infoWindow.open(map);
        map.setCenter(pos);
    }

    //! ------------------------------------- Maps
    let map, infoWindow;

    // Unitama Location
    const myLatLng = {
        lat: -5.1416248,
        lng: 119.4848931
    };

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 20,
            center: myLatLng,
        });
        infoWindow = new google.maps.InfoWindow();
    }

    const getDistance = (lat, lng) => {
        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        function square(x) {
            return Math.pow(x, 2);
        }
        let r = 6371000; // radius of the earth in km
        lat = deg2rad(lat);
        myLatLng.lat = deg2rad(myLatLng.lat);
        let lat_dif = myLatLng.lat - lat;
        let lng_dif = deg2rad(myLatLng.lng - lng);
        let a =
            square(Math.sin(lat_dif / 2)) +
            Math.cos(lat) * Math.cos(myLatLng.lat) * square(Math.sin(lng_dif / 2));
        let d = 2 * r * Math.asin(Math.sqrt(a));
        // Meter
        return d.toFixed(0);
    };

    window.initMap = initMap;
</script>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBEMiAdMOBk5hxM-B8oY9ckRYbsqVJmOSk&callback=initMap"></script>
@endpush
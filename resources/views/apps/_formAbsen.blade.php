<div class="modal fade" id="ajaxModel2" role="dialog" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="formInput2" name="formInput2" action="">
                @csrf
                <input type="hidden" name="id2" id="formId2">
                <input type="hidden" id="_method2" name="_method" value="">
                <input type="hidden" id="lat" name="lat" value="">
                <input type="hidden" id="long" name="long" value="">
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
                    <div class="form-row my-2">
                        <label class="form-label">Kondisi</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input id="kondisi" type="radio" name="status" value="Hadir" class="selectgroup-input" checked="">
                                <span class="selectgroup-button">Sehat</span>
                            </label>
                            <label class="selectgroup-item">
                                <input id="kondisi" type="radio" name="status" value="Sakit" class="selectgroup-input">
                                <span class="selectgroup-button">Sakit</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-row" id="alasannya">
                        <div class="form-group col-md-12">
                            <label>Alasan</label>
                            <textarea class="form-control" name="ket" id="ket"></textarea>
                        </div>
                    </div>
                    <div class="form-row" id="form-surat-sakit">
                        <div class="form-group col-md-12">
                            <label>Surat Sakit</label>
                            <input type="file" class="form-control" name="surat_sakit" id="surat_sakit" required />
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning mr-2" id="sakitBtn" value="izin">Izin</button>
                    <button type="submit" class="btn btn-success" id="saveBtn2" value="create">Absen</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('jsScriptAjax')
<script type="text/javascript">
    function absenForm() {
        $('#formInput2').trigger("reset");
        $("#headForm2").empty();
        $("#headForm2").append("Form ");
        $('#saveBtn2').show();
        $('#formId2').val('');
        $('#ajaxModel2').modal('show');
        $('#_method2').val('POST');
        $("#form-surat-sakit").hide();
        $("#sakitBtn").hide();
    }
</script>
<script type="text/javascript">
    let urlx = "";
    $("#pilihan").on('change', function(event) {
        let pilih = $('#pilihan').val();
        if (pilih == '0') {
            $('#option').show();
        } else {
            $('#option').hide();
        }
    });
    loadpage('', "{{ config('constants.PAGINATION') }}");
    var $pagination = $('.twbs-pagination');
    var defaultOpts = {
        totalPages: 1,
        prev: '&#8672;',
        next: '&#8674;',
        first: '&#8676;',
        last: '&#8677;',
    };
    $pagination.twbsPagination(defaultOpts);

    function loaddata(page, cari, jml) {
        $.ajax({
            url: urlx + '/data',
            data: {
                "page": page,
                "cari": cari,
                "jml": jml
            },
            type: "GET",
            datatype: "json",
            success: function(data) {
                $(".datatabel").html(data.html);
            }
        });
    }

    function loadpage(cari, jml) {
        $.ajax({
            url: urlx + '/data',
            data: {
                "cari": cari,
                "jml": jml
            },
            type: "GET",
            datatype: "json",
            success: function(response) {
                console.log(response);
                if ($pagination.data("twbs-pagination")) {
                    $pagination.twbsPagination('destroy');
                    $(".datatabel").html('<tr><td colspan="8">Data not found</td></tr>');
                }
                $pagination.twbsPagination($.extend({}, defaultOpts, {
                    startPage: 1,
                    totalPages: response.total_page,
                    visiblePages: 8,
                    prev: '&#8672;',
                    next: '&#8674;',
                    first: '&#8676;',
                    last: '&#8677;',
                    onPageClick: function(event, page) {
                        if (page == 1) {
                            var to = 1;
                        } else {
                            var to = page * jml - (jml - 1);
                        }
                        if (page == response.total_page) {
                            var end = response.total_data;
                        } else {
                            var end = page * jml;
                        }
                        $('#contentx').text('Showing ' + to + ' to ' + end +
                            ' of ' + response.total_data + ' entries');
                        loaddata(page, cari, jml);
                    }
                }));
            }
        });
    }

    $("[name='status']").change(function() {
        if ($(this).val() == "Sakit") {
            $("#form-surat-sakit").show();
            $("#sakitBtn").show();
            $("#saveBtn2").hide();
        } else {
            $("#form-surat-sakit").hide();
            $("#sakitBtn").hide();
            $("#saveBtn2").show();
        }
    });


    //! ------------------------------------- Maps
    let map, infoWindow;

    // Unitama Location
    // const myLatLng = {
    //     lat: -5.1416248,
    //     lng: 119.4848931
    // };
    const myLatLng = {
        lat: -5.1384705,
        lng: 119.4844017
    };

    function initMap() {
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 20,
            center: myLatLng,
        });
        infoWindow = new google.maps.InfoWindow();

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

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    let distan = getDistance(position.coords.latitude, position.coords.longitude)
                    $('#lat').val(position.coords.latitude);
                    $('#long').val(position.coords.longitude);
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
                },
                () => {
                    handleLocationError(true, infoWindow, map.getCenter());
                }, () => {}, options
            );
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
        }
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

    $('#saveBtn2').click(function(e) {
        e.preventDefault();
        $.ajax({
            data: $('#formInput2').serialize(),
            url: "{{route('home.absensi')}}",
            type: "POST",
            dataType: 'json',
            success: function(data) {
                $('#formInput2').trigger("reset");
                $('#ajaxModel2').modal('hide');
                loaddata('', "{{config('constants.PAGINATION')}}");
                iziToast.success({
                    title: 'Successfull.',
                    message: 'Save it data!',
                    position: 'topRight',
                    timeout: 1500
                });
            },
            error: function(data) {
                console.log('Error:', data);
                $('#formInput2').trigger("reset");
                $('#ajaxModel2').modal('hide');
                iziToast.error({
                    title: 'Failed,',
                    message: 'Save it data!',
                    position: 'topRight',
                    timeout: 1500
                });
            }
        });
    });

    $('#sakitBtn').click(function(e) {
        e.preventDefault();
        let formData = new FormData(formInput2);
        formData.append('surat_sakit', surat_sakit);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: urlx + "/izinSakit",
            data: formData,
            type: "POST",
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(data) {
                $('#formInput2').trigger("reset");
                $('#ajaxModel2').modal('hide');
                loadpage('', "{{ config('constants.PAGINATION') }}");
                iziToast.success({
                    title: 'Successfull.',
                    message: 'Create it data!',
                    position: 'topRight'
                });
            },
            error: function(data) {
                iziToast.error({
                    title: 'Failed.',
                    message: 'Create it data!',
                    position: 'topRight'
                });
            }
        });
    });

    window.initMap = initMap;
</script>

<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyBEMiAdMOBk5hxM-B8oY9ckRYbsqVJmOSk&callback=initMap"></script>
@endpush

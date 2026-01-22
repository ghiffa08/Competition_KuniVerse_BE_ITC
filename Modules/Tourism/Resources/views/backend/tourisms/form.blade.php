
@push('after-styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.11.0/dist/geosearch.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet" />
<style>
    .note-editor.note-frame :after { display: none; }
    .note-editor .note-toolbar .note-dropdown-menu, .note-popover .popover-content .note-dropdown-menu { min-width: 180px; }
</style>
@endpush

<div class="row">
    {{ html()->hidden('type', 'wisata') }}
    
    <div class="col-12 col-sm-4 mb-3">
        <label class="form-label">Nama Wisata</label>
        {{ html()->text('name')->class('form-control')->placeholder('Contoh: Waduk Darma')->attributes(['required']) }}
    </div>
    
    <div class="col-12 col-sm-4 mb-3">
        <label class="form-label">Slug (URL)</label>
        {{ html()->text('slug')->id('slug')->class('form-control')->attribute('readonly', 'readonly') }}
    </div>

    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'status';
            $field_label = 'Status Publikasi';
            $required = "required";
            $select_options = [
                '1'=>'Diterbitkan',
                '0'=>'Tidak Diterbitkan',
                '2'=>'Draft'
            ];
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->select($field_name, $select_options)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <label class="form-label">Harga Tiket</label>
        {{ html()->text('price')
            ->id('price-input')
            ->placeholder('Rp 0')
            ->class('form-control')
            ->attributes(['required'])
            ->value(isset($$module_name_singular) ? number_format($$module_name_singular->price, 0, ',', '.') : '') 
        }}
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <label class="form-label">Jam Operasional</label>
        <div class="input-group">
            <input type="time" id="start_time" class="form-control" placeholder="Buka">
            <span class="input-group-text">s/d</span>
            <input type="time" id="end_time" class="form-control" placeholder="Tutup">
        </div>
        <?php
            $open_hours_val = old('open_hours') ?? (isset($$module_name_singular) ? $$module_name_singular->open_hours : null);
        ?>
        {{ html()->hidden('open_hours', $open_hours_val)->id('open_hours') }}
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <label class="form-label">Gambar Utama</label>
        <div class="input-group mb-3">
            {{ html()->text('image')->id('image')->placeholder('Pilih Gambar')->class('form-control')->attributes(['required', 'aria-label' => 'Image', 'aria-describedby' => 'button-image']) }}
            <button class="btn btn-outline-info" id="button-image" data-input="image" data-preview="holder" type="button">
                <i class="fas fa-folder-open"></i>
                &nbsp;
                Cari
            </button>
        </div>
        <div id="holder" class="mt-2" style="max-height:100px;">
            @if(isset($$module_name_singular) && $$module_name_singular->image)
                <img src="{{ $$module_name_singular->image }}" alt="Preview" class="img-thumbnail" style="height: 5rem;">
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <label class="form-label">Deskripsi Singkat (Intro)</label>
        {{ html()->textarea('intro')->placeholder('Ringkasan singkat untuk tampilan kartu...')->class('form-control')->rows(3) }}
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Konten Lengkap (Deskripsi Utuh)</label>
        {{ html()->textarea('content')
            ->id('content')
            ->placeholder('Deskripsi lengkap wisata...')
            ->class('form-control')
            ->rows(6)
            ->value(old('content') ?? (isset($$module_name_singular) ? $$module_name_singular->content : ''))
        }}
    </div>
    <div class="col-12 mb-3">
        <label class="form-label">Fasilitas</label>
        {{ html()->textarea('facilities')->placeholder('List fasilitas (contoh: WiFi, Parkir, Musholla)...')->class('form-control')->rows(3) }}
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <div class="form-group">
            <?php
            $field_name = 'note';
            $field_label = 'Catatan Internal (Opsional)';
            $field_placeholder = 'Catatan tambahan...';
            $required = "";
            ?>
            {{ html()->label($field_label, $field_name)->class('form-label') }} {!! field_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12 mb-3">
        <label class="form-label">Peta Lokasi (Pilih Titik)</label>
        <div id="map" style="height: 400px; border-radius: 8px; border: 1px solid #dee2e6;"></div>
        <small class="text-muted">Geser marker untuk menentukan lokasi.</small>
        
        <?php
            $latitude_val = old('latitude') ?? (isset($$module_name_singular) ? $$module_name_singular->latitude : null);
            $longitude_val = old('longitude') ?? (isset($$module_name_singular) ? $$module_name_singular->longitude : null);
        ?>
        {{ html()->hidden('latitude', $latitude_val)->id('latitude') }}
        {{ html()->hidden('longitude', $longitude_val)->id('longitude') }}
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <label class="form-label">Alamat Lengkap</label>
        {{ html()->textarea('address')->placeholder('Alamat Lengkap (Terisi Otomatis dari Peta)')->class('form-control')->rows(3)->attribute('readonly', 'readonly') }}
    </div>
</div>

<x-library.select2 />


@push('after-scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-geosearch@3.11.0/dist/geosearch.umd.js"></script>
<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

{{-- Inline LFM Script to ensure it loads --}}
<script>
    (function( $ ){
      $.fn.filemanager = function(type, options) {
        type = type || 'file';

        this.on('click', function(e) {
          var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
          var target_input = $('#' + $(this).data('input'));
          var target_preview = $('#' + $(this).data('preview'));
          window.open(route_prefix + '?type=' + type, 'FileManager', 'width=900,height=600');
          window.SetUrl = function (items) {
            var file_path = items.map(function (item) {
              return item.url;
            }).join(',');

            // set the value of the desired input to image url
            target_input.val('').val(file_path).trigger('change');

            // clear previous preview
            target_preview.html('');

            // set or change the preview image src
            items.forEach(function (item) {
              target_preview.append(
                $('<img>').css('height', '5rem').addClass('img-thumbnail').attr('src', item.thumb_url)
              );
            });

            // trigger change event
            target_preview.trigger('change');
          };
          return false;
        });
      }
    })(jQuery);
</script>

<script type="module">
    // Init Summernote
    $('#content').summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });

    // Init LFM
    $('#button-image').filemanager('image');

    // Auto Slug
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.getElementById('slug');

    if(nameInput && slugInput) {
        nameInput.addEventListener('change', function() {
            let title = nameInput.value;
            let slug = title.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            slugInput.value = slug;
        });
    }

    // ----------------------------------------
    // PRICE FORMATTING FIX (Removed 'Input' event, using 'Keyup' with stricter regex)
    // ----------------------------------------
    const priceInput = document.getElementById('price-input');
    
    function formatRupiah(angka) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
            
        if(ribuan){
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return 'Rp ' + rupiah;
    }

    if(priceInput) {
        // Run once on load to format existing value (e.g. 50000 -> Rp 50.000)
        // Only if it doesn't already have Rp to avoid double prefix
        if(priceInput.value && !priceInput.value.trim().startsWith('Rp')) {
             priceInput.value = formatRupiah(priceInput.value);
        }

        priceInput.addEventListener('keyup', function(e) {
            // Allow arrow keys
            if ([37, 38, 39, 40].indexOf(e.keyCode) > -1) return;
            
            // Re-format
            this.value = formatRupiah(this.value);
        });
    }

    // ----------------------------------------
    // OPENING HOURS LOGIC - Populate from DB
    // ----------------------------------------
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    const openHours = document.getElementById('open_hours');

    function updateOpenHours() {
        if(startTime.value && endTime.value) {
            openHours.value = startTime.value + ' - ' + endTime.value;
        } else {
            openHours.value = '';
        }
    }

    if(startTime && endTime && openHours) {
        // Pre-fill inputs from hidden value (DB value)
        const existingValue = openHours.value;
        if(existingValue && existingValue.includes(' - ')) {
            const parts = existingValue.split(' - ');
            if(parts.length === 2 && parts[0] && parts[1]) {
                startTime.value = parts[0].trim();
                endTime.value = parts[1].trim();
            }
        }

        startTime.addEventListener('change', updateOpenHours);
        endTime.addEventListener('change', updateOpenHours);
    }
    
    // ----------------------------------------
    // MAP LOGIC
    // ----------------------------------------
    const provider = new GeoSearch.OpenStreetMapProvider();
    
    // Default location (Kuningan)
    let defaultLat = -6.9775;
    let defaultLng = 108.4864;
    
    // Check if we have saved values
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const addressInput = document.querySelector('textarea[name="address"]'); // Use querySelector for reliability

    if(latInput.value && lngInput.value) {
        defaultLat = parseFloat(latInput.value);
        defaultLng = parseFloat(lngInput.value);
    }

    const map = L.map('map').setView([defaultLat, defaultLng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    let marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

    function updateAddress(lat, lng) {
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                if(data && addressInput) {
                    addressInput.value = data.display_name;
                }
            });
    }

    marker.on('dragend', function(e) {
        let lat = e.target.getLatLng().lat;
        let lng = e.target.getLatLng().lng;
        latInput.value = lat;
        lngInput.value = lng;
        updateAddress(lat, lng);
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        latInput.value = e.latlng.lat;
        lngInput.value = e.latlng.lng;
        updateAddress(e.latlng.lat, e.latlng.lng);
    });

    const searchControl = new GeoSearch.GeoSearchControl({
        provider: provider,
        style: 'bar',
        autoComplete: true, 
        autoCompleteDelay: 250,
        showMarker: false, 
        retainZoomLevel: false, 
        animateZoom: true, 
        keepResult: true,
        searchLabel: 'Cari lokasi...',
    });

    map.addControl(searchControl);
    
    // Listen for search selection
    map.on('geosearch/showlocation', function(result) {
        if(result && result.location) {
             let lat = result.location.y;
             let lng = result.location.x;
             let label = result.location.label;
             
             marker.setLatLng([lat, lng]);
             latInput.value = lat;
             lngInput.value = lng;
             
             if(addressInput) addressInput.value = label;
        }
    });

</script>
@endpush

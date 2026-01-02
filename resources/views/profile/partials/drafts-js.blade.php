<script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ==================================================
        📍 1) REGION → CITY → DISTRICT (динамический выбор)
        ================================================== */

        let region = document.querySelector('select[name="region_id"]');
        let city = document.querySelector('select[name="city_id"]');
        let district = document.querySelector('select[name="district_id"]');

        const oldRegion = "{{ old('region_id') }}";
        const oldCity = "{{ old('city_id') }}";
        const oldDistrict = "{{ old('district_id') }}";

        // Подгрузка городов
        function loadCities(regionId, restore = false) {
            fetch(`/cities/${regionId}`)
                .then(r => r.json())
                .then(data => {
                    city.innerHTML = `<option value="">Выберите город</option>`;
                    city.disabled = false;
                    data.forEach(c =>
                        city.innerHTML += `<option value="${c.id}">${c.name}</option>`
                    );
                    if (restore && oldCity) {
                        city.value = oldCity;
                        loadDistricts(oldCity, true);
                    }
                });
        }

        // Подгрузка районов
        function loadDistricts(cityId, restore = false) {
            fetch(`/districts/${cityId}`)
                .then(r => r.json())
                .then(data => {
                    district.innerHTML = `<option value="">Выберите район</option>`;
                    district.disabled = false;
                    data.forEach(d =>
                        district.innerHTML += `<option value="${d.id}">${d.name}</option>`
                    );
                    if (restore && oldDistrict) district.value = oldDistrict;
                });
        }

        // Первоначальная загрузка + восстановление из old()
        fetch('/regions').then(r => r.json()).then(data => {
            region.innerHTML = `<option value="">Выберите регион</option>`;
            data.forEach(r => region.innerHTML += `<option value="${r.id}">${r.name}</option>`);
            if (oldRegion) {
                region.value = oldRegion;
                loadCities(oldRegion, true);
            }
        });

        // Изменение региона
        region.addEventListener('change', function () {
            city.innerHTML = `<option value="">Загрузка...</option>`;
            loadCities(this.value);
        });

        // Изменение города
        city.addEventListener('change', function () {
            loadDistricts(this.value);
            let regionId = this.options[this.selectedIndex].dataset.region;
            if (regionId) region.value = regionId;
        });

        /* ==================================================
        📝 2) Автосохранение (каждые 7 секунд)
        ================================================== */

        setInterval(() => {
            let formData = new FormData(document.getElementById('listingForm'));
            fetch("{{ route('draft.save') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            });
        }, 7000);

        /* ==================================================
        📸 3) Drag & Drop Upload + WebP compression
        ================================================== */

        const dropBox = document.getElementById('dropBox');
        const draftPhotos = document.getElementById('draftPhotos');
        const previewArea = document.getElementById('previewArea');

        // Click → trigger file input
        dropBox.addEventListener('click', () => draftPhotos.click());

        // Highlight on drag
        ['dragenter', 'dragover'].forEach(evt =>
            dropBox.addEventListener(evt, e => {
                e.preventDefault();
                dropBox.style.background = "#eefdf7";
            })
        );
        ['dragleave', 'drop'].forEach(evt =>
            dropBox.addEventListener(evt, e => {
                e.preventDefault();
                dropBox.style.background = "#f9faf9";
            })
        );

        // Drop & Input events
        dropBox.addEventListener('drop', e => handleFiles(e.dataTransfer.files));
        draftPhotos.addEventListener('change', e => handleFiles(e.target.files));

        // Array handler
        function handleFiles(files) {
            [...files].forEach(file => compressAndUpload(file));
        }

        // WebP compress + preview + upload
        function compressAndUpload(file, quality = 0.75) {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = e => {
                const img = new Image();
                img.src = e.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    canvas.getContext('2d').drawImage(img, 0, 0);
                    canvas.toBlob(blob => {
                        uploadBlob(blob);
                        showPreview(URL.createObjectURL(blob), blob);
                    }, 'image/webp', quality);
                };
            };
        }

        // AJAX upload to server
        function uploadBlob(blob) {
            let fd = new FormData();
            fd.append('file', blob, `draft_${Date.now()}.webp`);
            fetch("{{ route('draft.photo') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: fd
            });
        }

        // Show preview
        function showPreview(src, blob) {
            let box = document.createElement('div');
            box.classList.add('position-relative');
            box.style.width = "110px";
            box.innerHTML = `
                <img src="${src}" class="rounded shadow-sm" 
                    style="width:110px;height:110px;object-fit:cover;">
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 removeDraftPhoto"
                        style="padding:2px 6px;">✕</button>
            `;
            previewArea.appendChild(box);
        }

        // Delete preview (client only, server deletion next version)
        document.addEventListener('click', e => {
            if (e.target.classList.contains('removeDraftPhoto')) {
                e.target.parentNode.remove();
            }
        });

    });
</script>

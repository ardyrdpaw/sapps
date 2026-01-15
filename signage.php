<?php include 'layout_header.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
<!-- Signage Content -->
<div class="container-fluid mt-4">
    <h1 class="h3 mb-4">Signage</h1>
    <div id="crudAlert" style="display:none;"></div>
    
    <!-- Activities Management Section -->
    <div class="card mt-4">
        <div class="card-header">Activities Management (Kegiatan & Agenda)</div>
        <div class="card-body">
            <div class="mb-3">
                <button class="btn btn-success" id="addActivityBtn">Add Activity</button>
                <a class="btn btn-outline-primary ms-2" id="previewSignageBtn" href="saview.php" target="_blank" rel="noopener noreferrer" title="Open signage viewer in a new tab"><i class="bi bi-eye"></i> Preview</a>
            </div>
            <ul class="nav nav-tabs mb-3" id="activityTabs" role="tablist">
                <li class="nav-item" role="presentation"><button class="nav-link active" data-actcat="Kegiatan" type="button">Kegiatan</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" data-actcat="Agenda" type="button">Agenda</button></li>
            </ul>
            <div class="activity-table-wrapper">
            <table class="table table-bordered" id="activitiesTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kegiatan</th>
                        <th>Tempat</th>
                        <th>Waktu</th>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded here -->
                </tbody>
            </table>
            </div>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">Signage Items</div>
        <div class="card-body">
            <div id="clockControls">
            <div class="mb-3 row align-items-center">
                <label class="col-auto col-form-label">Footer Clock Format</label>
                <div class="col-auto">
                    <select id="clockFormatSelect" class="form-select"></select>
                    <div id="clockFormatSelectedPreview" class="form-text text-muted mt-1"></div>
                </div>
                <div class="col-auto">
                    <button id="saveClockFormat" class="btn btn-primary">Save</button>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-auto col-form-label">Add Custom Format</label>
                <div class="col-4">
                    <input id="customFormatLabel" class="form-control" placeholder="Label (e.g. My Format)">
                </div>
                <div class="col-5">
                    <input id="customFormatPattern" class="form-control" placeholder="ICU pattern (e.g. EEEE, d MMMM yyyy HH:mm:ss)">
                </div>
                <div class="col-auto">
                    <button id="addCustomFormat" class="btn btn-outline-secondary">Add</button>
                </div>
            </div>
            </div>
            <div id="slideshowControls" class="mt-4 mb-3">
                <h6>Gallery Slideshow Settings</h6>
                <div class="row align-items-center">
                    <div class="col-auto">
                        <label class="col-form-label">Timeout (seconds)</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="slideshowTimeout" class="form-control" min="1" max="60" value="5" style="width: 100px;">
                    </div>
                    <div class="col-auto">
                        <label class="col-form-label">Transition</label>
                    </div>
                    <div class="col-auto">
                        <select id="slideshowTransition" class="form-select">
                            <option value="fade">Fade</option>
                            <option value="slide">Slide</option>
                            <option value="none">None</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button id="saveSlideshowSettings" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <button class="btn btn-success" id="addSignageBtn">Add Item</button>
                <a class="btn btn-outline-primary ms-2" id="previewSignageBtn" href="saview.php" target="_blank" rel="noopener noreferrer" title="Open signage viewer in a new tab"><i class="bi bi-eye"></i> Preview</a>
            </div>

            <!-- Templates -->
            <div class="mb-3 card p-3">
              <div class="d-flex align-items-center mb-2">
                <h6 class="mb-0 me-3">Templates</h6>
                <div class="btn-group me-2" role="group">
                  <button class="btn btn-outline-secondary" id="saveAsTemplate1">Save current as Template_1</button>
                  <button class="btn btn-outline-secondary" id="saveAsTemplate2">Save current as Template_2</button>
                </div>
                <div class="input-group" style="max-width:360px;">
                  <select id="templateSelect" class="form-select"></select>
                  <button class="btn btn-primary" id="applyTemplate">Apply</button>
                </div>
              </div>
              <div id="templateList" class="small text-muted">No templates</div>
            </div>

            <!-- Background Settings -->
            <div class="mb-3 card p-3">
              <h6 class="mb-3">Background Settings (Saview)</h6>
              <div class="row align-items-end">
                <div class="col-md-2">
                  <label class="form-label">Fit</label>
                  <select id="bgFit" class="form-select">
                    <option value="cover">Stretch (cover)</option>
                    <option value="contain">Fit (contain)</option>
                    <option value="repeat">Tile</option>
                    <option value="auto">Center</option>
                    <option value="100% 100%">Span</option>
                  </select>
                </div>
                <div class="col-md-2">
                  <label class="form-label">Background Color</label>
                  <input type="color" id="bgColor" class="form-control form-control-color" value="#ffffff">
                </div>
                <div class="col-md-4">
                  <label class="form-label">Background Image</label>
                  <input type="file" id="bgImage" class="form-control" accept="image/*">
                  <small class="text-muted">Leave empty to use color only</small>
                </div>
                <div class="col-md-4">
                  <button id="saveBgSettings" class="btn btn-primary">Save Background</button>
                  <button id="clearBgImage" class="btn btn-outline-secondary">Clear Image</button>
                </div>
              </div>
              <div id="bgPreview" class="mt-2 p-2 border rounded" style="height: 80px; background: #ffffff; background-size: cover; background-position: center;"></div>
            </div>

            <!-- Category Tabs -->
            <ul class="nav nav-tabs mb-3" id="signageTabs" role="tablist">
                <li class="nav-item" role="presentation"><button class="nav-link active" data-cat="Video" type="button">Video</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" data-cat="Galeri" type="button">Galeri</button></li>
                <li class="nav-item" role="presentation"><button class="nav-link" data-cat="Text" type="button">Text</button></li>
            </ul>

            <table class="table table-bordered" id="signageMgmtTable">
                <thead>
                    <tr>
                        <th>Sort</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Content</th>
                        <th>Autoplay</th>
                        <th>Loop</th>
                        <th>Muted</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Add/Edit Activity Modal -->
    <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel">Add/Edit Activity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="activityForm">
                        <input type="hidden" id="activityId" name="id">
                        <div class="mb-3">
                            <label for="activityNo" class="form-label">No</label>
                            <input type="number" class="form-control" id="activityNo" name="no" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="activityKegiatan" class="form-label">Kegiatan</label>
                            <input type="text" class="form-control" id="activityKegiatan" name="kegiatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="activityTempat" class="form-label">Tempat</label>
                            <input type="text" class="form-control" id="activityTempat" name="tempat">
                        </div>
                        <div class="mb-3">
                            <label for="activityWaktu" class="form-label">Waktu</label>
                            <input type="text" class="form-control" id="activityWaktu" name="waktu" placeholder="e.g. 10:00-12:00">
                        </div>
                        <div class="mb-3">
                            <label for="activityTahun" class="form-label">Tahun</label>
                            <input type="number" class="form-control" id="activityTahun" name="tahun" min="2020" max="2100" required>
                        </div>
                        <div class="mb-3">
                            <label for="activityBulan" class="form-label">Bulan</label>
                            <select class="form-select" id="activityBulan" name="bulan" required>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="activityStatus" class="form-label">Status</label>
                            <select class="form-select" id="activityStatus" name="status" required>
                                <option value="Terjadwal">Terjadwal</option>
                                <option value="Berlangsung">Berlangsung</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="activityCategory" class="form-label">Category</label>
                            <select class="form-select" id="activityCategory" name="category" required>
                                <option value="Kegiatan">Kegiatan</option>
                                <option value="Agenda">Agenda</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
        <!-- Add/Edit Signage Modal -->
        <div class="modal fade" id="signageModal" tabindex="-1" aria-labelledby="signageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="signageModalLabel">Add/Edit Signage Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="signageForm">
                            <input type="hidden" id="signageId" name="id">
                            <div class="mb-3">
                                <label for="signageName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="signageName" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="signageSortOrder" class="form-label">Sort Order (for playlist)</label>
                                <input type="number" class="form-control" id="signageSortOrder" name="sort_order" min="0" value="0">
                                <small class="text-muted">Lower numbers play first. Use for video playlist order.</small>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="signageType" class="form-label">Type</label>
                                    <select class="form-select" id="signageType" name="type" required>
                                        <option value="Text">Text</option>
                                        <option value="Video">Video</option>
                                        <option value="Images">Images</option>
                                        <option value="Table">Table</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="signageCategory" class="form-label">Category</label>
                                    <select class="form-select" id="signageCategory" name="category" required>
                                        <option value="Video">Video</option>
                                        <option value="Galeri">Galeri</option>
                                        <option value="Text">Text</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="signageContent" class="form-label">Content (URL or text)</label>
                                <textarea class="form-control" id="signageContent" name="content" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="signageFile" class="form-label">Upload Media File</label>
                                <input type="file" class="form-control" id="signageFile" name="file" accept="image/*,video/*">
                                <small class="text-muted">Upload image or video file (optional)</small>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="signageAutoplay" name="autoplay" value="1">
                                    <label class="form-check-label" for="signageAutoplay">
                                        Autoplay (for Video type)
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="signageLoop" name="loop" value="1">
                                    <label class="form-check-label" for="signageLoop">
                                        Loop (for Video type)
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="signageMuted" name="muted" value="1" checked>
                                    <label class="form-check-label" for="signageMuted">
                                        Muted by default (recommended for autoplay video)
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <script>
    $(document).ready(function() {
        let isWysiwygEnabled = false;

        function enableWysiwyg() {
            if (isWysiwygEnabled) return;
            $('#signageContent').summernote({
                placeholder: 'Content (text / HTML)',
                height: 260,
                styleTags: ['p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4'],
                lineHeights: ['1.0', '1.2', '1.4', '1.6', '2.0'],
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'hr', 'table']],
                    ['view', ['codeview', 'undo', 'redo']]
                ],
                fontNames: ['Arial', 'Helvetica', 'Times New Roman', 'Courier New', 'Georgia', 'Verdana'],
                fontSizes: ['10', '12', '14', '16', '18', '20', '24', '28', '32'],
                shortcuts: true
            });
            isWysiwygEnabled = true;
        }

        function disableWysiwyg() {
            if (!isWysiwygEnabled) return;
            const html = $('#signageContent').summernote('code');
            $('#signageContent').summernote('destroy');
            $('#signageContent').val(html);
            isWysiwygEnabled = false;
        }

        function toggleEditorByType(type) {
            if (type === 'Text' || type === 'Table') {
                enableWysiwyg();
                $('#signageContent').closest('.mb-3').show();
                $('#signageFile').closest('.mb-3').show();
            } else {
                disableWysiwyg();
                $('#signageContent').closest('.mb-3').show();
                $('#signageFile').closest('.mb-3').show();
            }
        }

        var __allSignageItems = [];
        var __activeSignageCategory = 'Video';
        var SIGNAGE_CATEGORIES = ['Video','Galeri','Text'];

        function deriveCategoryFromItem(item) {
            if (item.category && item.category.trim() !== '') return item.category;
            var t = (item.type || '').toLowerCase();
            if (t === 'video') return 'Video';
            if (t === 'images') return 'Galeri';
            return 'Text';
        }

        function renderSignageTableForCategory(cat) {
            var rows = '';
            $.each(__allSignageItems, function(i, item) {
                var category = deriveCategoryFromItem(item);
                if (category !== cat) return;
                var autoplay = Number(item.autoplay) === 1;
                var loop = Number(item.loop) === 1;
                var muted = Number(item.muted) === 1;
                var sortOrder = item.sort_order || 0;
                rows += '<tr>' +
                    '<td>' + sortOrder + '</td>' +
                    '<td>' + item.name + '</td>' +
                    '<td>' + item.type + '</td>' +
                    '<td>' + category + '</td>' +
                    '<td>' + (item.content ? item.content : '') + '</td>' +
                    '<td>' + (autoplay ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>') + '</td>' +
                    '<td>' + (loop ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>') + '</td>' +
                    '<td>' + (muted ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>') + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-warning editSignageBtn" data-id="' + item.id + '">Edit</button> ' +
                    '<button class="btn btn-sm btn-danger deleteSignageBtn" data-id="' + item.id + '">Delete</button>' +
                    '</td>' +
                    '</tr>';
            });
            $('#signageMgmtTable tbody').html(rows);
        }

        function renderTabs() {
            $('#signageTabs button').removeClass('active');
            $('#signageTabs button[data-cat="' + __activeSignageCategory + '"]').addClass('active');
        }

        function loadSignage() {
            $.getJSON('php/signage_api.php?action=list', function(response) {
                __allSignageItems = response.data || [];
                renderTabs();
                renderSignageTableForCategory(__activeSignageCategory);
            });
        }
        loadSignage();

        // Tab click handler
        $('#signageTabs').on('click', 'button', function() {
            var cat = $(this).data('cat');
            if (!cat) return;
            __activeSignageCategory = cat;
            renderTabs();
            renderSignageTableForCategory(cat);
        });

        // Templates: load, save, apply, delete
        function loadTemplates() {
            $.getJSON('php/signage_api.php?action=list_templates', function(resp){
                if (!resp || !resp.templates) return;
                var templates = resp.templates;
                $('#templateSelect').empty();
                var listHtml = '';
                templates.forEach(function(t){
                    $('#templateSelect').append($('<option>').val(t.id).text(t.name + ' (' + t.created_at + ')'));
                    listHtml += '<div class="d-flex justify-content-between align-items-center py-1">' +
                                '<div>' + $('<div>').text(t.name).html() + ' <small class="text-muted">' + t.created_at + '</small></div>' +
                                '<div><button class="btn btn-sm btn-primary me-1 apply-template" data-id="'+t.id+'">Apply</button> <button class="btn btn-sm btn-danger delete-template" data-id="'+t.id+'">Delete</button></div>' +
                                '</div>';
                });
                $('#templateList').html(templates.length ? listHtml : 'No templates');
            });
        }

        $('#saveAsTemplate1').on('click', function(){
            $.post('php/signage_api.php?action=save_template', {name: 'Template_1'}, function(r){ if (r && r.success) { showCrudAlert('Saved as Template_1','success'); loadTemplates(); } else showCrudAlert('Save failed','danger'); }, 'json');
        });
        $('#saveAsTemplate2').on('click', function(){
            $.post('php/signage_api.php?action=save_template', {name: 'Template_2'}, function(r){ if (r && r.success) { showCrudAlert('Saved as Template_2','success'); loadTemplates(); } else showCrudAlert('Save failed','danger'); }, 'json');
        });

        // Apply from select
        $('#applyTemplate').on('click', function(){
            var id = $('#templateSelect').val();
            if (!id) { showCrudAlert('No template selected','warning'); return; }
            if (!confirm('Apply selected template? This will replace current signage items.')) return;
            $.post('php/signage_api.php?action=apply_template', {id: id}, function(r){ if (r && r.success) { showCrudAlert('Template applied','success'); loadSignage(); } else showCrudAlert(r.msg || 'Apply failed','danger'); }, 'json');
        });

        // Delegate apply/delete buttons in list
        $(document).on('click', '.apply-template', function(){
            var id = $(this).data('id');
            if (!confirm('Apply this template? This will replace current signage items.')) return;
            $.post('php/signage_api.php?action=apply_template', {id: id}, function(r){ if (r && r.success) { showCrudAlert('Template applied','success'); loadSignage(); } else showCrudAlert(r.msg || 'Apply failed','danger'); }, 'json');
        });
        $(document).on('click', '.delete-template', function(){
            var id = $(this).data('id');
            if (!confirm('Delete this template?')) return;
            $.post('php/signage_api.php?action=delete_template', {id: id}, function(r){ if (r && r.success) { showCrudAlert('Template deleted','success'); loadTemplates(); } else showCrudAlert(r.msg || 'Delete failed','danger'); }, 'json');
        });

        loadTemplates();

        // load clock format and populate dropdown with inline preview timestamps (truncated option text & helper preview)
        function loadClockFormat() {
            // show placeholder while loading
            $('#clockFormatSelect').empty().append($('<option>').val('').text('Loading formats...').prop('disabled', true));
            $.getJSON('php/signage_api.php?action=get_clock_format', function(resp) {
                console.log('get_clock_format response:', resp);
                $('#clockFormatSelect').empty();
                const trunc = function(s, n){ return (s || '').length>n ? (s || '').slice(0,n-1)+'…' : (s || ''); };
                if (!resp || !Array.isArray(resp.formats) || resp.formats.length === 0) {
                    $('#clockFormatSelect').append($('<option>').val('').text('No formats available').prop('disabled', true));
                    $('#clockFormatSelectedPreview').text('No clock formats found.');
                    return;
                }
                resp.formats.forEach(function(f, idx) {
                    var key = f.key || ('k_'+Date.now() + '_' + idx);
                    var fullLabel = f.label || '';
                    var displayLabel = trunc(fullLabel, 40) + ' — Loading...';
                    var opt = $('<option>').val(key).text(displayLabel).attr('title', fullLabel);
                    $('#clockFormatSelect').append(opt);
                    // fetch preview time and update option label and data-preview/title
                    $.getJSON('php/signage_api.php?action=get_server_time&format=' + encodeURIComponent(key), function(r){
                        var preview = (r && r.time) ? r.time : 'N/A';
                        var text = trunc(fullLabel, 40) + ' — ' + preview;
                        opt.text(text).attr('title', fullLabel + ' — ' + preview).data('preview', preview).data('fulllabel', fullLabel);
                        // if this option is currently selected, update helper preview
                        if ($('#clockFormatSelect').val() === key) updateClockPreview(opt);
                    }).fail(function(){
                        opt.text(trunc(fullLabel, 40) + ' — N/A').attr('title', fullLabel + ' — N/A').data('preview','N/A').data('fulllabel', fullLabel);
                    });
                });
                if (resp.selected) $('#clockFormatSelect').val(resp.selected);
                // update preview for selected after options added
                setTimeout(function(){
                    var sel = $('#clockFormatSelect option:selected');
                    if (sel.length) updateClockPreview(sel);
                }, 250);
            }).fail(function(jqxhr, status, err){
                console.error('Failed to load clock formats:', status, err, jqxhr.responseText);
                $('#clockFormatSelect').empty().append($('<option>').val('').text('Unable to load formats (check console)').prop('disabled', true));
                $('#clockFormatSelectedPreview').text('Unable to load preview.');
            });
        }
        function updateClockPreview(opt) {
            var full = opt.data('fulllabel') || opt.text().split(' — ')[0] || opt.text();
            var preview = opt.data('preview') || (opt.text().split(' — ')[1] || '');
            $('#clockFormatSelectedPreview').text((full ? full + ' — ' : '') + (preview || ''));
        }
        $('#clockFormatSelect').on('change', function(){ updateClockPreview($('#clockFormatSelect option:selected')); });
        loadClockFormat();


        $('#saveClockFormat').click(function(){
            var fmt = $('#clockFormatSelect').val();
            $.post('php/signage_api.php?action=set_clock_format', {format: fmt}, function(r){
                showCrudAlert('Clock format saved.', 'success');
                loadClockFormat();
            }, 'json');
        });



        // Add custom format
        $('#addCustomFormat').click(function(e){
            e.preventDefault();
            var label = $('#customFormatLabel').val().trim();
            var pattern = $('#customFormatPattern').val().trim();
            if (!label || !pattern) { showCrudAlert('Provide label and pattern for custom format.', 'warning'); return; }
            $.getJSON('php/signage_api.php?action=get_clock_format', function(resp){
                var formats = resp.formats || [];
                // generate unique key
                var key = 'custom_' + Date.now();
                formats.push({key: key, label: label + ' — ' + pattern, type: 'custom', pattern: pattern});
                var payload = {formats: JSON.stringify(formats), selected: key};
                $.post('php/signage_api.php?action=set_clock_format', payload, function(r){
                    showCrudAlert('Custom format added and selected.', 'success');
                    loadClockFormat();
                    $('#customFormatLabel').val(''); $('#customFormatPattern').val('');
                }, 'json');
            });
        });
        
        // Load and manage background settings
        function loadBgSettings() {
            $.getJSON('php/signage_api.php?action=get_background', function(resp) {
                console.log('loadBgSettings response:', resp);
                if (resp && resp.success && resp.bg) {
                    $('#bgColor').val(resp.bg.color || '#ffffff');
                    $('#bgFit').val(resp.bg.fit || 'cover');
                    console.log('Loaded bg color:', resp.bg.color, 'fit:', resp.bg.fit, 'image:', resp.bg.image);
                    updateBgPreview();
                }
            }).fail(function(jqxhr, status, err){
                console.error('Failed to load background settings:', status, err, jqxhr.responseText);
            });
        }
        loadBgSettings();
        
        function updateBgPreview() {
            var color = $('#bgColor').val();
            var fit = $('#bgFit').val();
            var bgStyle = 'background-color: ' + color + '; background-size: ' + fit + '; background-repeat: ' + (fit === 'repeat' ? 'repeat' : 'no-repeat') + '; background-position: center;';
            $('#bgPreview').attr('style', 'height: 80px; ' + bgStyle + ' border: 1px solid #ddd; border-radius: 4px;');
        }
        
        $('#bgColor').on('change', updateBgPreview);
        $('#bgFit').on('change', updateBgPreview);
        $('#bgImage').on('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var fit = $('#bgFit').val();
                    var bgStyle = 'background-color: ' + $('#bgColor').val() + '; background-image: url(' + e.target.result + '); background-size: ' + fit + '; background-repeat: ' + (fit === 'repeat' ? 'repeat' : 'no-repeat') + '; background-position: center;';
                    $('#bgPreview').attr('style', 'height: 80px; ' + bgStyle + ' border: 1px solid #ddd; border-radius: 4px;');
                };
                reader.readAsDataURL(file);
            }
        });
        
        $('#saveBgSettings').click(function() {
            var formData = new FormData();
            formData.append('color', $('#bgColor').val());
            formData.append('fit', $('#bgFit').val());
            if ($('#bgImage')[0].files.length > 0) {
                formData.append('image', $('#bgImage')[0].files[0]);
            }
            console.log('Saving background color:', $('#bgColor').val(), 'fit:', $('#bgFit').val(), 'has image:', $('#bgImage')[0].files.length > 0);
            $.ajax({
                url: 'php/signage_api.php?action=set_background',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(r) {
                    console.log('set_background response:', r);
                    if (r && r.success) {
                        showCrudAlert('Background saved.', 'success');
                        $('#bgImage').val('');
                        loadBgSettings();
                    } else {
                        showCrudAlert('Failed to save background: ' + (r.error || 'unknown error'), 'danger');
                    }
                },
                error: function(jqxhr, status, err) {
                    console.error('AJAX error:', status, err, jqxhr.responseText);
                    showCrudAlert('Error saving background: ' + status, 'danger');
                }
            });
        });
        
        $('#clearBgImage').click(function() {
            $.post('php/signage_api.php?action=set_background', {clear_image: 1}, function(r) {
                if (r && r.success) {
                    showCrudAlert('Background image cleared.', 'success');
                    $('#bgImage').val('');
                    loadBgSettings();
                } else {
                    showCrudAlert('Failed to clear image.', 'danger');
                }
            }, 'json');
        });
        
        // Load slideshow settings
        function loadSlideshowSettings() {
            $.getJSON('php/signage_api.php?action=get_slideshow_settings', function(resp) {
                if (resp && resp.success && resp.settings) {
                    $('#slideshowTimeout').val(resp.settings.timeout / 1000);
                    $('#slideshowTransition').val(resp.settings.transition);
                }
            });
        }
        loadSlideshowSettings();
        
        // Save slideshow settings
        $('#saveSlideshowSettings').click(function(){
            var timeout = parseInt($('#slideshowTimeout').val()) * 1000;
            var transition = $('#slideshowTransition').val();
            $.post('php/signage_api.php?action=set_slideshow_settings', {
                timeout: timeout,
                transition: transition
            }, function(r){
                showCrudAlert('Slideshow settings saved.', 'success');
            }, 'json');
        });
        
        // Add Signage
        $('#addSignageBtn').click(function() {
            $('#signageForm')[0].reset();
            $('#signageId').val('');
            $('#signageType').val('Text');
            $('#signageCategory').val(__activeSignageCategory || 'Text');
            $('#signageContent').val('');
            $('#signageSortOrder').val('0');
            toggleEditorByType('Text');
            $('#signageModal').modal('show');
        });
        $('#signageType').on('change', function() {
            toggleEditorByType($(this).val());
        });
        // Edit Signage
        $(document).on('click', '.editSignageBtn', function() {
            var id = $(this).data('id');
            $.getJSON('php/signage_api.php?action=get&id=' + id, function(response) {
                if(response.data) {
                    $('#signageId').val(response.data.id);
                    $('#signageName').val(response.data.name);
                    $('#signageType').val(response.data.type);
                    // populate category (fallback to derive)
                    $('#signageCategory').val(response.data.category || deriveCategoryFromItem(response.data));
                    $('#signageSortOrder').val(response.data.sort_order || 0);
                    
                    // Set content based on type
                    var contentValue = response.data.content || '';
                    toggleEditorByType(response.data.type);
                    
                    if (isWysiwygEnabled) {
                        $('#signageContent').summernote('code', contentValue);
                    } else {
                        $('#signageContent').val(contentValue);
                    }
                    
                    $('#signageAutoplay').prop('checked', Number(response.data.autoplay) === 1);
                    $('#signageLoop').prop('checked', Number(response.data.loop) === 1);
                    $('#signageMuted').prop('checked', Number(response.data.muted) === 1);
                    $('#signageModal').modal('show');
                }
            });
        });
        // Delete Signage
        $(document).on('click', '.deleteSignageBtn', function() {
            if(confirm('Are you sure you want to delete this item?')) {
                var id = $(this).data('id');
                $.post('php/signage_api.php?action=delete', {id: id}, function(response) {
                    showCrudAlert('Signage item deleted successfully.', 'success');
                    loadSignage();
                }, 'json');
            }
        });
        // Save Signage
        $('#signageForm').submit(function(e) {
            e.preventDefault();
            
            // Ensure Summernote content is synced to textarea
            if (isWysiwygEnabled) {
                var summernoteCode = $('#signageContent').summernote('code');
                $('#signageContent').val(summernoteCode);
            }
            
            var formData = new FormData(this);
            var action = $('#signageId').val() ? 'edit' : 'add';
            
            $.ajax({
                url: 'php/signage_api.php?action=' + action,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    $('#signageModal').modal('hide');
                    if(action === 'add') {
                        showCrudAlert('Signage item added successfully.', 'success');
                    } else {
                        showCrudAlert('Signage item updated successfully.', 'success');
                    }
                    loadSignage();
                },
                error: function(xhr, status, error) {
                    console.error('Save error:', status, error, xhr.responseText);
                    showCrudAlert('Error saving signage item: ' + (xhr.responseText || error), 'danger');
                }
            });
            
            return false;
        });

        // Show notification
        function showCrudAlert(message, type) {
            var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>';
            $('#crudAlert').html(alertHtml).show();
            setTimeout(function() { $('#crudAlert').fadeOut(); }, 3000);
        }
        
        // Activities Management
        var __activeActivityCategory = 'Kegiatan';
        
        function loadActivities() {
            $.getJSON('php/signage_api.php?action=list_activities&category=' + __activeActivityCategory, function(response) {
                if (response.success) {
                    renderActivitiesTable(response.activities);
                }
            });
        }
        
        function renderActivitiesTable(activities) {
            var rows = '';
            $.each(activities, function(i, act) {
                rows += '<tr>' +
                    '<td>' + (act.no || '-') + '</td>' +
                    '<td>' + act.kegiatan + '</td>' +
                    '<td>' + (act.tempat || '-') + '</td>' +
                    '<td>' + (act.waktu || '-') + '</td>' +
                    '<td>' + (act.tahun || '-') + '</td>' +
                    '<td>' + (act.bulan || '-') + '</td>' +
                    '<td><span class="badge bg-' + (act.status === 'Selesai' ? 'success' : (act.status === 'Berlangsung' ? 'warning' : 'info')) + '">' + act.status + '</span></td>' +
                    '<td>' + act.category + '</td>' +
                    '<td>' +
                    '<button class="btn btn-sm btn-warning editActivityBtn" data-id="' + act.id + '">Edit</button> ' +
                    '<button class="btn btn-sm btn-danger deleteActivityBtn" data-id="' + act.id + '">Delete</button>' +
                    '</td>' +
                    '</tr>';
            });
            if (rows === '') {
                rows = '<tr><td colspan="9" class="text-center text-muted">No activities found</td></tr>';
            }
            $('#activitiesTable tbody').html(rows);
        }
        
        $('#activityTabs').on('click', 'button', function() {
            var cat = $(this).data('actcat');
            if (!cat) return;
            __activeActivityCategory = cat;
            $('#activityTabs button').removeClass('active');
            $(this).addClass('active');
            loadActivities();
        });
        
        $('#addActivityBtn').click(function() {
            $('#activityForm')[0].reset();
            $('#activityId').val('');
            $('#activityCategory').val(__activeActivityCategory);
            $('#activityModal').modal('show');
        });
        
        $(document).on('click', '.editActivityBtn', function() {
            var id = $(this).data('id');
            $.getJSON('php/signage_api.php?action=get_activity&id=' + id, function(response) {
                if(response.success && response.data) {
                    $('#activityId').val(response.data.id);
                    $('#activityNo').val(response.data.no);
                    $('#activityKegiatan').val(response.data.kegiatan);
                    $('#activityTempat').val(response.data.tempat);
                    $('#activityWaktu').val(response.data.waktu);
                    $('#activityTahun').val(response.data.tahun);
                    $('#activityBulan').val(response.data.bulan);
                    $('#activityStatus').val(response.data.status);
                    $('#activityCategory').val(response.data.category);
                    $('#activityModal').modal('show');
                }
            });
        });
        
        $(document).on('click', '.deleteActivityBtn', function() {
            if(confirm('Are you sure you want to delete this activity?')) {
                var id = $(this).data('id');
                $.post('php/signage_api.php?action=delete_activity', {id: id}, function(response) {
                    showCrudAlert('Activity deleted successfully.', 'success');
                    loadActivities();
                }, 'json');
            }
        });
        
        $('#activityForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var action = $('#activityId').val() ? 'edit_activity' : 'add_activity';
            $.post('php/signage_api.php?action=' + action, formData, function(response) {
                $('#activityModal').modal('hide');
                if(action === 'add_activity') {
                    showCrudAlert('Activity added successfully.', 'success');
                } else {
                    showCrudAlert('Activity updated successfully.', 'success');
                }
                loadActivities();
            }, 'json').fail(function(xhr) {
                showCrudAlert('Error saving activity: ' + xhr.responseText, 'danger');
            });
            return false;
        });
        
        loadActivities();
    });
    </script>
    <!-- Signage Content ends here -->
<?php include 'layout_footer.php'; ?>

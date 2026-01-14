<?php include 'layout_header.php'; $isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'); ?>
<div class="container-fluid mt-4">
  <h1 class="h3 mb-4">Infrastruktur TI</h1>
  <?php if (!$isAdmin): ?>
    <div class="alert alert-info">You have read-only access to this module.</div>
  <?php endif; ?>
  <div id="infToastPlaceholder"></div>
  <script>const INF_TI_IS_ADMIN = <?= $isAdmin ? '1' : '0' ?>;</script>
  <!-- DataTables CSS/JS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <p class="mb-3">Manajemen Infrastruktur TI</p>

          <div class="d-flex mb-2">
            <div class="me-2">
              <button id="btnExportAll" class="btn btn-sm btn-outline-secondary">Export All CSV</button>
            </div>
            <div class="me-2">
              <button id="btnExportSelected" class="btn btn-sm btn-outline-secondary">Export Selected</button>
            </div>
            <div class="me-2 dropdown">
              <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="exportColsDropdown" data-bs-toggle="dropdown" aria-expanded="false">Export Columns</button>
              <ul class="dropdown-menu p-3" aria-labelledby="exportColsDropdown" style="min-width:240px;">
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="kode" checked> <span class="form-check-label">Kode</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="id"> <span class="form-check-label">ID</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="category" checked> <span class="form-check-label">Category</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="name" checked> <span class="form-check-label">Name</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="detail" checked> <span class="form-check-label">Detail</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="tipe"> <span class="form-check-label">Tipe</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="sn"> <span class="form-check-label">SN</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="tahun"> <span class="form-check-label">Pengadaan Tahun</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="kondisi"> <span class="form-check-label">Kondisi</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="lokasi"> <span class="form-check-label">Lokasi</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="created_at" checked> <span class="form-check-label">Created At</span></label></li>
                <li><label class="form-check"><input class="form-check-input export-col" type="checkbox" value="updated_at" checked> <span class="form-check-label">Updated At</span></label></li>
                <li class="pt-2"><button id="btnSelectAllCols" class="btn btn-sm btn-outline-secondary me-2">All</button><button id="btnDeselectAllCols" class="btn btn-sm btn-outline-secondary">None</button></li>
              </ul>
            </div>
            <div>
              <?php if ($isAdmin): ?>
                <button id="btnDeleteSelected" class="btn btn-sm btn-danger">Delete Selected</button>
              <?php else: ?>
                <button id="btnDeleteSelected" class="btn btn-sm btn-danger" disabled>Delete Selected</button>
              <?php endif; ?>
            </div>
          </div>

          <!-- Tabs -->
          <ul class="nav nav-tabs" id="infTiTabs" role="tablist">
            <li class="nav-item" role="presentation"><button class="nav-link active" id="tab-komputer-tab" data-bs-toggle="tab" data-bs-target="#tab-komputer" type="button" role="tab" aria-controls="tab-komputer" aria-selected="true">Komputer</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="tab-support-tab" data-bs-toggle="tab" data-bs-target="#tab-support" type="button" role="tab" aria-controls="tab-support" aria-selected="false">Support</button></li>
            <li class="nav-item" role="presentation"><button class="nav-link" id="tab-jaringan-tab" data-bs-toggle="tab" data-bs-target="#tab-jaringan" type="button" role="tab" aria-controls="tab-jaringan" aria-selected="false">Jaringan</button></li>
          </ul>
          <div class="tab-content mt-3">
            <div class="tab-pane fade show active" id="tab-komputer" role="tabpanel" aria-labelledby="tab-komputer-tab">

              <?php if ($isAdmin): ?>
                <div class="d-inline-flex align-items-center mb-2">
                  <button id="addKomputer" class="btn btn-sm btn-primary me-2">Add Komputer</button>
                  <button id="saveOrderKomputer" class="btn btn-sm btn-outline-primary" disabled>Save Order</button>
                </div>
              <?php endif; ?>
              <table class="table table-sm table-striped" id="tblKomputer">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="chkAllKomputer"></th>
                    <th></th>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Merk</th>
                    <th>Spesifikasi</th>
                    <th>SN</th>
                    <th>Pengadaan Tahun</th>
                    <th>Kondisi</th>
                    <th>Lokasi</th>
                    <th>Tanggal Update</th>
                    <th>Actions</th>
                  </tr>
                  <tr class="dt-filters">
                    <th></th><th></th>
                    <th><input class="form-control form-control-sm filter-kode" placeholder="Kode"></th>
                    <th><input class="form-control form-control-sm filter-tipe" placeholder="Tipe"></th>
                    <th><input class="form-control form-control-sm filter-merk" placeholder="Merk"></th>
                    <th><input class="form-control form-control-sm filter-spesifikasi" placeholder="Spesifikasi"></th>
                    <th><input class="form-control form-control-sm filter-sn" placeholder="SN"></th>
                    <th><input class="form-control form-control-sm filter-tahun" placeholder="Tahun"></th>
                    <th><input class="form-control form-control-sm filter-kondisi" placeholder="Kondisi"></th>
                    <th><input class="form-control form-control-sm filter-lokasi" placeholder="Lokasi"></th>
                    <th><input class="form-control form-control-sm filter-tgl" placeholder="Tanggal"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="tab-support" role="tabpanel" aria-labelledby="tab-support-tab">

              <?php if ($isAdmin): ?>
                <div class="d-inline-flex align-items-center mb-2">
                  <button id="addSupport" class="btn btn-sm btn-primary me-2">Add Support</button>
                  <button id="saveOrderSupport" class="btn btn-sm btn-outline-primary" disabled>Save Order</button>
                </div>
              <?php endif; ?>
              <table class="table table-sm table-striped" id="tblSupport">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="chkAllSupport"></th>
                    <th></th>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Merk</th>
                    <th>Spesifikasi</th>
                    <th>SN</th>
                    <th>Pengadaan Tahun</th>
                    <th>Kondisi</th>
                    <th>Lokasi</th>
                    <th>Tanggal Update</th>
                    <th>Actions</th>
                  </tr>
                  <tr class="dt-filters">
                    <th></th><th></th>
                    <th><input class="form-control form-control-sm filter-kode" placeholder="Kode"></th>
                    <th><input class="form-control form-control-sm filter-tipe" placeholder="Tipe"></th>
                    <th><input class="form-control form-control-sm filter-merk" placeholder="Merk"></th>
                    <th><input class="form-control form-control-sm filter-spesifikasi" placeholder="Spesifikasi"></th>
                    <th><input class="form-control form-control-sm filter-sn" placeholder="SN"></th>
                    <th><input class="form-control form-control-sm filter-tahun" placeholder="Tahun"></th>
                    <th><input class="form-control form-control-sm filter-kondisi" placeholder="Kondisi"></th>
                    <th><input class="form-control form-control-sm filter-lokasi" placeholder="Lokasi"></th>
                    <th><input class="form-control form-control-sm filter-tgl" placeholder="Tanggal"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="tab-jaringan" role="tabpanel" aria-labelledby="tab-jaringan-tab">

              <?php if ($isAdmin): ?>
                <div class="d-inline-flex align-items-center mb-2">
                  <button id="addJaringan" class="btn btn-sm btn-primary me-2">Add Jaringan</button>
                  <button id="saveOrderJaringan" class="btn btn-sm btn-outline-primary" disabled>Save Order</button>
                </div>
              <?php endif; ?>
              <table class="table table-sm table-striped" id="tblJaringan">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="chkAllJaringan"></th>
                    <th></th>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Merk</th>
                    <th>Spesifikasi</th>
                    <th>SN</th>
                    <th>Pengadaan Tahun</th>
                    <th>Kondisi</th>
                    <th>Lokasi</th>
                    <th>Tanggal Update</th>
                    <th>Actions</th>
                  </tr>
                  <tr class="dt-filters">
                    <th></th><th></th>
                    <th><input class="form-control form-control-sm filter-kode" placeholder="Kode"></th>
                    <th><input class="form-control form-control-sm filter-tipe" placeholder="Tipe"></th>
                    <th><input class="form-control form-control-sm filter-merk" placeholder="Merk"></th>
                    <th><input class="form-control form-control-sm filter-spesifikasi" placeholder="Spesifikasi"></th>
                    <th><input class="form-control form-control-sm filter-sn" placeholder="SN"></th>
                    <th><input class="form-control form-control-sm filter-tahun" placeholder="Tahun"></th>
                    <th><input class="form-control form-control-sm filter-kondisi" placeholder="Kondisi"></th>
                    <th><input class="form-control form-control-sm filter-lokasi" placeholder="Lokasi"></th>
                    <th><input class="form-control form-control-sm filter-tgl" placeholder="Tanggal"></th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

            </div>
          </div>
        </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="infTiModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infTiModalLabel">Add Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="infAlert" class="alert alert-danger d-none" role="alert" aria-live="polite"></div>
        <form id="infTiForm" novalidate>
                    <div class="mb-3" id="kodeGroup">
                      <label class="form-label">Kode</label>
                      <input class="form-control" id="inf_kode" name="kode" placeholder="e.g. COM0001">
                      <div class="invalid-feedback" id="kodeFeedback">Kode already exists or invalid.</div>
                    </div>
          <input type="hidden" name="id" id="inf_id" value="">
          <input type="hidden" name="category" id="inf_category" value="">
          <div class="mb-3">
            <label class="form-label">Tipe</label>
            <select class="form-select" id="inf_tipe" name="tipe">
            </select>
            <div class="invalid-feedback" id="tipeFeedback">Invalid tipe for selected category.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Merk</label>
            <input class="form-control" id="inf_name" name="name" required aria-required="true">
            <div class="invalid-feedback">Merk is required.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Spesifikasi</label>
            <textarea class="form-control" id="inf_detail" name="detail" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">SN</label>
            <input class="form-control" id="inf_sn" name="sn">
          </div>
          <div class="mb-3">
            <label class="form-label">Pengadaan Tahun</label>
            <input class="form-control" id="inf_tahun" name="tahun">
          </div>
          <div class="mb-3">
            <label class="form-label">Kondisi</label>
            <input class="form-control" id="inf_kondisi" name="kondisi">
          </div>
          <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input class="form-control" id="inf_lokasi" name="lokasi">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="infSave" class="btn btn-primary" disabled>
          <span id="infSaveSpinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
          <span id="infSaveText">Save</span>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
$(function(){
  const api = 'php/inf_ti_api.php';
  const modal = new bootstrap.Modal(document.getElementById('infTiModal'));
  let currentCategory = null;
  let editingId = null;

  // tipe options per category
  const tipeOptions = {
    komputer: ['PC','Laptop'],
    support: ['Printer','Scanner','Lainnya'],
    jaringan: ['Router','Hub','Adapter','Lainnya']
  };

  // DataTable instances
let dtKomputer = null, dtSupport = null, dtJaringan = null;

  function initDataTables(){
    dtKomputer = $('#tblKomputer').DataTable({
      paging: true, pageLength: 10, lengthChange: false, searching: true, autoWidth: false, responsive: true,
      columnDefs: [
        { orderable: false, targets: [0,1,11] },
        { width: '36px', targets: 1 },
        { width: '40px', targets: 2 },
        { className: 'text-center', targets: [0,1,2] }
      ],
      order: []
    });
    dtSupport = $('#tblSupport').DataTable({
      paging: true, pageLength: 10, lengthChange: false, searching: true, autoWidth: false, responsive: true,
      columnDefs: [
        { orderable: false, targets: [0,1,11] },
        { width: '36px', targets: 1 },
        { width: '40px', targets: 2 },
        { className: 'text-center', targets: [0,1,2] }
      ],
      order: []
    });
    dtJaringan = $('#tblJaringan').DataTable({
      paging: true, pageLength: 10, lengthChange: false, searching: true, autoWidth: false, responsive: true,
      columnDefs: [
        { orderable: false, targets: [0,1,11] },
        { width: '36px', targets: 1 },
        { width: '40px', targets: 2 },
        { className: 'text-center', targets: [0,1,2] }
      ],
      order: []
    });
  }

  function refresh() {
    ['komputer','support','jaringan'].forEach(cat => {
      $.get(api, {action: 'list', category: cat}, function(resp){
        if (!resp.success) return;
        const rows = [];
        resp.items.forEach((it, idx) => {
          const chk = '<input type="checkbox" class="row-chk" data-id="' + it.id + '">';
          const drag = '<div class="text-center drag-handle" style="width:36px; cursor:grab"><i class="bi bi-list"></i></div>';
          const kode = escapeHtml(it.kode || '');
          const tipe = escapeHtml(it.tipe || it.category);
          const merk = escapeHtml(it.name);
          const spesifikasi = escapeHtml(it.detail);
          const sn = escapeHtml(it.sn || '');
          const tahun = escapeHtml(it.tahun || '');
          const kondisi = escapeHtml(it.kondisi || '');
          const lokasi = escapeHtml(it.lokasi || '');
          const tgl = escapeHtml(it.updated_at || '');
          const actions = actionButtons(it.id);
          rows.push([chk, drag, kode, tipe, merk, spesifikasi, sn, tahun, kondisi, lokasi, tgl, actions, it.id]);
        });

        // update DataTable
        let table, dt;
        if (cat === 'komputer') { dt = dtKomputer; table = '#tblKomputer'; }
        if (cat === 'support') { dt = dtSupport; table = '#tblSupport'; }
        if (cat === 'jaringan') { dt = dtJaringan; table = '#tblJaringan'; }
        if (!dt) return;
        dt.clear();
        rows.forEach(r => dt.row.add(r.slice(0,12)) );
        dt.draw(false);
        // set data-id and draggable on rows in DOM to support drag
        const nodes = $(table + ' tbody tr');
        nodes.each(function(i){
          const id = rows[i][rows[i].length - 1];
          $(this).attr('data-id', id).attr('draggable', true);
          // ensure checkbox has correct data-id (DataTables may clone)
          $(this).find('.row-chk').attr('data-id', id);
        });
      }, 'json');
    });
  }

  function actionButtons(id) {
    let btns = '';
    btns += '<a class="btn btn-sm btn-info btn-detail me-1" href="inf_ti_detail.php?id=' + id + '">Detail</a>';
    if (INF_TI_IS_ADMIN) {
      btns += '<button class="btn btn-sm btn-secondary btn-edit me-1" data-id="' + id + '">Edit</button>';
      btns += '<button class="btn btn-sm btn-danger btn-delete" data-id="' + id + '">Delete</button>';
    }
    return btns;
  }

  function capitalize(s){ return s.charAt(0).toUpperCase() + s.slice(1); }
  function escapeHtml(s){ return (s||'').replace(/[&<>"']/g, function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"}[c]; }); }

  // open modal for add
  $('#addJaringan').on('click', function(){ openModal('jaringan'); });
  $('#addKomputer').on('click', function(){ openModal('komputer'); });
  $('#addSupport').on('click', function(){ openModal('support'); });

  function openModal(category, item){
    // Kode is manually editable for all categories
    $('#kodeGroup label').text('Kode');
    $('#inf_kode').prop('readonly', false);
    $('#inf_kode').val(item ? (item.kode || '') : '');
    currentCategory = category;
    editingId = item ? item.id : null;
    $('#inf_category').val(category);
    $('#inf_id').val(editingId || '');

    // populate tipe select based on category
    const opts = tipeOptions[category] || [];
    $('#inf_tipe').empty();
    opts.forEach(function(o){ $('#inf_tipe').append(new Option(o, o)); });
    if (item && item.tipe) $('#inf_tipe').val(item.tipe); else if (opts.length) $('#inf_tipe').val(opts[0]); else $('#inf_tipe').val('');

    $('#inf_name').val(item ? item.name : '');
    $('#inf_detail').val(item ? item.detail : '');
    $('#inf_sn').val(item ? item.sn : '');
    $('#inf_tahun').val(item ? item.tahun : '');
    $('#inf_kondisi').val(item ? item.kondisi : '');
    $('#inf_lokasi').val(item ? item.lokasi : '');
    $('#infTiModalLabel').text(editingId ? 'Edit Item' : 'Add Item');
    // reset validation state
    $('#infAlert').addClass('d-none').text('');
    $('#inf_name').removeClass('is-invalid');
    $('#infSave').prop('disabled', !INF_TI_IS_ADMIN || !$('#inf_name').val().trim());
    modal.show();
  }

  // enable focus and validation when shown
  document.getElementById('infTiModal').addEventListener('shown.bs.modal', function(){
    $('#inf_name').trigger('focus');
  });

  // live validation
  $('#inf_name').on('input', function(){
    const valid = $(this).val().trim() !== '';
    $(this).toggleClass('is-invalid', !valid);
    $('#infSave').prop('disabled', !INF_TI_IS_ADMIN || !valid);
  });

  function showToast(message, type='success'){
    const id = 't' + Date.now();
    const el = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
    $('#infToastPlaceholder').append(el);
    setTimeout(()=> el.alert('close'), 4000);
  }

  // handle save
  $('#infSave').on('click', function(){
    const id = $('#inf_id').val();
    const cat = $('#inf_category').val();
    const name = $('#inf_name').val().trim();
    const detail = $('#inf_detail').val().trim();
    if (!name) { $('#inf_name').addClass('is-invalid'); return; }
    $('#infAlert').addClass('d-none').text('');
    $('#infSaveSpinner').removeClass('d-none');
    $('#infSave').prop('disabled', true);
    const url = api + '?action=' + (id ? 'edit' : 'add');
    const kode = $('#inf_kode').val().trim();
    const tipe = $('#inf_tipe').val() || '';
    const sn = $('#inf_sn').val().trim();
    const tahun = $('#inf_tahun').val().trim();
    const kondisi = $('#inf_kondisi').val().trim();
    const lokasi = $('#inf_lokasi').val().trim();
    let data;
    if (id) {
      data = {id: id, kode: kode, tipe: tipe, name: name, detail: detail, sn: sn, tahun: tahun, kondisi: kondisi, lokasi: lokasi};
    } else {
      data = {category: cat, kode: kode, tipe: tipe, name: name, detail: detail, sn: sn, tahun: tahun, kondisi: kondisi, lokasi: lokasi};
    }

    function doPost(){
      $.post(url, data, function(resp){
        $('#infSaveSpinner').addClass('d-none');
        if (resp.success) {
          modal.hide();
          refresh();
          showToast(id ? 'Item updated' : 'Item added');
        } else {
          $('#infAlert').removeClass('d-none').text(resp.msg || 'Error');
          if (resp.msg && resp.msg.toLowerCase().includes('kode')) { $('#inf_kode').addClass('is-invalid'); $('#kodeFeedback').text(resp.msg); }
        }
      }, 'json').fail(function(){
        $('#infSaveSpinner').addClass('d-none');
        $('#infAlert').removeClass('d-none').text('Network error');
      }).always(function(){
        $('#infSave').prop('disabled', !INF_TI_IS_ADMIN || !$('#inf_name').val().trim());
      });
    }

    // validate tipe client-side
    const allowed = tipeOptions[cat] || [];
    if (tipe && allowed.indexOf(tipe) === -1) {
      $('#infSaveSpinner').addClass('d-none');
      $('#inf_tipe').addClass('is-invalid');
      $('#tipeFeedback').text('Invalid tipe for selected category');
      $('#infSave').prop('disabled', false);
      return;
    } else {
      $('#inf_tipe').removeClass('is-invalid');
      $('#tipeFeedback').text('');
    }

    // if kode provided, check uniqueness first
    if (kode) {
      $.get(api, {action: 'check_kode', kode: kode, id: id || ''}, function(resp){
        if (!resp.success || resp.exists) {
          $('#infSaveSpinner').addClass('d-none');
          $('#inf_kode').addClass('is-invalid');
          $('#kodeFeedback').text(resp.msg || 'Kode already exists');
          $('#infSave').prop('disabled', false);
          return;
        }
        $('#inf_kode').removeClass('is-invalid');
        $('#kodeFeedback').text('');
        doPost();
      }, 'json').fail(function(){
        $('#infSaveSpinner').addClass('d-none');
        $('#infAlert').removeClass('d-none').text('Network error');
        $('#infSave').prop('disabled', false);
      });
    } else {
      $('#inf_kode').removeClass('is-invalid');
      $('#kodeFeedback').text('');
      doPost();
    }
  });

  // edit/delete handlers
  $(document).on('click', '.btn-edit', function(){
    if (!INF_TI_IS_ADMIN) return;
    const id = $(this).data('id');
    // fetch item details from list
    $.get(api, {action: 'list'}, function(resp){
      if (!resp.success) return;
      const found = resp.items.find(x => x.id == id);
      if (found) openModal(found.category, found);
    }, 'json');
  });

  $(document).on('click', '.btn-delete', function(){
    if (!INF_TI_IS_ADMIN) return;
    if (!confirm('Delete this item?')) return;
    const id = $(this).data('id');
    $.post(api + '?action=delete', {id: id}, function(resp){
      if (resp.success) { refresh(); showToast('Item deleted','warning'); } else {
        alert(resp.msg || 'Error');
      }
    }, 'json');
  });

  // header checkboxes
  $('#chkAllKomputer').on('change', function(){ $('#tblKomputer tbody .row-chk').prop('checked', $(this).prop('checked')); });
  $('#chkAllSupport').on('change', function(){ $('#tblSupport tbody .row-chk').prop('checked', $(this).prop('checked')); });
  $('#chkAllJaringan').on('change', function(){ $('#tblJaringan tbody .row-chk').prop('checked', $(this).prop('checked')); });

  // initialize DataTables after DOM ready
  initDataTables();
  // wire column filters to DataTables
  // Komputer filters
  $('#tblKomputer thead .filter-kode').on('input', function(){ dtKomputer.column(2).search(this.value).draw(); });
  $('#tblKomputer thead .filter-tipe').on('input', function(){ dtKomputer.column(3).search(this.value).draw(); });
  $('#tblKomputer thead .filter-merk').on('input', function(){ dtKomputer.column(4).search(this.value).draw(); });
  $('#tblKomputer thead .filter-spesifikasi').on('input', function(){ dtKomputer.column(5).search(this.value).draw(); });
  $('#tblKomputer thead .filter-sn').on('input', function(){ dtKomputer.column(6).search(this.value).draw(); });
  $('#tblKomputer thead .filter-tahun').on('input', function(){ dtKomputer.column(7).search(this.value).draw(); });
  $('#tblKomputer thead .filter-kondisi').on('input', function(){ dtKomputer.column(8).search(this.value).draw(); });
  $('#tblKomputer thead .filter-lokasi').on('input', function(){ dtKomputer.column(9).search(this.value).draw(); });
  $('#tblKomputer thead .filter-tgl').on('input', function(){ dtKomputer.column(10).search(this.value).draw(); });

  // Support filters
  $('#tblSupport thead .filter-kode').on('input', function(){ dtSupport.column(2).search(this.value).draw(); });
  $('#tblSupport thead .filter-tipe').on('input', function(){ dtSupport.column(3).search(this.value).draw(); });
  $('#tblSupport thead .filter-merk').on('input', function(){ dtSupport.column(4).search(this.value).draw(); });
  $('#tblSupport thead .filter-spesifikasi').on('input', function(){ dtSupport.column(5).search(this.value).draw(); });
  $('#tblSupport thead .filter-sn').on('input', function(){ dtSupport.column(6).search(this.value).draw(); });
  $('#tblSupport thead .filter-tahun').on('input', function(){ dtSupport.column(7).search(this.value).draw(); });
  $('#tblSupport thead .filter-kondisi').on('input', function(){ dtSupport.column(8).search(this.value).draw(); });
  $('#tblSupport thead .filter-lokasi').on('input', function(){ dtSupport.column(9).search(this.value).draw(); });
  $('#tblSupport thead .filter-tgl').on('input', function(){ dtSupport.column(10).search(this.value).draw(); });

  // Jaringan filters
  $('#tblJaringan thead .filter-kode').on('input', function(){ dtJaringan.column(2).search(this.value).draw(); });
  $('#tblJaringan thead .filter-tipe').on('input', function(){ dtJaringan.column(3).search(this.value).draw(); });
  $('#tblJaringan thead .filter-merk').on('input', function(){ dtJaringan.column(4).search(this.value).draw(); });
  $('#tblJaringan thead .filter-spesifikasi').on('input', function(){ dtJaringan.column(5).search(this.value).draw(); });
  $('#tblJaringan thead .filter-sn').on('input', function(){ dtJaringan.column(6).search(this.value).draw(); });
  $('#tblJaringan thead .filter-tahun').on('input', function(){ dtJaringan.column(7).search(this.value).draw(); });
  $('#tblJaringan thead .filter-kondisi').on('input', function(){ dtJaringan.column(8).search(this.value).draw(); });
  $('#tblJaringan thead .filter-lokasi').on('input', function(){ dtJaringan.column(9).search(this.value).draw(); });
  $('#tblJaringan thead .filter-tgl').on('input', function(){ dtJaringan.column(10).search(this.value).draw(); });

  // call refresh to populate tables
  refresh();

  // redraw DataTables when a tab becomes visible to fix rendering in hidden tabs (use small delay for Bootstrap animation)
  $('button[data-bs-toggle="tab"], a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e){
    const target = $(e.target).attr('data-bs-target');
    setTimeout(function(){
      if (target === '#tab-komputer' && dtKomputer) { dtKomputer.columns.adjust().draw(); }
      if (target === '#tab-support' && dtSupport) { dtSupport.columns.adjust().draw(); }
      if (target === '#tab-jaringan' && dtJaringan) { dtJaringan.columns.adjust().draw(); }
    }, 120);
  });

  // initial adjust for the active tab (delayed)
  setTimeout(function(){
    if (dtKomputer) { dtKomputer.columns.adjust().draw(); }
    if (dtSupport && $('#tab-support').hasClass('show')) { dtSupport.columns.adjust().draw(); }
    if (dtJaringan && $('#tab-jaringan').hasClass('show')) { dtJaringan.columns.adjust().draw(); }
  }, 120);

  function selectedIds(){
    const ids = [];
    $('.row-chk:checked').each(function(){ ids.push($(this).data('id')); });
    return ids;
  }

  // drag-and-drop ordering
  function makeSortable(tbodySelector, saveBtnSelector){
    const tbody = $(tbodySelector);
    tbody.on('dragstart', 'tr', function(e){
      e.originalEvent.dataTransfer.setData('text/plain', $(this).data('id'));
      $(this).addClass('dragging');
    });
    tbody.on('dragover', 'tr', function(e){
      e.preventDefault();
      const dragging = tbody.find('.dragging');
      if (!dragging.length) return;
      const target = $(this);
      if (target.hasClass('dragging')) return;
      // determine whether to insert before or after based on mouse position
      const rect = this.getBoundingClientRect();
      const mid = rect.top + rect.height / 2;
      if (e.originalEvent.clientY < mid) target.before(dragging);
      else target.after(dragging);
    });
    tbody.on('dragend', 'tr', function(){
      $(this).removeClass('dragging');
      // renumber
      tbody.find('tr').each(function(i){ $(this).find('td').eq(2).text(i+1); });
      $(saveBtnSelector).prop('disabled', false);
    });

    // set drag cursor on handle only
    tbody.on('mousedown', '.drag-handle', function(){ $(this).closest('tr').attr('draggable', true); });
    tbody.on('mouseup', '.drag-handle', function(){ $(this).closest('tr').attr('draggable', false); });
  }

  makeSortable('#tblKomputer tbody', '#saveOrderKomputer');
  makeSortable('#tblSupport tbody', '#saveOrderSupport');
  makeSortable('#tblJaringan tbody', '#saveOrderJaringan');

  // Save order handlers
  $('#saveOrderKomputer').on('click', function(){ saveOrder('komputer', '#tblKomputer', this); });
  $('#saveOrderSupport').on('click', function(){ saveOrder('support', '#tblSupport', this); });
  $('#saveOrderJaringan').on('click', function(){ saveOrder('jaringan', '#tblJaringan', this); });

  function saveOrder(category, tableSelector, btn){
    const ids = $(tableSelector + ' tbody tr').map(function(){ return $(this).data('id'); }).get();
    if (!ids.length) return;
    $(btn).prop('disabled', true).text('Saving...');
    $.post(api + '?action=save_order', {category: category, ids: ids}, function(resp){
      if (resp.success) { showToast('Order saved'); refresh(); } else { alert(resp.msg || 'Error'); }
      $(btn).prop('disabled', false).text('Save Order');
    }, 'json').fail(function(){ alert('Network error'); $(btn).prop('disabled', false).text('Save Order'); });
  }
  // helper to get selected columns
  function getSelectedCols(){
    return $('.export-col:checked').map(function(){ return $(this).val(); }).get();
  }

  // Export All
  $('#btnExportAll').on('click', function(){
    const cols = getSelectedCols();
    const q = cols.length ? '&cols=' + encodeURIComponent(cols.join(',')) : '';
    window.location = api + '?action=export' + q;
  });

  // Export Selected
  $('#btnExportSelected').on('click', function(){
    const ids = selectedIds();
    if (!ids.length){ alert('No items selected'); return; }
    const cols = getSelectedCols();
    const q = cols.length ? '&cols=' + encodeURIComponent(cols.join(',')) : '';
    window.location = api + '?action=export&ids=' + ids.join(',') + q;
  });

  // Export columns select all/none
  $('#btnSelectAllCols').on('click', function(e){ e.preventDefault(); $('.export-col').prop('checked', true); });
  $('#btnDeselectAllCols').on('click', function(e){ e.preventDefault(); $('.export-col').prop('checked', false); });

  // Delete Selected
  $('#btnDeleteSelected').on('click', function(){
    if (!INF_TI_IS_ADMIN){ alert('Admin only'); return; }
    const ids = selectedIds();
    if (!ids.length){ alert('No items selected'); return; }
    if (!confirm('Delete selected items?')) return;
    $.post(api + '?action=bulk_delete', {ids: ids}, function(resp){
      if (resp.success) { refresh(); showToast(resp.deleted + ' items deleted','warning'); } else {
        alert(resp.msg || 'Error');
      }
    }, 'json');
  });

  refresh();
});
</script>

<?php include 'layout_footer.php'; ?>

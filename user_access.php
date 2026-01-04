<?php include 'layout_header.php'; ?>
<?php
// Only admin can manage access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
    echo '<div class="container-fluid mt-4"><div class="alert alert-danger">Unauthorized</div></div>';
    include 'layout_footer.php';
    exit;
}
?>
<div class="container-fluid mt-4">
  <h1 class="h3 mb-4">Akses (User Access Management)</h1>
  <div id="crudAlert" style="display:none;"></div>
  <div class="card mt-4">
    <div class="card-header">Manage User Access</div>
    <div class="card-body">
      <div class="mb-3 row align-items-center">
        <label class="col-auto col-form-label">Select User</label>
        <div class="col-auto">
          <select id="accessUserSelect" class="form-select"></select>
        </div>
        <div class="col-auto">
          <button id="loadAccessBtn" class="btn btn-primary">Load</button>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" id="accessTable">
          <thead>
            <tr>
              <th>Menu</th>
              <th class="text-center"><div class="form-check"><input id="selectAllFull" class="form-check-input" type="checkbox"><label class="form-check-label ms-1">Full</label></div></th>
              <th class="text-center"><div class="form-check"><input id="selectAllCreate" class="form-check-input" type="checkbox"><label class="form-check-label ms-1">Create</label></div></th>
              <th class="text-center"><div class="form-check"><input id="selectAllRead" class="form-check-input" type="checkbox"><label class="form-check-label ms-1">Read</label></div></th>
              <th class="text-center"><div class="form-check"><input id="selectAllUpdate" class="form-check-input" type="checkbox"><label class="form-check-label ms-1">Update</label></div></th>
              <th class="text-center"><div class="form-check"><input id="selectAllDelete" class="form-check-input" type="checkbox"><label class="form-check-label ms-1">Delete</label></div></th>
            </tr>
          </thead>
          <tbody>
            <!-- rows populated via JS -->
          </tbody>
        </table>
      </div>
      <button id="saveAccessBtn" class="btn btn-success">Save Access</button>
    </div>
  </div>
</div>

<script>
$(function(){
  function loadUsers(){
    $.getJSON('php/user_api.php?action=list', function(resp){
      $('#accessUserSelect').empty();
      if(resp.data && resp.data.length){
        resp.data.forEach(function(u){
          $('#accessUserSelect').append($('<option>').val(u.id).text(u.name + ' ('+u.id+')'));
        });
      }
    });
  }

  function loadMenus(){
    $.getJSON('php/access_api.php?action=get_menus', function(resp){
      var rows = '';
      resp.data.forEach(function(m){
        rows += '<tr data-menu="'+m.key+'">';
        rows += '<td>'+m.label+'</td>';
        rows += '<td class="text-center"><div class="form-check form-switch"><input class="form-check-input fullToggle" type="checkbox"></div></td>';
        rows += '<td class="text-center"><div class="form-check form-switch"><input class="form-check-input createToggle" type="checkbox"></div></td>';
        rows += '<td class="text-center"><div class="form-check form-switch"><input class="form-check-input readToggle" type="checkbox"></div></td>';
        rows += '<td class="text-center"><div class="form-check form-switch"><input class="form-check-input updateToggle" type="checkbox"></div></td>';
        rows += '<td class="text-center"><div class="form-check form-switch"><input class="form-check-input deleteToggle" type="checkbox"></div></td>';
        rows += '</tr>';
      });
      $('#accessTable tbody').html(rows);
    });
  }

  function loadAccessForUser(userId){
    if(!userId) return;
    $.getJSON('php/access_api.php?action=list&user_id='+userId, function(resp){
      // clear
      $('#accessTable tbody tr').each(function(){
        $(this).find('input[type=checkbox]').prop('checked', false);
      });
      if(resp.data){
        Object.keys(resp.data).forEach(function(menuKey){
          var row = $('#accessTable tbody tr[data-menu="'+menuKey+'"]');
          if(row.length){
            var p = resp.data[menuKey];
            row.find('.fullToggle').prop('checked', !!p.full);
            row.find('.createToggle').prop('checked', !!p.create);
            row.find('.readToggle').prop('checked', !!p.read);
            row.find('.updateToggle').prop('checked', !!p.update);
            row.find('.deleteToggle').prop('checked', !!p.delete);
          }
        });
      }
    });
  }

  // when Full is toggled, set/clear other toggles in the same row
  $(document).on('change', '.fullToggle', function(){
    var row = $(this).closest('tr');
    var checked = $(this).prop('checked');
    row.find('.createToggle, .readToggle, .updateToggle, .deleteToggle').prop('checked', checked);
    updateHeaderState();
  });

  // header select-all handlers
  $('#selectAllFull').on('change', function(){ $('#accessTable tbody .fullToggle').prop('checked', this.checked).trigger('change'); });
  $('#selectAllCreate').on('change', function(){ $('#accessTable tbody .createToggle').prop('checked', this.checked); updateHeaderState(); });
  $('#selectAllRead').on('change', function(){ $('#accessTable tbody .readToggle').prop('checked', this.checked); updateHeaderState(); });
  $('#selectAllUpdate').on('change', function(){ $('#accessTable tbody .updateToggle').prop('checked', this.checked); updateHeaderState(); });
  $('#selectAllDelete').on('change', function(){ $('#accessTable tbody .deleteToggle').prop('checked', this.checked); updateHeaderState(); });

  // Update header checkbox states (checked/indeterminate) based on row checkboxes
  function updateHeaderState(){
    function updateFor(selector, headerId){
      var $all = $('#accessTable tbody '+selector);
      if(!$all.length) { $('#'+headerId).prop('checked', false).prop('indeterminate', false); return; }
      var total = $all.length;
      var checked = $all.filter(':checked').length;
      $('#'+headerId).prop('checked', checked === total);
      $('#'+headerId).prop('indeterminate', checked > 0 && checked < total);
    }
    updateFor('.fullToggle', 'selectAllFull');
    updateFor('.createToggle', 'selectAllCreate');
    updateFor('.readToggle', 'selectAllRead');
    updateFor('.updateToggle', 'selectAllUpdate');
    updateFor('.deleteToggle', 'selectAllDelete');
  }

  $('#loadAccessBtn').click(function(){
    var uid = $('#accessUserSelect').val();
    loadAccessForUser(uid);
  });

  $('#saveAccessBtn').click(function(){
    var uid = $('#accessUserSelect').val();
    if(!uid){ alert('Please select a user'); return; }
    var perms = [];
    $('#accessTable tbody tr').each(function(){
      var menu = $(this).data('menu');
      var full = $(this).find('.fullToggle').prop('checked') ? 1 : 0;
      var create = $(this).find('.createToggle').prop('checked') ? 1 : 0;
      var read = $(this).find('.readToggle').prop('checked') ? 1 : 0;
      var update = $(this).find('.updateToggle').prop('checked') ? 1 : 0;
      var del = $(this).find('.deleteToggle').prop('checked') ? 1 : 0;
      // if no permission set, we still send zero rows to clear existing
      perms.push({menu: menu, full: full, create: create, read: read, update: update, delete: del});
    });
    $.ajax({
      url: 'php/access_api.php?action=set',
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({user_id: uid, permissions: perms}),
      success: function(resp){
        showCrudAlert('Access saved successfully', 'success');
      }
    });
  });

  function showCrudAlert(message, type){
    var html = '<div class="alert alert-'+type+' alert-dismissible fade show" role="alert">'+message+'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    $('#crudAlert').html(html).show();
    setTimeout(function(){ $('#crudAlert').fadeOut(); }, 3000);
  }

  loadUsers();
  loadMenus();

  // auto-select first user when available
  $(document).on('change', '#accessUserSelect', function(){
    var v = $(this).val();
    if(v) loadAccessForUser(v);
  });

  // after menus loaded, ensure header state is reset
  $(document).ajaxStop(function(){
    // update header states when any ajax completes (simple approach)
    updateHeaderState();
  });

});
</script>

<?php include 'layout_footer.php'; ?>
<?php include 'layout_header.php'; ?>
<!-- Dashboard Content -->
<div class="container-fluid mt-4">
  <div class="site-hero mb-4">
    <div class="d-flex align-items-start justify-content-between">
      <div>
        <div class="mb-2">
          <span class="badge bg-light text-dark btn-pill">BKPSDM Kabupaten Gresik</span>
          <span class="badge bg-light text-dark ms-2 btn-pill">PRYO ARDY WARDHANA</span>
          <span class="badge bg-light text-dark ms-2 btn-pill">199003052024211008</span>
          <span class="badge bg-light text-dark ms-2 btn-pill"><?php echo date('l, d F Y'); ?></span>
          <span class="badge bg-light text-dark ms-2 btn-pill" id="heroTime"><?php echo date('H:i:s'); ?></span>
        </div>
        <h1>Badan Kepegawaian dan Pengembangan Sumber Daya Manusia</h1>
        <p class="lead">Kendalikan layanan dan data kepegawaian internal dalam satu aplikasi terpadu</p>
        <div class="tags">
          <span class="tag">Kedaton</span>
          <span class="tag">Sipantas</span>
          <span class="tag">Prestige</span>
          <span class="tag">Satmata</span>
          <span class="tag">Gapura</span>
          <span class="tag">Performa</span>
        </div>
      </div>
    </div>
  </div>

    <div class="card mt-2 rounded-lg shadow-sm">
        <div class="card-header">Sample User List (AJAX)</div>
        <div class="card-body">
            <table class="table table-bordered" id="userTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded here -->
                </tbody>
            </table>
        </div>
    </div>
    <script>
    // live hero time update
+    setInterval(function(){
+      document.getElementById('heroTime').textContent = new Date().toLocaleTimeString('en-GB');
+    },1000);
    $(document).ready(function() {
        $.getJSON('php/sample_users.php', function(response) {
            var rows = '';
            $.each(response.data, function(i, user) {
                rows += '<tr>' +
                    '<td>' + user.id + '</td>' +
                    '<td>' + user.name + '</td>' +
                    '<td>' + user.email + '</td>' +
                    '</tr>';
            });
            $('#userTable tbody').html(rows);
        });
    });
    </script>
    <!-- Dashboard Content ends here -->
<?php include 'layout_footer.php'; ?>

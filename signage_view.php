<?php
// signage_view.php: View and arrange signage items visually
include 'layout_header.php';
?>
<style>
.signage-banner { background: #d48422; color: #111; min-height: 80px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
.signage-footer { background: #2ca3a3; color: #111; min-height: 40px; display: flex; align-items: center; justify-content: center; }
.signage-main { background: #4a90e2; min-height: 400px; display: flex; align-items: center; justify-content: center; color: #111; font-size: 2rem; }
.signage-side { background: #17989e; min-height: 400px; }
.signage-table { background: #17989e; margin-bottom: 20px; }
.signage-gallery { background: #17989e; }
.signage-gallery-img { background: #4a90e2; min-height: 120px; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; color: #fff; overflow: hidden; }
.signage-gallery-img img { width: 100%; height: 100%; object-fit: cover; }
.signage-video { width: 100%; height: 100%; }
.signage-noimg { color: #aaa; font-size: 0.9rem; }
</style>
<?php
$signage = [];
$conn = new mysqli('127.0.0.1', 'root', '', 'sapps');
$result = $conn->query("SELECT * FROM signage_items");
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $signage[$row['name']] = ['type' => $row['type'], 'content' => $row['content']];
  }
}
?>
<div class="container-fluid p-0">
  <div class="row g-0">
    <div class="col-12 signage-banner">
      <span class="signage-noimg me-3">No Image</span>
      <b><?= isset($signage['Welcome 1']) ? $signage['Welcome 1']['content'] : 'Welcome 1' ?></b>
    </div>
  </div>
  <div class="row g-0">
    <div class="col-md-8 signage-main">
      <?php if (isset($signage['Video 1']) && $signage['Video 1']['type'] === 'Video'): ?>
        <video class="signage-video" controls>
          <source src="<?= htmlspecialchars($signage['Video 1']['content']) ?>" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      <?php else: ?>
        Video 1
      <?php endif; ?>
    </div>
    <div class="col-md-4 signage-side p-3">
      <div class="signage-table mb-3">
        <div class="fw-bold text-center"><?= isset($signage['Tabel Kegiatan']) ? $signage['Tabel Kegiatan']['content'] : 'Tabel Kegiatan' ?></div>
        <table class="table table-bordered table-sm mb-2">
          <thead><tr><th>No</th><th>Kegiatan</th><th>Tempat</th><th>Waktu</th><th>Status</th></tr></thead>
          <tbody><tr><td>1</td><td>a</td><td>b</td><td>c</td><td>d</td></tr></tbody>
        </table>
      </div>
      <div class="signage-table mb-3">
        <div class="fw-bold text-center"><?= isset($signage['Tabel Agenda']) ? $signage['Tabel Agenda']['content'] : 'Tabel Agenda' ?></div>
        <table class="table table-bordered table-sm mb-2">
          <thead><tr><th>No</th><th>Kegiatan</th><th>Tempat</th><th>Waktu</th><th>Status</th></tr></thead>
          <tbody><tr><td>1</td><td>a</td><td>b</td><td>c</td><td>d</td></tr></tbody>
        </table>
      </div>
      <div class="row signage-gallery">
        <div class="col-6">
          <div class="fw-bold text-center mb-2"><?= isset($signage['Galeri 1']) && !empty($signage['Galeri 1']['content']) ? 'Galeri 1' : 'Galeri 1' ?></div>
          <div class="signage-gallery-img">
            <?php if (isset($signage['Galeri 1']) && $signage['Galeri 1']['type'] === 'Images' && !empty($signage['Galeri 1']['content'])): ?>
              <img src="<?= htmlspecialchars($signage['Galeri 1']['content']) ?>" alt="Galeri 1" style="width:100%; height:100%; object-fit:cover;">
            <?php else: ?>
              <span style="color:#ccc; font-size:0.9rem;">No Image</span>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-6">
          <div class="fw-bold text-center mb-2"><?= isset($signage['Galeri 2']) && !empty($signage['Galeri 2']['content']) ? 'Galeri 2' : 'Galeri 2' ?></div>
          <div class="signage-gallery-img">
            <?php if (isset($signage['Galeri 2']) && $signage['Galeri 2']['type'] === 'Images' && !empty($signage['Galeri 2']['content'])): ?>
              <img src="<?= htmlspecialchars($signage['Galeri 2']['content']) ?>" alt="Galeri 2" style="width:100%; height:100%; object-fit:cover;">
            <?php else: ?>
              <span style="color:#ccc; font-size:0.9rem;">No Image</span>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-0">
    <div class="col-12 signage-banner">
      <b><?= isset($signage['Welcome 2']) ? $signage['Welcome 2']['content'] : 'Welcome 2' ?></b>
    </div>
  </div>
  <div class="row g-0">
    <div class="col-12 signage-footer">
      <?= isset($signage['Footer']) ? $signage['Footer']['content'] : 'Footer' ?>
    </div>
  </div>
</div>
<?php include 'layout_footer.php'; ?>

<?php
// Detail page for Infrastruktur TI item
include 'layout_header.php';
include_once 'php/db_connect.php';
include_once 'php/qr_helper.php';

// Support lookup by either id or kode (so QR can point to kode and still resolve)
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$kode = isset($_GET['kode']) ? trim($_GET['kode']) : '';
$item = null;
if ($id > 0) {
  $res = $conn->prepare('SELECT * FROM inf_ti_items WHERE id = ?');
  $res->bind_param('i', $id);
  $res->execute();
  $item = $res->get_result()->fetch_assoc();
  $res->close();
} elseif ($kode !== '') {
  $res = $conn->prepare('SELECT * FROM inf_ti_items WHERE kode = ?');
  $res->bind_param('s', $kode);
  $res->execute();
  $item = $res->get_result()->fetch_assoc();
  $res->close();
}
if (!$item) { echo '<div class="alert alert-danger">Item not found.</div>'; include 'layout_footer.php'; exit; }

// Prefer QR that links using kode (human-friendly) if available
$linkId = $item['kode'] ? ('?kode=' . urlencode($item['kode'])) : ('?id=' . intval($item['id']));
$qr_url = generate_qr_url((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/sapps/inf_ti_detail.php' . $linkId);
?>
<div class="container mt-4">
  <h2>Detail Infrastruktur TI</h2>
  <table class="table table-bordered w-auto">
    <tr><th>Kode</th><td><?= htmlspecialchars($item['kode'] ?? $item['id']) ?></td></tr>
    <tr><th>Kategori</th><td><?= htmlspecialchars($item['category']) ?></td></tr>
    <tr><th>Tipe</th><td><?= htmlspecialchars($item['category']) ?></td></tr>
    <tr><th>Merk</th><td><?= htmlspecialchars($item['name']) ?></td></tr>
    <tr><th>Spesifikasi</th><td><?= htmlspecialchars($item['detail']) ?></td></tr>
    <tr><th>SN</th><td><?= htmlspecialchars($item['sn'] ?? '') ?></td></tr>
    <tr><th>Pengadaan Tahun</th><td><?= htmlspecialchars($item['tahun'] ?? '') ?></td></tr>
    <tr><th>Kondisi</th><td><?= htmlspecialchars($item['kondisi'] ?? '') ?></td></tr>
    <tr><th>Lokasi</th><td><?= htmlspecialchars($item['lokasi'] ?? '') ?></td></tr>
    <tr><th>Tanggal Update</th><td><?= htmlspecialchars($item['updated_at']) ?></td></tr>
  </table>
  <div class="mb-3">
    <img src="<?= $qr_url ?>" alt="QR Code" width="120" height="120">
    <div class="small text-muted">Scan untuk detail ini</div>
  </div>
  <a href="inf_ti.php" class="btn btn-secondary">Kembali</a>
</div>
<?php include 'layout_footer.php'; ?>

<?php
// saview.php: Signage view page without navbar/sidebar
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signage View - Support Apps BKPSDM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="margin: 0; padding: 0;">
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
.signage-logo { max-height: 60px; max-width: 160px; object-fit: contain; margin-right: 12px; }
.signage-video-wrap { position: relative; width: 100%; height: 100%; } .signage-footer { position: relative; } .saview-clock { position: absolute; right: 16px; bottom: 8px; color: #fff; font-weight: 700; font-size: 1rem; z-index: 5; text-shadow: 0 1px 2px rgba(0,0,0,0.4); display:flex; align-items:center; gap:8px; }
.saview-clock svg { width: 18px; height: 18px; fill: #fff; }
.saview-clock .visually-hidden { position: absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0; }</style>
<?php
$signage = [];
$conn = new mysqli('127.0.0.1', 'root', '', 'sapps');
$result = $conn->query("SELECT * FROM signage_items");
if ($result) {
  while ($row = $result->fetch_assoc()) {
    $autoplay = isset($row['autoplay']) ? (int)$row['autoplay'] : 0;
    $loop = isset($row['loop']) ? (int)$row['loop'] : 0;
    $muted = isset($row['muted']) ? (int)$row['muted'] : 1;
    $signage[$row['name']] = [
      'type' => $row['type'],
      'content' => $row['content'],
      'autoplay' => $autoplay,
      'loop' => $loop,
      'muted' => $muted
    ];
  }
}

// Current date/time in Indonesian format (Asia/Jakarta)
$nowStr = '';
try {
    $tz = new DateTimeZone('Asia/Jakarta');
} catch (Exception $e) {
    $tz = new DateTimeZone(date_default_timezone_get());
}
$now = new DateTime('now', $tz);
// clock format from settings (default long)
$clockFormat = 'long';
if (isset($signage['SaviewClockFormat']) && !empty($signage['SaviewClockFormat']['content'])) {
  $cf = trim($signage['SaviewClockFormat']['content']);
  $decoded = json_decode($cf, true);
  if (is_array($decoded) && isset($decoded['selected'])) {
    $clockFormat = $decoded['selected'];
  } else {
    $allowed = ['long','short','time','date','iso','weekday_short'];
    if (in_array($cf, $allowed)) $clockFormat = $cf;
  }
}

// Helper to build server-side formatted string according to selected format
if (class_exists('IntlDateFormatter')) {
  switch ($clockFormat) {
    case 'short':
      $fmt = new IntlDateFormatter('id_ID', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT, 'Asia/Jakarta', IntlDateFormatter::GREGORIAN, "dd/MM/yyyy HH:mm");
      $nowStr = $fmt->format($now);
      break;
    case 'time':
      $fmt = new IntlDateFormatter('id_ID', IntlDateFormatter::NONE, IntlDateFormatter::MEDIUM, 'Asia/Jakarta', IntlDateFormatter::GREGORIAN, "HH:mm:ss");
      $nowStr = $fmt->format($now);
      break;
    case 'date':
      $fmt = new IntlDateFormatter('id_ID', IntlDateFormatter::MEDIUM, IntlDateFormatter::NONE, 'Asia/Jakarta', IntlDateFormatter::GREGORIAN, "d MMMM yyyy");
      $nowStr = $fmt->format($now);
      break;
    case 'iso':
      $nowStr = $now->format('Y-m-d H:i:s');
      break;
    case 'weekday_short':
      $fmt = new IntlDateFormatter('id_ID', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT, 'Asia/Jakarta', IntlDateFormatter::GREGORIAN, "EEE, d MMM yyyy HH:mm");
      $nowStr = $fmt->format($now);
      break;
    default:
      $fmt = new IntlDateFormatter('id_ID', IntlDateFormatter::FULL, IntlDateFormatter::MEDIUM, 'Asia/Jakarta', IntlDateFormatter::GREGORIAN, "EEEE, d MMMM yyyy HH:mm:ss");
      $nowStr = $fmt->format($now);
      break;
  }
} else {
  $days = [0 => 'Minggu', 1 => 'Senin', 2 => 'Selasa', 3 => 'Rabu', 4 => 'Kamis', 5 => 'Jumat', 6 => 'Sabtu'];
  $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
  $w = (int)$now->format('w');
  $d = (int)$now->format('j');
  $m = (int)$now->format('n');
  $y = $now->format('Y');
  $hh = $now->format('H');
  $mm = $now->format('i');
  $ss = $now->format('s');
  switch ($clockFormat) {
    case 'short':
      $nowStr = sprintf('%02d/%02d/%s %s:%s', $d, $m, $y, $hh, $mm);
      break;
    case 'time':
      $nowStr = sprintf('%s:%s:%s', $hh, $mm, $ss);
      break;
    case 'date':
      $nowStr = sprintf('%d %s %s', $d, $months[$m], $y);
      break;
    case 'iso':
      $nowStr = $now->format('Y-m-d H:i:s');
      break;
    case 'weekday_short':
      $shortDays = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
      $nowStr = sprintf('%s, %d %s %s %s:%s', $shortDays[$w], $d, substr($months[$m],0,3), $y, $hh, $mm);
      break;
    default:
      $nowStr = sprintf('%s, %d %s %s %s:%s:%s', $days[$w], $d, $months[$m], $y, $hh, $mm, $ss);
      break;
  }
}
?>
<div class="container-fluid p-0">
  <div class="row g-0">
    <div class="col-12 signage-banner">
      <?php if (isset($signage['Logo']) && $signage['Logo']['type'] === 'Images' && !empty($signage['Logo']['content'])): ?>
        <img class="signage-logo" src="<?= htmlspecialchars($signage['Logo']['content']) ?>" alt="Logo">
      <?php else: ?>
        <span class="signage-noimg me-3">Logo</span>
      <?php endif; ?>
      <b><?= isset($signage['Welcome 1']) ? $signage['Welcome 1']['content'] : 'Welcome 1' ?></b>
    </div>
  </div>
  <div class="row g-0">
    <div class="col-md-8 signage-main">
      <?php if (isset($signage['Video 1']) && $signage['Video 1']['type'] === 'Video'): ?>
        <div class="signage-video-wrap">
          <video id="signageVideo" class="signage-video" controls <?= ($signage['Video 1']['autoplay'] ?? 0) === 1 ? 'autoplay' : '' ?> <?= ($signage['Video 1']['loop'] ?? 0) === 1 ? 'loop' : '' ?> <?= ($signage['Video 1']['muted'] ?? 1) === 1 ? 'muted' : '' ?> playsinline>
            <source src="<?= htmlspecialchars($signage['Video 1']['content']) ?>" type="video/mp4">
            Your browser does not support the video tag.
          </video>
        </div>
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
      <div><?= isset($signage['Footer']) ? $signage['Footer']['content'] : 'Footer' ?></div>
      <div class="saview-clock" aria-hidden="false">
        <span class="saview-clock-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" focusable="false" aria-hidden="true"><path d="M12 1a11 11 0 1 0 .001 22.001A11 11 0 0 0 12 1zm0 2a9 9 0 1 1 0 18 9 9 0 0 1 0-18zm.5 4h-1v6l5 3 .5-.86-4.5-2.64V7z"/></svg>
        </span>
        <span id="saviewClock"><?= htmlspecialchars($nowStr) ?></span>
      </div>
    </div>
  </div>
</div>
<script>
(function(){
  function pad(n){return n<10?('0'+n):n;}
  // format according to selected clock format from admin (long/short/time/date/iso/weekday_short)
  var saviewClockFormat = 'long';
  try { saviewClockFormat = <?= json_encode($clockFormat) ?>; } catch(e) {}
  function formatIndo(d){
    function pad2(n){return n<10?('0'+n):n}
    if (saviewClockFormat === 'short') {
      if (typeof Intl !== 'undefined' && Intl.DateTimeFormat) {
        try { return new Intl.DateTimeFormat('id-ID',{day:'2-digit',month:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit',hour12:false,timeZone:'Asia/Jakarta'}).format(d); } catch(e){}
      }
      return pad2(d.getDate()) + '/' + pad2(d.getMonth()+1) + '/' + d.getFullYear() + ' ' + pad2(d.getHours()) + ':' + pad2(d.getMinutes());
    }
    if (saviewClockFormat === 'time') {
      return pad2(d.getHours()) + ':' + pad2(d.getMinutes()) + ':' + pad2(d.getSeconds());
    }
    if (saviewClockFormat === 'date') {
      if (typeof Intl !== 'undefined' && Intl.DateTimeFormat) {
        try { return new Intl.DateTimeFormat('id-ID',{day:'numeric',month:'long',year:'numeric',timeZone:'Asia/Jakarta'}).format(d); } catch(e){}
      }
      var months=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
      return d.getDate() + ' ' + months[d.getMonth()+1] + ' ' + d.getFullYear();
    }
    if (saviewClockFormat === 'iso') {
      return d.getFullYear() + '-' + pad2(d.getMonth()+1) + '-' + pad2(d.getDate()) + ' ' + pad2(d.getHours()) + ':' + pad2(d.getMinutes()) + ':' + pad2(d.getSeconds());
    }
    if (saviewClockFormat === 'weekday_short') {
      if (typeof Intl !== 'undefined' && Intl.DateTimeFormat) {
        try { return new Intl.DateTimeFormat('id-ID',{weekday:'short',day:'numeric',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit',hour12:false,timeZone:'Asia/Jakarta'}).format(d); } catch(e){}
      }
      var days=['Min','Sen','Sel','Rab','Kam','Jum','Sab'];
      var months=['','Jan','Feb','Mar','Apr','Me','Jun','Jul','Agt','Sep','Okt','Nov','Des'];
      return days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()+1] + ' ' + d.getFullYear() + ' ' + pad2(d.getHours()) + ':' + pad2(d.getMinutes());
    }
    // default long format
    if (typeof Intl !== 'undefined' && Intl.DateTimeFormat) {
      try { return new Intl.DateTimeFormat('id-ID',{weekday:'long',day:'numeric',month:'long',year:'numeric',hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:false,timeZone:'Asia/Jakarta'}).format(d); } catch(e){}
    }
    var days=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    var months=['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    return days[d.getDay()] + ', ' + d.getDate() + ' ' + months[d.getMonth()+1] + ' ' + d.getFullYear() + ' ' + pad2(d.getHours()) + ':' + pad2(d.getMinutes()) + ':' + pad2(d.getSeconds());
  }

  function toJakartaDate(now){
    // Prefer Intl to get Jakarta time, otherwise approximate via offsets
    if (typeof Intl !== 'undefined' && Intl.DateTimeFormat) {
      try {
        // Use toLocaleString trick to get components in target timezone
        const s = now.toLocaleString('en-US', {timeZone: 'Asia/Jakarta', hour12:false, year:'numeric', month:'numeric', day:'numeric', hour:'2-digit', minute:'2-digit', second:'2-digit'});
        const parts = s.match(/(\d+)\/(\d+)\/(\d+),\s*(\d+):(\d+):(\d+)/);
        if (parts) {
          const [,mo,day,yr,hh,mm,ss] = parts;
          return new Date(Number(yr), Number(mo)-1, Number(day), Number(hh), Number(mm), Number(ss));
        }
      } catch(e){}
    }
    // Fallback: convert local time to UTC then apply Jakarta offset (UTC+7)
    const localOffset = now.getTimezoneOffset() * 60000;
    const jakartaOffset = 7 * 60 * 60000;
    return new Date(now.getTime() + localOffset + jakartaOffset);
  }

  function update(){
    const el = document.getElementById('saviewClock');
    if (!el) return;
    // if format is custom (not one of builtins), fetch server-rendered time
    const builtins = ['long','short','time','date','iso','weekday_short'];
    if (builtins.indexOf(saviewClockFormat) === -1) {
      // request server time
      fetch('php/signage_api.php?action=get_server_time').then(r=>r.json()).then(j=>{
        if (j && j.time) el.textContent = j.time;
      }).catch(()=>{});
      return;
    }
    const now = new Date();
    const j = toJakartaDate(now);
    const s = formatIndo(j);
    el.textContent = s;
  }

  update();
  setInterval(update, 1000);
})();
</script>
</body>
</html>

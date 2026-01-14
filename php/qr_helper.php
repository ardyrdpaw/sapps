<?php
// Simple QR code generator using Google Chart API (no library required)
function generate_qr_url($data, $size = 120) {
    // Use a stable public QR generation service (api.qrserver.com)
    $url = 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . 'x' . $size . '&data=' . urlencode($data);
    return $url;
}

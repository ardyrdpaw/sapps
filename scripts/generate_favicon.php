<?php
// scripts/generate_favicon.php
// Usage: php scripts/generate_favicon.php
// This simple script will create a favicon.ico file at the project root by embedding
// the PNG data from assets/images/logo.png (if available) into a valid ICO container.
// If logo.png isn't available, falls back to a tiny transparent PNG.

$logoPng = __DIR__ . '/../assets/images/logo.png';
$outIco = __DIR__ . '/../favicon.ico';

if (file_exists($logoPng)) {
    $png = file_get_contents($logoPng);
    // Ensure it appears to be a PNG (header check)
    if (substr($png, 0, 8) !== "\x89PNG\r\n\x1a\n") {
        fwrite(STDERR, "Warning: logo file does not look like a PNG. Using fallback PNG.\n");
        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AApEB/Yo2QkYAAAAASUVORK5CYII=');
    }
} else {
    // fallback: 1x1 transparent PNG
    $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AApEB/Yo2QkYAAAAASUVORK5CYII=');
}

$pngLen = strlen($png);

// Build ICO header (ICONDIR)
$iconDir = pack('vvv', 0, 1, 1); // reserved 0, type 1 (icon), count 1

// ICONDIRENTRY
$width = 0x10; // use 16 for width; 0 means 256 but many readers understand
$height = 0x10; // 16
$colorCount = 0;
$reserved = 0;
$planes = 1;
$bitCount = 32; // store PNG with 32-bit
$bytesInRes = $pngLen;
$imageOffset = 6 + 16; // header (6) + one dir entry (16)

$iconEntry = pack('CCCCvvVV', $width, $height, $colorCount, $reserved, $planes, $bitCount, $bytesInRes, $imageOffset);

$ico = $iconDir . $iconEntry . $png;

if (file_put_contents($outIco, $ico) === false) {
    fwrite(STDERR, "Failed to write $outIco\n");
    exit(1);
}

fwrite(STDOUT, "favicon.ico written to $outIco\n");
exit(0);

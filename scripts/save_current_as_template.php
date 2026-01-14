<?php
// Usage: php save_current_as_template.php TemplateName
$name = $argv[1] ?? 'Template';
$db = new mysqli('127.0.0.1','root','', 'sapps');
if ($db->connect_errno) { echo "DB connect error: {$db->connect_error}\n"; exit(1); }
$res = $db->query("SELECT id, name, content, type, category, autoplay, `loop`, muted, sort_order FROM signage_items ORDER BY sort_order ASC, id ASC");
$items = [];
if ($res) {
  while ($r = $res->fetch_assoc()) $items[] = $r;
}
$payload = json_encode(['items' => $items], JSON_UNESCAPED_SLASHES);
$esc = $db->real_escape_string($payload);
$nameEsc = $db->real_escape_string($name);
$db->query("INSERT INTO signage_templates (name, content) VALUES ('$nameEsc', '$esc')");
if ($db->affected_rows > 0) echo "Inserted template: $name\n"; else echo "Insert failed: " . $db->error . "\n";
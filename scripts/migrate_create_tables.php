<?php
// scripts/migrate_create_tables.php
// Usage: php scripts/migrate_create_tables.php

// Load existing DB connection config (sets $conn)
require __DIR__ . '/../php/db_connect.php';

$sqlFile = __DIR__ . '/../php/create_tables.sql';
if (!file_exists($sqlFile)) {
    fwrite(STDERR, "SQL file not found: $sqlFile\n");
    exit(1);
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    fwrite(STDERR, "Failed to read SQL file: $sqlFile\n");
    exit(1);
}

echo "Running SQL from: $sqlFile\n";

// Enable multiple statement execution
if ($conn->multi_query($sql)) {
    // Flush all results
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());

    echo "Migration completed successfully.\n";
    exit(0);
} else {
    fwrite(STDERR, "Migration failed: (" . $conn->errno . ") " . $conn->error . "\n");
    exit(1);
}

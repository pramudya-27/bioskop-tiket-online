<?php
include "config/crud.php";
$proses = new proses();

// Check existing
$count = $proses->con->query("SELECT COUNT(*) FROM pemesan WHERE id_member = '3'")->fetchColumn();
echo "Found $count orphaned orders for ID 3.\n";

if ($count > 0) {
    // Update
    $stmt = $proses->con->prepare("UPDATE pemesan SET id_member = '12' WHERE id_member = '3'");
    $stmt->execute();
    echo "Updated " . $stmt->rowCount() . " rows.\n";
} else {
    echo "No rows to update.\n";
}
?>

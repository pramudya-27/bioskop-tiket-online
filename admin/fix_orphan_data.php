<?php
include "config/crud.php";
$proses = new proses();

// Update orphaned orders (ID 3) to current valid user (ID 12 - daimyo)
$update = $proses->con->query("UPDATE pemesan SET id_member = '12' WHERE id_member = '3'");

if ($update) {
    echo "Successfully updated orders. Refresh the page.";
} else {
    echo "Update failed.";
}
?>

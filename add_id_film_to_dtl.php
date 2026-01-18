<?php
include 'config/crud.php';

try {
    $sql = "ALTER TABLE dtl_pemesan ADD COLUMN id_film INT NOT NULL AFTER id_dtl_pemesan";
    $proses->con->exec($sql);
    echo "Column id_film added successfully to dtl_pemesan table.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php
include 'config/crud.php';

try {
    // Add tgl_tayang column to dtl_pemesan table
    $sql = "ALTER TABLE dtl_pemesan ADD COLUMN tgl_tayang DATE AFTER id_pemesan";
    $proses->con->exec($sql);
    echo "Column tgl_tayang added successfully.";
} catch (PDOException $e) {
    if ($e->getCode() == '42S21') {
        echo "Column tgl_tayang already exists.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>

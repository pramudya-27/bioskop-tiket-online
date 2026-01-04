<?php
include 'config/crud.php';

try {
    // Add id_sesi column to dtl_pemesan table
    // It should be varchar or int depending on sesi table. usually int.
    // Based on bioskop.sql, id_sesi in sesi is int.
    $sql = "ALTER TABLE dtl_pemesan ADD COLUMN id_sesi INT AFTER tgl_tayang";
    $proses->con->exec($sql);
    echo "Column id_sesi added successfully.";
} catch (PDOException $e) {
    if ($e->getCode() == '42S21') {
        echo "Column id_sesi already exists.";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>

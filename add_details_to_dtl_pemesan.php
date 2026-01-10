<?php
include 'config/crud.php';

try {
    $sql = "ALTER TABLE dtl_pemesan 
            ADD COLUMN tgl_tayang DATE NOT NULL AFTER id_pemesan,
            ADD COLUMN id_sesi VARCHAR(10) NOT NULL AFTER tgl_tayang";
            
    $proses->con->exec($sql);
    echo "Columns tgl_tayang and id_sesi added successfully to dtl_pemesan table.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

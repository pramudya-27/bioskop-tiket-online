<?php
// Ensure no output before JSON
ob_start();

// Disable display errors to prevent HTML injection in JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$logFile = '../debug_seats.log';

try {
    include '../config/crud.php';

    if (!isset($proses)) {
        throw new Exception("Database connection failed.");
    }

    $id_tiket = isset($_POST['id_tiket']) ? $_POST['id_tiket'] : '';
    $tgl_tayang = isset($_POST['tgl_tayang']) ? $_POST['tgl_tayang'] : '';
    $id_sesi = isset($_POST['id_sesi']) ? $_POST['id_sesi'] : '';

    $logEntry = date('Y-m-d H:i:s') . " REQ: id_tiket=$id_tiket, tgl_tayang=$tgl_tayang, id_sesi=$id_sesi \n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);

    $occupied_seats = [];

    if (!empty($id_tiket) && !empty($tgl_tayang) && !empty($id_sesi)) {
        $id_tiket = addslashes($id_tiket);
        $tgl_tayang = addslashes($tgl_tayang);
        $id_sesi = addslashes($id_sesi);

        $sql = "SELECT kursi FROM dtl_pemesan 
                WHERE id_tiket = '$id_tiket' 
                AND tgl_tayang = '$tgl_tayang' 
                AND id_sesi = '$id_sesi'
                ORDER BY kursi ASC";
        
        file_put_contents($logFile, "SQL: $sql \n", FILE_APPEND);

        $result = $proses->con->query($sql);
        
        if ($result) {
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $occupied_seats[] = (int)$row['kursi'];
            }
        } 
    }

    file_put_contents($logFile, "RES: " . json_encode($occupied_seats) . "\n", FILE_APPEND);

    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($occupied_seats);

} catch (Throwable $e) {
    file_put_contents($logFile, "ERR: " . $e->getMessage() . "\n", FILE_APPEND);
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>

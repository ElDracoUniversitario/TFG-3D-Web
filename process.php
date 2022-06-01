<?php
require_once('config.php');
 
$offset = $_POST['offset'];
$batch = $_POST['batch'];
 
$result = $connexion->query(
    'SELECT * FROM ejecucion'
);
if ($result->num_rows > 0) {
    while ($row_comments = $result->fetch_assoc()) {
        //proceso
        $update_comment = "UPDATE comments SET approved = 1 WHERE comment_id = ".$row_comments['comment_id'];
        $connexion->query($update_comment);
 
        $update_process = 'UPDATE process SET executed = executed + 1 WHERE id_process = 1';
        $connexion->query($update_process);
        //sleep(3);
    }
 
    $result_process = $connexion->query('SELECT * FROM process WHERE id_process = 1');
    $row_process = $result_process->fetch_assoc();
 
    $percentage = round(($row_process['executed'] * 100) / $row_process['total'], 2);
 
    $date_add = new DateTime($row_process['date_add']);
    $date_upd = new DateTime($row_process['date_upd']);
    $diff = $date_add->diff($date_upd);
 
    $execute_time = '';
 
    if ($diff->days > 0) {
        $execute_time .= $diff->days.' dias';
    }
    if ($diff->h > 0) {
        $execute_time .= ' '.$diff->h.' horas';
    }
    if ($diff->i > 0) {
        $execute_time .= ' '.$diff->i.' minutos';
    }
 
    if ($diff->s > 1) {
        $execute_time .= ' '.$diff->s.' segundos';
    } else {
        $execute_time .= ' 1 segundo';
    }
 
    $update_process = 'UPDATE process SET percentage = '.$percentage.', execute_time = "'.(string)$execute_time.'" WHERE id_process = 1';
    $connexion->query($update_process);
 
    $row = array(
        'executed' => $row_process['executed'],
        'total' => $row_process['total'],
        'percentage' => round($percentage, 0),
        'execute_time' => $execute_time
    );
    die(json_encode($row));
}
?>

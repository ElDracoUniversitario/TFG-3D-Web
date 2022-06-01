<?php 
require('config.php');
$result = $connexion->query('SELECT total FROM ejecucion');
$row = $result->fetch_assoc();
$total = $row['total'];
 
//$update_process = 'UPDATE process SET total = '.$num_total_rows.', percentage = 0, executed = 0, execute_time = "", date_add = now() WHERE id_process = 1';
//$connexion->query($update_process);
?>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script type="text/javascript">
function executeProcess(offset, batch = false) {
    if (batch == false) {
        batch = parseInt($('#batch').val());
    } else {
        batch = parseInt(batch);
    }
 
    if (offset == 0) {
        $('#start_form').hide();
        $('#sending').show();
        $('#sended').text(0);
        $('#total').text($('#total_comments').val());
 
        //reset progress bar
        $('.progress-bar').css('width', '0%');
        $('.progress-bar').text('0%');
        $('.progress-bar').attr('data-progress', '0');
    }
 
    $.ajax({ 
        type: 'POST',
        dataType: "json",
        url : "process.php", 
        data: {
            id_process: 1,
            offset: offset,
            batch: batch
        },
        success: function(response) {
            $('.progress-bar').css('width', response.percentage+'%');
            $('.progress-bar').text(response.percentage+'%');
            $('.progress-bar').attr('data-progress', response.percentage);
 
            $('#done').text(response.executed);
            //$('.execute-time').text(response.execute_time);
 
            if (response.percentage == 100) {
                $('.end-process').show();
            } else {
                var newOffset = offset + batch;
 
                executeProcess(newOffset, batch);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (textStatus == 'parsererror') {
                textStatus = 'Technical error: Unexpected response returned by server. Sending stopped.';
            }
            alert(textStatus);
       }
    });
}
</script>
</head>
<body onload="executeProcess(0)">
<div id="sending" class="col-lg-12" style="display:none;">
    <h3>Procesando...</h3>
    <div class="progress">
        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" data-progress="0" style="width: 0%;">
            0%
        </div>
    </div>
    <div class="counter-sending">
        (<span id="done">0</span>/<span id="total">0</span>)
    </div>
 
    <div class="execute-time-content">
        Tiempo transcurrido: <span class="execute-time">0 segundos</span>
    </div>
 
    <div class="end-process" style="display:none;">
        <div class="alert alert-success">El proceso ha sido completado. <a href="https://www.jose-aguilar.com/scripts/jquery/ajax-progress-bar/">Probar otra vez</a></div>
    </div>    
</div>
</div>

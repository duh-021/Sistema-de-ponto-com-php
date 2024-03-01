<?php include_once("conexao.php");?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link rel="stylesheet" href="css/puxa_grade.css">
    <header>
            <a href="inicio.php"><img class="logo" src="img/logo-compo3.png"></img></a>
        </header>
</head>
<body>
<style>body{font-family:'Roboto';}</style>
<?php
$row_funcionarios = null;

// Verifica se o ID do usuário foi passado na URL
if (isset($_GET['id'])) {
    $id_usuario_clicado = $_GET['id'];

    include_once("conexao.php");

    $query_usuario = "SELECT id, nome, empresa FROM usuario WHERE id = ?";
    $stmt_usuario = $conecta_db->prepare($query_usuario);
    $stmt_usuario->bind_param('i', $id_usuario_clicado);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();

    if ($result_usuario->num_rows > 0) {
        $row_usuario = $result_usuario->fetch_assoc();
    } else {
        echo "Não encontrou o usuário.";
    }
} else {
    echo "ID não foi passado na URL.";
}

echo"<div class='info'><a href='tela-inicial-ponto.php'><input class='voltar' value='⭠' type='submit'></input><a><img class='user' src='http://localhost/ponto/img/user.png'>";
echo "<h1 class='nome'>".$row_usuario["nome"]."</h1>";
echo "<h3 class='empresa'>".$row_usuario["empresa"]."</h3>";
echo "<h3 class='nr'>Nr: ".$row_usuario["id"]."</h3></div>";


?>
<div class="filtrar">
<form method="GET" action="">
    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
    <label  for="mes"><h3 class="filtro">Referente ao Mes:</h3></label>
    <select class="filtro2" name="mes" id="mes">
        <?php
        $mes_filtrado = isset($_GET['mes']) ? $_GET['mes'] : ''; // Obter o valor do parâmetro 'mes' da URL
        $meses = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Março',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Setembro',
            '10' => 'Outubro',
            '11' => 'Novembro',
            '12' => 'Dezembro'
        );

        $mes_atual = date('m'); // Obter o número do mês atual

        foreach ($meses as $numero_mes => $nome_mes) {
            $selected = ($numero_mes == $mes_filtrado || $numero_mes == $mes_atual) ? 'selected' : ''; // Verifica se o mês atual é igual ao mês filtrado ou é o mês atual
            echo "<option value='$numero_mes' $selected>$nome_mes</option>";
        }
        ?>
    </select>
    <button class='botaofiltro' type="submit">Filtrar</button>
</form>
    </div>

<?php

$row_usuario = null;

if (isset($_GET['id'])) {
    $id_usuario_clicado = $_GET['id'];

    include_once("conexao.php");

    $query_usuario = "SELECT id, nome, empresa FROM usuario WHERE id = ?";
    $stmt_usuario = $conecta_db->prepare($query_usuario);
    $stmt_usuario->bind_param('i', $id_usuario_clicado);
    $stmt_usuario->execute();
    $result_usuario = $stmt_usuario->get_result();

    if ($result_usuario->num_rows > 0) {
        $row_usuario = $result_usuario->fetch_assoc();
    } else {
        echo "Não encontrou o usuário.";
    }

    $pega_dado = "SELECT * FROM ponto WHERE usuario_id = ?";
    
    // Verifica se o filtro por mês foi aplicado
    if (isset($_GET['mes'])) {
        $mes_filtrado = $_GET['mes'];
        $pega_dado .= " AND MONTH(data_entrada) = ?";
        $stmt_ponto = $conecta_db->prepare($pega_dado);
        $stmt_ponto->bind_param('is', $id_usuario_clicado, $mes_filtrado);
    } else {
        $stmt_ponto = $conecta_db->prepare($pega_dado);
        $stmt_ponto->bind_param('i', $id_usuario_clicado);
    }
    
    $stmt_ponto->execute();
    $result_ponto = $stmt_ponto->get_result();

    // Inicializa a variável que irá acumular o total de horas trabalhadas no mês
    $total_mes= 0;
    $extraTotal=0;
    $total_extra = 0;
    $totalextra=0;
    $totalAtraso = 0; 
    $somaextram=0;
    $somaextran=0;
    $somaAtrasom=0;
    $somaAtrason=0;
    $totalAtrasohr=0;
    $vazio="00:00:00";
    $sabadou ="";
    $fim_semana = 0;
    $extra_noturna = 101;
    $extra_noturna_seconds = 0;
    $hrsaida_noite =0;
    $saida_noite =0;
    $calcula = 0;
    $fim_semana_total =0;
    $na = 'n/a';
    $soma_extra_noturna = 0;
    $fim_semana_seconds = 0;
    $extraNoite = 0;
    $totalHorasExtras_seconds=0;
    while ($row_ponto = $result_ponto->fetch_assoc()) {
        
        
        setlocale(LC_TIME, 'pt_br.utf-8');
        $data_formatada = strftime("%a %d %b ", strtotime($row_ponto['data_entrada']));
        $data_formatada2 = date("d/m/Y", strtotime($row_ponto['data_entrada']));
        
        // Calcular o tempo de trabalho entre a entrada e a saída para o intervalo
        $entrada = strtotime($row_ponto['entrada']);
        $saida_intervalo = strtotime($row_ponto['saida_intervalo']);
        $tempo_intervalo = $saida_intervalo - $entrada;
    
        // Calcular o tempo de trabalho entre o retorno do intervalo e a saída
        $retorno_intervalo = strtotime($row_ponto['retorno_intervalo']);
        $saida = strtotime($row_ponto['saida']);
        $tempo_retorno = $saida - $retorno_intervalo;
    
        // Calcular a quantidade total de horas trabalhadas no dia
        
        $total_horas_trabalhadas = ($tempo_intervalo + $tempo_retorno) / 3600; // Convertendo segundos para horas
        $row_ponto['data_entrada'] = date("y/m/d");
        // Se for vazio ou null mostre n/a e deixe o dia 00
        if(( $row_ponto['saida_intervalo'] == "") or ( $row_ponto['saida_intervalo'] == null)){
            $row_ponto['saida_intervalo'] = "N/a";
            $tempo_intervalo = 0;
        }
        if(( $row_ponto['retorno_intervalo'] == "") or ( $row_ponto['retorno_intervalo'] == null)){
            $row_ponto['retorno_intervalo'] = "N/a";

        }
        if(( $row_ponto['saida'] == "") or ( $row_ponto['saida'] == null)){
            $row_ponto['saida'] = "N/a";
            $total_horas_trabalhadas = 0;
            $tempo_retorno = 0;

            
        }
    
        // Adicione o total de horas trabalhadas de cada dia à variável $total_mes

        if ($total_horas_trabalhadas > 0) {
            $total_mes += $total_horas_trabalhadas;
        }

///////////////////////////////////////////
        if ($row_ponto['saida_intervalo'] == '03:00:00') {
            $row_ponto['saida_intervalo'] = 'Sem regst.';
            $tempo_intervalo = 0;
            $tempo_retorno = 0;
            $total_horas_trabalhadas = 0;
            
        }
        if ($row_ponto['retorno_intervalo'] == '03:00:00') {
            $row_ponto['retorno_intervalo'] = 'Sem regst.';
            $tempo_intervalo = 0;
            $tempo_retorno = 0;
            $total_horas_trabalhadas = 0;
        }
        if ($row_ponto['saida'] == '03:00:00') {
            $row_ponto['saida'] = 'Sem regst.';
            $tempo_intervalo = 0;
            $tempo_retorno = 0;
            $total_horas_trabalhadas = 0;
        }
       
        //atraso entrada
        if ($row_ponto['entrada'] > '08:10:00') {
            $entrada = strtotime('08:10:00'); 
            $hrentrada = strtotime($row_ponto['entrada']); 

            if ($hrentrada > $entrada) {
               
                $atrasoManha = $hrentrada- $entrada ;
               
                $atrasoManha = gmdate("H:i:s", $atrasoManha);
            } else {
                $atrasoManha = '00:00:00'; 
            }
        } else {
            $atrasoManha = '00:00:00'; // Se a entrada for depois das 8h, não há hora extra
        }
        //atrasos sextas e saida dias da semana
        if (strpos($data_formatada, 'sex') !== false || $row_ponto['saida'] < '17:00:00') {
           
            $saidahr = strtotime('17:00:00'); 
            $hrsaida = strtotime($row_ponto['saida']); 

            if ($hrsaida < $saidahr) {
               
                $atrasoSaida = $saidahr - $hrsaida;
               
                $atrasoSaida = gmdate("H:i:s", $atrasoSaida);

            } else {
                $atrasoSaida = '00:00:00';
            }
        }elseif ($row_ponto['saida'] < '18:00:00') {
            $saidahr = strtotime('18:00:00'); 
            $hrsaida = strtotime($row_ponto['saida']); 

            if ($hrsaida < $saidahr) {
               
                $atrasoSaida = $saidahr - $hrsaida;
               
                $atrasoSaida = gmdate("H:i:s", $atrasoSaida);
            } else {
                $atrasoSaida = '00:00:00'; 
            }
        } else {
            $atrasoSaida = '00:00:00'; 
        }

////////////////////calcula final de semana

$fim_semana='00:00';

if (strpos($data_formatada,'sáb') !== false || strpos($data_formatada,'dom') !== false) {
    $fim_semana = ($tempo_intervalo + $tempo_retorno);
    if ($fim_semana > 0){
        $fim_semana_total += $fim_semana;
        $fim_semana = $fim_semana_total;
        $atrasoTotal = '00:00:00';
        $atrasoManha = '00:00:00';
        $atrasoSaida = '00:00:00';
        $extraTotal = '00:00:00';
        $extraManha = '00:00:00';
        $extraNoite = '00:00:00';
       
    }else{
        $fim_semana='00:00';
    }
}else{
    $fim_semana='00:00';
}

////////////////////


////////////////////////////////////SOMA ATRASO////////////////////////////////////
//SOMA ATRASO dia
$atrasoTotal = 0;

$atrasoManha_seconds = strtotime($atrasoManha) - strtotime('00:00:00');
$atrasoNoite_seconds = strtotime($atrasoSaida) - strtotime('00:00:00');

$atrasoTotalmes_seconds = $atrasoManha_seconds + $atrasoNoite_seconds;

$atrasoTotal = gmdate("H:i:s", $atrasoTotalmes_seconds);

// Incremento do total de atrasos
if ($atrasoManha_seconds > 0 || $atrasoNoite_seconds > 0) {
    $totalAtrasoMes_secunds = $atrasoManha_seconds + $atrasoNoite_seconds;
    $totalAtraso += $totalAtrasoMes_secunds;
}

if ($row_ponto['saida'] > '18:10:00') {
    $saida = strtotime('18:10:00');
    $hrsaida = strtotime($row_ponto['saida']);

    if ($hrsaida > $saida || $row_ponto['saida'] < '22:00:00') {

        $extraNoite = $hrsaida - $saida;
        $extraNoite = gmdate("H:i:s", $extraNoite);
    } else {
        $extraNoite = '00:00:00';
    }
    if($extraNoite > '04:00:00'){
        $extraNoite = '04:00:00';
    }
    }elseif(strpos($data_formatada, 'sex') !== false) {
        $saida = strtotime('17:10:00');
        $hrsaida = strtotime($row_ponto['saida']);
        
        if ($hrsaida > $saida) {
            $extraNoite = $hrsaida - $saida;
            $extraNoite = gmdate("H:i:s", $extraNoite);
        }
    }

        if ($row_ponto['entrada'] < '08:00:00'){
            $entrada = strtotime('08:00:00'); 
            $hrentrada = strtotime($row_ponto['entrada']); 
            
            if ($hrentrada < $entrada) {
               
                $extraManha = $entrada - $hrentrada;
              
                $extraManha = gmdate("H:i:s", $extraManha);
            } else {
                $extraManha = '00:00:00'; 
            }
        } else {
            $extraManha = '00:00:00'; 
        }
      
            if ($row_ponto['saida'] > '22:10:00'){
                
            $saida_noite = strtotime('22:10:00');
            $hrsaida_noite = strtotime($row_ponto['saida']);

            $extra_noturna = $hrsaida_noite - $saida_noite;

            $extra_noturna_seconds = $extra_noturna;
            $extra_noturna = gmdate("H:i:s", $extra_noturna);

            }else{
                $extra_noturna = '00:00:00';
            }

        if ($extra_noturna_seconds > 0){
            $soma_extra_noturna += $extra_noturna_seconds;
            $extra_noturna_seconds = $soma_extra_noturna;
        }
        


//calcula hora extra noturna
        
        
$extraManha_seconds = strtotime($extraManha) - strtotime('00:00:00');
$extraNoite_seconds = strtotime($extraNoite) - strtotime('00:00:00');
$extraTotal_seconds = strtotime($extraTotal) - strtotime('00:00:00');

$total_seconds = $extraManha_seconds + $extraNoite_seconds;

$extraTotal = gmdate("H:i:s", $total_seconds);

if ($extraManha_seconds > 0 || $extraNoite_seconds > 0) {
    // Adiciona as horas extras ao total de horas extras
    $totalHorasExtras_seconds = $extraTotal_seconds;
    $totalHorasExtras_seconds += $total_seconds ;

    // Converte o total de segundos em horas
    $totalHorasExtras = $totalHorasExtras_seconds;

    // Armazena o total de horas extras trabalhadas
    $horasExtrasTrabalhadas = $totalHorasExtras;

    // Arredonda o total de horas extras acumuladas para duas casas decimais
    $total_extra = round($total_extra + $horasExtrasTrabalhadas, 2);

}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//extra periodo manha
if ($extraManha_seconds > 0) {
    // Adiciona as horas extras ao total de horas extras

    $somaextram += $extraManha_seconds;
    $extraManha_seconds = $somaextram;
    
}
//extra periodo noite
if ($extraNoite_seconds > 0) {
    // Adiciona as horas extras ao total de horas extras

    $somaextran += $extraNoite_seconds;
    $extraNoite_seconds = $somaextran;
    
}

if ($totalHorasExtras_seconds > 0){
    $calcula = $extraManha_seconds + $extraNoite_seconds;
 
}

//atraso periodo manha
if ($atrasoManha_seconds > 0){

    $somaAtrasom += $atrasoManha_seconds;
    $atrasoManha_seconds = $somaAtrasom; 
}


//atraso periodo noite

if ($atrasoNoite_seconds > 0){
    $somaAtrason += $atrasoNoite_seconds;
    $atrasoNoite_seconds = $somaAtrason;
}



if(( $row_ponto['saida'] == "") or ( $row_ponto['saida'] == "N/a")){
    $na= "N/a ";
    $atrasoTotal = $na;
    $atrasoSaida = $na;
    $somaAtrason = 00;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$totalAtrasohr = $totalAtraso / 3600;

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 /*
 
 $data_formatada2 /data de entrada
 
 entradas do dia
 $row_ponto['entrada']/horario de entrada
 $row_ponto['saida_intervalo'] /horario de saida intervalo
 $row_ponto['retorno_intervalo'] /horario de retorno intervalo
 $row_ponto['saida'] /horario de saida 

 carga de trablhos periodo do dia
 date('H:i', $tempo_intervalo) /periodo manha
 date('H:i', $tempo_retorno) /periodo tarde
 
 tempo atrasos do dia
 $atrasoManha /atraso periodo manha
 $atrasoSaida /atraso periodo noite

 horas extra do dia
 $extraManha
 $extraNoite 
 $extraTotal /extra total do dia
 
 horas trabalhadas do dia
 number_format($total_horas_trabalhadas, 2)/ horas total trabalhada no dia
 
 total horas trabalhadas no mes
 number_format($total_mes, 2)
 $data_formatada dia por escrito

 total extra do mes 
 gmdate("H:i:s", $totalHorasExtras_seconds)
 */

 

 /* Arrumar calculo de extra noite */



        echo "<div class='conteiner'>";
        echo "<h4 class='data'>".$data_formatada2."</h3>";
        echo "<img src='img/data.png' class='imgdata'>";
        echo "<h3 class='totaldia'>‎‎Total do dia:</h3><h3 class='hrttdia'> " . number_format($total_horas_trabalhadas, 2, ':', '') . "h</h3>";
        echo "<hr class='hrinicial'>";

        echo "<img src='img/relogio.png' class='relogioic'><h3 class='registros'>Registros</h3><h3 class='entrada'>Entrada 1</h3>";
        echo "<h4 class='hrentrada'>" . $row_ponto['entrada'] . " h</h4>";
        echo "<h3 class='saida'>Saída 1</h3>";
        echo "<h4 class='hrsaida'>" . $row_ponto['saida_intervalo'] . " h</h3>";

        echo "<h3 class='manha'>Carga horaria periodo manhã: " . date('H:i', $tempo_intervalo) . "h</h3>";
        
        echo "<h3 class='entrada2'>Entrada 2</h3>";
        echo "<h4 class='hrretorno'>" . $row_ponto['retorno_intervalo'] . " h</h3>";

        echo "<h3 class='saida2'>Saída 2</h3>";
        echo "<h4 class='hrsaida2'>" . $row_ponto['saida'] . " h</h3>";
        echo "<h3 class='tarde'>Carga horaria periodo tarde: " . date('H:i', $tempo_retorno) . "h</h3>";
        
        echo "<img src='img/mais.png' class='mais'><h3 class='calculo'>Calculo de horas</h3>";
        echo "<img src='img/atrasado.png' class='atraso'><h3 class='atrasoTT'>" . $atrasoTotal  . " h</h3><h3 class='atrasototal'>Atraso Total</h3>"; //$atrasoTotal
        echo "<img src='img/sol.png' class='atrasomanhasol'><h3 class='atrasomanha'>". $atrasoManha ."</h3>";
        echo "<img src='img/lua.png' class='atrasotardelua'><h3 class='atrasotarde'>".  $atrasoSaida ."</h3>";

        echo "<img src='img/relogioextra.png' class='iconextra'><h3 class='extraT'>" . $extraTotal . " h</h3><h3 class='hrextra'>Hora Extra</h3>";
        echo "<img src='img/sol.png' class='extramanhasol'><h3 class='extramanhaa'>". $extraManha ."</h3>";
        echo "<img src='img/lua.png' class='extratardelua'><h3 class='extratarde'>". $extraNoite ."</h3>";
        
        echo "<hr class='divide_calculo'>";
        
        echo "<h3 class='dataft'>" . $data_formatada . "</h3><hr class='hrfinal'>";
        echo "</div>";
        
    }

    }else{       
        echo "ID não foi passado na URL.";
}
//extra, atraso e extra total do mes 

echo "<div class='conteiner3'><img src='img/dash.png' class='dash'><h3 class='titulo'>Relatorio de Horas</h3><h3 class='subtitulo'>Horas trabalhadas e Atrasos</h3><img class='relogioimg1' src='img/relogio.png'><h3 class='totalhr'>".number_format($total_mes, 2)." h</h3><h3 class='totalmes'>Horas no mes</h3><h3 class='totalmessub'>Total horas trabalhadas no mes</h3>";
echo "<img src='img/atrasado.png' class='atrasado' ><h3 class='totalhrAT'>". gmdate("H:i:s", $totalAtraso)." h</h3><h3 class='atrasotitulo'>Horas de atraso</h3><h3 class='atrasotitulosub'>Total de horas Atrasdas no mes</h3>";
echo "<img class='sol' src='img/sol.png'><h3 class='tatmanha'>".gmdate("H:i:s", $somaAtrasom)."</h3><h3 class='tatmanhasub'>Atraso Manhã</h3>";
echo "<img class='lua' src='img/lua.png'><h3 class='tattarde'>".gmdate("H:i:s", $somaAtrason)."</h3><h3 class='tattardesub'>Atraso Tarde</h3>";
//grafico
 

$total_extrahrr=0;

$total_extrahr = $total_extrahrr  / 3600;

$fim_semana_total /3600;

echo "
<html>
<head>
<script src='js/chart.js'></script>

</head>
<body>
    <style>
        canvas{
            height: 10px;

        }
        .grafico1{
            
            height: 200px;
            width: 200px;

            margin-left: 430px;
            margin-top: -290px;
            
        }

    </style>

    <div class='grafico1'>
        
        <canvas id='myChart'></canvas>
    </div>
    <script>

        var ctx = document.getElementById('myChart').getContext('2d');

        var total_mes = ".number_format($total_mes,2).";
        var totalAtraso = ".number_format($totalAtrasohr, 2).";
        var horaextra =". ($calcula) / 3600 .";
        var noturno = ". gmdate("H",$extra_noturna_seconds) .";//criar função
        var extrafim = ". $fim_semana_total /3600 .";//criar função
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    label:'',
                    data: [total_mes, totalAtraso,horaextra,noturno , extrafim ],
                    backgroundColor: [
                        'rgb(0, 255, 145)', //horas trabalhadas
                        'rgb(255, 153, 0)',//horas atrasadas
                         'rgb(155, 253, 0)',
                         'rgb(158, 0, 172)','rgb(0, 9, 185)'//hr extra 
                    ],
                    borderColor: [
                        'rgb(0, 183, 104)',//horas trabalhadas
                        'rgb(199, 119, 0)',//horas atrasadas
                        'rgb(55, 203, 0)',
                        'rgb(158, 0, 172)','rgb(0, 9, 185)'
                    ],
                    borderWidth: 1.5,
                    
                }]
            },
            options: {
                scales: {
                
                }
            }
        });

    </script>
</body>
</html>

";


echo "<div class='verde'></div><h3 class='hrm'>Horas no Mes</h3>";
echo "<div class='laranja'></div><h3 class='hrmt'>Horas atraso</h3>";
echo "<div class='verdeclaro'></div><h3 class='hrex'>Horas Extra</h3>";
echo "<div class='roxo'></div><h3 class='hrexn'>Extra Noturnas</h3>";
echo "<div class='azul'></div><h3 class='hrexf'>Extra Finais de semana</h3>";
//grafico

echo "<hr class='divisao'>";



echo "<h3 class='titulo2'>Relatorio de Horas Extra</h3>";
echo "<img src='img/relogioextra.png' class='relogiomais'><h3 class='totalhrEX'>". gmdate("H:i:s", $calcula)." h</h3><h3 class='horaextran'>Horas Extra Normal</h3><h3 class='horaextransub'>Total de horas Extra no mes</h3>";
//extra total mes periodos 
echo "<img src='img/sol.png' class='sol2'><h3 class='texmanha'>".gmdate("H:i:s", $somaextram )."</h3><h3 class='extramanha'>Extra Manhã</h3>";
echo "<img src='img/lua.png' class='lua2'><h3  class='texnoite'>".gmdate("H:i:s",$somaextran )."</h3><h3 class='extranoite'>Extra Tarde</h3>";
//atraso total mes periodos
echo "<h3 class='subhrx'>Total de horas Extra por periodos</h3>";

echo "<img src='img/relogiolua.png' class='relogiolua'><h3 class='exmanha'>".gmdate("H:i:s",$extra_noturna_seconds)."</h3><h3 class='extranoturno'>Extra Noturna</h3>";
echo "<img src='img/fimsemana.png' class='fimsemana'><h3  class='exnoite'>". gmdate("H:i:s",$fim_semana_total) ." h</h3><h3 class='extrafim'>Finais de semana</h3></div>";

?>

<div class="verifica">
<input class="sim" type="checkbox"><h3 class="concordo">Minha grade de horas está correta.</h3></input><input class="nao" type="checkbox"><h3 class="descordo">Houve um problema com minha grade.</h3></input>
<h6 class="dev">Developer By CompoSystem</h6>
</div>
</body>
</html>
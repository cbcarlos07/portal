<?php

$user = $_GET['user'];

?>
<html>
    <head>
        <title>PORTAL DE CHAMADOS DTI</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta HTTP-EQUIV="refresh" CONTENT="30"> 
        <link rel="stylesheet" type="text/css" href="../../public/css/situacao.css">
        <link rel="shortcut icon" href="public/img/ham.ico">  
        
        
        
        
    </head>
   
    <body>
    
    <div id="tablelist" >

        <table>
                        <tr id="title">
                            <td colspan="9" align="center" bgcolor="#a4cbf6" >Serviços Recebidos Por Usu&aacute;rio - <font color="blue"><?php echo $user;?> </font> </td>
                        </tr>
                        <tr id="titulo">

                            <td>Item</td><td>Oficina</td><td>C&oacute;digo</td><td>Setor</td><td>Descri&ccedil;&atilde;o do Servi&ccedil;o</td>
                            <td>Solicitante</td><td>Data da Solcita&ccedil;&atilde;o</td><td>Status</td>
                        </tr>
                        <?php
                        require '../controller/OS_Controller.class.php';
                        require_once '../services/OSListIterator.class.php';
                        $osc = new OS_Controller();
                        $rs = $osc->ordem_Por_usuario($user);
                        $osList = new OSListIterator($rs);
                        $os = new Ordem_Servico();
                        $i = 0;
                                while($osList->hasNextOs()){
                                    $i++;

                                    $os = $osList->getNextOs();
                                   if($i % 2 == 0){
                                       $par = "#d5e6ef";
                                   }else{
                                       $par = "#ffffff";
                                   }
                                   
                                                switch ($os->getStatus()){
                                                           case 'ABERTA':
                                                                    $status = "#ffcc99";
                                                                    $cor = "#fff";
                                                                    $par = $status;
                                                               break;
                                                           case 'CONCLUIDA':
                                                                    $status = "#f1ff0b";
                                                                    $cor = "#000";
                                                                    
                                                               break;
                                                           case 'PROJETOS FUTUROS':
                                                                    $status = "#99cc00";
                                                                    $cor = "#000";
                                                                    $par = $status;
                                                               
                                                               break;

                                                       }

                                    echo "<tr height=20px bgcolor=$par id=fundoc".$i." class=corpo >";
                                    #echo "<td align=center><a href='#'><img id=$i src=public/img/salcir.png width=29 height=29 onclick=mudaImagem();></a></td>";

                                    echo "<td align=center> ".$i." </td>";
                                    echo "<td>".$os->getOficina()."</td>";
                                    echo "<td bgcolor=#ccffcc>".$os->getCodigo()."</td>";
                                    echo "<td bgcolor=#ffcc99>".$os->getSetor()."</td>";
                                    echo "<td>".$os->getDescricao()."</td>";
                                    echo "<td>".$os->getSolicitante()."</td>";
                                    echo "<td>".$os->getData()."</td>";
                                    echo "<td>".$os->getStatus()."</td>";
                                    echo "</tr>";


                                }

                        ?>

        </table>
</div>
           
    </body>   
</html>

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
    
    <?php 
            require '../controller/OS_Controller.class.php';
            require_once '../services/OSListIterator.class.php';
            $osc = new OS_Controller();
            $total = $osc->getServico_Aguardando_Count();
            if($total > 0){
                    
    ?>
        <div class="container">
                        <div id="tabela2" >


                            <table width="100%">
                                            <tr id="title">
                                                 <td colspan="9" align="center" bgcolor="#a4cbf6" >Serviços Solicitados</td>
                                            </tr>
                                            <tr id="titulo">

                                                <td>Item</td><td>C&oacute;digo</td><td>Solicitante</td><td>Setor</td><td>Descri&ccedil;&atilde;o do Servi&ccedil;o</td>
                                                <td>Data da Solcita&ccedil;&atilde;o</td><td>Tempo Aguardando</td><td>Meta</td>
                                            </tr>
                                            <?php

                                            $osc = new OS_Controller();
                                            $rs = $osc->getServico_Aguardando();
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

                                                       //echo 'Status: '.$os->getStatus();
                                                        
                                                       switch ($os->getStatus()){
                                                           case 'vermelha':
                                                                    $status = "red";
                                                               break;
                                                           case 'amarela':
                                                                    $status = "yellow";
                                                               break;
                                                           case 'verde':
                                                                    $status = "#99cc00";
                                                               break;

                                                       }

                                                        echo "<tr height=20px bgcolor=$par id=fundoc".$i." class=corpo >";
                                                                #echo "<td align=center><a href='#'><img id=$i src=public/img/salcir.png width=29 height=29 onclick=mudaImagem();></a></td>";

                                                        echo "<td align=center> ".$os->getItem()." </td>";
                                                        echo "<td>".$os->getOficina()."</td>";
                                                        echo "<td bgcolor=#ccffcc>".$os->getCodigo()."</td>";
                                                        echo "<td bgcolor=#ffcc99>".$os->getSetor()."</td>";
                                                        echo "<td>".$os->getDescricao()."</td>";
                                                        echo "<td><a href=lista.php?user=".$os->getResponsavel()." title='Clique para visualizar todas as ordens de servi&ccedil;os'>".$os->getResponsavel()."</a></td>";
                                                        echo "<td>".$os->getData()."</td>";
                                                        echo "<td bgcolor=$status align=center><font color=$cor _color=$cor>".$os->getTempo()."</font></td> ";                                                                
                                                        echo "</tr>";


                                                    }

                                            ?>

                            </table>
                            </div>
           <?php
            }
                    else{
            ?>
                <h2>N&Atilde;O EXISTEM SERVI&Ccedil;OS AGUARDANDO</h2>
              <?php  
                        }

                ?>                                     


         </div>           
               
               
       
                            
                        
                        
                        
       
    </body>   
</html>
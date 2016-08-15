<?php
  session_start();
 if(empty($_SESSION['data1'])){
     $data1 = date('m/Y');
    
     $_SESSION['data1'] = $data1;
    
 }else if( !empty($_SESSION['data1']) && isset($_POST['data1'])){
     $data1 = $_POST['data1'];
     $_SESSION['data1'] = $data1;
 }else if(!empty($_SESSION['data1']) && !isset($_POST['data1'])){
     $data1 = $_SESSION['data1'];
     $_SESSION['data1'] = $data1;
 }
 
 if(empty($_SESSION['data2'])){
     
     $data2 = date('d/m/Y');
  
     $_SESSION['data2'] = $data2;
 }else if( !empty($_SESSION['data2']) && isset($_POST['data2'])){
     $data2 = $_POST['data2'];
      $_SESSION['data2'] = $data2;
 }else if(!empty($_SESSION['data2']) && !isset($_POST['data2'])){
     $data2 = $_SESSION['data2'];
      $_SESSION['data2'] = $data2;
 }
 
?>


<html>
    <head>
        <title>PORTAL DE CHAMADOS DTI</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta HTTP-EQUIV="refresh" CONTENT="30"> 
        <link rel="stylesheet" type="text/css" href="../../public/css/situacao.css">
        <link rel="stylesheet" href="../../public/css/bootstrap.min.css">
        <link rel="shortcut icon" href="public/img/ham.ico">  
        <script src="../../public/js/bootstrap.min.js"></script>    
        <script src="../../public/js/jquery.min.js"></script>
            
        
        
        
        
    </head>
   
    <body>
        
        <div class="container ">
             <div class="row" >
                 <div class="col-md-6 ">
                     <center>
                          <!--<div id="tabelaresp" > -->
                                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                                <table>
                                                    <tr>
                                                        <td>Data: </td><td><input name="data1" value="<?php echo $_SESSION['data1']; ?>" size="5" style="text-align: center;"> </td><td><input type="submit" name="salvar" value="Pesquisar"></td>
                                                    </tr>
                                                </table>
                                            </form>
                                                <table>
                                                                <tr id="title">
                                                                    <td colspan="9" align="center" bgcolor="#a4cbf6" >Usu&aacute;rio Respons&aacute;vel</td>
                                                                </tr>
                                                                <tr id="titulo">

                                                                    <td align="center">Respons&aacute;vel</td><td>Solicitadas</td><td>Atendidadas</td>
                                                                </tr>
                                                                <?php

                                                                require '../controller/OS_Controller.class.php';
                                                                require_once '../services/OSListIterator.class.php';

                                                                $osc = new OS_Controller();
                                                                $rs = $osc->getTI_Usuario_Resp($data1);
                                                                $osList = new OSListIterator($rs);
                                                                $os = new Ordem_Servico();
                                                                $i = 0;
                                                                $sol = 0;
                                                                $atend = 0;
                                                                        while($osList->hasNextOs()){
                                                                            $i++;

                                                                            $os = $osList->getNextOs();
                                                                           if($i % 2 == 0){
                                                                               $par = "#d5e6ef";
                                                                           }else{
                                                                               $par = "#ffffff";
                                                                           }

                                                                            echo "<tr height=20px bgcolor=$par id=fundoc".$i." class=corpo >";
                                                                            #echo "<td align=center><a href='#'><img id=$i src=public/img/salcir.png width=29 height=29 onclick=mudaImagem();></a></td>";

                                                                            //echo "<td align=center> ".$os->getItem()." </td>";
                                                                            echo "<td >".$os->getResponsavel()."</td>";
                                                                            echo "<td align=center>".$os->getSolicitadas()."</td>";
                                                                            echo "<td  align=center>".$os->getAtendidas()."</td>";
                                                                            echo "</tr>";
                                                                            $sol = $sol + $os->getSolicitadas();
                                                                            $atend = $atend + $os->getAtendidas();


                                                                        }
                                                                        echo "<tr>";
                                                                        //echo "<td></td>";
                                                                        echo "<td>TOTAL</td>";
                                                                        echo "<td align=center>$sol</td>";
                                                                        echo "<td align=center>$atend</td>";
                                                                        echo "</tr>";
                                                                ?>


                                                </table>
                           <!-- </div> <!-- fim da div tabela -->
                    </center>
                 </div>   
                <div class="col-md-6">
                    <center>
                    <!--  <div id="tabelausers">-->
                                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                                    <table>
                                                        <tr>
                                                            <td>Data: </td><td><input name="data2" value="<?php echo $_SESSION['data2']; ?>"  style="text-align: center;" size="8"></td><td><input type="submit" name="salvar" value="Pesquisar"></td>
                                                        </tr>
                                                    </table>
                                            </form>
                                              <table>
                                                            <tr id="title">
                                                                 <td colspan="9" align="center" bgcolor="#a4cbf6" >Serviços TI x Dia</td>
                                                            </tr>
                                                            <tr id="titulo">

                                                                <td>Item</td><td align="center">Respons&aacute;vel</td><td>Qtde</td>
                                                            </tr>
                                                            <?php
                                                            //require '../controller/OS_Controller.class.php';
                                                            require_once '../services/OSListIterator.class.php';
                                                            $osc = new OS_Controller();
                                                            $rs = $osc->getTI_Usuario_Dia($data2);
                                                            $osList = new OSListIterator($rs);
                                                            $os = new Ordem_Servico();
                                                            $i = 0;
                                                            $total = 0;
                                                                    while($osList->hasNextOs()){
                                                                        $i++;

                                                                        $os = $osList->getNextOs();
                                                                       if($i % 2 == 0){
                                                                           $par = "#d5e6ef";
                                                                       }else{
                                                                           $par = "#ffffff";
                                                                       }

                                                                        echo "<tr height=20px bgcolor=$par id=fundoc".$i." class=corpo >";
                                                                        #echo "<td align=center><a href='#'><img id=$i src=public/img/salcir.png width=29 height=29 onclick=mudaImagem();></a></td>";

                                                                        echo "<td align=center> ".$i." </td>";
                                                                        echo "<td>".$os->getResponsavel()."</td>";
                                                                        echo "<td align=center><a href=listauser.php?user=".$os->getResponsavel()."&data=$data2 title='Clique para visualizar as ordens de servi&ccedil;os'>".$os->getQtde()."</a></td>";                                                    
                                                                        echo "</tr>";
                                                                        $total = $total + $os->getQtde();


                                                                    }
                                                                    echo "<tr>";
                                                                    echo "<td></td>";
                                                                    echo "<td>TOTAL</td>";
                                                                    echo "<td align=center>$total</td>";                                                
                                                                    echo "</tr>";
                                                            ?>


                                            </table>
                        <!-- </div>-->
                    </center>
                </div>   
             </div>
   
         </div>                                   
       
    </body>   
</html>
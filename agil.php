<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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

            
        
        <?php
            include ('./include/head.php');    
            include ('./include/menu.php');
        ?>
        <div id="main" class="container-fluid">
            
            <div id="top" class="row">
               
            </div><!-- /#top -->
            <hr />
            <div class="row ">
                 <div class="col-md-6 search-user">
                     
                     <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                            <div class="input-group h2">
                                <input name="data1" size="5" class="form-control text-center" id="search" type="text" placeholder="Pesquisar Itens" value="<?php echo $_SESSION['data1']; ?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                      </form>
                  
                </div>
                
                            <div class="col-md-6 search-user-1">
                                 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                                            <div class="input-group h2">
                                                <input  name="data2" size="5" class="form-control text-center" id="search" type="text" placeholder="Pesquisar Itens" value="<?php echo $_SESSION['data2']; ?>">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="submit">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                    </button>
                                                </span>
                                            </div>
                                     </form>
                            </div>
                
            </div>
            <div id="list" class="row">                
                <div class="table-responsive col-md-6">
                    <table class="table table-striped table-users" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th class="text-center">Respons&aacute;vel</th>
                                <th class="text-center">Solicitadas</th>
                                <th class="text-center">Atendidas</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                                                require_once 'application/controller/OS_Controller.class.php';
                                                                require_once 'application/services/OSListIterator.class.php';

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

                                                                            echo "<tr  bgcolor=$par >";
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
                           
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive col-md-6">
                    <table class="table table-striped table-users-1" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th class="text-center">Item</th>
                                <th class="text-center">Respons&aacute;vel</th>
                                <th class="text-center">Qtde</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                                            //require '../controller/OS_Controller.class.php';
                                                            require_once 'application/services/OSListIterator.class.php';
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

                                                                        echo "<tr bgcolor=$par>";
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
                           
                        </tbody>
                    </table>
                    
                </div>
                
            </div><!-- /#list -->
            <div id="buttom" class="row">
               <!-- <div class="col-md-12">
                    <ul class="pagination">
                        <li class="disabled"><a>&lt; Anterior</a></li>
                        <li class="disabled"><a>1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li class="next"><a href="#" rel="next">Próximo &gt;</a></li>
                    </ul>
                </div>
               -->
            </div><!-- /#bottom -->
            
        </div> <!-- /#main -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

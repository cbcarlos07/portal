<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

            
        
        <?php
            session_start();
            $aberta = " AND OS.TP_SITUACAO = 'A' ";
            $todos = "   ";
           // $user = $_GET['user'];
            if(isset($_GET['user'])){
                $user = $_GET['user'];
            }else{
                $user = $_POST['user'];
            }
            $checked2 = "";
            $checked1 = "";
           
                if(isset($_GET['par'])){
                    $par = $_GET['par'];
                    
                    if($par == 1 ){
                        $_SESSION['par'] = $aberta;
                        $checked1 = 'checked';
                    }else{
                        $checked2 = 'checked';
                        $_SESSION['par'] = $todos;
                    }
                }else{
                    $_SESSION['par'] = $aberta;
                    $par = $_SESSION['par'];
                    $checked1 = 'checked';
                }
                
            
            
            
            
            $_SESSION['user'] = $user;
            $envio = $_SESSION['par'];
            
            include ('./include/head.php');    
            include ('./include/menu.php');
        ?>
        <div id="main" class="container-fluid">
            <?php 
                    require_once 'application/controller/OS_Controller.class.php';
                    require_once 'application/services/OSListIterator.class.php';
                    $osc = new OS_Controller();
                    $total = $osc->getTotalServicosRecebidos();
                    if($total > 0){
            ?>
            <div id="top" class="row">
                <div class="col-md-12">                    
                    <h2 class="text-center">Servi&ccedil;os Recebidos - <?php echo $user; ?></h2>
                </div>
            </div><!-- /#top -->
            <hr />
            <div class="row">
                <div class="col-md-6">
                    <div class="radio pull-right">
                        <label >
                           
                            <input type="radio" name="radio" <?php echo $checked1; ?>  onclick="ciente(this,1)">Abertas
                        </label>
                    </div>
                </div>  
                <div class="col-md-6">
                    <div class="radio">
                        <label>
                            <input type="radio" name="radio"   <?php echo $checked2; ?> onclick="ciente(this,2)">Todas
                        </label>
                    </div>
                </div>  
                
            </div>   
            <div id="list" class="row">
                <div class="table-responsive col-md-12">
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Ofina</th>
                                <th>C&oacute;digo</th>
                                <th>Setor</th>                                
                                <th>Descri&ccedil;&atilde;o do Servi&ccedil;o</th>
                                <th>Solicitante</th>
                                <th>Data da Solicita&ccedil;&atilde;o</th>
                                <th>Status</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        require_once 'application/controller/OS_Controller.class.php';
                        require_once 'application/services/OSListIterator.class.php';
                        $osc = new OS_Controller();
                        //echo $envio;
                       
                        $rs = $osc->ordem_Por_usuario($user, $envio);
                        $osList = new OSListIterator($rs);
                        $os = new Ordem_Servico();
                        $i = 0;
                                while($osList->hasNextOs()){
                                    $i++;

                                    $os = $osList->getNextOs();
                                  /* if($i % 2 == 0){
                                       $par = "#d5e6ef";
                                   }else{
                                       $par = "#ffffff";
                                   }
                                  */
                                    $par = '';
                                                switch ($os->getStatus()){
                                                           case 'ABERTA':
                                                                    $status = "#ffcc99";
                                                                    $cor = "#fff";
                                                                    $par = $status;
                                                                    $bold = "<b>";
                                                                    $bold1 = "</b>";
                                                               break;
                                                           case 'CONCLUIDA':
                                                                    $status = "#f1ff0b";
                                                                    $cor = "#000";
                                                                    $bold = "";
                                                                    $bold1 = "";
                                                                    
                                                               break;
                                                           case 'PROJETOS FUTUROS':
                                                                    $status = "#99cc00";
                                                                    $cor = "#000";
                                                                    $par = $status;
                                                                     $bold = "";
                                                                    $bold1 = "";
                                                               
                                                               break;

                                                       }

                                    echo "<tr >";
                                    

                                    echo "<td align=center>$bold ".$i." $bold1</td>";
                                    echo "<td> $bold".$os->getOficina()."$bold1</td>";
                                    echo "<td bgcolor=#ccffcc>$bold".$os->getCodigo()."$bold1</td>";
                                    echo "<td bgcolor=#ffcc99>$bold".$os->getSetor()."$bold1</td>";
                                    echo "<td>$bold".$os->getDescricao()." $bold1 </td>";
                                    echo "<td>$bold".$os->getSolicitante()."$bold1</td>";
                                    echo "<td>$bold".$os->getData()."$bold1</td>";
                                    echo "<td>$bold".$os->getStatus()."$bold1</td>";
                                    echo "</tr>";


                                }

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
            <?php 
                    }
                    else{
            ?>
                    <div id="top" class="row">
                        <div class="col-md-12">                    
                            <h2 class="text-center">N&atilde;o Existem Servi&ccedil;os Recedidos</h2>
                        </div>
                    </div><!-- /#top -->
            <?php
                    }
            ?>
        </div> <!-- /#main -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
                    
           function ciente(cb, cod){
               
              if(cb.checked){
                   par = "<?php echo $user; ?>";
                   window.location = "getdados.php?user="+par+"&par="+cod;
             }

            }       
                    
                  
                    
                </script>
    </body>
</html>

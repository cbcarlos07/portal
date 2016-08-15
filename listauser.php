<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

            
        
        <?php
            $user = $_GET['user'];
            $data = $_GET['data'];
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
                    <h2 class="text-center">Servi&ccedil;os Conclu&iacute;dos - <?php echo $user; ?></h2>
                </div>
            </div><!-- /#top -->
            <hr />
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
                                
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                        require_once 'application/controller/OS_Controller.class.php';
                        require_once 'application/services/OSListIterator.class.php';
                        $osc = new OS_Controller();
                        $rs = $osc->ordem_Por_usuario_Dia($user, $data);
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
                                                           case 'vermelha':
                                                                    $status = "#d52b00";
                                                                    $cor = "#fff";
                                                               break;
                                                           case 'amarela':
                                                                    $status = "#f1ff0b";
                                                                    $cor = "#000";
                                                               break;
                                                           case 'verde':
                                                                    $status = "#99cc00";
                                                                    $cor = "#000";
                                                               
                                                               break;

                                                       }

                                    echo "<tr >";
                                    #echo "<td align=center><a href='#'><img id=$i src=public/img/salcir.png width=29 height=29 onclick=mudaImagem();></a></td>";

                                    echo "<td align=center> ".$i." </td>";
                                    echo "<td>".$os->getOficina()."</td>";
                                    echo "<td bgcolor=#ccffcc>".$os->getCodigo()."</td>";
                                    echo "<td bgcolor=#ffcc99>".$os->getSetor()."</td>";
                                    echo "<td>".$os->getDescricao()."</td>";
                                    echo "<td>".$os->getSolicitante()."</td>";
                                    echo "<td>".$os->getData()."</td>";
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
    </body>
</html>

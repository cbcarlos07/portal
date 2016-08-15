<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

            
        
        <?php
            include ('./include/head.php');    
            include ('./include/menu.php');
        ?>
        <div id="main" class="container-fluid">
            <?php 
                    require_once  'application/controller/OS_Controller.class.php';
                    require_once 'application/services/OSListIterator.class.php';
                    $osc = new OS_Controller();
                    $total = $osc->get_PDA_Count();
                    if($total > 0){
                        
            ?>
            
            <div id="top" class="row"> 
                
            </div><!-- /#top -->
            <hr />
            <div id="list" class="row">
                <div class="table-responsive col-md-12">
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                        <thead>
                            <tr>
                                <TH>Item</TH>
                                <TH>C&oacute;digo</TH>
                                <TH>Oficina</TH>
                                <TH>Setor Solicitante</TH>
                                <TH>Descri&ccedil;&atilde;o do Servi&ccedil;o</TH>
                                <TH>Respons&aacute;vel</TH>
                                <TH>Data do Servi&ccedil;o</TH>                                                 
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                                            $osc = new OS_Controller();
                                            $rs = $osc->get_PDA();
                                            $osList = new OSListIterator($rs);
                                            $os = new Ordem_Servico();
                                            $i = 0;
                                                    while($osList->hasNextOs()){
                                                        $i++;

                                                        $os = $osList->getNextOs();
                                                      

                                                       //echo 'Status: '.$os->getStatus();
                                                        
                                                      
                                                       echo "<bgsound src='som.wav'  loop=3 volume=0 ></bgsound>";
                                                       echo "<tr >";
                                                                #echo "<td align=center><a href='#'><img id=$i src=public/img/salcir.png width=29 height=29 onclick=mudaImagem();></a></td>";

                                                        echo "<td align=center> ".$i." </td>";                                                        
                                                        echo "<td bgcolor=#ccffcc>".$os->getCodigo()."</td>";
                                                        echo "<td>".$os->getOficina()."</td>";
                                                        echo "<td bgcolor=#ffcc99>".$os->getSetor()."</td>";
                                                        echo "<td>".$os->getDescricao()."</td>";
                                                        echo "<td>".$os->getResponsavel()."</td>";
                                                        echo "<td>".$os->getData()."</td>";
                                                        echo "<td align=center>".$os->getTempo()."</td> ";                                                                
                                                        echo "</tr>";


                                                    }

                                            ?>
                            
                                
                        </tbody>
                    </table>
                </div>
            </div><!-- /#list -->
           <!-- 
            <div id="buttom" class="row">
                <div class="col-md-12">
                    <ul class="pagination">
                        <li class="disabled"><a>&lt; Anterior</a></li>
                        <li class="disabled"><a>1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li class="next"><a href="#" rel="next">Próximo &gt;</a></li>
                    </ul>
                </div>
            </div><!-- /#bottom -->
           
        <?php 
                 }
                  else{
        ?>
                    
                 <div id="top" class="row"> 
                     <h2 class="text-center">N&Atilde;O EXISTEM SERVI&Ccedil;OS EM ESPERA</h2>
                </div><!-- /#top -->       
        <?php                
                    }
        ?>    
            
            
        </div> <!-- /#main -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>

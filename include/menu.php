 <?php 
                    require_once 'application/controller/OS_Controller.class.php';
                    require_once 'application/services/OSListIterator.class.php';
                    $osc = new OS_Controller();
                    $total = $osc->getServico_Aguardando_Count();
                    $total_agil = $osc->getTI_Usuario_Dia_Count(date('d/m/Y'));
                    $total_recebidos = $osc->getTotalServicosRecebidos();
                    $total_pda = $osc->get_PDA_Count();
                    if($total > 0){
                        $ativo = 'texto';
                    ?>
            <div style="display: none;">
                    <audio controls="controls" height="50px" width="100px" autoplay="autoplay" >
                      <source src="som.mp3" type="audio/mpeg" />
                    <!--  <source src="som.ogg" type="audio/ogg" /> -->
                    <embed height="50px" width="100px" src="som.mp3" />
                    </audio>
            </div>
<?php
                    }  else{
                        $ativo = '';
                    }
            ?>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href=".">Portal de Chamados</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li role="presentation" ><a href="index.php" ><div id="<?php echo $ativo; ?>">Aguardando <span class="badge"><?php echo $total; ?></span></div></a></li>
                        <li role="presentation" ><a href="recebidos.php">Recebidos<span class="badge"><?php echo $total_recebidos; ?></span></a></li>
                        <li><a href="agil.php">Agilidade<span class="badge"><?php echo $total_agil; ?></span></a></li>                        
                        <li role="presentation"><a href="pda.php">PDA<span class="badge"><?php echo $total_pda; ?></span></a></li>
                    </ul>
                </div>
            </div>
        </nav>
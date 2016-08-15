
 <?php
            require_once  '..//controller/OS_Controller.class.php';
            require_once '../services/OSListIterator.class.php';
            $osc = new OS_Controller();
            $i = $osc->getTotalServicosRecebidos();
            if($i < 10){
                $i =  '0'.$i;
            }
            
            $wait = $osc->getServico_Aguardando_Count();
            if($wait < 10){
                $wait = '0'.$wait;
            }
            
            if($wait > 0){
               echo "<bgsound src='som.wav'   volume=0 ></bgsound>";
               ?>
               <div style="display: none;">
                    <audio controls="controls" height="50px" width="100px" autoplay="autoplay" >
                      <source src="som.mp3" type="audio/mpeg" />
                    <!--  <source src="som.ogg" type="audio/ogg" /> -->
                    <embed height="50px" width="100px" src="som.mp3" />
                    </audio>
               </div>
        <?php
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

           

            $tDia = $osc->getTI_Usuario_Dia_Count($data2);
            if($tDia < 10){
                $tDia = '0'.$tDia;
            }
            
            
?>
        <link rel="stylesheet" type="text/css" href="../../public/css/situacao.css">
        <meta HTTP-EQUIV="refresh" CONTENT="30">
        <div id="abas">
            
            
            
            
            
            <div id="guia1" class="guia">
                <div id="total1"><?php echo $wait; ?></div> <!-- total dos serviços aguardando -->
                <div id="total2"><?php echo $i; ?></div> <!-- total dos serviços recebidos -->
                <div id="total3"><?php echo $tDia; ?></div> <!-- total dos serviços por dia -->
              
                <div id="guia11" >
                   
                    <a href="../view/aguardo.php" target="central">  
                            Serviços Solicitados
                            
                    </a>
                                   
                </div>
         
                
                <img src="../../public/img/tab4.png" >
             </div>      
           
            
            <div id="guia2" class="guia">
                
                <div id="guia22" >
                    
                     <a href="../view/inicial.php" target="central">  
                            Serviços Recebidos
                            
                    </a>
                    
                </div>
                <img src="../../public/img/tab4.png" >
                
            </div>
            
            
            
            <div id="guia3" class="guia">
                 <div id="guia33" >
                    
                     <a href="../view/agilidade.php" target="central">  
                            Serviços x Agilidade
                            
                     </a>
                    
                </div>
                 <img src="../../public/img/tab4.png" >
            
            </div>    
       
  </div> <!-- fim da div das guias  -->
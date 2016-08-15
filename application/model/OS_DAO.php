<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 include 'ConnectionFactory.class.php';
 include_once 'application/beans/Ordem_Servico.class.php'; 
 include_once 'application/services/OSList.class.php';
 include_once 'application/services/OSListIterator.class.php';
 class OS_DAO  {
       
       
        public function lista(){
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "Select rownum nr_linha
                                            , ds_oficina
                                            , cd_os
                                            , setor_solicitante
                                            , ds_servico
                                            , CD_RESPONSAVEL
                                            
                                            , hr_solicitacao                           dt_hr_sol                                            

                                            ,CASE 
                                                 WHEN to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss') IS NOT NULL
                                                   THEN
                                                      CASE
                                                         WHEN TRUNC(TRUNC(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24))) < 10 
                                                             THEN 0||TRUNC(TRUNC((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24))
                                                         ELSE TO_CHAR(TRUNC(TRUNC((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24))) 
                                                       END||':'||

                                                        CASE
                                                          WHEN trunc((MOD(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24),1))*60) < 10 
                                                              THEN 0||trunc(MOD(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24),1)*60)
                                                          ELSE TO_CHAR(TRUNC((MOD(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24),1))*60))
                                                        END

                                                   END  Tempo_aguardando
                                            ,META
                                            , status
                                            From (
                                           Select os.cd_oficina codigo_oficina
                                            , ds_oficina
                                            , os.cd_os
                                            , substr(setor.nm_setor,0,30) setor_solicitante
                                            , ds_servico
                                            , trunc(os.dt_pedido) dt_solicitacao
                                            , to_char(os.dt_pedido,'dd/mm/yyyy hh24:mi')hr_solicitacao
                                            , nvl(os.dt_prev_exec,os.dt_pedido) dt_prev_conclusao
                                            , to_char(sysdate,'dd/mm/yyyy hh24:mi') hr_atual
                                            , tipo_os.ds_tipo_os tipo_servico
                                            , '01:00' Meta
                                            , Case When trunc((sysdate-nvl(os.dt_pedido,sysdate))*24,0) >= 1
                                                    Then 'vermelha'
                                                    When trunc((sysdate-nvl(os.dt_pedido,sysdate))*24,0) > 0.95
                                                    Then 'amarela'
                                                    Else 'verde'
                                              End Status
                                            , os.cd_tipo_os
                                            , cd_responsavel
                                            From dbamv.solicitacao_os os
                                            , dbamv.setor
                                            , dbamv.tipo_os
                                            , dbamv.oficina
                                            Where os.cd_setor = setor.cd_setor
                                            And os.cd_tipo_os = tipo_os.cd_tipo_os
                                            AND os.cd_oficina = oficina.cd_oficina
                                            And os.tp_situacao not in('C','S','E', 'F')
                                            Order by os.dt_pedido desc
                                            )
                                            Where codigo_oficina in (14,16,17,18)
                                            AND ds_servico not like '%PDA%'";
				$stmt = ociparse($con, $query);
                                        //("select p.nm_prestador nome from dbamv.prestador p");
				//$stmt = $this->conex->query($query);
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            
                             $os =  new Ordem_Servico();                                                                                 
                             $os->setItem($row["NR_LINHA"]); 
                             $os->setOficina($row["DS_OFICINA"]);
                             $os->setCodigo($row["CD_OS"]);
                             $os->setSetor($row["SETOR_SOLICITANTE"]);
                             $os->setDescricao($row["DS_SERVICO"]);
                             $os->setResponsavel($row["CD_RESPONSAVEL"]);
                             $os->setData($row["DT_HR_SOL"]);
                             $os->setTempo($row["TEMPO_AGUARDANDO"]);
                             $os->setMeta($row["META"]); 
                             $os->setStatus($row['STATUS']);
                             $oSList->addOs($os);
                             
                         }  
                          
                               
			$conn->closeConnection($con);
			// retorna o resultado da query
			return $oSList;
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
	}
        
        
        public function getTotalServicosRecebidos(){
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            $total = 0;
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "Select count(*) TOTAL
                                            From (
                                           Select os.cd_oficina codigo_oficina
                                            , ds_oficina
                                            , os.cd_os
                                            , substr(setor.nm_setor,0,30) setor_solicitante
                                            , ds_servico
                                            , trunc(os.dt_pedido) dt_solicitacao
                                            , to_char(os.dt_pedido,'dd/mm/yyyy hh24:mi')hr_solicitacao
                                            , nvl(os.dt_prev_exec,os.dt_pedido) dt_prev_conclusao
                                            , to_char(sysdate,'dd/mm/yyyy hh24:mi') hr_atual
                                            , tipo_os.ds_tipo_os tipo_servico
                                            , '01:00' Meta
                                            , Case When trunc((sysdate-nvl(os.dt_pedido,sysdate))*24,0) >= 1
                                            Then '<img src=vermelha border=0>'
                                            When trunc((sysdate-nvl(os.dt_pedido,sysdate))*24,0) > 0.95
                                            Then '<img src=amarela border=0>'
                                            Else '<img src=verde border=0>'
                                            End Status
                                            , os.cd_tipo_os
                                            , cd_responsavel
                                            From dbamv.solicitacao_os os
                                            , dbamv.setor
                                            , dbamv.tipo_os
                                            , dbamv.oficina
                                            Where os.cd_setor = setor.cd_setor
                                            And os.cd_tipo_os = tipo_os.cd_tipo_os
                                            AND os.cd_oficina = oficina.cd_oficina
                                            And os.tp_situacao not in('C','S','E', 'F')
                                            Order by os.dt_pedido desc
                                            )
                                            Where codigo_oficina in (14,16,17,18)
                                            AND ds_servico not like '%PDA%'";
				$stmt = ociparse($con, $query);
                                        //("select p.nm_prestador nome from dbamv.prestador p");
				//$stmt = $this->conex->query($query);
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         if ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            
                              $total = $row['TOTAL'];
                             
                         }  
                          
                               
			$conn->closeConnection($con);
			// retorna o resultado da query
			
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
                return $total;
	}
        
        
        public function getTI_Usuario_Resp($data){
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            $total = 0;
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "SELECT A.SEQ,
                                            A.RESPONSAVEL,
                                            A.SOL,
                                            DECODE(B.ATD,NULL,0,B.ATD) ATD
                                           FROM
                                           (
                                     SELECT 1 SEQ
                                            , decode(SO.CD_RESPONSAVEL,null,'SEM_RECEBER',SO.CD_RESPONSAVEL) RESPONSAVEL
                                            , COUNT(1)SOL
                                     FROM DBAMV.SOLICITACAO_OS SO
                                         ,DBAMV.SETOR S
                                     WHERE SO.CD_SETOR = S.CD_SETOR
                                     AND   SO.CD_OFICINA IN (14,15,16,17,18)
                                     AND   TO_CHAR(SO.DT_PEDIDO,'MM/YYYY') = NVL (:DATA,TO_CHAR(SYSDATE,'MM/YYYY'))
                                     GROUP BY SO.CD_RESPONSAVEL

                                     )A
                                     ,
                                     (
                                     SELECT 1
                                            , decode(SO.CD_RESPONSAVEL,null,'SEM_RECEBER',SO.CD_RESPONSAVEL) RESPONSAVEL
                                            , COUNT(1)ATD
                                     FROM DBAMV.SOLICITACAO_OS SO
                                         ,DBAMV.SETOR S
                                     WHERE SO.CD_SETOR = S.CD_SETOR
                                     AND   SO.CD_OFICINA IN (14,15,16,17,18)
                                     AND   TO_CHAR(SO.DT_EXECUCAO,'MM/YYYY') = NVL (:DATA,TO_CHAR(SYSDATE,'MM/YYYY'))
                                     AND   SO.TP_SITUACAO IN ('C')
                                     GROUP BY SO.CD_RESPONSAVEL

                                     )B
                                     WHERE A.RESPONSAVEL = B.RESPONSAVEL(+)
                                     ORDER BY 3 DESC";
				$stmt = ociparse($con, $query);
                                        //("select p.nm_prestador nome from dbamv.prestador p");
				//$stmt = $this->conex->query($query);
                                oci_bind_by_name($stmt, ":DATA", $data);
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            
                             $os =  new Ordem_Servico();                                                                                 
                             $os->setItem($row["SEQ"]); 
                             $os->setResponsavel($row["RESPONSAVEL"]);
                             $os->setSolicitadas($row['SOL']);
                             $os->setAtendidas($row['ATD']);
                             $oSList->addOs($os);  
                         }         
			$conn->closeConnection($con);
			// retorna o resultado da query
			
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
                return $oSList;
	}
        
         public function getTI_Usuario_Dia($data){
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "SELECT 1 SEQ,SO.CD_RESPONSAVEL,COUNT(1)Qtd
                                            FROM DBAMV.SOLICITACAO_OS SO
                                            WHERE SO.CD_OFICINA IN (14,15,16)
                                            AND to_char(SO.DT_EXECUCAO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                                            GROUP BY SO.CD_RESPONSAVEL
                                             ORDER BY COUNT(1) DESC";
				$stmt = ociparse($con, $query);
                                oci_bind_by_name($stmt, ":DATA", $data);
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            
                             $os =  new Ordem_Servico();   
                             $os->setResponsavel($row["CD_RESPONSAVEL"]);
                             $os->setQtde($row['QTD']);                             
                             $oSList->addOs($os);  
                         }         
			$conn->closeConnection($con);
			// retorna o resultado da query
			
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
                return $oSList;
	}
        
        
        public function getTI_Usuario_Dia_Count($data){
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            $total = 0;
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "SELECT 
                                            SUM(A.Qtd) TOTAL
                                          FROM(
                                          SELECT 1 SEQ,SO.CD_RESPONSAVEL,COUNT(1)Qtd
                                            FROM DBAMV.SOLICITACAO_OS SO
                                            WHERE SO.CD_OFICINA IN (14,15,16)
                                            AND to_char(SO.DT_EXECUCAO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))
                                            GROUP BY SO.CD_RESPONSAVEL
                                            )A";
				$stmt = ociparse($con, $query);
                                oci_bind_by_name($stmt, ":DATA", $data);
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         if ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                              $total = $row['TOTAL']; 
                         }         
			$conn->closeConnection($con);
			// retorna o resultado da query
			
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
                return $total;
	}
       
         public function getServico_Aguardando(){
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            $total = 0;
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "Select rownum nr_linha
                                            , codigo_oficina
                                            , ds_oficina
                                            , cd_os
                                            , solicitante
                                            , setor_solicitante
                                            , ds_servico
                                            
                                            , hr_solicitacao                           dt_hr_sol
                                            

                                            ,CASE 
                                                 WHEN to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss') IS NOT NULL
                                                   THEN
                                                      CASE
                                                         WHEN TRUNC(TRUNC(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24))) < 10 
                                                             THEN 0||TRUNC(TRUNC((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24))
                                                         ELSE TO_CHAR(TRUNC(TRUNC((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24))) 
                                                       END||':'||

                                                        CASE
                                                          WHEN trunc((MOD(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24),1))*60) < 10 
                                                              THEN 0||trunc(MOD(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24),1)*60)
                                                          ELSE TO_CHAR(TRUNC((MOD(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24),1))*60))
                                                        END

                                                   END  Tempo_aguardando
                                            ,META
                                             , status
                                            From (
                                           Select os.cd_oficina codigo_oficina
                                            , ds_oficina
                                            , os.cd_os
                                            , os.nm_solicitante           solicitante
                                            , substr(setor.nm_setor,0,30) setor_solicitante
                                            , ds_servico
                                            , trunc(os.dt_pedido) dt_solicitacao
                                            , to_char(os.dt_pedido,'dd/mm/yyyy hh24:mi')hr_solicitacao
                                            , nvl(os.dt_prev_exec,os.dt_pedido) dt_prev_conclusao
                                            , to_char(sysdate,'dd/mm/yyyy hh24:mi') hr_atual
                                            , tipo_os.ds_tipo_os tipo_servico
                                            , '00:15' Meta
                                            , Case When trunc((sysdate-nvl(os.dt_pedido,sysdate))*24,0) >= 1
                                            Then 'vermelha'
                                            When trunc((sysdate-nvl(os.dt_pedido,sysdate))*24,0) > 0.95
                                            Then 'amarela'
                                            Else 'verde'
                                            End Status
                                            , os.cd_tipo_os
                                            , cd_responsavel
                                            From dbamv.solicitacao_os os
                                            , dbamv.setor
                                            , dbamv.tipo_os
                                            , dbamv.oficina
                                            Where os.cd_setor = setor.cd_setor
                                            And os.cd_tipo_os = tipo_os.cd_tipo_os
                                            AND os.cd_oficina = oficina.cd_oficina
                                            And os.tp_situacao in ('S')
                                            Order by os.dt_pedido desc
                                            )
                                            Where codigo_oficina in (14,15,16,17,18)
                                           ";
				$stmt = ociparse($con, $query);
                                        //("select p.nm_prestador nome from dbamv.prestador p");
				//$stmt = $this->conex->query($query);
                                
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            
                             $os =  new Ordem_Servico();                                                                                 
                             $os->setItem($row["NR_LINHA"]);                              
                             $os->setCodigo($row["CD_OS"]);
                             $os->setSetor($row["SETOR_SOLICITANTE"]);
                             $os->setDescricao($row["DS_SERVICO"]);
                             $os->setSolicitante($row["SOLICITANTE"]);
                             $os->setData($row["DT_HR_SOL"]);
                             $os->setTempo($row["TEMPO_AGUARDANDO"]);
                             $os->setMeta($row["META"]);
                             $os->setStatus($row['STATUS']);
                             
                             $oSList->addOs($os);
                         }         
			$conn->closeConnection($con);
			// retorna o resultado da query
			
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
                return $oSList;
	}
        
        
        public function getServico_Aguardando_Count(){
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            $total = 0;
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "SELECT COUNT(A.NR_LINHA) TOTAL
                                                        FROM
                                                        (
                                                        Select rownum nr_linha
                                                         , codigo_oficina
                                                         , ds_oficina
                                                         , cd_os
                                                         , solicitante
                                                         , setor_solicitante
                                                         , ds_servico
                                                         
                                                         , hr_solicitacao                           dt_hr_sol
                                                         

                                                         ,CASE 
                                                              WHEN to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss') IS NOT NULL
                                                                THEN
                                                                   CASE
                                                                      WHEN TRUNC(TRUNC(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24))) < 10 
                                                                          THEN 0||TRUNC(TRUNC((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24))
                                                                      ELSE TO_CHAR(TRUNC(TRUNC((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24))) 
                                                                    END||':'||

                                                                     CASE
                                                                       WHEN trunc((MOD(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24),1))*60) < 10 
                                                                           THEN 0||trunc(MOD(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24),1)*60)
                                                                       ELSE TO_CHAR(TRUNC((MOD(((to_date(hr_atual,'dd/mm/yyyy hh24:mi:ss')-to_date(hr_solicitacao,'dd/mm/yyyy hh24:mi:ss'))*24),1))*60))
                                                                     END

                                                                END  Tempo_aguardando
                                                         ,META
                                                        
                                                         From (
                                                        Select os.cd_oficina codigo_oficina
                                                         , ds_oficina
                                                         , os.cd_os
                                                         , os.nm_solicitante           solicitante
                                                         , substr(setor.nm_setor,0,30) setor_solicitante
                                                         , ds_servico
                                                         , trunc(os.dt_pedido) dt_solicitacao
                                                         , to_char(os.dt_pedido,'dd/mm/yyyy hh24:mi')hr_solicitacao
                                                         , nvl(os.dt_prev_exec,os.dt_pedido) dt_prev_conclusao
                                                         , to_char(sysdate,'dd/mm/yyyy hh24:mi') hr_atual
                                                         , tipo_os.ds_tipo_os tipo_servico
                                                         , '00:15' Meta                                                         
                                                         , os.cd_tipo_os
                                                         , cd_responsavel
                                                         From dbamv.solicitacao_os os
                                                         , dbamv.setor
                                                         , dbamv.tipo_os
                                                         , dbamv.oficina
                                                         Where os.cd_setor = setor.cd_setor
                                                         And os.cd_tipo_os = tipo_os.cd_tipo_os
                                                         AND os.cd_oficina = oficina.cd_oficina
                                                         And os.tp_situacao in ('S')
                                                         Order by os.dt_pedido desc
                                                         )
                                                         Where codigo_oficina in (14,15,16,17,18)
                                                         ) A";
				$stmt = ociparse($con, $query);
                                        //("select p.nm_prestador nome from dbamv.prestador p");
				//$stmt = $this->conex->query($query);
                                
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            
                             $total = $row['TOTAL'];
                         }         
			$conn->closeConnection($con);
			// retorna o resultado da query
			
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
                return $total;
	}
        
        
        public function ordem_Por_usuario($user, $parametro){
            
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "SELECT 
                                            OS.CD_OS           CODIGO
                                           ,TO_CHAR(OS.DT_PEDIDO, 'DD/MM/YYYY HH24:MI')       DATA
                                           ,OS.DS_SERVICO      DESCRICAO
                                           ,OS.NM_SOLICITANTE  SOLICITANTE
                                           ,CASE 
                                              WHEN (OS.TP_SITUACAO = 'A')
                                                THEN 'ABERTA'
                                              WHEN   (OS.TP_SITUACAO = 'C')
                                                 THEN 'CONCLUIDA'
                                              WHEN   (OS.TP_SITUACAO = 'F')
                                                 THEN 'PROJETOS FUTUROS'
                                              WHEN   (OS.TP_SITUACAO = 'E')
                                                 THEN 'AGURDANDO'
                                              END SITUACAO                
                                           ,S.NM_SETOR         SETOR
                                           ,O.DS_OFICINA       OFICINA

                                          FROM 
                                            DBAMV.SOLICITACAO_OS OS
                                           ,DBAMV.OFICINA   O
                                           ,DBAMV.TIPO_OS   T
                                           ,DBAMV.SETOR     S
                                          WHERE 
                                                OS.CD_RESPONSAVEL = :NM_USER
                                                AND O.CD_OFICINA  = OS.CD_OFICINA
                                                AND T.CD_TIPO_OS  = OS.CD_TIPO_OS
                                                AND OS.CD_SETOR   = S.CD_SETOR 
                                                $parametro
                                                ORDER BY 1 DESC ";
				$stmt = ociparse($con, $query);
                                oci_bind_by_name($stmt, ":NM_USER", $user);
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            
                             $os =  new Ordem_Servico();                                                                                 
                             
                             if(isset($row['SITUACAO'])){
                                 $situacao = $row['SITUACAO'];
                             }else{
                                 $situacao = "";
                             }
                             
                             $os->setOficina($row["OFICINA"]);
                             $os->setCodigo($row["CODIGO"]);
                             $os->setSetor($row["SETOR"]);
                             $os->setDescricao($row["DESCRICAO"]);                             
                             $os->setData($row["DATA"]);                              
                             $os->setStatus($situacao);
                             $os->setSolicitante($row['SOLICITANTE']);
                             $oSList->addOs($os);
                             
                         }  
                          
                               
			$conn->closeConnection($con);
			// retorna o resultado da query
			return $oSList;
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
	}
        
       
        public function ordem_Por_usuario_Dia($user, $data){
            
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "SELECT 
                                            OS.CD_OS           CODIGO
                                           ,TO_CHAR(OS.DT_PEDIDO, 'DD/MM/YYYY HH24:MI')       DATA
                                           ,OS.DS_SERVICO      DESCRICAO
                                           ,OS.NM_SOLICITANTE  SOLICITANTE
                                           ,CASE 
                                              WHEN (OS.TP_SITUACAO = 'A')
                                                THEN 'ABERTA'
                                              WHEN   (OS.TP_SITUACAO = 'C')
                                                 THEN 'CONCLUIDA'
                                              WHEN   (OS.TP_SITUACAO = 'F')
                                                 THEN 'PROJETOS FUTUROS'
                                              WHEN   (OS.TP_SITUACAO = 'E')
                                                 THEN 'AGURDANDO'
                                              END SITUACAO                
                                           ,S.NM_SETOR         SETOR
                                           ,O.DS_OFICINA       OFICINA

                                          FROM 
                                            DBAMV.SOLICITACAO_OS OS
                                           ,DBAMV.OFICINA   O
                                           ,DBAMV.TIPO_OS   T
                                           ,DBAMV.SETOR     S
                                          WHERE 
                                                OS.CD_RESPONSAVEL = :NM_USER
                                                AND to_char(OS.DT_EXECUCAO,'DD/MM/YYYY') = NVL(:DATA,TO_CHAR(SYSDATE,'DD/MM/YYYY'))    
                                                AND O.CD_OFICINA  = OS.CD_OFICINA
                                                AND T.CD_TIPO_OS  = OS.CD_TIPO_OS
                                                AND OS.CD_SETOR   = S.CD_SETOR 
                                                ORDER BY 1 DESC ";
				$stmt = ociparse($con, $query);
                                oci_bind_by_name($stmt, ":NM_USER", $user);
                                oci_bind_by_name($stmt, ":DATA", $data);
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            
                             $os =  new Ordem_Servico();                                                                                 
                             
                             $os->setOficina($row["OFICINA"]);
                             $os->setCodigo($row["CODIGO"]);
                             $os->setSetor($row["SETOR"]);
                             $os->setDescricao($row["DESCRICAO"]);                             
                             $os->setData($row["DATA"]);                              
                             $os->setStatus($row['SITUACAO']);
                             $os->setSolicitante($row['SOLICITANTE']);
                             $oSList->addOs($os);
                             
                         }  
                          
                               
			$conn->closeConnection($con);
			// retorna o resultado da query
			return $oSList;
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
	}
        
        
        public function get_PDA(){
            
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "Select rownum nr_linha
                                                , ds_oficina
                                                , cd_os
                                                , setor_solicitante
                                                , ds_servico
                                                , cd_responsavel

                                                , hr_solicitacao                           dt_hr_sol


                                                From (
                                               Select os.cd_oficina codigo_oficina
                                                , ds_oficina
                                                , os.cd_os
                                                , substr(setor.nm_setor,0,30) setor_solicitante
                                                , ds_servico
                                                , trunc(os.dt_pedido) dt_solicitacao
                                                , to_char(os.dt_pedido,'dd/mm/yyyy hh24:mi')hr_solicitacao
                                                , nvl(os.dt_prev_exec,os.dt_pedido) dt_prev_conclusao
                                                , to_char(sysdate,'dd/mm/yyyy hh24:mi') hr_atual
                                                , tipo_os.ds_tipo_os tipo_servico 
                                                , os.cd_tipo_os
                                                , cd_responsavel
                                                From dbamv.solicitacao_os os
                                                , dbamv.setor
                                                , dbamv.tipo_os
                                                , dbamv.oficina
                                                Where os.cd_setor = setor.cd_setor
                                                And os.cd_tipo_os = tipo_os.cd_tipo_os
                                                AND os.cd_oficina = oficina.cd_oficina
                                                And os.tp_situacao not in('C','S','E', 'F')
                                                Order by os.dt_pedido desc
                                                )
                                                Where codigo_oficina in (14,15,16,17,18)
                                                AND ds_servico like '%PDA%' ";
				$stmt = ociparse($con, $query);
                                
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            
                             $os =  new Ordem_Servico();                                                                                 
                             
                             $os->setOficina($row["DS_OFICINA"]);
                             $os->setCodigo($row["CD_OS"]);
                             $os->setSetor($row["SETOR_SOLICITANTE"]);
                             $os->setDescricao($row["DS_SERVICO"]);                             
                             $os->setResponsavel($row["CD_RESPONSAVEL"]);                              
                             $os->setData($row['DT_HR_SOL']);
                             
                             $oSList->addOs($os);
                             
                         }  
                          
                               
			$conn->closeConnection($con);
			// retorna o resultado da query
			return $oSList;
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
	}
        
        public function get_PDA_Count(){
            $i = 0;
            $conn = new ConnectionFactory();
            $con = $conn->getConnection();
            //$paciente = new Paciente();
            //$sp = new SituacaoPaciente();
			try{
				// executo a query
                            //$con = ociparse($connection_resource, $sql_text)
                                $query = "SELECT COUNT(A.DS_OFICINA) TOTAL FROM
                                                    (
                                                        Select rownum nr_linha
                                                         , ds_oficina
                                                         , cd_os
                                                         , setor_solicitante
                                                         , ds_servico
                                                         , cd_responsavel

                                                         , hr_solicitacao                           dt_hr_sol


                                                         From (
                                                        Select os.cd_oficina codigo_oficina
                                                         , ds_oficina
                                                         , os.cd_os
                                                         , substr(setor.nm_setor,0,30) setor_solicitante
                                                         , ds_servico
                                                         , trunc(os.dt_pedido) dt_solicitacao
                                                         , to_char(os.dt_pedido,'dd/mm/yyyy hh24:mi')hr_solicitacao
                                                         , nvl(os.dt_prev_exec,os.dt_pedido) dt_prev_conclusao
                                                         , to_char(sysdate,'dd/mm/yyyy hh24:mi') hr_atual
                                                         , tipo_os.ds_tipo_os tipo_servico 
                                                         , os.cd_tipo_os
                                                         , cd_responsavel
                                                         From dbamv.solicitacao_os os
                                                         , dbamv.setor
                                                         , dbamv.tipo_os
                                                         , dbamv.oficina
                                                         Where os.cd_setor = setor.cd_setor
                                                         And os.cd_tipo_os = tipo_os.cd_tipo_os
                                                         AND os.cd_oficina = oficina.cd_oficina
                                                         And os.tp_situacao not in('C','S','E', 'F')
                                                         Order by os.dt_pedido desc
                                                         )
                                                         Where codigo_oficina in (14,15,16,17,18)
                                                         AND ds_servico like '%PDA%'
                                                     ) A";
				$stmt = ociparse($con, $query);
                                
                                oci_execute($stmt);
			   // desconecta 
                              
                           $oSList = new OsList();
                           
                         while ($row = oci_fetch_array($stmt, OCI_ASSOC)){
                            $i = $row['TOTAL'];
                             
                         }  
                          
                               
			$conn->closeConnection($con);
			// retorna o resultado da query
			
		}catch ( PDOException $ex ){  echo "Erro: ".$ex->getMessage(); }
                return $i;
	}
        
        
 }
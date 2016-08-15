<?php
include_once 'application/model/OS_DAO.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class OS_Controller{
     
    
    public function lista(){
        $teste_DAO = new OS_DAO();
        $lista =   $teste_DAO->lista();
        return $lista;
    }
    public function getTotalServicosRecebidos(){
        $teste_DAO = new OS_DAO();
        $i =   $teste_DAO->getTotalServicosRecebidos();
        return $i;
    }
  public function getTI_Usuario_Resp($data){
      $teste_DAO = new OS_DAO();
      $lista =   $teste_DAO->getTI_Usuario_Resp($data);
      return $lista;
  }
  
  public function getTI_Usuario_Dia($data){
      $teste_DAO = new OS_DAO();
      $lista =   $teste_DAO->getTI_Usuario_Dia($data);
      return $lista;
  }
  
  public function getTI_Usuario_Dia_Count($data){
      $teste_DAO = new OS_DAO();
      $lista =   $teste_DAO->getTI_Usuario_Dia_Count($data);
      return $lista;
  }
  
  public function getServico_Aguardando(){
      $teste_DAO = new OS_DAO();
      $lista =   $teste_DAO->getServico_Aguardando();
      return $lista;
  }
  public function getServico_Aguardando_Count(){
      $teste_DAO = new OS_DAO();
      $lista =   $teste_DAO->getServico_Aguardando_Count();
      return $lista;
  }
  
  public function ordem_Por_usuario($user, $parametro){
      $teste_DAO = new OS_DAO();
      $lista =   $teste_DAO->ordem_Por_usuario($user, $parametro);
      return $lista;
  }
  public function ordem_Por_usuario_Dia($user, $data){
      $teste_DAO = new OS_DAO();
      $lista =   $teste_DAO->ordem_Por_usuario_Dia($user, $data);
      return $lista;
  }
  
  public function get_PDA(){
       $teste_DAO = new OS_DAO();
      $lista =   $teste_DAO->get_PDA();
      return $lista;
  }
  
 public function get_PDA_Count(){
      $teste_DAO = new OS_DAO();
      $lista =   $teste_DAO->get_PDA_Count();
      return $lista;
 }
          
}
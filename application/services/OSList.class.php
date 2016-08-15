<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class OsList {
    private $os = array();
    private $osCount = 0;
    public function __construct() {
    }
    public function getOsCount() {
      return $this->osCount;
    }
    private function setOsCount($newCount) {
      $this->osCount = $newCount;
    }
    public function getOs($osNumberToGet) {
      if ( (is_numeric($osNumberToGet)) && 
           ($osNumberToGet <= $this->getOsCount())) {
           return $this->os[$osNumberToGet];
         } else {
           return NULL;
         }
    }
    public function addOs(Ordem_Servico $os_in) {
      $this->setOsCount($this->getOsCount() + 1);
      $this->os[$this->getOsCount()] = $os_in;
      return $this->getOsCount();
    }
    public function removeOs(Ordem_Servico $os_in) {
      $counter = 0;
      while (++$counter <= $this->getOsCount()) {
        if ($os_in->getAuthorAndTitle() == 
          $this->os[$counter]->getAuthorAndTitle())
          {
            for ($x = $counter; $x < $this->getOsCount(); $x++) {
              $this->os[$x] = $this->os[$x + 1];
          }
          $this->setOsCount($this->getOsCount() - 1);
        }
      }
      return $this->getOsCount();
    }
}

<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class OSListIterator {
    protected $osList;
    protected $currentOs = 0;

    public function __construct(OsList $osList_in) {
      $this->osList = $osList_in;
    }
    public function getCurrentOs() {
      if (($this->currentOs > 0) && 
          ($this->osList->getOsCount() >= $this->currentOs)) {
        return $this->osList->getOs($this->currentOs);
      }
    }
    public function getNextOs() {
      if ($this->hasNextOs()) {
        return $this->osList->getOs(++$this->currentOs);
      } else {
        return NULL;
      }
    }
    public function hasNextOs() {
      if ($this->osList->getOsCount() > $this->currentOs) {
        return TRUE;
      } else {
        return FALSE;
      }
    }
}
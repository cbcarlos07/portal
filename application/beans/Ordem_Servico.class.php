<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 class Ordem_Servico{
    private $item;
    private $oficina;
    private $codigo;
    private $setor;
    private $descricao;
    private $responsavel;
    private $data;
    private $tempo;
    private $meta;
    private $solicitadas;
    private $atendidas;
    private $qtde;
    private $solicitante;
    private $status;
    
    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

        function getSolicitante() {
        return $this->solicitante;
    }

    function setSolicitante($solicitante) {
        $this->solicitante = $solicitante;
    }

        function getQtde() {
        return $this->qtde;
    }

    function setQtde($qtde) {
        $this->qtde = $qtde;
    }

        function getSolicitadas() {
        return $this->solicitadas;
    }

    function getAtendidas() {
        return $this->atendidas;
    }

    function setSolicitadas($solicitadas) {
        $this->solicitadas = $solicitadas;
    }

    function setAtendidas($atendidas) {
        $this->atendidas = $atendidas;
    }

    
        function getItem() {
        return $this->item;
    }

    function getOficina() {
        return $this->oficina;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getSetor() {
        return $this->setor;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getResponsavel() {
        return $this->responsavel;
    }

    function getData() {
        return $this->data;
    }

    function getTempo() {
        return $this->tempo;
    }

    function getMeta() {
        return $this->meta;
    }

    function setItem($item) {
        $this->item = $item;
    }

    function setOficina($oficina) {
        $this->oficina = $oficina;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setSetor($setor) {
        $this->setor = $setor;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setTempo($tempo) {
        $this->tempo = $tempo;
    }

    function setMeta($meta) {
        $this->meta = $meta;
    }



}

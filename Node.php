<?php

/**
 * @access public
 * @author Kaan
 */
App::uses("PropertyContainer", "Lib");

class Node extends PropertyContainer {

    /**
     * Label'lar Neo4j üzerinde kayıtlı Nodelara ait etiketlerdir 
     * Bir node'un birden fazla etiketi olabilir.Bu sebebten dolayı değişken tipi
     * array olarak belirlenmiştir.
     * 
     * @AttributeType string
     */
    protected $Label=array();
    protected $ID;

    /**
     * @access public
     * @return string
     * @ReturnType string
     */
    public function GetLabel($Key) {
        $Label = $this->Label[$Key];
        return $Label;
    }

    /**
     * @access public
     * @param string aLabel
     * @return string
     * @ParamType aLabel string
     * @ReturnType string
     */
    public function SetLabel($Label) {
        $this->Label[] = $Label;
        return $Label;
    }

    /**
     * @access public
     * @return string
     * @ReturnType string
     */
    public function GetID() {
        $ID = $this->ID;
        return $ID;
    }

    /**
     * @access public
     * @param string aLabel
     * @return string
     * @ParamType aLabel string
     * @ReturnType string
     */
    public function SetID($ID) {
        $this->ID = $ID;
        return $ID;
    }

    /**
     * @access public
     */
    public function NodeProperties() {
        /*
         *  Node'un property bilgileri girilecek
         * 
         */
    }

    public function Load() {
        /*
         * Nodu property ve label v.b. her bilgisi ile sisteme upload edilecek
         * 
         */
    }

}

?>
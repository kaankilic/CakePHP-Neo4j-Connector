<?php
/**
 * @access public
 * @author Kaan
 */
App::uses("PropertyContainer", "Lib");
class Relationships extends PropertyContainer {
	protected $Start;
	protected $End;
	protected $Type;
	/**
	 * @AttributeType string
	 */
	const DirectionAll = "all";
	/**
	 * @AttributeType string
	 */
	const DirectionIn = "in";
	/**
	 * @AttributeType string
	 */
	const DirectionOut = "out";
	
	public $PropertyContainer;
        public function SetStart($Start){
            $this->Start = $Start;
        }
        public function GetStart(){
            $Start = $this->Start;
            return $Start;
        }
        public function SetEnd($End){
            $this->End = $End;
        }
        public function GetEnd(){
            $End = $this->End;
            return $End;
        }
        public function SetType($Type){
            $this->Type = $Type;
        }
        public function GetType(){
            $Type = $this->Type;
            return $Type;
        }
        public function Load() {
        
    }

}
?>
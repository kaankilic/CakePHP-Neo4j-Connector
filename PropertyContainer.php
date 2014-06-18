<?php
/**
 * @access public
 * @author Kaan
 */
abstract class PropertyContainer {
	/**
	 * @AttributeType array
	 */
	protected $Properties=array();
	/**
	 * @AttributeType boolean
	 */
	private $isLoaded;
	/**
	 * @access public
	 */
	public abstract function Load();

	/**
	 * @access public
	 * @param string aKey
	 * @param string aValue
	 * @return void
	 * @ParamType aKey string
	 * @ParamType aValue string
	 * @ReturnType void
	 */
	public function SetProperty($Key, $Value) {
            $this->Properties[$Key] = $Value;
            $this->isLoaded = true;
	}

	/**
	 * @access public
	 * @return array_1
	 * @ReturnType array
	 */
	public function GetProperty($Key) {
            $Value = $this->Properties[$Key];
            return $Value;
	}
}
?>
<?php
namespace Projet;

class ArrayList {
	private $list = array();
	private $size = 0;

	function __construct(){
	}

	/*
	 * public
	 */
	public function get($index){
		return $this->_get($index);
	}

	public function size(){
		return $this->_size();
	}

	public function add($item){
		return $this->_add($item);
	}

	public function insert($index, $item){
		if($this->_isinrange($index)){
			return $this->_insert($index, $item);
		}
		return FALSE;
	}

	public function removeAt($index){
		if($this->_isinrange($index)){
			return $this->_removeAt($index);
		}
		return FALSE;
	}

	public function removeFirst($item){
		return $this->_removeFirst($item);
	}

	/*
	 * private
	 */
	private function _isinrange($index){
		return ($index >= 0 && $index < $this->size());
	}

	private function _get($index){
		return $this->list[$index];
	}

	private function _size(){
		return $this->size;
	}

	private function _add($item){
		$this->list[$this->size] = $item;
		$this->size += 1;
		return TRUE;
	}

	private function _insert($index, $item){
		for($i = $this->size; $i > $index; --$i){
			$this->list[$i] = $this->list[$i - 1];
		}
		$this->list[$i] = $item;
		$this->size += 1;
		return TRUE;
	}

	private function _removeAt($index){
		for($i = $index; $i < $this->size; ++$i){
			$this->list[$i] = $this->list[$i + 1];
		}
		unset($this->list[$this->size]);
		$this->size -= 1;
		return TRUE;
	}

	private function _removeFirst($item){
		foreach($this->list as $index => $value){
			if($value === $item){
				$this->_removeAt($index);
				break;
			}
		}
		return TRUE;
	}

	/*
	 * print info
	 */
	public function toArray(){
		$a = array();
		for($i = 0; $i < $this->size; ++$i){
			$a[$i] = $this->get($i);
		}
		return $a;
	}

	public function dump(){
		for($i = 0; $i < $this->size; ++$i){
			echo "$i:\t\t";
			echo $this->get($i);
			echo "</br>";
		}
		echo "</br>";
	}
}

?>
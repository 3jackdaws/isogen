<?php

class json_response
{
	private $_response = [];
	public function __construct(){
		$this->_response["error"] = false;
		$this->_response["num"] = 0;
	}

	public function add_error($message){
		$this->_response["error"] = true;
		$this->_response["message"][] = $message;
		$this->_response["num"]++;
	}

	public function add_message($message){
		$this->_response["message"][] = $message;
	}

	public function add_content_to_field($field, $content){
		$this->_response[$field] = $content;
	}

	public function __toString(){
		return json_encode($this->_response);
	}
}
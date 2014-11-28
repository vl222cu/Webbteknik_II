<?php

class MessageRegulator {

	protected $db = null;

	public function __construct() {

		try {
			$this->db = new PDO("sqlite:db.db");
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOEception $e) {

			die("Something went wrong, try again";
		}

		$mode = $this->fetch('mode');

		switch($mode) {

            case 'get':
                $this->getMessage();
                break;
            case 'post':
                $this->postMessage();
                break;
            default:
                $this->output(false, 'Wrong mode.');
                break;
        } 

       	return;
	}

	protected function getMessage() {


	}
}
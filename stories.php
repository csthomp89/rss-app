<?php
require_once 'db.php';

new stories();

class stories {
	private $db;
	
	public function __construct() {
		$this->db = new database();
	}
	
}

?>
<?php

class database {
	private $conn;
	
	public function __construct() {
		$this->conn = new PDO('mysql:host=localhost;dbname=rss;','root','root');
	}
	
	public function add_feed($title, $url) {
		$insertsql = "INSERT INTO sources (title, url) VALUES (:title, :url)";
		$query = $this->conn->prepare($insertsql);
		$query->bindParam(":title",$title);
		$query->bindParam(":url",$url);
		$query->execute();
	}
	
	public function delete_feed($id) {
		$deletesql = "DELETE FROM sources WHERE id=:id";
		$query = $this->conn->prepare($deletesql);
		$query->bindParam(":id", $id);
		$query->execute();
	}
	
	public function get_feed_list() {
		$sql = "SELECT * FROM sources";
		return $this->conn->query($sql);
	}
	
	public function get_source_stories() {
		$sql = "SELECT * FROM source_content WHERE date BETWEEN date_sub(now(), INTERVAL 4 WEEK) AND now() ORDER BY date DESC";
		return $this->conn->query($sql);
	}
	
	public function add_source_content($feed_id, $title, $description, $url, $date, $guid) {
		$insertsql = "INSERT INTO source_content (feed_id, title, description, url, date, guid) VALUES (:feed_id, :title, :description, :url, :date, :guid)";
		$query = $this->conn->prepare($insertsql);
		$query->bindParam(":feed_id", $feed_id);
		$query->bindParam(":title",$title);
		$query->bindParam(":description",$description);
		$query->bindParam(":url",$url);
		$query->bindParam(":date",$date);
		$query->bindParam(":guid",$guid);
		$query->execute();
	}
	
	public function add_story($id) {
		$insertsql = "INSERT INTO feed_content (feed_id, source_content_id) VALUES (1, :source_content_id)";
		$query = $this->conn->prepare($insertsql);
		$query->bindParam(":source_content_id", $id);
		$query->execute();
	}
	
	public function get_feed_info($id) {
		$selectsql = "SELECT * FROM feeds WHERE id=:id";
		$query = $this->conn->prepare($selectsql);
		$query->bindParam(":id", $id);
		$query->execute();
		return $query->fetchAll();
	}
	
	public function delete_story($story_id, $feed_id) {
		$deletesql = "DELETE FROM feed_content WHERE feed_id=:feed_id AND source_content_id=:story_id";
		$query = $this->conn->prepare($deletesql);
		$query->bindParam(":feed_id", $feed_id);
		$query->bindParam(":story_id", $story_id);
		$query->execute();
	}
	
	public function get_feed_stories($id) {
		$selectsql = "SELECT * FROM source_content WHERE id IN (SELECT source_content_id FROM feed_content WHERE feed_id=:feed_id) ORDER BY date DESC";
		$query = $this->conn->prepare($selectsql);
		$query->bindParam(":feed_id",$id);
		$query->execute();
		return $query->fetchAll();
	}
}
?>
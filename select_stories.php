<?php
require_once 'db.php';

new select_stories();

class select_stories {
	private $db;
	
	public function __construct() {
		$this->db = new database();
		if(isset($_POST['submit'])) {
			foreach($_POST['story_id'] as $id) {
				$this->db->add_story($id);
			}
		} else if(isset($_POST['delete'])) {
			foreach($_POST['delete_story'] as $id) {
				$this->db->delete_story($id, 1);
			}
		}
		include 'header.php';
		$this->print_page();
	}
	
	public function print_page() {
		echo '
			<html>
			<head>
				<title>Story Selection</title>
				<meta http-equiv="Content-Type"
				    content="text/html; charset=UTF-8" />
				<style type="text/css">
					#source_feeds {
						float:left;
						width: 50%;
					}
					#output_feeds {
						float:right;
						$width: 50%;
					}
				</style>
			</head>
			<body>
			<div id="source_feeds">
				'.$this->print_source_feeds().'
			</div>
			<div id="output_feed">
				'.$this->print_output_feeds().'
			</div>
			</body>
		';
	}
	
	public function print_source_feeds() {
		$stories = $this->db->get_source_stories();
		$output .= '<h1>Available Stories</h1>';
		$output .= '<form name="source_stories" method="POST"><table>';
		foreach($stories as $story) {
			$output .= '<tr><td>';
			$output .= '<input type="checkbox" name="story_id[]" value="'.$story['id'].'" />';
			$output .= '</td><td>';
			$output .= '<a href="'.$story['url'].'">'.$story['title'].'</a>';
			$output .= '</td><td>';
			$output .= substr($story['description'],0,200);
			$output .= '</td></tr>';
		}
		$output .= '</table><input type="submit" name="submit" value="Submit" /></form>';
		return $output;
	}
	
	public function print_output_feeds() {
		$stories = $this->db->get_feed_stories(1);
		$output .= '<h1>Stories in Feed</h1>';
		$output .= '<form name="source_stories" method="POST" ><table>';
		foreach($stories as $story) {
			$output .= '<tr><td>';
			$output .= '<input type="checkbox" name="delete_story[]" value="'.$story['id'].'" />';
			$output .= '</td><td>';
			$output .= '<a href="'.$story['url'].'">'.$story['title'].'</a>';
			$output .= '</td><td>';
			$output .= substr($story['description'],0,200);
			$output .= '</td></tr>';
			
		}
		$output .= '</table><input type="submit" name="delete" value="Delete" /></form>';
		return $output;
	}
	
}

?>
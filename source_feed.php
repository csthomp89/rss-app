<?php
session_start();
require_once 'db.php';

new source_feed();

class source_feed {
	private $db;	
	
	public function __construct() {
		$this->db = new database();
		if(isset($_POST['new'])) {
			$this->db->add_feed($_POST['description'],$_POST['url']);
		} else if (isset($_POST['delete'])) {
			foreach($_POST['delete_feed'] as $id) {
				$this->db->delete_feed($id);
			}
		}
		include 'header.php';
		echo $this->print_page();
	}
	
	public function print_feeds() {
		$feed_list = $this->db->get_feed_list();
		$output .= '<form name="sources" method="POST" ><table>';
		foreach($feed_list as $item) {
			$output .= '<tr><td>';
			$output .= '<input type="checkbox" name="delete_feed[]" value="'.$item['id'].'" />';
			$output .= "</td><td>";
			$output .= $item['title'];
			$output .= '</td><td>';
			$output .= '<a href="'.$item['url'].'">'.$item['url'].'</a>';
			$output .= '</td></tr>';
		}
		$output .= '</table><input type="submit" name="delete" value="Delete Feed" /></form>';
		return $output;
	}
	
	public function print_form() {
		$output .= '
			<form name="new_feed" method="POST" action="source_feed.php">
				Feed: <input type="text" name="url" /><br />
				Description <input type="text" name="description" /><br />
				<input type="submit" name="new" value="Submit" />
			</form>
		';
		return $output;
	}
	
	public function print_page() {
		$output .= '
			<html>
			<head>
				<title>RSS Feeds</title>
			</head>
			<body>
				'. $this->print_form(). '<br />' . $this->print_feeds().'
			</body>
			</html>
		';
		return $output;
	}
}

?>
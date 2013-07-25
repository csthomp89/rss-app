<?php
require_once 'db.php';

new feed();

class feed {
	private $db;
	
	public function __construct() {
		$this->db = new database();
		echo $this->output_feed(1);
	}
	
	public function output_feed($id) {
		$feed = $this->db->get_feed_info($id);
		$stories = $this->db->get_feed_stories($id);
		
		$output .= '<rss version="2.0">
		<channel>
		    <title>'.htmlspecialchars($feed[0]['title']).'</title>
		    <link>'.htmlspecialchars($feed[0]['link']).'</link>
		    <description>'.htmlspecialchars($feed[0]['description']).'</description>
		    <language>en-us</language>';
			
		    foreach($stories as $story) {
		    $output .= '<item>';
		        $output .= '<title>' . htmlspecialchars($story['title']) .'</title>';
		        $output .= '<link>' . htmlspecialchars($story['url']) . '</link>';
		        $output .= '<guid isPermaLink="true">' . htmlspecialchars($story['guid']) . '</guid>';
		        $output .= '<description>'. htmlspecialchars($story['description']) .'</description>';
		        $output .= '<pubDate>' . date('r',strtotime($story['date'])) . '</pubDate>';
		        $output .= '</item>';
		    }
		$output .= '</channel>
		</rss>';
		return $output;
	}
	
}

?>
<?php

require_once 'db.php';

new load_feeds();

class load_feeds {
	private $db;
	
	public function __construct() {
		$this->db = new database();
		$this->refresh();
		include 'header.php';
		echo 'Feeds refreshed!';
	}

	public function refresh() {
		$feeds = $this->db->get_feed_list();
		foreach($feeds as $feed) {
			$ch = curl_init($feed['url']);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			#curl_setopt($ch, CURLOPT_HEADER, 0);

			$output = curl_exec($ch);

			curl_close($ch);

			$doc = new SimpleXmlElement($output, LIBXML_NOCDATA);
			
			foreach($doc->channel->item as $item) {
				$this->db->add_source_content(
				$feed['id'],
				$item->title,
				$item->description,
				$item->link,
				date('Y-m-d H:i:s', strtotime($item->pubDate)),
				$item->guid
				);
			}
		}
	}

}

?>
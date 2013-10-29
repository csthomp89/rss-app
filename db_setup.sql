--
-- Database: `rss`
--

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `lastBuild` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pubDate` datetime NOT NULL,
  `ttl` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `feed_content`
--

CREATE TABLE `feed_content` (
  `feed_id` int(11) NOT NULL,
  `source_content_id` int(11) NOT NULL,
  PRIMARY KEY (`feed_id`,`source_content_id`),
  KEY `source_content_id` (`source_content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

CREATE TABLE `sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `source_content`
--

CREATE TABLE `source_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `guid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  UNIQUE KEY `url_2` (`url`),
  KEY `feed_id` (`feed_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=480 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feed_content`
--
ALTER TABLE `feed_content`
  ADD CONSTRAINT `feed_content_ibfk_1` FOREIGN KEY (`source_content_id`) REFERENCES `source_content` (`id`),
  ADD CONSTRAINT `feed_content_ibfk_2` FOREIGN KEY (`feed_id`) REFERENCES `feeds` (`id`);

--
-- Constraints for table `source_content`
--
ALTER TABLE `source_content`
  ADD CONSTRAINT `source_content_ibfk_1` FOREIGN KEY (`feed_id`) REFERENCES `sources` (`id`);

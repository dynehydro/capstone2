DROP DATABASE IF EXISTS siremmanuel_db_wbapp;
CREATE DATABASE IF NOT EXISTS siremmanuel_db_wbapp;
USE siremmanuel_db_wbapp;

-- Create tbl_gallery table
DROP TABLE IF EXISTS `tbl_gallery`;
CREATE TABLE `tbl_gallery` (
  `gallery_id` int(8) unsigned NOT NULL auto_increment,
  `image_id` int(8) unsigned NOT NULL,
  `gallery_name` varchar(100) NOT NULL,
  `gallery_image` text NOT NULL,
  `gallery_link` text,
  `image_name` varchar(255) NOT NULL,
  `gallery_location` varchar(255) NOT NULL,
  `gallery_description` text,
  `gallery_curator` varchar(100) NOT NULL,
  `gallery_contact_no` int(20) NOT NULL,
  PRIMARY KEY (`gallery_id`)  
);

-- Create tbl_art_pieces table
DROP TABLE IF EXISTS `tbl_art_pieces`;
CREATE TABLE `tbl_art_pieces` (
  `artpiece_id` int(8) unsigned NOT NULL auto_increment,
  `artpiece_title` varchar(255) NOT NULL,
  `artpiece_artist` varchar(100) NOT NULL,
  `artpiece_description` text,
  `artpiece_status` varchar(50),
  `gallery_id` int(8) unsigned NOT NULL,
  `artpiece_medium` varchar(100),
  `artpiece_creation_date` date,
  `artpiece_price` decimal(10,2),
  `artpiece_dimensions` varchar(50),
  `artpiece_image` text NOT NULL,
  PRIMARY KEY (`artpiece_id`),
  FOREIGN KEY (`gallery_id`) REFERENCES tbl_gallery(`gallery_id`)
);

-- Create tbl_users table (updated with role field)
DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `user_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_lastname` VARCHAR(180) NOT NULL,
  `user_firstname` VARCHAR(180) NOT NULL,
  `user_email` VARCHAR(255) NOT NULL UNIQUE,
  `user_password` VARCHAR(255) NOT NULL,
  `user_added` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `user_updated` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_status` TINYINT(1) NOT NULL DEFAULT 0,
  `user_access` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
  `is_admin` BOOLEAN DEFAULT 0,
  PRIMARY KEY (`user_id`)
);

-- Create tbl_tours table
DROP TABLE IF EXISTS `tbl_tours`;
CREATE TABLE `tbl_tours` (
  `tour_id` int(8) unsigned NOT NULL auto_increment,
  `gallery_id` int(8) unsigned NOT NULL,
  `tour_image` varchar(100) NOT NULL,
  PRIMARY KEY (`tour_id`),
  FOREIGN KEY (`gallery_id`) REFERENCES tbl_gallery(`gallery_id`)
);

-- Create tbl_auctions table
DROP TABLE IF EXISTS `tbl_auctions`;
CREATE TABLE `tbl_auctions` (
  `auction_id` int(8) unsigned NOT NULL auto_increment,
  `gallery_id` int(8) unsigned NOT NULL,
  `artpiece_id` int(8) unsigned NOT NULL,
  `artpiece_title` varchar(255) NOT NULL,
  `artpiece_price` decimal(10,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `starting_bid` decimal(10,2),
  `current_bid` decimal(10,2),
  `highestbidder_id` int(11) unsigned,
  `auction_status` enum('open', 'closed', 'ended') DEFAULT 'open',
  `auction_description` text,
  PRIMARY KEY (`auction_id`),
  FOREIGN KEY (`gallery_id`) REFERENCES tbl_gallery(`gallery_id`),
  FOREIGN KEY (`artpiece_id`) REFERENCES tbl_art_pieces(`artpiece_id`),
  FOREIGN KEY (`highestbidder_id`) REFERENCES tbl_users(`user_id`)
);

-- Create tbl_bids table
DROP TABLE IF EXISTS `tbl_bids`;
CREATE TABLE `tbl_bids` (
  `bids_id` int(8) unsigned NOT NULL auto_increment,
  `auction_id` int(8) unsigned NOT NULL,
  `user_id` int(8) unsigned NOT NULL,
  `bids_amount` decimal(10,2) NOT NULL,
  `bids_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`bids_id`),
  FOREIGN KEY (`auction_id`) REFERENCES `tbl_auctions`(`auction_id`),
  FOREIGN KEY (`user_id`) REFERENCES tbl_users(`user_id`)
);

-- Create tbl_transactions table
DROP TABLE IF EXISTS `tbl_transactions`;
CREATE TABLE `tbl_transactions` (
  `transaction_id` int(8) unsigned NOT NULL auto_increment,
  `auction_id` int(8) unsigned NOT NULL,
  `user_id` int(8) unsigned NOT NULL,
  `gallery_id` int(8) unsigned NOT NULL,
  `artpiece_id` int(8) unsigned NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `transaction_date` date,
  PRIMARY KEY (`transaction_id`),
  FOREIGN KEY (`auction_id`) REFERENCES tbl_auctions(`auction_id`),
  FOREIGN KEY (`user_id`) REFERENCES tbl_users(`user_id`),
  FOREIGN KEY (`gallery_id`) REFERENCES tbl_gallery(`gallery_id`),
  FOREIGN KEY (`artpiece_id`) REFERENCES tbl_art_pieces(`artpiece_id`)
);

-- Forum Module: Create tbl_forum_posts table
DROP TABLE IF EXISTS `tbl_forum_posts`;
CREATE TABLE `tbl_forum_posts` (
  `post_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(8) UNSIGNED NOT NULL,
  `post_title` VARCHAR(255) NOT NULL,
  `post_content` TEXT NOT NULL,
  `post_image` TEXT, -- Optional field for attached images
  `post_created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `post_updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  FOREIGN KEY (`user_id`) REFERENCES `tbl_users`(`user_id`)
);

-- Forum Module: Create tbl_forum_comments table
DROP TABLE IF EXISTS `tbl_forum_comments`;
CREATE TABLE `tbl_forum_comments` (
  `comment_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` INT(8) UNSIGNED NOT NULL,
  `user_id` INT(8) UNSIGNED NOT NULL,
  `comment_content` TEXT NOT NULL,
  `comment_created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  FOREIGN KEY (`post_id`) REFERENCES `tbl_forum_posts`(`post_id`),
  FOREIGN KEY (`user_id`) REFERENCES `tbl_users`(`user_id`)
);

-- Create tbl_likes table
DROP TABLE IF EXISTS `tbl_likes`;
CREATE TABLE `tbl_likes` (
  `like_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` INT(8) UNSIGNED NOT NULL,
  `user_id` INT(8) UNSIGNED NOT NULL,
  `like_type` ENUM('like', 'dislike') NOT NULL,
  `like_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`like_id`)
);

CREATE TABLE tbl_forum (
    forum_id INT AUTO_INCREMENT PRIMARY KEY,
    forum_title VARCHAR(255) NOT NULL,
    forum_description TEXT,
    forum_status ENUM('active', 'inactive') DEFAULT 'active',
    post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Added post_date column
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

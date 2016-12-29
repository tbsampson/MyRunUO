-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2016 at 11:21 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `myrunuo`
--

-- --------------------------------------------------------

--
-- Table structure for table `myrunuo_characters`
--

CREATE TABLE IF NOT EXISTS `myrunuo_characters` (
  `char_id` int(12) unsigned DEFAULT NULL,
  `char_name` varchar(150) DEFAULT NULL,
  `char_title` varchar(150) DEFAULT NULL,
  `char_race` varchar(150) DEFAULT NULL,
  `char_body` varchar(10) NOT NULL,
  `char_str` int(3) unsigned DEFAULT NULL,
  `char_dex` int(3) unsigned DEFAULT NULL,
  `char_int` int(3) unsigned DEFAULT NULL,
  `char_female` int(2) unsigned DEFAULT NULL,
  `char_counts` int(3) unsigned DEFAULT NULL,
  `char_guild` varchar(4) DEFAULT NULL,
  `char_guildtitle` varchar(150) DEFAULT NULL,
  `char_nototitle` varchar(150) DEFAULT NULL,
  `char_bodyhue` int(3) unsigned DEFAULT NULL,
  `char_karma` int(6) DEFAULT NULL,
  `char_fame` int(6) DEFAULT NULL,
  `char_public` int(1) unsigned DEFAULT '1',
  UNIQUE KEY `char_id_2` (`char_id`),
  KEY `char_id` (`char_id`),
  KEY `char_guild` (`char_guild`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `myrunuo_characters_layers`
--

CREATE TABLE IF NOT EXISTS `myrunuo_characters_layers` (
  `char_id` int(12) unsigned DEFAULT NULL,
  `layer_id` int(3) unsigned DEFAULT NULL,
  `item_id` int(12) unsigned DEFAULT NULL,
  `item_hue` int(3) unsigned DEFAULT NULL,
  KEY `charid` (`char_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `myrunuo_characters_skills`
--

CREATE TABLE IF NOT EXISTS `myrunuo_characters_skills` (
  `char_id` int(12) unsigned DEFAULT NULL,
  `skill_id` int(3) unsigned DEFAULT NULL,
  `skill_value` int(3) unsigned DEFAULT NULL,
  KEY `charid` (`char_id`),
  KEY `skillid` (`skill_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `myrunuo_guilds`
--

CREATE TABLE IF NOT EXISTS `myrunuo_guilds` (
  `guild_id` varchar(4) DEFAULT NULL,
  `guild_name` varchar(150) DEFAULT NULL,
  `guild_abbreviation` varchar(4) DEFAULT NULL,
  `guild_website` varchar(150) DEFAULT NULL,
  `guild_charter` varchar(250) DEFAULT NULL,
  `guild_type` varchar(8) DEFAULT NULL,
  `guild_wars` int(3) unsigned DEFAULT NULL,
  `guild_members` int(3) unsigned DEFAULT NULL,
  `guild_master` int(12) unsigned DEFAULT NULL,
  KEY `guild_id` (`guild_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `myrunuo_guilds_wars`
--

CREATE TABLE IF NOT EXISTS `myrunuo_guilds_wars` (
  `guild_1` varchar(4) DEFAULT NULL,
  `guild_2` varchar(4) DEFAULT NULL,
  KEY `guild1` (`guild_1`),
  KEY `guild2` (`guild_2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `myrunuo_status`
--

CREATE TABLE IF NOT EXISTS `myrunuo_status` (
  `char_id` int(12) unsigned DEFAULT NULL,
  `char_location` varchar(14) DEFAULT NULL,
  `char_map` varchar(8) DEFAULT NULL,
  `char_karma` int(6) DEFAULT NULL,
  `char_fame` int(6) DEFAULT NULL,
  KEY `charid` (`char_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `myrunuo_timestamps`
--

CREATE TABLE IF NOT EXISTS `myrunuo_timestamps` (
  `time_datetime` varchar(22) DEFAULT NULL,
  `time_type` varchar(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `myrunuo_updates`
--

CREATE TABLE IF NOT EXISTS `myrunuo_updates` (
  `last_update` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


--
-- Table structure for table `myrunuo_skills`
--
CREATE TABLE IF NOT EXISTS `myrunuo_skills` (
  `id` int(3) NOT NULL,
  `short_name` varchar(25) NOT NULL,
  `long_name` varchar(50) NOT NULL,
  `uo_guide_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `myrunuo_skills`
--

INSERT INTO `myrunuo_skills` (`id`, `short_name`, `long_name`, `uo_guide_name`) VALUES
(0, 'Alchemy', 'Alchemy', 'Alchemy'),
(1, 'Anatomy', 'Anatomy', 'Anatomy'),
(2, 'AnimalLore', 'Animal Lore', 'Animal_Lore'),
(3, 'ItemID', 'Item Identification', 'Item_Identification'),
(4, 'ArmsLore', 'Arms Lore', 'Arms_Lore'),
(5, 'Parry', 'Parry', 'Parry'),
(6, 'Begging', 'Begging', 'Begging'),
(7, 'Blacksmith', 'Blacksmithy', 'Blacksmithy'),
(8, 'Fletching', 'Bowcraft & Fletching', 'Bowcraft_%26_Fletching'),
(9, 'Peacemaking', 'Peacemaking', 'Peacemaking'),
(10, 'Camping', 'Camping', 'Camping'),
(11, 'Carpentry', 'Carpentry', 'Carpentry'),
(12, 'Cartography', 'Cartography', 'Cartography'),
(13, 'Cooking', 'Cooking', 'Cooking'),
(14, 'DetectHidden', 'Detecting Hidden', 'Detecting_Hidden'),
(15, 'Discordance', 'Discordance', 'Discordance'),
(16, 'EvalInt', 'Evaluating Intelligence', 'Evaluating_Intelligence'),
(17, 'Healing', 'Healing', 'Healing'),
(18, 'Fishing', 'Fishing', 'Fishing'),
(19, 'Forensics', 'Forensic Evalutation', 'Forensic_Evalutation'),
(20, 'Herding', 'Herding', 'Herding'),
(21, 'Hiding', 'Hiding', 'Hiding'),
(22, 'Provocation', 'Provocation', 'Provocation'),
(23, 'Inscribe', 'Inscription', 'Inscription'),
(24, 'Lockpicking', 'Lockpicking', 'Lockpicking'),
(25, 'Magery', 'Magery', 'Magery'),
(26, 'MagicResist', 'Resisting Spells', 'Resisting_Spells'),
(27, 'Tactics', 'Tactics', 'Tactics'),
(28, 'Snooping', 'Snooping', 'Snooping'),
(29, 'Musicianship', 'Musicianship', 'Musicianship'),
(30, 'Poisoning', 'Poisoning', 'Poisoning'),
(31, 'Archery', 'Archery', 'Archery'),
(32, 'SpiritSpeak', 'Spirit Speak', 'Spirit_Speak'),
(33, 'Stealing', 'Stealing', 'Stealing'),
(34, 'Tailoring', 'Tailoring', 'Tailoring'),
(35, 'AnimalTaming', 'Animal Taming', 'Animal_Taming'),
(36, 'TasteID', 'Taste Identification', 'Taste_Identification'),
(37, 'Tinkering', 'Tinkering', 'Tinkering'),
(38, 'Tracking', 'Tracking', 'Tracking'),
(39, 'Veterinary', 'Veterinary', 'Veterinary'),
(40, 'Swords', 'Swordsmanship', 'Swordsmanship'),
(41, 'Macing', 'Macing', 'Macing'),
(42, 'Fencing', 'Fencing', 'Fencing'),
(43, 'Wrestling', 'Wrestling', 'Wrestling'),
(44, 'Lumberjacking', 'Lumberjacking', 'Lumberjacking'),
(45, 'Mining', 'Mining', 'Mining'),
(46, 'Meditation', 'Meditation', 'Meditation'),
(47, 'Stealth', 'Stealth', 'Stealth'),
(48, 'RemoveTrap', 'Remove Trap', 'Remove_Trap'),
(49, 'Necromancy', 'Necromancy', 'Necromancy'),
(50, 'Focus', 'Focus', 'Focus'),
(51, 'Chivalry', 'Chivalry', 'Chivalry'),
(52, 'Bushido', 'Bushido', 'Bushido'),
(53, 'Ninjitsu', 'Ninjitsu', 'Ninjitsu'),
(54, 'Spellweaving', 'Spellweaving', 'Spellweaving'),
(55, 'Mysticism', 'Mysticism', 'Mysticism'),
(56, 'Imbuing', 'Imbuing', 'Imbuing'),
(57, 'Throwing', 'Throwing', 'Throwing');


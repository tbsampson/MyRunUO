-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2016 at 05:58 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

--
-- Database: `myrunuo`
--

-- --------------------------------------------------------

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

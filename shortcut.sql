-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2014 at 06:22 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `shortcut`
--

-- --------------------------------------------------------

--
-- Table structure for table `application`
--

CREATE TABLE IF NOT EXISTS `application` (
  `id_application` int(11) NOT NULL AUTO_INCREMENT,
  `id_applicant` int(11) NOT NULL,
  `id_job` int(11) NOT NULL,
  `apply_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invite_code` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id_application`),
  KEY `id_application_user_idx` (`id_applicant`),
  KEY `id_application_job_idx` (`id_job`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id_company` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) NOT NULL,
  `company_address` varchar(200) DEFAULT NULL,
  `company_description` text,
  `cellphone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_company`),
  UNIQUE KEY `company_name_UNIQUE` (`company_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id_company`, `company_name`, `company_address`, `company_description`, `cellphone`) VALUES
(8, 'IBM', 'Englewood Cliffs', 'IBM is committed to creating a diverse environment and is proud to be an equal opportunity employer. All qualified applicants will receive consideration for employment without regard to race, color, religion, gender, gender identity or expression, sexual orientation, national origin, genetics, disability, age, or veteran status. IBM is also committed to compliance with all fair employment practices regarding citizenship and immigration status.', '8007969876'),
(9, 'Stevens Institute of Technology', 'Hoboken', 'A good university.', '070305991'),
(10, 'Shortcut ', 'Hoboken', 'Job search engine.', '9171111111'),
(11, 'Society', 'U.S', 'Society is a big company.', '9171234567');

-- --------------------------------------------------------

--
-- Table structure for table `invitation`
--

CREATE TABLE IF NOT EXISTS `invitation` (
  `id_invitation` int(11) NOT NULL AUTO_INCREMENT,
  `id_invitor` int(11) NOT NULL,
  `id_invitee` int(11) NOT NULL,
  `id_job` int(11) NOT NULL,
  `invite_code` varchar(64) NOT NULL,
  `invite_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `applied` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_invitation`),
  KEY `id_invitor_user_idx` (`id_invitor`),
  KEY `id_intitee_user_idx` (`id_invitee`),
  KEY `id_invitjob_job_idx` (`id_job`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE IF NOT EXISTS `job` (
  `id_job` int(11) NOT NULL AUTO_INCREMENT,
  `job_title` varchar(100) NOT NULL,
  `job_description` text NOT NULL,
  `job_location` varchar(100) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  PRIMARY KEY (`id_job`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`id_job`, `job_title`, `job_description`, `job_location`, `expire_date`) VALUES
(35, 'Customer Solutions Engineer', 'The SalesTech team is a solution-generating force that helps our sales teams and advertisers.', 'san jose', '2014-07-27');

-- --------------------------------------------------------

--
-- Table structure for table `job_post`
--

CREATE TABLE IF NOT EXISTS `job_post` (
  `id_job_post` int(11) NOT NULL AUTO_INCREMENT,
  `id_poster` int(11) NOT NULL,
  `id_job` int(11) NOT NULL,
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_job_post`),
  KEY `id_job_post_user_idx` (`id_poster`),
  KEY `id_job_post_job_idx` (`id_job`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `job_post`
--

INSERT INTO `job_post` (`id_job_post`, `id_poster`, `id_job`, `post_time`) VALUES
(22, 12, 35, '2014-07-01 04:45:00');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id_module` int(11) NOT NULL AUTO_INCREMENT,
  `module_code` varchar(50) NOT NULL,
  `module_text` varchar(50) NOT NULL,
  `module_description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_module`),
  UNIQUE KEY `module_code_UNIQUE` (`module_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id_module`, `module_code`, `module_text`, `module_description`) VALUES
(1, 'jobmanagement', 'Job Management', 'post new jobs'),
(2, 'profile', 'Profile', 'Personal page'),
(3, 'administration', 'Site Administration', 'Only for administrat'),
(4, 'searchcandidate', 'Search Candidates', 'Search Candidates'),
(5, 'applicationmanagement', 'Application Management', 'Application Manageme');

-- --------------------------------------------------------

--
-- Table structure for table `resume`
--

CREATE TABLE IF NOT EXISTS `resume` (
  `id_resume` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `content` mediumblob NOT NULL,
  PRIMARY KEY (`id_resume`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `role_code` varchar(20) NOT NULL,
  `role_description` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `id_role_UNIQUE` (`id_role`),
  UNIQUE KEY `role_code_UNIQUE` (`role_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `role_code`, `role_description`) VALUES
(1, 'admin', 'administrator'),
(2, 'hr', 'recruiter'),
(3, 'standard', 'standard user');

-- --------------------------------------------------------

--
-- Table structure for table `role_module`
--

CREATE TABLE IF NOT EXISTS `role_module` (
  `id_role_module` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(11) NOT NULL,
  `id_module` int(11) NOT NULL,
  PRIMARY KEY (`id_role_module`),
  KEY `id_role_module_role_idx` (`id_role`),
  KEY `id_role_module_module_idx` (`id_module`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `role_module`
--

INSERT INTO `role_module` (`id_role_module`, `id_role`, `id_module`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 1, 1),
(5, 1, 4),
(6, 2, 4),
(7, 2, 5),
(8, 1, 2),
(9, 1, 3),
(10, 1, 5),
(11, 3, 2),
(12, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(20) NOT NULL,
  `login_pwd` varchar(64) NOT NULL,
  `fullname` varchar(45) NOT NULL,
  `cellphone` varchar(16) NOT NULL,
  `email` varchar(30) NOT NULL,
  `id_role` int(11) NOT NULL,
  `resume` text NOT NULL,
  `career` varchar(20) DEFAULT NULL,
  `location` varchar(20) DEFAULT NULL,
  `id_resume` int(11) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_user_UNIQUE` (`id_user`),
  UNIQUE KEY `login_name_UNIQUE` (`login_name`),
  KEY `id_user_role_idx` (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `login_name`, `login_pwd`, `fullname`, `cellphone`, `email`, `id_role`, `resume`, `career`, `location`, `id_resume`) VALUES
(12, 'bkwang', 'd17f25ecfbcc7857f7bebea469308be0b2580943e96d13a3ad98a13675c4bfc2', 'Baokun Wang', '9171111111', 'abc@stevens.edu', 1, 'I''m administrator.', 'Software Engineer', 'Hoboken', 0),
(17, 'di', 'd17f25ecfbcc7857f7bebea469308be0b2580943e96d13a3ad98a13675c4bfc2', 'Di Ren', '9171111111', 'di@gmail.com', 3, 'I''m an happy engineer. I like PHP.', 'Software Engineer', 'Hoboken', 0),
(18, 'ibm_jack', 'd17f25ecfbcc7857f7bebea469308be0b2580943e96d13a3ad98a13675c4bfc2', 'Jack lee', '9171111111', 'jack@gmail.com', 2, 'I''m a happy hr. I like hiring!', 'Human Resource', 'Hoboken', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_company`
--

CREATE TABLE IF NOT EXISTS `user_company` (
  `id_user_company` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_company` int(11) NOT NULL,
  PRIMARY KEY (`id_user_company`),
  KEY `id_uc_user_idx` (`id_user`),
  KEY `id_uc_company_idx` (`id_company`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `user_company`
--

INSERT INTO `user_company` (`id_user_company`, `id_user`, `id_company`) VALUES
(11, 12, 10),
(12, 18, 8),
(13, 17, 11);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `id_application_applicant_user` FOREIGN KEY (`id_applicant`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_application_job` FOREIGN KEY (`id_job`) REFERENCES `job` (`id_job`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `invitation`
--
ALTER TABLE `invitation`
  ADD CONSTRAINT `id_intitee_user` FOREIGN KEY (`id_invitee`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_invitjob_job` FOREIGN KEY (`id_job`) REFERENCES `job` (`id_job`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_invitor_user` FOREIGN KEY (`id_invitor`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `job_post`
--
ALTER TABLE `job_post`
  ADD CONSTRAINT `id_job_post_job` FOREIGN KEY (`id_job`) REFERENCES `job` (`id_job`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_job_post_user` FOREIGN KEY (`id_poster`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `role_module`
--
ALTER TABLE `role_module`
  ADD CONSTRAINT `id_role_module_module` FOREIGN KEY (`id_module`) REFERENCES `module` (`id_module`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_role_module_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `id_user_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_company`
--
ALTER TABLE `user_company`
  ADD CONSTRAINT `id_uc_company` FOREIGN KEY (`id_company`) REFERENCES `company` (`id_company`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `id_uc_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

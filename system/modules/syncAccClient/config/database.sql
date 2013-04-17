-- ********************************************************
-- *                                                      *
-- * IMPORTANT NOTE                                       *
-- *                                                      *
-- * Do not import this file manually but use the Contao  *
-- * install tool to create and maintain database tables! *
-- *                                                      *
-- ********************************************************

-- --------------------------------------------------------

-- 
-- Table `tl_member`
-- 

CREATE TABLE `tl_member` (
  `syncacc` char(1) NOT NULL default '',
  `sync_acc_master` varchar(255) NOT NULL default '',
  UNIQUE KEY `username` (`username`, `email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- Table `tl_user`
-- 

CREATE TABLE `tl_user` (
  `syncacc` char(1) NOT NULL default '',
  `sync_acc_master` varchar(255) NOT NULL default '',
  UNIQUE KEY `username` (`username`, `email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Database: 'CrashCards'
-- --------------------------------------------------------

--
-- Table structure for table 'cccourses'
--

CREATE TABLE IF NOT EXISTS cccourses (
  coursecode varchar(6) NOT NULL,
  `subject` varchar(25) NOT NULL,
  PRIMARY KEY (coursecode),
  KEY `subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'ccdecks'
--

CREATE TABLE IF NOT EXISTS ccdecks (
  deckid int(10) NOT NULL AUTO_INCREMENT,
  creatorid int(10) NOT NULL,
  title varchar(25) NOT NULL,
  coursecode varchar(6) NOT NULL,
  `subject` varchar(25) NOT NULL,
  tstamp datetime NOT NULL,
  upv int(5) NOT NULL DEFAULT '0',
  dnv int(5) NOT NULL DEFAULT '0',
  cardcount int(2) NOT NULL DEFAULT '0',
  pubed int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (deckid),
  KEY coursecode (coursecode),
  KEY creatorid (creatorid),
  KEY `subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table 'ccsubjects'
--

CREATE TABLE IF NOT EXISTS ccsubjects (
  `subject` varchar(25) NOT NULL,
  PRIMARY KEY (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'ccusers'
--

CREATE TABLE IF NOT EXISTS ccusers (
  uid int(10) NOT NULL AUTO_INCREMENT,
  email varchar(100) NOT NULL,
  `name` varchar(25) NOT NULL,
  alias varchar(25) NOT NULL,
  pass varchar(100) NOT NULL,
  PRIMARY KEY (uid),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for table `cccourses`
--
ALTER TABLE `cccourses`
  ADD CONSTRAINT cccourses_ibfk_1 FOREIGN KEY (`subject`) REFERENCES ccsubjects (`subject`);

--
-- Constraints for table `ccdecks`
--
ALTER TABLE `ccdecks`
  ADD CONSTRAINT ccdecks_ibfk_4 FOREIGN KEY (`subject`) REFERENCES ccsubjects (`subject`),
  ADD CONSTRAINT ccdecks_ibfk_2 FOREIGN KEY (creatorid) REFERENCES ccusers (uid) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ccdecks_ibfk_3 FOREIGN KEY (coursecode) REFERENCES cccourses (coursecode);
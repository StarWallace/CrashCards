-- Database: 'CrashCards'
-- --------------------------------------------------------
DROP TABLE IF EXISTS ccClips CASCADE;
DROP TABLE IF EXISTS ccViews CASCADE;
DROP TABLE IF EXISTS ccVotes CASCADE;
DROP TABLE IF EXISTS ccDecks CASCADE;
DROP TABLE IF EXISTS ccCourses CASCADE;
DROP TABLE IF EXISTS ccSubjects CASCADE;
DROP TABLE IF EXISTS ccUsers CASCADE;

--
-- Table structure for table 'ccCourses'
--


CREATE TABLE IF NOT EXISTS ccCourses (
  coursecode varchar(7) NOT NULL,
  `subject` varchar(25) NOT NULL,
  PRIMARY KEY (coursecode),
  KEY `subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'ccDecks'
--


CREATE TABLE IF NOT EXISTS ccDecks (
  deckid int(10) NOT NULL AUTO_INCREMENT,
  creatorid int(10) NOT NULL,
  title varchar(25) NOT NULL,
  coursecode varchar(7) NOT NULL,
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
-- Table structure for table 'ccSubjects'
--


CREATE TABLE IF NOT EXISTS ccSubjects (
  `subject` varchar(25) NOT NULL,
  PRIMARY KEY (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'ccUsers'
--


CREATE TABLE IF NOT EXISTS ccUsers (
  uid int(10) NOT NULL AUTO_INCREMENT,
  email varchar(100) NOT NULL,
  `name` varchar(25) NOT NULL,
  alias varchar(25) NOT NULL,
  pass varchar(100) NOT NULL,
  PRIMARY KEY (uid),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table 'ccVotes'
--


CREATE TABLE IF NOT EXISTS ccVotes (
  deckid int(10) NOT NULL,
  uid int(10) NOT NULL,
  isupv tinyint(1) NOT NULL,
  PRIMARY KEY (deckid,uid),
  KEY uid (uid),
  KEY deckid (deckid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'ccClips'
--


CREATE TABLE IF NOT EXISTS ccClips (
  uid int(10) NOT NULL,
  deckid int(10) NOT NULL,
  PRIMARY KEY (uid,deckid),
  KEY uid (uid),
  KEY deckid (deckid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table 'ccViews'
--


CREATE TABLE IF NOT EXISTS ccViews (
  deckid int(10) NOT NULL,
  uid int(10) NOT NULL,
  PRIMARY KEY (deckid,uid),
  KEY deckid (deckid),
  KEY uid (uid)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for table `ccCourses`
--
ALTER TABLE `ccCourses`
  ADD CONSTRAINT ccCourses_ibfk_1 FOREIGN KEY (`subject`) REFERENCES ccSubjects (`subject`);

--
-- Constraints for table `ccDecks`
--
ALTER TABLE `ccDecks`
  ADD CONSTRAINT ccDecks_ibfk_4 FOREIGN KEY (`subject`) REFERENCES ccSubjects (`subject`),
  ADD CONSTRAINT ccDecks_ibfk_2 FOREIGN KEY (creatorid) REFERENCES ccUsers (uid) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ccDecks_ibfk_3 FOREIGN KEY (coursecode) REFERENCES ccCourses (coursecode);

--
-- Constraints for table `ccVotes`
--
ALTER TABLE `ccVotes`
  ADD CONSTRAINT ccVotes_ibfk_2 FOREIGN KEY (uid) REFERENCES ccUsers (uid) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ccVotes_ibfk_1 FOREIGN KEY (deckid) REFERENCES ccDecks (deckid) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ccClips`
--
ALTER TABLE `ccClips`
  ADD CONSTRAINT ccClips_ibfk_2 FOREIGN KEY (deckid) REFERENCES ccDecks (deckid) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ccClips_ibfk_1 FOREIGN KEY (uid) REFERENCES ccUsers (uid) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ccViews`
--
ALTER TABLE `ccViews`
  ADD CONSTRAINT ccViews_ibfk_2 FOREIGN KEY (uid) REFERENCES ccUsers (uid) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT ccViews_ibfk_1 FOREIGN KEY (deckid) REFERENCES ccDecks (deckid) ON DELETE CASCADE ON UPDATE CASCADE;
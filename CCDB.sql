-- Database: `CrashCards`
-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS User (
  uid int(10) NOT NULL AUTO_INCREMENT,
  email varchar(100) NOT NULL,
  name varchar(25) NOT NULL,
  alias varchar(25) NOT NULL,
  pass varchar(100) NOT NULL,
  PRIMARY KEY (uid),
  UNIQUE KEY email (email)
) AUTO_INCREMENT=1 ;

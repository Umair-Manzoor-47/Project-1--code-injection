CREATE TABLE `member2` (
  `customerID` int(8) NOT NULL,
  `fullName` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(15) DEFAULT NULL,
  `groups` varchar(15) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `member2` (`customerID`, `fullName`, `email`, `password`, `groups`, `status`) VALUES
(1, 'C. Edward Chow', 'cchow@uccs.edu', 'cs00net', '-gold', 0),
(2, 'Wonderful Wu', 'hwwu@uccs.edu', 'hwwu0011', '-silver', 0),
(3, 'John Smith', 'jsmith@uccs.edu', 'cs00net', '-bronze', 0),
(4, 'Jane Kennedy', 'jk@uccs.edu', 'cs00net', '-normal', 0),
(5, 'Famous Dave', 'cs526@cs.uccs.edu', 'cs526', '-silver', 0),
(6, 'Charle Chuck', 'cs591@uccs.edu', 'netsec', '-gold', 0),
(7, 'Cyber Resil', 'cs691@uccs.edu', 'cyber', 'silver', 1),
(8, 'Porg Webb', 'cs3110@uccs.edu', '1234', 'gold', 1);


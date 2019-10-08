-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2018 at 04:42 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicare`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `updateCost` (IN `oid` INT)  MODIFIES SQL DATA
    DETERMINISTIC
BEGIN
DECLARE VAL INT;
DECLARE CNT INT;
DECLARE DNAME VARCHAR(30);

SET VAL = 0;
SET CNT = 0;

SELECT amount INTO CNT FROM orderdetails WHERE order_id=oid;
SELECT product_name INTO DNAME FROM orderdetails WHERE order_id=oid;
SELECT price INTO VAL FROM drug_info WHERE product_name=DNAME;

SET VAL = VAL*CNT;

UPDATE orderdetails SET tot_cost=VAL WHERE order_id=oid;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_amount` (IN `sid` INT, IN `pname` VARCHAR(40), IN `AMNT` INT)  NO SQL
BEGIN
DECLARE VAL INT;
DECLARE IDD INT;
SET VAL = 0;
SET IDD = 0;
SELECT amount INTO VAL FROM instore WHERE store_id=sid and product_name = pname;
SELECT id INTO IDD FROM instore WHERE store_id=sid and product_name = pname;

IF IDD =0 THEN
INSERT INTO instore(store_id,product_name,amount) VALUES (sid,pname,0);
END IF;

SET VAL=VAL+AMNT;
UPDATE instore SET amount=VAL WHERE store_id=sid and product_name = pname;

END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `CalcPrice_with_Vat` (`pName` VARCHAR(50), `amount` INT) RETURNS INT(11) MODIFIES SQL DATA
BEGIN
DECLARE TOT INT;
SET TOT=5;
SELECT price INTO TOT FROM drag_info WHERE product_name = pName;

SET TOT = TOT*amount;

RETURN TOT;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `Func` (`numb` INT(10), `pName` VARCHAR(50)) RETURNS INT(10) NO SQL
Begin
DECLARE TOT INT;
SET TOT = 10;

SELECT price INTO TOT FROM drag_info WHERE product_name = pName;

SET TOT = TOT*numb;

RETURN TOT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `drug_info`
--

CREATE TABLE `drug_info` (
  `product_name` varchar(40) NOT NULL,
  `generic_name` varchar(40) NOT NULL,
  `company` varchar(40) NOT NULL,
  `product_details` text NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `drug_info`
--

INSERT INTO `drug_info` (`product_name`, `generic_name`, `company`, `product_details`, `Price`) VALUES
('Ace', 'Paracetamol', 'Square Pharmaceuticals Ltd.', 'Indication:\r\nFever, headache, toothache, earache, bodyache, myalgia, dysmenorrhoea, neuralgia and sprains. Colic pain, back pain, chronic pain of cancer, inflammatory pain, and post-vaccination pain and fever of children. Rheumatism and osteoarthritic pain & stiffness of joints in fingers, hips, knees, wrists, elbows, feet, ankles and top & bottom of the spine.', 12),
('Ambrox', 'Ambroxol', 'Square Pharmaceuticals Ltd.', 'Indication:\r\nProductive cough, Acute and chronic inflammatory disorders of upper and lower respiratory tracts associated with viscid mucus including acute and chronic bronchitis, laryngitis, Pharyngitis, sinusitis and rhinitis associated with viscid mucus, Asthmatic bronchitis, bronchial asthma with thick expectoration, Bronchiectasis, Chronic pneumonia', 0),
('brolox', 'lobro', 'Square Pharmaceuticals Ltd.', 'Indication:\r\nProductive cough, Acute and chronic inflammatory disorders of upper and lower respiratory tracts associated with viscid mucus including acute and chronic bronchitis, laryngitis, Pharyngitis, sinusitis and rhinitis associated with viscid mucus, Asthmatic bronchitis, bronchial asthma with thick expectoration, Bronchiectasis, Chronic pneumonia', 0),
('Ceevit', 'Vitamin-C', 'Square Pharmaceuticals Ltd.', 'Indication:\r\nScurvy, pregnancy, lactation, infection, trauma, burns, cold exposure, following surgery, fever, stress, peptic ulcer, cancer, methaemoglobinaemia haematuria, dental caries, pyorrhea, acne, infertility, atherosclerosis, fractures, leg ulcers, hay fever, vascular thrombosis prevention, levodopa toxicity, succinyl-choline toxicity,arsenic toxicity etc.\r\n\r\nDosage & Administration:\r\n1-2 tablets daily.', 20),
('Fexo', 'Fexofenadine HCl', 'Square Pharmaceuticals Ltd.', '\r\n\r\nIndication:\r\nSeasonal allergic rhinitis & Chronic idiopathic urticaria\r\n\r\nPreparation:\r\nFexoTM 60 : Each box contains 5 x 10 tablets in blister pack.\r\nFexoTM 120 : Each box contains 5 x 10 tablets in blister pack.\r\nFexoTM 180 : Each box contains 3 x 10 tablets in blister pack.\r\nFexoTM Susupension: Each bottle contains 50 ml suspension and calibrated dropper & measuring cup.\r\nRevision\r\n', 33),
('Napa', 'Paracetamol', 'Square Pharmaceuticals Ltd.', 'Indication:\r\nProductive cough, Acute and chronic inflammatory disorders of upper and lower respiratory tracts associated with viscid mucus including acute and chronic bronchitis, laryngitis, Pharyngitis, sinusitis and rhinitis associated with viscid mucus, Asthmatic bronchitis, bronchial asthma with thick expectoration, Bronchiectasis, Chronic pneumonia', 0),
('ticothopy', 'tetrahexamin', 'Square Pharmaceuticals Ltd.', 'Indication:\r\nProductive cough, Acute and chronic inflammatory disorders of upper and lower respiratory tracts associated with viscid mucus including acute and chronic bronchitis, laryngitis, Pharyngitis, sinusitis and rhinitis associated with viscid mucus, Asthmatic bronchitis, bronchial asthma with thick expectoration, Bronchiectasis, Chronic pneumonia', 0),
('tripoli', 'itripoli', 'Square Pharmaceuticals Ltd.', 'Indication:\r\nProductive cough, Acute and chronic inflammatory disorders of upper and lower respiratory tracts associated with viscid mucus including acute and chronic bronchitis, laryngitis, Pharyngitis, sinusitis and rhinitis associated with viscid mucus, Asthmatic bronchitis, bronchial asthma with thick expectoration, Bronchiectasis, Chronic pneumonia', 0),
('Zimax', 'Azithromycin', 'Square Ltd.', '\r\n\r\nIndication:\r\nBronchitis and pneumonia, sinusitis and pharyngitis/ tonsillitis, in otitis media, and in skin and soft tissue infections, sexually transmitted diseases.\r\n\r\nDosage & Administration:\r\nAdults: 500 mg once daily for 3 days. Children: 10 mg/kg body weight once daily for 3 days.\r\n', 45);

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `hospital_id` int(11) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='store the details of hospital data';

-- --------------------------------------------------------

--
-- Table structure for table `instore`
--

CREATE TABLE `instore` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `product_name` varchar(40) DEFAULT NULL,
  `amount` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `instore`
--

INSERT INTO `instore` (`id`, `store_id`, `product_name`, `amount`) VALUES
(1, 3, 'Zimax', '9'),
(7, 7, 'Ace', '1'),
(8, 3, 'Ceevit', '4'),
(9, 7, 'Ceevit', '2'),
(10, 7, 'Fexo', '8'),
(11, 10, 'Ace', '100'),
(12, 10, 'Zimax', '19'),
(13, 13, 'Ace', '12'),
(14, 13, 'Ambrox', '20'),
(15, 13, 'brolox', '33'),
(16, 13, 'Ceevit', '5'),
(17, 13, 'Fexo', '6'),
(18, 13, 'ticothopy', '50'),
(19, 13, 'tripoli', '10'),
(20, 13, 'Zimax', '50'),
(21, 14, 'Ace', '89'),
(22, 14, 'Ambrox', '35'),
(23, 14, 'Ceevit', '120'),
(24, 14, 'Fexo', '196'),
(25, 14, 'Zimax', '540'),
(26, 7, 'brolox', '0'),
(27, 7, 'Napa', '75'),
(28, 7, 'ticothopy', '54'),
(29, 7, 'Zimax', '44'),
(30, 14, 'brolox', '100'),
(31, 14, 'Napa', '100'),
(32, 14, 'ticothopy', '100'),
(33, 14, 'tripoli', '200'),
(34, 15, 'Zimax', '20');

--
-- Triggers `instore`
--
DELIMITER $$
CREATE TRIGGER `afterupdate` AFTER UPDATE ON `instore` FOR EACH ROW BEGIN
INSERT INTO recent_update(store_id,product_name,prev_amount,new_amount,modify_date) VALUES (old.store_id,old.product_name,old.amount,new.amount,NOW());
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `order_id` int(11) NOT NULL,
  `product_name` varchar(40) NOT NULL,
  `store_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `customer_name` varchar(40) NOT NULL,
  `customer_mobile` text NOT NULL,
  `customer_address` text NOT NULL,
  `order_date` date NOT NULL,
  `tot_cost` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`order_id`, `product_name`, `store_id`, `amount`, `customer_name`, `customer_mobile`, `customer_address`, `order_date`, `tot_cost`) VALUES
(1, 'Ace', 7, 2, 'shahed', '1234', '5566', '0000-00-00', 24),
(2, 'Ace', 7, 1, 'shahed', '1234', '1445', '0000-00-00', 12),
(25, 'Ace', 7, 3, 'shahed', '01922922', 'IUT', '0000-00-00', 36),
(26, 'Ace', 7, 4, 'shahed', '018991212331', 'IUT', '0000-00-00', 48),
(28, 'Ace', 7, 10, 'Rakib', '01681454784', 'IUT', '0000-00-00', 120),
(29, 'Zimax', 13, 4, 'shahed', '01681454784', 'gtrrff ffg', '0000-00-00', 180),
(30, 'Ace', 14, 5, 'Imam', '01812231231', 'IUT', '0000-00-00', 60),
(31, 'Ceevit', 14, 5, 'Shahed Ahmed', '018991212331', 'IUT gate', '0000-00-00', 100),
(32, 'Ace', 7, 55, 'Shahed Ahmed', '01922922', 'IUT', '0000-00-00', 660),
(33, 'Ace', 14, 45, 'uchhas', '56789', 'IUT', '0000-00-00', 540),
(34, 'Ace', 14, 5, 'Kazi Atikur Islam', '01817665433', 'IUT', '0000-00-00', 60),
(35, 'Napa', 7, 20, 'shahed ahmed', '01681454784', 'IUT', '0000-00-00', 0),
(36, 'Zimax', 14, 50, 'Shahed Ahmed', '01922922', 'IUT', '0000-00-00', 2250),
(37, 'Zimax', 13, 10, 'Shahed Ahmed', '01681454784', 'IUT', '0000-00-00', 450),
(38, 'Zimax', 7, 20, 'shaon', '12343212', 'iut', '0000-00-00', 900),
(39, 'Zimax', 14, 500, 'tanvir', '01681454784', 'IUT  N-528', '0000-00-00', 22500),
(40, 'Zimax', 15, 15, 'gaab', '11223345', 'IUT  N-528', '0000-00-00', 675),
(41, 'Ace', 13, 10, 'shahed', '01681454784', 'IUT', '0000-00-00', 120),
(42, 'Zimax', 13, 1, 'shahed', '018991212331', 'IUT', '0000-00-00', 45),
(43, 'Ace', 13, 4, 'shahed', '018991212331', 'shahed@gmail.com', '0000-00-00', 48),
(44, 'Ace', 7, 2, 'shahed', '018991212331', 'IUT', '0000-00-00', 24),
(45, 'Ace', 13, 2, 'shahed', '018991212331', 'IUT gate', '0000-00-00', 24),
(46, 'Ace', 14, 10, 'shahed', '018991212331', 'IUT gate', '0000-00-00', 120);

-- --------------------------------------------------------

--
-- Table structure for table `recent_info`
--

CREATE TABLE `recent_info` (
  `recent_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_name` int(11) NOT NULL,
  `prev_amount` int(11) NOT NULL,
  `new_amount` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recent_update`
--

CREATE TABLE `recent_update` (
  `id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `prev_amount` int(11) NOT NULL,
  `new_amount` int(11) NOT NULL,
  `modify_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recent_update`
--

INSERT INTO `recent_update` (`id`, `store_id`, `product_name`, `prev_amount`, `new_amount`, `modify_date`) VALUES
(1, 10, 'Zimax', 196, 19, '2018-05-15'),
(2, 7, 'Ace', 3, 125, '2018-05-15'),
(3, 7, 'Ace', 125, 122, '2018-05-15'),
(4, 13, 'Ace', 0, 10, '2018-05-15'),
(5, 13, 'Ambrox', 0, 20, '2018-05-15'),
(6, 13, 'brolox', 0, 33, '2018-05-15'),
(7, 13, 'Ceevit', 0, 5, '2018-05-15'),
(8, 13, 'Fexo', 0, 6, '2018-05-15'),
(9, 13, 'ticothopy', 0, 50, '2018-05-15'),
(10, 13, 'tripoli', 0, 10, '2018-05-15'),
(11, 13, 'Zimax', 0, 50, '2018-05-15'),
(12, 13, 'Ace', 10, 8, '2018-05-15'),
(13, 14, 'Ace', 0, 120, '2018-05-15'),
(14, 14, 'Ambrox', 0, 35, '2018-05-15'),
(15, 14, 'Ceevit', 0, 120, '2018-05-15'),
(16, 14, 'Fexo', 0, 200, '2018-05-15'),
(17, 14, 'Zimax', 0, 200, '2018-05-15'),
(18, 14, 'Fexo', 200, 196, '2018-05-15'),
(19, 7, 'brolox', 0, 7, '2018-05-15'),
(20, 7, 'Napa', 0, 50, '2018-05-15'),
(21, 7, 'ticothopy', 0, 54, '2018-05-15'),
(22, 7, 'Zimax', 0, 44, '2018-05-15'),
(23, 14, 'brolox', 0, 100, '2018-05-15'),
(24, 14, 'Napa', 0, 100, '2018-05-15'),
(25, 14, 'ticothopy', 0, 100, '2018-05-15'),
(26, 14, 'tripoli', 0, 200, '2018-05-15'),
(27, 14, 'Zimax', 200, 540, '2018-05-15'),
(28, 13, 'Ace', 8, 108, '2018-05-15'),
(29, 14, 'Ace', 120, 127, '2018-05-15'),
(30, 14, 'Ace', 127, 107, '2018-05-15'),
(31, 7, 'Napa', 50, 60, '2018-05-15'),
(32, 7, 'Ace', 122, 117, '2018-05-15'),
(33, 7, 'Ace', 117, 234, '2018-05-15'),
(34, 7, 'Ace', 234, 0, '2018-05-15'),
(35, 7, 'Napa', 60, 65, '2018-05-15'),
(36, 7, 'Ace', 0, 5, '2018-05-15'),
(37, 7, 'brolox', 7, 1007, '2018-05-15'),
(38, 7, 'brolox', 1007, 2014, '2018-05-15'),
(39, 7, 'brolox', 2014, 0, '2018-05-15'),
(40, 15, 'Zimax', 0, 20, '2018-05-15'),
(41, 7, 'Napa', 65, 75, '2018-05-18'),
(42, 13, 'Ace', 108, 216, '2018-07-15'),
(43, 13, 'Ace', 216, 16, '2018-07-15'),
(44, 13, 'Ace', 16, 12, '2018-10-08'),
(45, 7, 'Ace', 5, 1, '2018-10-08'),
(46, 14, 'Ace', 107, 99, '2018-10-08'),
(47, 14, 'Ace', 99, 89, '2018-10-08');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `blood_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL COMMENT 'in ml',
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='request detail by user to the hospital';

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `blood_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='blood stock available in the hospital';

-- --------------------------------------------------------

--
-- Table structure for table `store_info`
--

CREATE TABLE `store_info` (
  `store_id` int(11) NOT NULL,
  `store_name` varchar(40) NOT NULL,
  `owner_name` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `contact_no` varchar(20) NOT NULL,
  `street_address` varchar(40) NOT NULL,
  `area` varchar(40) NOT NULL,
  `division` varchar(40) NOT NULL,
  `store_detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_info`
--

INSERT INTO `store_info` (`store_id`, `store_name`, `owner_name`, `password`, `email`, `contact_no`, `street_address`, `area`, `division`, `store_detail`) VALUES
(3, 'bb store', 'alvy', '12345', 'alvy@gmail.com', '01733555333', 'gazipur college', 'College Gate', 'Gazipur', ''),
(7, 'a1 store', 'shahed ahmed', 'shahed', 'shahed95@gmail.com', '01733651434', 'IUT', 'Boardbazar', 'Gazipur', ' a medicine shop near iut'),
(8, 'abc draghouse', 'abc', 'abc', 'abc@gmail.com', '1234', '11/2 street road', 'College Gate', 'Gazipur', ' A store near gazipur college gate. 24 hour home delivery service. '),
(10, 'Ali Pharmacy', 'Ali Masud', '12345', 'aliphar@outlook.com', '019876255621', '135/A,Elephant Road', 'Dhanmondi', 'Dhaka', ' 24 hour open'),
(11, 'Abdul Pharma', 'Abdulah Al Kashif', '1234', 'abdul@gmail.com', '019986662627', '127/A,Gulshan Avenue', 'Gulshan', 'Dhaka', ' Reliable and Safe'),
(13, 'Fair Price', 'fairul', 'fair', 'fair@gmail.com', '0173737373', 'IUT gate', 'Boardbazar', 'Gazipur', ' *24 hour delivery service'),
(14, 'Care Pharmacy', 'Abdul Kamal', 'care', 'care@gmail.com', '01715996987', '112/A,Boro Shorok', 'Boardbazar', 'Gazipur', ' Shoshomoi Er Shongi'),
(15, 'Tanvir Store', 'tanvir', '12345', 'tanvir@gmail.com', '111222', 'kunjogon', 'rampura', 'dhaka', ' ');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `blood_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` bigint(20) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='all data of reciever';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drug_info`
--
ALTER TABLE `drug_info`
  ADD PRIMARY KEY (`product_name`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`hospital_id`);

--
-- Indexes for table `instore`
--
ALTER TABLE `instore`
  ADD PRIMARY KEY (`id`),
  ADD KEY `store_id` (`store_id`),
  ADD KEY `product_name` (`product_name`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `recent_update`
--
ALTER TABLE `recent_update`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `store_info`
--
ALTER TABLE `store_info`
  ADD PRIMARY KEY (`store_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `hospital_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instore`
--
ALTER TABLE `instore`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `recent_update`
--
ALTER TABLE `recent_update`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_info`
--
ALTER TABLE `store_info`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `instore`
--
ALTER TABLE `instore`
  ADD CONSTRAINT `instore_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `store_info` (`store_id`),
  ADD CONSTRAINT `instore_ibfk_2` FOREIGN KEY (`product_name`) REFERENCES `drug_info` (`product_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

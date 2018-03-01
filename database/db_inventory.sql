-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 02, 2018 at 08:35 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_borrow`
--

CREATE TABLE IF NOT EXISTS `tb_borrow` (
`borrowID` int(11) NOT NULL,
  `equipmentID` int(11) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `dateTimeBorrow` varchar(255) NOT NULL,
  `dateTimeReturn` varchar(255) NOT NULL,
  `purpose` text NOT NULL,
  `roomID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_borrow`
--

INSERT INTO `tb_borrow` (`borrowID`, `equipmentID`, `teacherID`, `dateTimeBorrow`, `dateTimeReturn`, `purpose`, `roomID`) VALUES
(1, 2, 2, '2016/09/10', '2016/11/01', '', 2),
(2, 3, 3, '2016/10/10', '2016/10/10', 'Test. Sample.', 2),
(3, 2, 3, '2016/10/10', '2016/10/10', 'Sample. TEST.', 2),
(4, 2, 5, '2016/10/11', '2016/10/11', 'Printing', 1),
(6, 2, 1, '2016/10/11', '2016/11/01', 'demonstration', 1),
(7, 2, 3, '2016/11/01', '2016/11/01', 'demo', 2),
(8, 2, 2, '2016/11/01', '2016/11/01', 'test1', 2),
(9, 2, 1, '2016/11/01', '2016/11/01', 'test2', 1),
(10, 2, 1, '2016/11/01', '2016/11/01', 'test2', 1),
(11, 2, 1, '2016/11/01', '2016/11/01', 'test3', 1),
(12, 2, 1, '2016/11/01', '2016/11/01', '', 1),
(13, 2, 1, '2016/11/01', '2016/11/01', '', 1),
(14, 2, 2, '2016/11/01', '2016/11/01', 'sample test1', 3),
(15, 22, 5, '2016/11/04', '2016/11/04', 'Test 2', 2),
(16, 22, 2, '2016/11/10', '2016/11/10', 'sample borrow', 2),
(17, 22, 1, '2016/12/12', '2016/12/12', 'Tst', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE IF NOT EXISTS `tb_category` (
`category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`category_id`, `category_name`) VALUES
(1, 'Uniform'),
(2, 'Book'),
(3, 'Sample 1'),
(4, 'School Supply'),
(5, 'Sample 2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_condition`
--

CREATE TABLE IF NOT EXISTS `tb_condition` (
`conditionID` int(11) NOT NULL,
  `condition` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_condition`
--

INSERT INTO `tb_condition` (`conditionID`, `condition`) VALUES
(1, 'Working'),
(2, 'Damage'),
(3, 'Dispose');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE IF NOT EXISTS `tb_customer` (
`customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_contact` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_customer`
--

INSERT INTO `tb_customer` (`customer_id`, `customer_name`, `customer_contact`) VALUES
(1, 'Maxine Caulfield', '9189873845'),
(2, 'Chloe Summers', '9937526377');

-- --------------------------------------------------------

--
-- Table structure for table `tb_equipment`
--

CREATE TABLE IF NOT EXISTS `tb_equipment` (
`equipmentID` int(11) NOT NULL,
  `equipmentNo` varchar(255) NOT NULL,
  `equipmentTypeID` int(11) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `purchaseDate` varchar(255) NOT NULL,
  `purchaseCost` varchar(255) NOT NULL,
  `warranty` varchar(255) NOT NULL,
  `teacherID` int(11) NOT NULL,
  `roomID` int(11) NOT NULL,
  `conditionID` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `remark` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_equipment`
--

INSERT INTO `tb_equipment` (`equipmentID`, `equipmentNo`, `equipmentTypeID`, `brand`, `model`, `purchaseDate`, `purchaseCost`, `warranty`, `teacherID`, `roomID`, `conditionID`, `status`, `remark`) VALUES
(2, '002', 2, 'Epson', 'L120', '04/01/2016', '4000', '3 YEARS', 2, 2, 1, 0, ''),
(3, '003', 1, 'VidTek', 'PRJ-34', '01/10/2016', '12000', '5 YEARS', 2, 1, 1, 0, ''),
(4, '005', 3, 'HP Laptop', 'Pavilion DM3', '03/10/2011', '23000', '5 YEARS', 2, 2, 2, 0, ''),
(5, '004', 1, 'asd', 'asd', '03/21/2015', '230', '2 MONTHS', 1, 1, 3, 0, 'test2'),
(6, '008', 1, 'Apple', 'iComputer', '11/08/2011', '54000', '5 YEARS', 1, 2, 3, 0, ''),
(7, '009', 3, 'HP Laptop', 'Pavilio DM3', '01/15/2016', '25600', '3 YEARS', 3, 1, 1, 0, ''),
(20, '010', 3, 'Apple', 'MacBook Pro', '11/10/2011', '900', '3 YEARS', 2, 1, 2, 0, ''),
(21, '011', 5, 'TPLink', 'Linksys Router', '11/01/2011', '900', '3 YEARS', 3, 1, 1, 0, ''),
(22, '001', 1, 'Linksys', 'TX500-C', '09/01/2000', '3500', '1 YEARS', 3, 1, 1, 0, ''),
(23, '012', 9, 'Magic', 'Sing', '11/01/2016', '8000', '3 YEARS', 3, 2, 1, 0, ''),
(24, '013', 1, 'project 1', 'project 1', '11/02/2016', '100', '1 YEARS', 1, 2, 2, 0, ''),
(25, '0100', 1, 'Toshiba', 'Model 1', '06/19/2010', '13499', '3 YEARS', 3, 1, 1, 0, ''),
(26, '0101', 2, 'Epson', 'L210', '05/20/2005', '4300', '2 YEARS', 6, 6, 1, 0, ''),
(27, '0102', 2, 'Epson', 'L210', '06/19/2010', '3500', '2 YEARS', 3, 3, 1, 0, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `tb_equipmenttype`
--

CREATE TABLE IF NOT EXISTS `tb_equipmenttype` (
`equipmentTypeID` int(11) NOT NULL,
  `equipmentType` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_equipmenttype`
--

INSERT INTO `tb_equipmenttype` (`equipmentTypeID`, `equipmentType`) VALUES
(1, 'Projector'),
(2, 'Printer'),
(3, 'Laptop'),
(4, 'PC'),
(5, 'Router'),
(6, 'PC2'),
(7, 'Banana'),
(8, 'Apple'),
(9, 'Misc');

-- --------------------------------------------------------

--
-- Table structure for table `tb_invoice`
--

CREATE TABLE IF NOT EXISTS `tb_invoice` (
  `invoice` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_invoice`
--

INSERT INTO `tb_invoice` (`invoice`) VALUES
(14);

-- --------------------------------------------------------

--
-- Table structure for table `tb_item`
--

CREATE TABLE IF NOT EXISTS `tb_item` (
`item_id` int(11) NOT NULL,
  `item_code` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `sale_price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `available_stock` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `reorder_lvl` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_item`
--

INSERT INTO `tb_item` (`item_id`, `item_code`, `item_name`, `sale_price`, `category_id`, `available_stock`, `unit_id`, `reorder_lvl`) VALUES
(1, '0001', 'Navy Blue Cloth', 200, 1, 15, 1, 20),
(2, '0002', 'Cloth for Pants', 200, 1, 40, 1, 20),
(3, '0003', 'Bag', 250, 4, 26, 3, 25),
(4, '0004', 'Digititans G7', 180, 2, 25, 3, 21),
(5, '005', 'Ballpen', 20, 4, 30, 3, 20),
(6, '0005', 'Keyboard', 150, 4, 20, 3, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_payment`
--

CREATE TABLE IF NOT EXISTS `tb_payment` (
`payment_id` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `customer` varchar(255) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `date` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_payment`
--

INSERT INTO `tb_payment` (`payment_id`, `invoice`, `customer`, `total_amount`, `date`, `user_id`) VALUES
(1, 1, 'Maxine Caulfield', 1500, '2016/10/7', 1),
(2, 2, 'James Raynor', 900, '2016/10/8', 1),
(3, 3, 'Maxine Caulfield', 1820, '2016/10/8', 1),
(4, 4, 'Maxine Caulfield', 250, '2016/10/11', 2),
(5, 5, 'James Raynor', 620, '2016/10/11', 2),
(6, 6, 'James Raynor', 900, '2016/10/11', 2),
(7, 7, 'Maxine Caulfield', 100, '2016/10/11', 2),
(8, 8, 'Darryl Alagdon', 580, '2016/10/13', 1),
(9, 9, 'Darwin Alagdon', 100, '2016/11/03', 1),
(10, 10, 'Peter Griffin', 810, '2016/11/03', 1),
(11, 11, 'Meg Griffin', 40, '2016/11/03', 1),
(12, 12, 'Josh Sweden', 1480, '2016/11/04', 1),
(13, 13, 'Macias', 2100, '2016/11/10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_room`
--

CREATE TABLE IF NOT EXISTS `tb_room` (
`roomID` int(11) NOT NULL,
  `room` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_room`
--

INSERT INTO `tb_room` (`roomID`, `room`) VALUES
(1, 'Computer Lab 1'),
(2, 'Administrator Office'),
(3, 'Computer Lab 2'),
(4, 'Room 205'),
(5, 'High School Faculty'),
(6, 'Grade School Faculty');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sales`
--

CREATE TABLE IF NOT EXISTS `tb_sales` (
`sale_id` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` varchar(15) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_sales`
--

INSERT INTO `tb_sales` (`sale_id`, `invoice`, `item_id`, `quantity`, `date`, `user_id`) VALUES
(16, 1, 3, 2, '2016/10/05', 1),
(17, 1, 2, 5, '2016/10/05', 1),
(19, 2, 4, 5, '2016/10/08', 1),
(20, 3, 4, 4, '2016/10/08', 1),
(21, 3, 3, 2, '2016/10/08', 1),
(22, 3, 1, 3, '2016/10/08', 1),
(23, 4, 3, 1, '2016/10/11', 2),
(24, 5, 5, 31, '2016/10/11', 2),
(25, 6, 5, 45, '2016/10/11', 2),
(26, 7, 5, 5, '2016/10/11', 2),
(28, 8, 5, 4, '2016/10/13', 1),
(29, 8, 3, 2, '2016/10/13', 1),
(39, 9, 5, 5, '2016/11/03', 1),
(40, 10, 3, 3, '2016/11/03', 1),
(41, 10, 5, 3, '2016/11/03', 1),
(42, 11, 5, 2, '2016/11/03', 1),
(43, 12, 2, 3, '2016/11/04', 1),
(44, 12, 1, 2, '2016/11/04', 1),
(45, 12, 4, 1, '2016/11/04', 1),
(46, 12, 6, 2, '2016/11/04', 1),
(48, 13, 1, 10, '2016/11/10', 1),
(49, 13, 5, 5, '2016/11/10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_stockin`
--

CREATE TABLE IF NOT EXISTS `tb_stockin` (
`stockIn_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_date` varchar(15) NOT NULL,
  `purchase_cost` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_stockin`
--

INSERT INTO `tb_stockin` (`stockIn_id`, `item_id`, `supplier_id`, `quantity`, `purchase_date`, `purchase_cost`, `user_id`) VALUES
(1, 1, 1, 20, '2016/09/08', 5000, 1),
(2, 1, 1, 10, '2016/09/08', 200, 1),
(3, 3, 3, 30, '2016/09/12', 6000, 1),
(6, 1, 1, 10, '2016/09/28', 100, 1),
(7, 4, 1, 35, '2016/10/08', 5000, 1),
(8, 5, 1, 100, '2016/10/11', 300, 2),
(9, 2, 1, 5, '2016/11/02', 100, 1),
(10, 2, 1, 5, '2016/11/02', 250, 1),
(11, 2, 1, 5, '2016/11/02', 250, 1),
(12, 2, 1, 3, '2016/11/02', 250, 1),
(13, 5, 3, 15, '2016/11/02', 100, 1),
(14, 6, 2, 3, '2016/11/02', 300, 1),
(15, 6, 3, 5, '2016/11/02', 500, 1),
(16, 6, 2, 2, '2016/11/02', 200, 1),
(17, 6, 1, 2, '2016/11/02', 200, 1),
(18, 3, 4, 3, '2016/11/04', 500, 1),
(19, 3, 3, 3, '2016/11/04', 500, 1),
(20, 5, 3, 15, '2016/11/04', 150, 1),
(21, 6, 5, 10, '2016/11/04', 500, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE IF NOT EXISTS `tb_supplier` (
`supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_contact` varchar(20) NOT NULL,
  `company_name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`supplier_id`, `supplier_name`, `supplier_contact`, `company_name`) VALUES
(1, 'Warren Vidic', '09726352787', 'Abstergo Inc'),
(2, 'Judie Holmes', '09237462810', 'DPA Inc'),
(3, 'Dana Elise Dela Sier', '09987654561', 'Dela Sier Inc'),
(4, 'Darryl Alagdon', '0998762333', 'Alagdon''s Software & PC Shop'),
(5, 'Mark Daniel Alagdon', '09989865332', 'The Daniel''s PC House');

-- --------------------------------------------------------

--
-- Table structure for table `tb_teacher`
--

CREATE TABLE IF NOT EXISTS `tb_teacher` (
`teacherID` int(11) NOT NULL,
  `teacherName` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_teacher`
--

INSERT INTO `tb_teacher` (`teacherID`, `teacherName`) VALUES
(1, 'Louiejie Porras'),
(2, 'Windy Mangco'),
(3, 'Darryl Alagdon'),
(4, 'Syke Regulacion'),
(5, 'Admin'),
(6, 'Sheldon Macias');

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit`
--

CREATE TABLE IF NOT EXISTS `tb_unit` (
`unit_id` int(11) NOT NULL,
  `unit_name` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_unit`
--

INSERT INTO `tb_unit` (`unit_id`, `unit_name`) VALUES
(1, 'Meter'),
(2, 'Inch'),
(3, 'Piece'),
(4, 'Liter');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE IF NOT EXISTS `tb_user` (
`userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `userlvlID` int(11) NOT NULL,
  `changable` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`userID`, `username`, `password`, `name`, `userlvlID`, `changable`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Darryl Alagdon', 1, 1),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'Demo Account', 2, 0),
(4, 'darwin', '3750c667d5cd8aecc0a9213b362066e9', 'Darwin Alagdon', 3, 0),
(9, 'sample', 'ee11cbb19052e40b07aac0ca060c23ee', 'Sample Sample', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_userlvl`
--

CREATE TABLE IF NOT EXISTS `tb_userlvl` (
`userlvlID` int(11) NOT NULL,
  `userlvl` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_userlvl`
--

INSERT INTO `tb_userlvl` (`userlvlID`, `userlvl`) VALUES
(1, 'Administrator'),
(2, 'Staff'),
(3, 'Guest');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_borrow`
--
ALTER TABLE `tb_borrow`
 ADD PRIMARY KEY (`borrowID`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
 ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tb_condition`
--
ALTER TABLE `tb_condition`
 ADD PRIMARY KEY (`conditionID`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
 ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `tb_equipment`
--
ALTER TABLE `tb_equipment`
 ADD PRIMARY KEY (`equipmentID`);

--
-- Indexes for table `tb_equipmenttype`
--
ALTER TABLE `tb_equipmenttype`
 ADD PRIMARY KEY (`equipmentTypeID`);

--
-- Indexes for table `tb_item`
--
ALTER TABLE `tb_item`
 ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `tb_payment`
--
ALTER TABLE `tb_payment`
 ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tb_room`
--
ALTER TABLE `tb_room`
 ADD PRIMARY KEY (`roomID`);

--
-- Indexes for table `tb_sales`
--
ALTER TABLE `tb_sales`
 ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `tb_stockin`
--
ALTER TABLE `tb_stockin`
 ADD PRIMARY KEY (`stockIn_id`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
 ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `tb_teacher`
--
ALTER TABLE `tb_teacher`
 ADD PRIMARY KEY (`teacherID`);

--
-- Indexes for table `tb_unit`
--
ALTER TABLE `tb_unit`
 ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
 ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `tb_userlvl`
--
ALTER TABLE `tb_userlvl`
 ADD PRIMARY KEY (`userlvlID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_borrow`
--
ALTER TABLE `tb_borrow`
MODIFY `borrowID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tb_condition`
--
ALTER TABLE `tb_condition`
MODIFY `conditionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_customer`
--
ALTER TABLE `tb_customer`
MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_equipment`
--
ALTER TABLE `tb_equipment`
MODIFY `equipmentID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `tb_equipmenttype`
--
ALTER TABLE `tb_equipmenttype`
MODIFY `equipmentTypeID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tb_item`
--
ALTER TABLE `tb_item`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_payment`
--
ALTER TABLE `tb_payment`
MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `tb_room`
--
ALTER TABLE `tb_room`
MODIFY `roomID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_sales`
--
ALTER TABLE `tb_sales`
MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `tb_stockin`
--
ALTER TABLE `tb_stockin`
MODIFY `stockIn_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tb_teacher`
--
ALTER TABLE `tb_teacher`
MODIFY `teacherID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tb_userlvl`
--
ALTER TABLE `tb_userlvl`
MODIFY `userlvlID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

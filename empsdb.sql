-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2024 at 01:31 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `empsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `batch_id` varchar(10) NOT NULL,
  `price_punit` decimal(10,2) NOT NULL,
  `quantity` int(10) NOT NULL,
  `quantity_stock` int(10) NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `status` varchar(10) NOT NULL,
  `purchase_date` date NOT NULL,
  `equipment_id` varchar(10) DEFAULT NULL,
  `medicine_id` varchar(10) DEFAULT NULL,
  `invoice_no` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch`
--

INSERT INTO `batch` (`batch_id`, `price_punit`, `quantity`, `quantity_stock`, `expiration_date`, `status`, `purchase_date`, `equipment_id`, `medicine_id`, `invoice_no`) VALUES
('bt00002', 4.00, 2, 2, '2024-01-04', 'Unused', '2024-01-01', NULL, 'md00001', 'inv00001'),
('bt00003', 6.32, 24, 24, '2024-01-24', 'Unused', '2024-01-01', NULL, 'md00001', 'inv00001'),
('bt00005', 22.00, 12, 12, '2024-01-20', 'Unused', '2024-01-04', NULL, 'md00001', 'inv00002'),
('bt00006', 12.00, 144, 144, '2024-01-27', 'Unused', '2024-01-06', NULL, 'md00001', 'inv00003'),
('bt00007', 23.00, 45, 45, '2024-01-19', 'Unused', '2024-01-06', NULL, 'md00001', 'inv00003'),
('bt00008', 12.34, 2, 2, '2024-01-11', 'Unused', '2024-01-08', NULL, 'md00002', 'inv00006'),
('bt00009', 10.00, 1, 1, '2024-01-11', 'Unused', '2024-01-08', NULL, 'md00002', 'inv00006'),
('bt00010', 2.00, 1, 1, '2024-01-08', 'Unused', '2024-01-01', NULL, 'md00001', 'inv00001'),
('bt00011', 1.00, 1, 1, '2024-01-08', 'Unused', '2024-01-02', NULL, 'md00001', 'inv00007'),
('bt00012', 2.00, 1, 1, '2024-01-10', 'Unused', '2024-01-02', NULL, 'md00001', 'inv00007'),
('bt00013', 2.00, 1, 1, NULL, 'Unused', '2024-01-08', 'eq00001', NULL, 'inv00008'),
('bt00014', 1.00, 7, 7, NULL, 'Unused', '2024-01-05', 'eq00004', NULL, 'inv00009'),
('bt00015', 2.00, 1, 1, '2024-01-27', 'Used', '2024-01-05', NULL, 'md00002', 'inv00009'),
('bt00016', 1.00, 2, 2, '2024-01-27', 'Unused', '2024-01-08', NULL, 'md00003', 'inv00008'),
('bt00017', 12.00, 2, 2, '2024-02-01', 'Unused', '2024-01-10', NULL, 'md00003', 'inv00010'),
('bt00018', 1.00, 1, 1, '2024-01-16', 'Unused', '2024-01-07', NULL, 'md00001', 'inv00011'),
('bt00019', 12.30, 8, 8, '2024-01-20', 'Unused', '2024-01-14', NULL, 'md00001', 'inv00012'),
('bt00020', 10.00, 4, 4, NULL, 'Used', '2024-01-15', 'eq00001', NULL, 'inv00013');

-- --------------------------------------------------------

--
-- Table structure for table `breed`
--

CREATE TABLE `breed` (
  `breed_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `type_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equipment_id` varchar(10) NOT NULL,
  `equipment_name` varchar(50) NOT NULL,
  `equipment_desc` varchar(300) NOT NULL,
  `equipment_status` varchar(10) NOT NULL,
  `supplier_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `equipment_name`, `equipment_desc`, `equipment_status`, `supplier_id`) VALUES
('eq00001', 'Digital Stethoscope', 'Amplifies and clarifies heart, lung, and abdominal sounds for accurate diagnosis of internal issues.', 'Active', 'sp00002'),
('eq00002', 'Veterinary Otoscope', 'Examines the ear canal for infections, parasites, and foreign objects.', 'Inactive', 'sp00005'),
('eq00003', 'Ophthalmoscope', 'Examines the internal structures of the eye, including the retina, lens, and optic nerve.', 'Inactive', 'sp00005'),
('eq00004', 'Grooming Supplies', 'Maintain hygiene and coat health through bathing, brushing, and nail trimming.', 'Inactive', 'sp00001'),
('eq00005', 'X-Ray Machine', 'Produces radiographs of bones, teeth, and other internal structures to diagnose fractures, joint problems, and other abnormalities.', 'Inactive', 'sp00005'),
('eq00006', 'Surgical Instruments', 'Perform various surgical procedures, from spays and neuters to more complex operations.', 'Inactive', 'sp00003'),
('eq00007', 'Syringe', 'Used as Vaccination item', 'Inactive', 'sp00002');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_no` varchar(20) NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `payment_reference` varchar(200) NOT NULL,
  `time_stamp` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_no`, `cost`, `payment_reference`, `time_stamp`) VALUES
('inv00001', 2.00, 'medicine', '2024-01-03'),
('inv00002', 0.00, '', '2024-01-06'),
('inv00003', 0.00, '', '2024-01-06'),
('inv00006', 34.68, 'Medicine_Invoice', '2024-01-08'),
('inv00007', 3.00, 'Medicine_Invoice', '2024-01-08'),
('inv00008', 4.00, 'Equipment_Invoice', '2024-01-09'),
('inv00009', 3.00, 'Equipment_Invoice', '2024-01-09'),
('inv00010', 24.00, 'Medicine_Invoice', '2024-01-10'),
('inv00011', 1.00, 'Medicine_Invoice', '2024-01-15'),
('inv00012', 98.40, 'Medicine_Invoice', '2024-01-15'),
('inv00013', 40.00, 'Equipment_Invoice', '2024-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `medicine`
--

CREATE TABLE `medicine` (
  `medicine_id` varchar(10) NOT NULL,
  `medicine_name` varchar(50) NOT NULL,
  `medicine_desc` varchar(300) NOT NULL,
  `medicine_status` varchar(10) NOT NULL,
  `supplier_id` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicine`
--

INSERT INTO `medicine` (`medicine_id`, `medicine_name`, `medicine_desc`, `medicine_status`, `supplier_id`) VALUES
('md00001', 'Meloxicam', 'Reduces pain and inflammation in dogs and cats, often associated with arthritis, sprains, and other musculoskeletal conditions.', 'Inactive', 'sp00001'),
('md00002', 'Cephalexin', 'Treats bacterial infections in dogs and cats, including skin infections, respiratory infections, urinary tract infections, and bone infections.', 'Active', 'sp00001'),
('md00003', 'Ivermectin', 'Prevents and treats heartworm disease in dogs, a serious parasitic infection transmitted by mosquitoes.', 'Inactive', 'sp00005'),
('md00004', 'Fipronil', 'Prevents and controls flea and tick infestations on dogs and cats.', 'Inactive', 'sp00005'),
('md00005', 'Prednisolone', ' Reduces inflammation, suppresses the immune system, and relieves allergic reactions in dogs and cats.', 'Inactive', 'sp00002'),
('md00006', 'Metronidazole', 'Treats bacterial and parasitic infections in dogs and cats, particularly those affecting the gastrointestinal tract and respiratory system.', 'Inactive', 'sp00001'),
('md00007', 'Panadol', 'This m edicine used for sick', 'Inactive', 'sp00004'),
('md00008', 'ok', 'wadsa', 'Inactive', 'sp00007'),
('md00009', 'fg', 'ddf', 'Inactive', 'sp00005');

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `owner_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `age` int(11) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `emergency_number` varchar(20) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `patient_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `color` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `gender` varchar(6) NOT NULL,
  `type_id` int(11) DEFAULT NULL,
  `breed_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `supplier_id` varchar(10) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `supplier_phone` varchar(20) NOT NULL,
  `supplier_email` varchar(50) NOT NULL,
  `supplier_address` varchar(300) NOT NULL,
  `supplier_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `supplier_name`, `supplier_phone`, `supplier_email`, `supplier_address`, `supplier_status`) VALUES
('sp00001', 'Global Veterinary Sdn Bhd (GLOVET)', '063345643', 'prestige@gmail.com', 'Jalan Murni,7049 Gombak, Selaangor', 'Active'),
('sp00002', 'Animalcare Sdn. Bhd.', '062812858', 'animalcare@gmail.com', 'No. 56, Jalan TP2, Taman Melaka Paya, Taman Paya Rumput, 75450 Melaka, Malaysia', 'Active'),
('sp00003', 'Pet Health Supplies Enterprise', '062820878', 'phs@email.com', ' G-1 & G-2, Jalan Cheng Perdana 3/15, Taman Cheng Perdana, 75250 Melaka, Malaysia', 'Active'),
('sp00004', 'Ecoscience Supplies Enterprise:', '032345634', 'ese@gmail.com', 'No. 32, Jalan TU 8, Taman Ayer Keroh Utama, 75450 Melaka, Malaysia.', 'Active'),
('sp00005', 'VetEquip Online', '01345503417', 'Vetequip@gmail.com', 'No. 49, Jalan Hang Kasturi, 75200 Melaka, Malaysia.', 'Active'),
('sp00006', 'MedicalPet care Sdn.Bhd', '0876543345', 'medicare@email.com', 'G-1, Jalan Merak, kuala Lankau,70400 Negeri Sembilan, Malaysia', 'Inactive'),
('sp00007', 'Paw Paw Sdn Bhd', '098765546', 'pawpaw@email.com', 'No.23, Jalan dua tiga, 4534 Perak, Malaysia', 'Active'),
('sp00008', 'IntervalVet', '019867544', 'IVet@gmail.com', 'Jalan bunga raya', 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `tbladdsalary`
--

CREATE TABLE `tbladdsalary` (
  `id` int(11) NOT NULL,
  `Department` varchar(45) DEFAULT NULL,
  `empid` varchar(45) DEFAULT NULL,
  `salary` varchar(45) DEFAULT NULL,
  `allowancesalary` varchar(45) DEFAULT NULL,
  `total` varchar(45) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladdsalary`
--

INSERT INTO `tbladdsalary` (`id`, `Department`, `empid`, `salary`, `allowancesalary`, `total`, `create_date`) VALUES
(2, '3', 'Emp12345', '50000', '2500', '52500', '2022-11-17 17:18:03'),
(3, '9', '10806121', '49100', '4523', '53623', '2022-11-22 01:57:23'),
(4, '11', 'EMP01', '5000', '1000', '6000', '2024-01-15 18:03:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`id`, `name`, `email`, `mobile`, `password`, `create_date`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, 'f925916e2754e5e03f75dd58a5733251', '2022-11-19 11:25:17');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartment`
--

CREATE TABLE `tbldepartment` (
  `id` int(11) NOT NULL,
  `DepartmentName` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbldepartment`
--

INSERT INTO `tbldepartment` (`id`, `DepartmentName`) VALUES
(11, 'Veterinary'),
(12, 'Veterinarians'),
(13, 'Technicians');

-- --------------------------------------------------------

--
-- Table structure for table `tblemployee`
--

CREATE TABLE `tblemployee` (
  `id` int(11) NOT NULL,
  `EmpId` varchar(45) DEFAULT NULL,
  `fname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) DEFAULT NULL,
  `department_name` varchar(100) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `photo` varchar(200) DEFAULT NULL,
  `dob` varchar(45) DEFAULT NULL,
  `date_of_joining` varchar(45) DEFAULT NULL,
  `password` varchar(450) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblemployee`
--

INSERT INTO `tblemployee` (`id`, `EmpId`, `fname`, `lname`, `department_name`, `email`, `mobile`, `country`, `state`, `city`, `address`, `photo`, `dob`, `date_of_joining`, `password`, `create_date`) VALUES
(3, '10806121', 'TEST', 'TEST', '13', 'test@test.com', '1234567891', 'MALAYSIA', 'UP', 'PJ', 'A 123 ABC Aprtment', '../uploads/1669081889-security-guard.png', '1996-06-04', '2023-10-14', 'f925916e2754e5e03f75dd58a5733251', '2022-11-22 01:51:29'),
(4, 'EMP01', 'ANIS SOFIA', 'ABDUL HAFIZ', '11', 'niscopia@gmail.com', '0111909981', 'MALAYSIA', 'PERLIS', 'BESERI', 'NO 1 KM 16 JALAN BARU', '../uploads/1705341536-WIN_20220608_00_56_55_Pro.jpg', '2001-01-01', '2024-01-17', '77a8b8bf8234c2f44e950e0ead248155', '2024-01-15 17:58:56');

-- --------------------------------------------------------

--
-- Table structure for table `tblleave`
--

CREATE TABLE `tblleave` (
  `id` int(11) NOT NULL,
  `userID` varchar(45) DEFAULT NULL,
  `EmpID` varchar(45) DEFAULT NULL,
  `LeaveType` varchar(45) DEFAULT NULL,
  `FromDate` varchar(45) DEFAULT NULL,
  `Todate` varchar(45) DEFAULT NULL,
  `Description` varchar(450) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `adminremarks` varchar(450) DEFAULT NULL,
  `Create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblleave`
--

INSERT INTO `tblleave` (`id`, `userID`, `EmpID`, `LeaveType`, `FromDate`, `Todate`, `Description`, `status`, `adminremarks`, `Create_date`) VALUES
(7, '4', 'EMP01', '1', '2024-01-17', '2024-01-19', 'sick\r\n', 'Pending', NULL, '2024-01-15 18:02:20');

-- --------------------------------------------------------

--
-- Table structure for table `tblleavetype`
--

CREATE TABLE `tblleavetype` (
  `id` int(11) NOT NULL,
  `leaveType` varchar(45) DEFAULT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblleavetype`
--

INSERT INTO `tblleavetype` (`id`, `leaveType`, `create_date`) VALUES
(1, 'Casual Leaves- CL', '2022-03-30 14:13:40'),
(2, 'Earned Leave-EL', '2022-11-17 16:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `breed`
--
ALTER TABLE `breed`
  ADD PRIMARY KEY (`breed_id`),
  ADD UNIQUE KEY `title_unique` (`title`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_no`);

--
-- Indexes for table `medicine`
--
ALTER TABLE `medicine`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`patient_id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `typeFK` (`type_id`),
  ADD KEY `fk_patient_breed` (`breed_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`supplier_id`),
  ADD UNIQUE KEY `supplier_name` (`supplier_name`);

--
-- Indexes for table `tbladdsalary`
--
ALTER TABLE `tbladdsalary`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblemployee`
--
ALTER TABLE `tblemployee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblleave`
--
ALTER TABLE `tblleave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`),
  ADD UNIQUE KEY `title_unique` (`title`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `breed`
--
ALTER TABLE `breed`
  MODIFY `breed_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbladdsalary`
--
ALTER TABLE `tbladdsalary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblemployee`
--
ALTER TABLE `tblemployee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblleave`
--
ALTER TABLE `tblleave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblleavetype`
--
ALTER TABLE `tblleavetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `breed`
--
ALTER TABLE `breed`
  ADD CONSTRAINT `breed_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`);

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `fk_patient_breed` FOREIGN KEY (`breed_id`) REFERENCES `breed` (`breed_id`),
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`owner_id`),
  ADD CONSTRAINT `typeFK` FOREIGN KEY (`type_id`) REFERENCES `type` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

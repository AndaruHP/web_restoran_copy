-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2023 at 12:15 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_uts`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_table`
--

CREATE TABLE `access_table` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender_type` varchar(1) NOT NULL,
  `birth_date` date NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `access_table`
--

INSERT INTO `access_table` (`id`, `first_name`, `last_name`, `gender_type`, `birth_date`, `username`, `password`, `role`) VALUES
(1, 'admin', 'ibn admin', 'm', '2000-01-01', 'admin', '$2y$10$.ih/iZI8wwHL1QIIPJbnHujosQuhDJuipze8MYuEaMw8A8b6X4Ore', 0),
(2, 'Andaru', 'Hymawan', 'm', '2004-02-19', 'andaruHP', '$2y$10$QztekePSFb52wwfQ2ehx2.Gui8GpxwzJ.Y.1h3bQPc7BOI/MX/NtK', 1),
(3, 'Andre', 'Taulany', 'm', '2023-10-14', 'andre', '$2y$10$k5xYlC0Kjgpn7LJUKzU7re/YqEDeVNx48r3jsIk.vTfjM.VxcQwGi', 1),
(4, 'Raja', 'Juliet', 'm', '2023-10-14', 'juliet', '$2y$10$IabZbAD9aRbmFdLVd5mUa.6oUGJ95MYVPRZZtbABFexW5NT2BtECW', 1),
(5, 'Andrew', 'Ko', 'm', '2023-10-21', 'an', '$2y$10$1Gaki8JIYac5IdPa.DWFgecOkvX0xASSr0iYRnoZxAZ56Kdp88uEy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart_table`
--

CREATE TABLE `cart_table` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_table`
--

INSERT INTO `cart_table` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(56, 1, 17, 0),
(57, 1, 24, 0),
(58, 1, 19, 1),
(59, 1, 22, 0),
(60, 1, 26, 0),
(61, 1, 18, 1),
(62, 1, 20, 1);

-- --------------------------------------------------------

--
-- Table structure for table `data_makanan`
--

CREATE TABLE `data_makanan` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `gambar_menu` varchar(255) NOT NULL,
  `deskripsi_menu` text NOT NULL,
  `harga_menu` int(11) NOT NULL,
  `kategori_menu` enum('Appetizer','Beverages','Main Course','Dessert','Side Dish') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_makanan`
--

INSERT INTO `data_makanan` (`id_menu`, `nama_menu`, `gambar_menu`, `deskripsi_menu`, `harga_menu`, `kategori_menu`) VALUES
(17, 'Caprese Salad', 'caprese.jpg', 'Caprese Salad kami adalah perpaduan segar antara irisan tomat merah matang, mozzarella mutiara berkualitas tinggi, dan daun basil segar yang disajikan dengan lapisan balsamic reduction, menciptakan harmoni rasa yang memanjakan selera Anda.', 52000, 'Appetizer'),
(18, 'Garlic Bread', 'garlicbread.jpg', 'Roti bawang putih kami adalah campuran sempurna dari roti panggang yang renyah dan potongan bawang putih yang dipanggang dengan mentega bawang, menghasilkan hidangan pembuka yang lezat dan aromatik.', 31500, 'Appetizer'),
(19, 'French Fries', 'frenchfries.jpg', 'Kami hadirkan French Fries yang renyah dan gurih, digoreng sempurna hingga keemasan, disajikan dengan pilihan saus favorit Anda untuk memuaskan selera camilan Anda.', 23000, 'Side Dish'),
(20, 'Coleslaw', 'coleslaw.jpg', 'Coleslaw kami adalah paduan segar dari kubis dan wortel yang diiris tipis, diselimuti dengan saus krim yang lembut dan rasa segar yang sempurna untuk melengkapi hidangan Anda.&quot;', 27000, 'Side Dish'),
(21, 'Iced Latte', 'icedlatte.jpg', 'Iced Latte kami adalah kombinasi sempurna antara espresso yang kuat dan susu yang dingin, disajikan dengan es batu untuk memberikan kepercayaan segar dan kafein yang mendalam dalam setiap tegukan.', 16000, 'Beverages'),
(22, 'Fresh Fruit Smoothie', 'freshfruit.jpg', 'Nikmati kelezatan alami dalam gelas dengan Fresh Fruit Smoothie kami yang diisi dengan berbagai buah segar yang dipadukan dengan yogurt lembut, menciptakan minuman sehat yang penuh dengan rasa dan energi.', 24500, 'Beverages'),
(23, 'Grilled Chicken Sandwich', 'grilledchicken.jpeg', 'Grilled Chicken Sandwich kami adalah kombinasi sempurna antara potongan daging ayam panggang yang saus, sayuran segar, dan saus spesial, diapit dalam roti yang gurih untuk memberikan cita rasa yang memuaskan di setiap gigitan.', 44000, 'Main Course'),
(24, 'Spaghetti Carbonara', 'carbonaraspaghetti.jpeg', 'Spaghetti Carbonara kami adalah kombinasi yang menggugah selera dari pasta lezat yang dipadukan dengan saus krim berbumbu, bacon crip yang gurih, dan taburan parmesan segar, menciptakan hidangan pasta klasik yang memanjakan lidah Anda.', 37000, 'Main Course'),
(25, 'Chocolate Brownie', 'chocolatebrownie.jpeg', 'Chocolate Brownie kami adalah sajian manis yang tak tertahankan, dengan tekstur luar yang renyah dan lapisan dalam yang lembut, disajikan dengan taburan cokelat leleh yang memikat.', 33000, 'Dessert'),
(26, 'New York Cheesecake', 'nycheesecake.jpeg', 'New York Cheesecake kami adalah kelezatan klasik yang tak tertandingi, dengan lapisan keju krim yang lembut dan pangsit graham yang garing, dihadirkan dengan topping buah-buahan segar untuk memberikan sentuhan manis yang sempurna.', 36000, 'Dessert'),
(27, 'Ice Cream', 'icecream.jpeg', 'Ice Cream kami adalah perpaduan rasa yang lezat dan tekstur lembut dalam setiap sendokan, dengan beragam pilihan varian yang memuaskan selera, sempurna untuk mengakhiri hidangan Anda dengan manis.', 8000, 'Dessert');

-- --------------------------------------------------------

--
-- Table structure for table `history_user`
--

CREATE TABLE `history_user` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_user`
--

INSERT INTO `history_user` (`id`, `id_user`, `nama_menu`, `quantity`, `total_price`) VALUES
(1, 5, 'Caprese Salad', 1, 52000),
(2, 5, 'Caprese Salad', 1, 52000),
(3, 5, 'Iced Latte', 1, 16000),
(4, 5, 'New York Cheesecake', 1, 36000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_table`
--
ALTER TABLE `access_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_table`
--
ALTER TABLE `cart_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carttouser` (`user_id`),
  ADD KEY `carttofood` (`product_id`);

--
-- Indexes for table `data_makanan`
--
ALTER TABLE `data_makanan`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `history_user`
--
ALTER TABLE `history_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtoid` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_table`
--
ALTER TABLE `access_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart_table`
--
ALTER TABLE `cart_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `data_makanan`
--
ALTER TABLE `data_makanan`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `history_user`
--
ALTER TABLE `history_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_table`
--
ALTER TABLE `cart_table`
  ADD CONSTRAINT `carttofood` FOREIGN KEY (`product_id`) REFERENCES `data_makanan` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carttouser` FOREIGN KEY (`user_id`) REFERENCES `access_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `history_user`
--
ALTER TABLE `history_user`
  ADD CONSTRAINT `idtoid` FOREIGN KEY (`id_user`) REFERENCES `access_table` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

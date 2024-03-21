-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2024 at 06:06 AM
-- Server version: 5.5.68-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_43227198`
--
CREATE DATABASE IF NOT EXISTS `db_43227198` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_43227198`;

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

DROP TABLE IF EXISTS `Comments`;
CREATE TABLE IF NOT EXISTS `Comments` (
  `commentID` int(11) NOT NULL,
  `postID` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `timePosted` date NOT NULL,
  `replyingTo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Discussions`
--

DROP TABLE IF EXISTS `Discussions`;
CREATE TABLE IF NOT EXISTS `Discussions` (
  `discussionID` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `discussion_picture` blob NOT NULL,
  `time_posted` date NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Discussions`
--

INSERT INTO `Discussions` (`discussionID`, `username`, `title`, `content`, `discussion_picture`, `time_posted`, `category`) VALUES
(1, 't1', 'Why are frogs green?', 'Frogs are green because they live in swamps.', 0xffd8ffe000104a46494600010100000100010000ffdb0084000906071010100f101010151510171015111616100f10101115101813161616151815181d2820181b251b1616213d2325292b2e2e2e171f3338332d37282d2e2b010a0a0a0e0d0e1b10101a2b252026322d372e2d2b2d2b2b322d322d2b372d2d2b2d2d2d2d2d2d2d2f2e2d2d2d2f2d2d2d2d2d2d2d2d2d2d352d2b2b2b2d2d2d2dffc000110800e100e103012200021101031101ffc4001c0001000202030100000000000000000000000506010402030708ffc4004410000201020305060206060709000000000001020311041221053141516106132271819132a1071442b1c1d12352627292a21524647382f0f1163443456365b3c2d2ffc400190101010101010100000000000000000000000103020405ffc40021110101000203010100020300000000000000010211032131124122b1325161ffda000c03010002110311003f00f703260003260c800000000000000000000000000000000000000000000000000000306401832000000000000000000035f0f88cdbcefb9585b432d59c2faaa925eaa44b74ef0c2e5e2c38cc4aa71727bf82e6ce58652ca9c9f89eaf92e8880c662255aad34a3e049393fb295ecf5f4658d312ed32c7e590015c800000000000000000000000000000000000000000003a6b51cde7f221369579d2d3c51be97bbcafc9f3e9bcb09c2ad28ce2e3249c5ab34d5d344b1d6364bda97571f2859c26d3e0ff0007cce188dab0aa939c6d523f6a3b9ae299b1da6d84e9c1d5a379456ae3ab945734f7b5f329b3c5ab3d75ba5f7bfc0c72b63dbc78e1977172d9bb4e9cab5284b55e293d2e928c5cbef45be9545249c5dd1e63d95a0e5f59c4bf829d3505fbd2945bf68dff0089175d838d4e53a77fda5f8fe077865fed873e125e938718d44db4b79a3b431aa2d534f5b5df489df818f854b9abfa703bdb0b2c6c800a800000000000000000000000000000000000000001118fed0d1a32719aa964ece51a7274d3e59b737e44b268c4a29a69a4d35669aba6bc8977f835b0f8aa55e29c1e68bdcd5d10fb6b63c67a4a9aa917a26d2cc9f9ef5e68e3b49f734ead3c37827079a9a8feb7c7952e37bb56ea6c61768cab53a0e71c939e44e3ae97f8b7eab4f639defaaef19963da0f0f5e961f0389c2dad2eeeab8b6d3cee57e3cd5d2f28a3436642b4634f151f853df7e0b7e9cb7a3676aecf93c456a54d274a2e9abb6de5751371574b75d357eaae72c462bead463466ad685acf5bf54fa9c5ffaf5cb35fc7bdfaecc3d49579b6fe2ab5147ca2df8bda0a5ec5a313b5210ba5c34d39ae08f3fecfed094aa3841fe93e183b5d433292751f947379bb732d35210a75e8597c10bb4f5bddd937cdab49f9b2e17a73cf8cfad27f0d29b49d4d1bdd1e3ebd4d922368e2b2d68abee827ef27f912e6af258017309dc2320000000000000000000000000000000001894535660746223c53f179ef3416d850938cf72d1b5bd7e677e2f06ed786bd1bb7b32b98869455577ccea644a4ad6b45ebd75b1ce56b5e3c65f5cb6c29cab54ab14fb9796d24d5aea11bb5c48c9f7f889d2a542ae4acef563369b4a51bc95fa37049f493dfb8eff00e904da8aaaa1c1e7be57e7f99b9b0b674a8e27be94a2e9774e31c8db69b71d6d6dd64ccb5bbd3d372d71eafbf8a5e2b6a4e38aa952966a357fe3524de5a7884dc6ac6dba516d67eaa659fb414e38bc2a71b778e9aab4f5b6ad5dc1be4f77b3203e91230a78e855a4d5ab53bcbfbd8ac9aff86303bb67637361e86bba5520bcbc324be667bb8e5631e0c6dc9b7d93d995307775ecaad44a59535271870bdb457d34e97e3652db42bb7888be0e8a5ed56ac7f035951a9e1a924f235962df149591b95f0cea4309521ff52127cbc79bef72349bb34f46524b2d6a4b1bf58c4da0fc318a836f9c23e2b73d532d0b6ed2c89a779db58f27d7a15f787c2e028b9cfc52b35793f14a4f5694772ff3a95ec2ed6bdeae551cd2bc62af6e4996df967f1392f5e47a1d3aea5e2a92b2e5f9237b0d5e335e1bdb75ed65e840ec4d9b52a2552ba693d541e927fbdc9742c7156d16e359e3cb9c92b2002b90000000000000000000000000000709d549a4ddae733ab11473ab71e04362f6a54c3e928dd7052d13f2992dd3ac70b95d44f149db152094e352f9235649d9da4929deebaa5afa139b3fb40ab4f277528bcae57728b8e9d56bc7915bed551695497eb4e4f7f0925f97cce32cbadc6fc5c7665f3920f6d76731b41b928bad4b7a9d14e4edc1b8ad57cd753afb1db4b113c4ac3295a0eead513d2693692e2b7347a0f64369aad83849bf1534e9cfce0bff009b1e5f3c5ff5d957836aa39f7eb728b929dec9f37aab71bef46796b1d5867cd9778d5bf686021566a8e22395ef6a5b9ae0e2f9f5442d0d990c3c127533455494d24b83c9a66ff072e24cd4ed0c31ef074b2e4aab149be3071eeaa2f6cd93c2ce9ed36c89acd3a49e8ef3a6b5b739439f97b721d59b8ef8f93eb29f892c56dba55a928c15a564945f07e64653da1dda508789a4de9c5daf29745bfc922b183c44ea548d2a3194aab795452d6fd7924afbf717ed91b2a9e1e0e1271a95a69c6acb7c52dce9c7a73e7f249bcab4cfe38e6a2838ca989c6ceca3396b6f0ee8c6fb937a2bf37a1e81d8fecb7716ad5f2bab64a1183cd0a51e8f8cbaff00a9e7f4294f68639e1e949aa72ad5249ef8d3a0a6db715b969b97391ebfb2b64d0c2c7250a6a2ac93b5db95b8b7c5978e6eede5cf9ee5353a6f000dd880000000000000000000000000000000070ab4e324e3249c5ef4d269fa1ca4ecae4563e739a6a2a4fa434f77b97a8ab3d4763f614e94e3570b24927e284dbb28f1caff00f57e856bb41b4e72bc649256e1ae84f53d838a93ba94297aba93f576fc4c43b17de34f135dcbf669c547f99fe46571b7c8f5e3c931bbcaeffb42f61b16a185da8dcbc318e7d37abd392d179a281b62bda0ed04ac9accdb949a7bfa25e9ea7a576c3b2d86c3e1e589a19a94e2953928d49b8d4a72928b8cd37aead3bf4f6f2edaf59649439a6f7f2ff532cf7b91e6cf2facb712b4dce34b0d5db7fa58b9292baf1467285efcef0bf9ebc4bd52db6abe1e8d5ccbbe5fa3a8afae65ba56e4d24fcdb2bb530ebfd9bc0d49ab4e352595fec4eb54f969197a22bbd9dda17a9357b49d27a7ed42519bfe58cc5c6e36e9df0ff9c5bb6a6367427531d454a588fab7d560924d4653a9151a9e49397ae5e1739ada33a542a460dca50a1349abca53a91a5277e6dca49bead9b3b2f0ef112c90695d5dc9abe58f176e2f975f23b3ea51c2e2f0b0526e12ab1516ed7df6b3f71bcac95ecf8e396cfdd26fb01d96581a0a5512facce2b3bdf923c29af2e3cdfa16b00f4c9a7cd000500000000000000000000000000000000189453d1848c800000223b598196230589a50579ba6dc5739c5a9457ab8a5ea7cd78dab29bf73eab3cafb75f46b3a956a62b04e094af52a5295e3e3df270b2d6ffaba6b7d75b2e6cfd58dfc05175361eca8a49b52c3cda6e2bf4719b6debc2c8aa54d8b86a389ad3a39a4bbca8e0dbcaa309271c8a2b7da326aefe45bb038e5536652aea118cbbe8e19c29ac94e2bbd50f0ade96569d88bc63a74f115e12965c3d3ab38250515567929acd1bb4ef2752a53577a24a5cae679cb7c7a3832c31bbcbb746c5dbb1c2b941fda4b7efd2fa75de73c6ed6a95abd29a4bc1255637575ce2edcb421254e15e4a0aa28d493f04674e2e2e4dd9473c568ddd2bb45a7b3dd95ab528538ce5ddd584a5096685ef4ef74add1b767c9f919c96f4f565c9c77f925b05da0c5c9f8a517d3bb489cc1ed6a92f8a9a5fc4bef34e876452569626af95250a4bee6dfab648617b3f469fdaa92fde9fe491b63327933cb8ef91214eb5f7ab7cd1dc74430908ee4ff008e5f99dc958d1e764000000000000000000000000000000000000000000079cd4a0b0b0da385dd08e3b0d888f254aad486ee8bbb651f6862eae22bb8d3a729d59d4a8e10a69ca5272a929393e51d52bf42f7f4952eeea36fe1ad8654f8eb529d78cd7f2b9139f47fb32347074ea382556aaef1cb2a52707f026edfab67eaccecddd3adea34fb0bd8cfaa2588c4da58b6b72d61493fb31e6f5dfedd6e0a9a4eeb79cc1dc9a72000a000000000000000000000000000000000000000000000000285f4b11bd2c3f3bd456d2f6718ebe9a7b979c3d25084611568c62a2bc92b228bf4ae964c337cea7dd07f817e24f6adf000150000000000000000000000000000000000000000000000000000144fa4fa39de0236f8ab4a1fc59117b299f4814f355d96bfb6457bd4a68b9927aa000a80000000000000000000000000000000000000000000000000000acf6ce2b36cd7c56d1a0bde4aff00722cc563b6caef66a5bffa4a87c9b7f8167228002a00000000000000000000000000000000000000000000000000002b9db05e2d9baffcc68fdd22c656fb60af3d98bfee349fb466cb21000050000000000000000000000000000000000000000000000000000103da6866abb3572c6c65d74a553713c407681ff5ad971fed151fb509fe64f91400150000000000000000000000000000000000000000000000000000103b73fdf3667f7b5bff00032780245000540000000000000000000000007fffd9, '2024-03-19', 'General');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE IF NOT EXISTS `User` (
  `userID` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_picture` blob,
  `dob` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`userID`, `username`, `password`, `email`, `profile_picture`, `dob`) VALUES
(1, 'testuser', 'testuser123', 'testuser@test.com', NULL, '2003-03-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `Discussions`
--
ALTER TABLE `Discussions`
  ADD PRIMARY KEY (`discussionID`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `commentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Discussions`
--
ALTER TABLE `Discussions`
  MODIFY `discussionID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

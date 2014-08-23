-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2014 at 07:27 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `proposalbuilder`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE IF NOT EXISTS `company_details` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `legal_name` text,
  `trading_name` text,
  `head_office` text,
  `postal_address` text,
  `telephone_no` text,
  `fac_no` text,
  `web` text,
  `primary_contact` text,
  `acn` text,
  `abn` text,
  `poc_email` text,
  `mobile_no` text,
  `proposal_id` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `proposal_id` (`proposal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `legal_name`, `trading_name`, `head_office`, `postal_address`, `telephone_no`, `fac_no`, `web`, `primary_contact`, `acn`, `abn`, `poc_email`, `mobile_no`, `proposal_id`) VALUES
(15, 'BRISTON TRAINING AND DEVELOPMENT PTY LTD', 'BRISTON OUTSOURCING SERVICE SOLUTIONS (BOSS)', 'Building 1, Level 3, 2-14 Murrajong Road, Springwood, QLD, 4127', 'Southgate, Box 8, 3350 Pacific Highway, Springwood, 4127', '1300 919 692', '(07) 3503 9191', 'http://www.briston.com.au', 'Andrew Bridge', '35 151 116 746', '35 151 116 746', 'andrew.bridge@briston.com.au', '0404 036 591', 27),
(16, 'BRISTON TRAINING AND DEVELOPMENT PTY LTD', 'BRISTON OUTSOURCING SERVICE SOLUTIONS (BOSS)', 'Building 1, Level 3, 2-14 Murrajong Road, Springwood, QLD, 4127', 'Southgate, Box 8, 3350 Pacific Highway, Springwood, 4127', '1300 919 692', '(07) 3503 9191', 'http://www.briston.com.au', 'Andrew Bridge', '35 151 116 746', '35 151 116 746', 'andrew.bridge@briston.com.au', '0404 036 591', 28);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `image` longtext NOT NULL,
  `proposal_id` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `proposal_id` (`proposal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE IF NOT EXISTS `proposals` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `client_name` text NOT NULL,
  `submission_date` date DEFAULT NULL,
  `company_overview` text,
  `confirmation_of_requirements` text,
  `scope_of_works` text,
  `cost_estimate` text,
  `conclusion` text,
  `date_modified` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(250) DEFAULT 'Draft',
  `proposal_type_id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `proposal_type_id` (`proposal_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `proposals`
--

INSERT INTO `proposals` (`id`, `title`, `client_name`, `submission_date`, `company_overview`, `confirmation_of_requirements`, `scope_of_works`, `cost_estimate`, `conclusion`, `date_modified`, `date_created`, `status`, `proposal_type_id`, `user_id`) VALUES
(27, 'Briston Proposal', 'Kevin Cotongco', '2014-08-02', '<p><br><br></p><table class="mce-item-table"><tbody><tr><td><img src="http://localhost/proposalbuilder/app/classes/tcpdf/images/company_overview_briston.jpg" alt="" data-mce-src="http://localhost/proposalbuilder/app/classes/tcpdf/images/company_overview_briston.jpg"></td><td><p>Briston Training and Development Pty Ltd (Briston) is a Registered Training Organisation (RTO) based in Brisbane, Qld. The company operates in three primary service areas, namely training design, training delivery, and provision of training support services. While Briston has the capacity to deliver nationally recognised qualifications from its own scope, the company also partners with several other RTOs including Evocca College, Outsource Services, and Shoreline Learning and Development to deliver a wide range of qualifications to clients across all industry groups.</p><p>Briston commenced delivery of training in January 2010 for its first client within the corrective services industry. Initial programs were custom designed for delivery to inmates within a maximum security remand center in Brisbane focusing on community based behaviors, and on provision of peer support roles within high risk units. The program was quickly expanded to incorporate delivery of â€œin Unitâ€ Health and Fitness programs and LLN tutor training. Since this time, Briston has designed and delivered more than 15 different education programs for correctional centers using delivery methods and systems, which integrate seamlessly with security and operational requirements within each facility.</p><p>In April 11, Briston restructured to form a dedicated training design cell responsible for the conduct of specialized training analysis and design, developing customized courses for delivery in response to clientâ€™s needs.</p></td></tr></tbody></table>', '<p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', '<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p><p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>', '<p>This cost allows for an initial consultation regarding the desired output of the overall project, three consolidated client feedback rounds, and the time and costs associated with producing audio scripts and voice.</p><p>The three feedback rounds consist of one following submission of an initial sample module to confirm style, structure and understanding of intent, a second following submission of all first draft modules and a third prior to final submission of the courses. As Briston guarantees the standard of our work and endeavours to set the standard amongst eLearning providers, we will ensure that all submitted materials are developed to meet the expectations agreed during project acceptance and in the three provided review rounds.</p><p><strong style="color: #1a69e0;" data-mce-style="color: #1a69e0;">Conclusion â€“ Moving forward</strong></p><p>Once you have made the decision to engage us for this project, we recommend a scope confirmation meeting to ensure that all parameters have been identified correctly, to discuss and review base materials, and to confirm design timeframes, processes and deliverables.</p><p>Should you have questions on this project or once you are ready to proceed, please feel contact me on the details below at any time. I would be happy to meet with you at your convenience should you wish to discuss the project or our capability in person.</p><p><strong>Andrew Bridge</strong><br> Director<br> <span style="color: #1a69e0;" data-mce-style="color: #1a69e0;"><em>Briston Training &amp; Development</em></span> <span style="color: #1a69e0;" data-mce-style="color: #1a69e0;"><em>Briston Outsourcing Service Solutions</em></span><br> <span style="color: #1a69e0;" data-mce-style="color: #1a69e0;"><em>M: 0404 036 591 | E: andrew.bridge@briston.com.au</em></span></p>', '2014-08-22', '2014-08-21 16:08:40', 'Draft', 1, 1),
(28, 'Sample Boss Proposal', 'Kevin Cotongco', '2014-08-15', '<p style="text-align:justify;">Briston Outsourcing Service Solutions (BOSS), is an Australian owned and operated company providing managed capability outsourcing services to clients across Australia. Our company specializes in identify existing or emerging capabilities within organizations and establishing low cost, fully integrated outsourced services to reduce your cost baseline and increase your scope of operations. We have the knowledge, skills and resources to provide your company with access to an inexpensive, highly proficient, global workforce that will allow you to compete effectively in any market.</p><br/><table><tr><td><p style="text-align:justify;"><br/>Our primary aim is to reduce the risk that clients face when stepping into the world of outsourcing by ensuring that we provide detailed analysis, and full capability management services. This is done by following a simple process:</p></td><td>&nbsp;&nbsp;<img src="http://localhost/proposalbuilder/app/classes/tcpdf/images/company_overview_boss.jpg" /></td></tr></table><ol><li><p style="text-align:justify;">Conduct a detailed analysis of your requirements to identify what capabilities are available for you to outsource, what systems and processes you have in place, and what modifications and support training you need to get moving.</p></li><li><p style="text-align:justify;">Establish the recruiting requirements for your new team members in the Philippines, then recruit, induct and train your new team.</p></li><li><p style="text-align:justify;">Manage minor modifications within your organisation to allow you to effectively integrate your new capability. This may include introduction of new cloud based IT and communications systems, development of new SOPs, and training of your existing team to work cohesively with your new team members.</p></li><li><p style="text-align:justify;">Provide ongoing performance management of your new team on the ground in our Manila office through detailed training, development, and management by our Australian management staff. We are one of the few BPOs to provide qualified Australian training and management staff in our Manila office working hand in hand with your Philippines staff to guarantee you get the capability that you need.</p></li></ol>', NULL, NULL, NULL, '<p>Jarrod I apologize for the sheer length of this overall quite simple estimate! However I wanted to give you as much information as I could. Whether you decide to go with us or not, as I mentioned via Skype, give me a call anytime and I am happy to act as a sounding board to talk you through some of the considerations, risks or options that you may encounter.</p><p>If you do decide to go with us then please contact me anytime and we can get started on refining exactly what you want in each role in terms of experience and skill, and my guys will start developing our testing procedures for the recruitment phase.</p><p>For the VA in particular, we are still in start up phase with that capability. We have plenty to select from, but I guess my point is that I am happy to play around with the rates I quoted above and run much lower margins if you can help me test and establish the procedures for clients as I take this to market, and once we have it running smoothly, help me spread the good word on BOSS! Anything you can do to help us get our name out there would be appreciated and I am happy to run referral programs etc.</p><p>Overall though, as I said above, we may not be the cheapest, but I guarantee we are the safest and most efficient. We would love the chance to work with you so please keep us in mind and hopefully I hear from you soon.</p><p>Kind regards,</p><b>Andrew Bridge</b><br/>Director<br/>Briston Outsourcing Service Solutions<br/><br/>M: 0404 036 591 | E: andrew.bridge@briston.com.au<br/>', '2014-08-22', '2014-08-21 16:09:13', 'Draft', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `proposal_types`
--

CREATE TABLE IF NOT EXISTS `proposal_types` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `type` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `proposal_types`
--

INSERT INTO `proposal_types` (`id`, `type`) VALUES
(1, 'Briston'),
(2, 'Boss');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `fname` text,
  `lname` text,
  `email` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `password`) VALUES
(1, 'Kevin', 'Cotongco', 'cotongcokevin@yahoo.com', '5f4dcc3b5aa765d61d8327deb882cf99');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company_details`
--
ALTER TABLE `company_details`
  ADD CONSTRAINT `company_details_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `proposals` (`id`);

--
-- Constraints for table `proposals`
--
ALTER TABLE `proposals`
  ADD CONSTRAINT `proposals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `proposals_ibfk_2` FOREIGN KEY (`proposal_type_id`) REFERENCES `proposal_types` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

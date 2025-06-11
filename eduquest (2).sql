-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 12:18 AM
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
-- Database: `eduquest`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `otp_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `otp`, `otp_expiry`) VALUES
(4, 'aswinsudhan2004@gmail.com', '$2y$10$6ry5R9hqbA.dZgGB8T4qye/PXLOnTxED4L3Q0WYJch081eagi9l.q', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_messages`
--

CREATE TABLE `admin_messages` (
  `id` int(11) NOT NULL,
  `recipient_type` enum('teacher','staff') NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_messages`
--

INSERT INTO `admin_messages` (`id`, `recipient_type`, `subject`, `message`, `sent_at`, `status`) VALUES
(1, 'teacher', 'test1', 'efsefsedfsdfsdfsd', '2025-04-20 20:06:29', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `assignment_title` varchar(255) DEFAULT NULL,
  `assignment_description` text DEFAULT NULL,
  `helping_material` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `section_id`, `assignment_title`, `assignment_description`, `helping_material`, `created_at`) VALUES
(1, 1, 'First Assignment', 'test1', 'uploads/1744959875_Tutorial_EDIT.pdf', '2025-04-18 07:04:35'),
(2, 5, 'html assignment ', 'html assignment 1', 'uploads/1745175868_html-tags-chart.pdf', '2025-04-20 19:04:28');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `published_date` datetime DEFAULT current_timestamp(),
  `main_image` varchar(255) DEFAULT NULL,
  `sub_image1` varchar(255) DEFAULT NULL,
  `sub_image2` varchar(255) DEFAULT NULL,
  `sub_image3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `content`, `author`, `published_date`, `main_image`, `sub_image1`, `sub_image2`, `sub_image3`) VALUES
(4, 'New cours ', 'This course offers a comprehensive journey through modern web development, focusing on cutting-edge technologies and industry best practices. Students will gain hands-on experience building responsive, dynamic, and secure web applications using HTML5, CSS3, JavaScript (ES6+), and frameworks such as React.js and Node.js.', 'COLLEGE MANAGEMENT', '2025-04-20 19:07:38', 'uploads/blog_1745156258_imp.webp', NULL, NULL, NULL),
(5, 'Final Exam', 'The Final Exam is the concluding assessment of the course and is designed to evaluate students\' overall understanding and mastery of the subject material. This exam encompasses key topics covered throughout the course and challenges students to apply their theoretical knowledge in practical scenarios.', 'COLLEGE MANAGEMENT', '2025-04-20 19:08:13', 'uploads/blog_1745156293_ex.webp', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `phone`, `subject`, `message`, `submitted_at`) VALUES
(13, 'Aswin', 'aswinsudhan2004@gmail.com', '789456123', 'test11', 'test11', '2025-04-20 11:02:45'),
(14, 'Aswin', 'aswinsudhan2004@gmail.com', '789456123', 'test11', 'test11', '2025-04-20 11:03:08'),
(15, 'Aswin', 'aswinsudhan2004@gmail.com', '789456123', 'test11', 'test11', '2025-04-20 11:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `sub_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `discounted_price` decimal(10,2) DEFAULT NULL,
  `discount_percentage` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `short_notes` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `requirements` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `sub_name`, `price`, `discounted_price`, `discount_percentage`, `image`, `short_notes`, `description`, `requirements`, `created_at`, `created_by`) VALUES
(4, 'web developer', 'in python', 10000.00, 6000.00, 40, 'uploads/cc1.jpg', 'Web Development is the process of creating websites or web applications that run on the internet. It includes two main areas: Frontend development, which focuses on what users see and interact with using HTML, CSS, and JavaScript, and Backend development, which handles the server, database, and application logic using languages like Python, PHP, or Node.js. Web developers build responsive, functional, and user-friendly websites by combining design, programming, and problem-solving skills.', 'Web Development refers to the process of building and maintaining websites or web applications that run on a browser. It involves a combination of coding, designing, and problem-solving to create functional and visually appealing digital platforms. The development process is generally divided into two parts: Frontend development, which deals with the user interface and experience, and Backend development, which manages data, servers, and business logic. Web developers use various tools and technologies to ensure websites are responsive, fast, secure, and user-friendly across different devices and platforms.', '0', '2025-04-15 09:30:01', NULL),
(5, 'python developer', 'beginner', 5000.00, 2500.00, 50, 'uploads/PY.png', 'A Python Developer course focused on data teaches the fundamentals of Python programming, including variables, data types, loops, functions, and object-oriented concepts. It also covers data handling with libraries like pandas and numpy, visualization using matplotlib, and working with files, APIs, and databases. You’ll learn how to scrape data from websites, fetch data from APIs, and store or manipulate it using SQL or NoSQL databases. Optional modules like Flask or Django introduce web development and API building. This course is ideal for those looking to build data-driven applications or work in data-focused roles.', 'The Python Developer (Data-Focused) Course is designed to equip learners with strong programming skills in Python, with a special emphasis on handling, analyzing, and working with data. This course covers Python basics, core programming concepts, and essential data libraries such as pandas, numpy, and matplotlib. Students will also learn to interact with databases, work with APIs, and perform web scraping. Additionally, the course introduces basic web development using Flask or Django to build data-driven applications. Ideal for aspiring data analysts, backend developers, or anyone looking to build real-world Python projects, this course provides hands-on experience through practical assignments and mini-projects.', '0', '2025-04-15 10:46:40', NULL),
(10, 'java developer', 'expert', 29999.00, 8999.70, 70, 'uploads/java2.jpg', 'The Java Expert Course is designed to take you from a solid understanding of Java fundamentals to mastering advanced concepts, equipping you with the skills needed to build scalable, efficient, and high-performance applications. The course begins with a review of core Java concepts such as object-oriented programming (OOP), data types, loops, functions, and exception handling. It then moves on to more advanced topics like multi-threading, concurrency, Java Collections Framework, and memory management. You’ll also learn how to work with databases using JDBC (Java Database Connectivity), implement design patterns, and build RESTful APIs. The course includes in-depth coverage of frameworks like Spring and Hibernate for building enterprise-level applications, along with tools like Maven and Gradle for project management. Further, it explores Java’s integration with web technologies, cloud computing, and best practices for security, testing, and performance tuning. The course culminates with practical, real-world projects that will help you gain hands-on experience and showcase your expertise as a Java developer.', ' The **Java Expert Course** is an advanced-level program designed for individuals who want to master Java programming and become proficient in building complex, high-performance applications. The course covers a wide range of topics, starting from core Java concepts like object-oriented programming (OOP), data structures, and exception handling, progressing to advanced subjects such as multi-threading, concurrency, and memory management. It also dives into popular frameworks like **Spring** and **Hibernate**, helping you build robust, scalable enterprise applications. You will gain experience in working with databases using JDBC, create RESTful APIs, and learn essential tools such as Maven and Gradle for project management. The course also emphasizes best practices in Java development, including security, testing, and performance optimization. By the end of the course, you will have a strong foundation in Java and the expertise needed to build complex applications and tackle real-world problems, making you an expert Java developer.', 'Computer with internet access (Windows, macOS, or Linux).\r\nJava Development Kit (JDK) installed on your machine (preferably the latest version).\r\nIDE for Java development, such as IntelliJ IDEA, Eclipse, or NetBeans.\r\nFamiliarity with command-line tools for running Java programs and managing dependencies.', '2025-04-15 11:55:18', NULL),
(12, 'data science', 'based on python', 12999.00, 3899.70, 70, 'uploads/cc2.jpg', '                The Data Science in Python syllabus provides a comprehensive journey into the world of data analysis and machine learning. It begins with an introduction to Python programming, covering core concepts such as variables, data types, functions, and object-oriented programming. Students then dive into data manipulation using powerful libraries like pandas for handling structured data, numpy for numerical operations, and matplotlib and seaborn for data visualization. As they progress, learners will explore statistical analysis, probability, and hypothesis testing to better understand data patterns. The course also introduces machine learning with scikit-learn, where students build and evaluate models for classification, regression, and clustering tasks. Finally, the course touches on working with real-world datasets, web scraping, APIs, and even deploying machine learning models to production. Throughout the course, students will work on hands-on projects and case studies to solidify their understanding and build a portfolio of work.', 'The **Data Science in Python** course is designed to teach students how to analyze and interpret complex data using Python. It starts with an introduction to Python programming, including essential concepts like variables, loops, and functions. The course focuses on data manipulation and cleaning using libraries such as **pandas** and **numpy**, along with data visualization using **matplotlib** and **seaborn**. Students will learn how to analyze datasets, perform statistical analysis, and gain insights through exploratory data analysis (EDA). As the course progresses, learners will be introduced to machine learning with **scikit-learn**, covering key techniques for classification, regression, and clustering. They will also explore working with real-world datasets, web scraping, and building data-driven applications. By the end of the course, students will be equipped to solve real-life problems and create predictive models, making them ready for roles in data science or analytics.', 'Computer with internet access (Windows, macOS, or Linux).\r\nPython installed on your system (preferably the latest version).\r\nCode editor/IDE such as VS Code, PyCharm, or Jupyter Notebook for coding.\r\nFamiliarity with command-line basics to install libraries and run scripts.', '2025-04-15 12:06:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `course_sections`
--

CREATE TABLE `course_sections` (
  `section_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `section_title` varchar(255) NOT NULL,
  `section_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_sections`
--

INSERT INTO `course_sections` (`section_id`, `course_id`, `section_title`, `section_description`) VALUES
(1, 5, 'beginning level', 'basic level '),
(2, 5, 'Advance level', 'more deeper in coding'),
(3, 5, 'Expert level', 'he/she can develop software'),
(5, 4, 'HTML', 'basic html'),
(6, 4, 'CSS', 'basic css'),
(7, 4, 'Javascript', 'basic javascript');

-- --------------------------------------------------------

--
-- Table structure for table `course_tags`
--

CREATE TABLE `course_tags` (
  `course_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course_tags`
--

INSERT INTO `course_tags` (`course_id`, `tag_id`) VALUES
(4, 1),
(4, 2),
(4, 3),
(4, 5),
(4, 6),
(4, 8),
(4, 48),
(4, 56),
(4, 57),
(4, 58),
(4, 59),
(4, 61),
(5, 5),
(5, 33),
(5, 34),
(10, 3),
(10, 22),
(10, 63),
(12, 15),
(12, 17),
(12, 33),
(12, 34),
(12, 61),
(12, 73);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `main_heading` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `organized_by` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `main_event_image` varchar(255) DEFAULT NULL,
  `sub_image1` varchar(255) DEFAULT NULL,
  `sub_image2` varchar(255) DEFAULT NULL,
  `sub_image3` varchar(255) DEFAULT NULL,
  `main_guest1` varchar(255) DEFAULT NULL,
  `main_guest2` varchar(255) DEFAULT NULL,
  `guest_images1` varchar(255) DEFAULT NULL,
  `guest_images2` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `main_heading`, `event_date`, `organized_by`, `description`, `main_event_image`, `sub_image1`, `sub_image2`, `sub_image3`, `main_guest1`, `main_guest2`, `guest_images1`, `guest_images2`, `created_at`) VALUES
(8, 'PROJECT SUBMISSION 2025', '2025-04-21', 'COLLEGE MANAGEMENT', 'College is a transformative journey that offers more than just academic learning. It’s a time of exploration, where students not only gain knowledge in their chosen fields but also discover their passions, build lifelong friendships, and develop important life skills. From late-night study sessions and campus events to spontaneous conversations in the cafeteria, every experience contributes to shaping a person\'s identity. College challenges individuals to step out of their comfort zones, think critically, and prepare for the opportunities and responsibilities that await beyond graduation.', 'uploads/1745185777_b2.jpg', 'uploads/1745185777_b4.jpg', 'uploads/1745185777_b5.jpg', 'uploads/1745185777_b6.jpg', 'professor 1', 'professor 2', 'uploads/1745185777_team-1.jpg', 'uploads/1745185777_team-3.jpg', '2025-04-20 21:49:37');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `note_id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `note_title` varchar(255) DEFAULT NULL,
  `note_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`note_id`, `video_id`, `note_title`, `note_file`) VALUES
(1, 2, 'basic note', 'uploads/notes/1744958613_python_tutorial.pdf'),
(2, 4, 'html tags', 'uploads/notes/1745175319_html-tags-chart.pdf'),
(3, 5, 'css', 'uploads/notes/1745186965_CSS.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `otp` varchar(100) NOT NULL,
  `otp_send_time` varchar(100) NOT NULL,
  `verify_otp` varchar(100) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `otp`
--

INSERT INTO `otp` (`id`, `name`, `email`, `phone`, `password`, `otp`, `otp_send_time`, `verify_otp`, `ip`, `status`) VALUES
(12, 'Aswin', 'Aswinsudhan2004@gmail.com', '9446978609', '$2y$10$GIZUH6VVaMTc/yDybwH.ReZVcqR0ZseXMzwbHrLp0R.3.dlwQYWHW', '880356', '2025-04-20 13:36:29', '', '::1', 'verified'),
(13, 'Aswin', 'aswinsudhan2004@gmail.com', '9446978609', '$2y$10$t4SSDCEzW/07/TH8veMkEO70RtTecUpUfniJpGYJZG5XIu.waUmuK', '960740', '2025-04-20 13:37:32', '', '::1', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_email`, `user_name`, `course_id`, `address`, `phone`, `amount`, `status`, `created_at`) VALUES
(13, 'aswinsudhan2004@gmail.com', 'Aswin', 5, 'hhhhhh', '83048 58609', 3500, 'approved', '2025-04-20 21:23:57'),
(14, 'aswinsudhan2004@gmail.com', 'Aswin', 10, 'Kanhangad,Kerala', '7907084848', 8999.7, 'pending', '2025-04-20 21:38:27'),
(15, 'aswinsudhan2004@gmail.com', 'Aswin', 4, 'Kannur.Kerala', '83048 58609', 5000, 'pending', '2025-04-20 21:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` enum('a','b','c','d') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `course_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`) VALUES
(74, 5, 'What is the output of: print(type([]))?', 'list', 'dict', 'tuple', 'set', 'a'),
(75, 5, 'Which keyword is used for function in Python?', 'func', 'def', 'function', 'define', 'b'),
(76, 5, 'Which of these is a Python tuple?', '[1, 2, 3]', '{1, 2, 3}', '(1, 2, 3)', '<<1, 2, 3>>', 'c'),
(77, 5, 'What does the len() function do?', 'Returns the type', 'Returns number of arguments', 'Returns the length', 'None of the above', 'c'),
(78, 5, 'Which of the following is a correct variable name?', '2var', '_var_name', 'var-name', 'None', 'b'),
(79, 5, 'Which operator is used for exponentiation in Python?', '^', '**', '//', '%', 'b'),
(80, 5, 'What is the output of: print(\"Hello\" + str(5))?', 'Hello5', 'Hello 5', 'Error', '5Hello', 'a'),
(81, 5, 'How do you start a comment in Python?', '#', '//', '--', '/*', 'a'),
(82, 5, 'Which of the following is immutable?', 'List', 'Set', 'Dictionary', 'Tuple', 'd'),
(83, 5, 'Which method adds an item to a list?', 'add()', 'append()', 'insert()', 'extend()', 'b'),
(84, 5, 'How do you create a set in Python?', '[1,2,3]', '{1,2,3}', '(1,2,3)', 'set[1,2,3]', 'b'),
(85, 5, 'What is the output of 5 // 2?', '2.5', '2', '3', '1', 'b'),
(86, 5, 'What does the “break” keyword do?', 'Skips current loop', 'Exits the loop', 'Restarts the loop', 'None', 'b'),
(87, 5, 'What will “type(3.14)” return?', 'int', 'str', 'float', 'double', 'c'),
(88, 5, 'Which of the following opens a file for reading in binary mode?', 'r', 'rb', 'r+', 'wb', 'b'),
(89, 5, 'Which keyword is used for a conditional statement in Python?', 'switch', 'if', 'when', 'select', 'b'),
(90, 5, 'What is the output of bool(0)?', 'True', 'False', 'None', 'Error', 'b'),
(91, 5, 'Which of the following is a loop structure in Python?', 'if', 'try', 'for', 'def', 'c'),
(92, 5, 'What does the range(3) return?', '[1, 2, 3]', '[0, 1, 2]', '[0, 1, 2, 3]', 'None of these', 'b'),
(93, 5, 'What is the correct syntax to define a class in Python?', 'function MyClass:', 'class MyClass:', 'define class MyClass:', 'MyClass class:', 'b');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `result_id` int(11) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `total_questions` int(11) DEFAULT NULL,
  `correct_answers` int(11) DEFAULT NULL,
  `wrong_answers` int(11) DEFAULT NULL,
  `negative_marks` float DEFAULT 0,
  `final_score` float DEFAULT NULL,
  `percentage` float DEFAULT NULL,
  `passed` tinyint(1) DEFAULT NULL,
  `taken_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`result_id`, `user_email`, `course_id`, `level`, `total_questions`, `correct_answers`, `wrong_answers`, `negative_marks`, `final_score`, `percentage`, `passed`, `taken_at`) VALUES
(1, 'nidhasheikh401@gmail.com', 5, 1, 30, 13, 7, 1.75, 11.25, 37.5, 0, '2025-04-18 11:22:41'),
(2, 'nidhasheikh401@gmail.com', 5, 2, 30, 18, 2, 0.5, 17.5, 58.3333, 1, '2025-04-18 11:24:34'),
(3, 'nidhasheikh401@gmail.com', 5, 1, 30, 17, 3, 0.75, 16.25, 54.1667, 1, '2025-04-18 11:33:28'),
(4, 'aswinsudhan2004@gmail.com', 5, 1, 20, 13, 7, 1.75, 11.25, 56.25, 1, '2025-04-20 08:16:55');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `house_name` varchar(150) DEFAULT NULL,
  `place` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `aadhar_number` varchar(20) DEFAULT NULL,
  `aadhar_file` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `first_name`, `last_name`, `email`, `phone`, `gender`, `dob`, `house_name`, `place`, `district`, `pincode`, `address`, `certificate`, `aadhar_number`, `aadhar_file`, `photo`, `password`, `created_at`) VALUES
(13, 'aswin', '01', 'darkspotgamin2020@gmail.com', '789456123', 'Male', '2012-06-07', 'pattuvath house', 'Kanhangad', 'Kasaragod', '654333', 'pattuvath house', 'team-2.jpg', '123456789', '71eGdf7X3rL._AC_UF1000,1000_QL80_.jpg', 'team-4.jpg', '$2y$10$kGc7wbu.5iNgyoNcVthWBOg8NVVNcYbIcjER02sQ.mk59Slri0WcC', '2025-04-20 13:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `staff_complaints`
--

CREATE TABLE `staff_complaints` (
  `id` int(11) NOT NULL,
  `staff_name` varchar(255) NOT NULL,
  `staff_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `recipient` enum('admin','teacher') NOT NULL,
  `status` enum('pending','resolved') DEFAULT 'pending',
  `submitted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_complaints`
--

INSERT INTO `staff_complaints` (`id`, `staff_name`, `staff_email`, `subject`, `message`, `recipient`, `status`, `submitted_at`) VALUES
(1, 'aswin 01', 'darkspotgamin2020@gmail.com', 'test1', 'wwdwdwdwddwdwwd', 'admin', '', '2025-04-21 00:12:48'),
(2, 'aswin 01', 'darkspotgamin2020@gmail.com', 'dwdwddw', 'wdwwdwd', 'admin', 'resolved', '2025-04-21 00:12:58'),
(4, 'aswin 01', 'darkspotgamin2020@gmail.com', 'test2', 'gsefsdf', 'teacher', 'resolved', '2025-04-21 02:02:24'),
(5, 'aswin 01', 'darkspotgamin2020@gmail.com', 'test2', 'durtrstustr', 'teacher', 'resolved', '2025-04-21 02:03:51');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `tag_name`) VALUES
(28, '.NET'),
(70, 'Agile'),
(52, 'Android'),
(9, 'Angular'),
(64, 'APIs'),
(37, 'Artificial Intelligence'),
(68, 'Automation Testing'),
(42, 'AWS'),
(43, 'Azure'),
(59, 'Backend'),
(77, 'Blockchain'),
(13, 'Bootstrap'),
(76, 'Business Analysis'),
(25, 'C'),
(27, 'C#'),
(26, 'C++'),
(50, 'Canva'),
(41, 'Cloud Computing'),
(72, 'Computer Basics'),
(78, 'Cryptocurrency'),
(2, 'CSS'),
(38, 'Cyber Security'),
(32, 'Data Analysis'),
(31, 'Data Science'),
(30, 'Deep Learning'),
(21, 'DevOps'),
(6, 'Django'),
(39, 'Ethical Hacking'),
(73, 'Excel'),
(12, 'Express.js'),
(49, 'Figma'),
(45, 'Firebase'),
(7, 'Flask'),
(54, 'Flutter'),
(58, 'Frontend'),
(57, 'Full Stack'),
(18, 'Git'),
(19, 'GitHub'),
(44, 'Google Cloud'),
(66, 'GraphQL'),
(1, 'HTML'),
(53, 'iOS'),
(22, 'Java'),
(3, 'JavaScript'),
(63, 'JQuery'),
(24, 'Kotlin'),
(20, 'Linux'),
(29, 'Machine Learning'),
(51, 'Mobile App Development'),
(17, 'MongoDB'),
(15, 'MySQL'),
(40, 'Networking'),
(11, 'Node.js'),
(62, 'NoSQL'),
(34, 'NumPy'),
(33, 'Pandas'),
(4, 'PHP'),
(16, 'PostgreSQL'),
(74, 'Power BI'),
(5, 'Python'),
(36, 'PyTorch'),
(8, 'React'),
(55, 'React Native'),
(65, 'REST API'),
(71, 'Scrum'),
(69, 'Selenium'),
(47, 'SEO'),
(67, 'Software Testing'),
(23, 'Spring Boot'),
(61, 'SQL'),
(75, 'Tableau'),
(14, 'Tailwind CSS'),
(35, 'TensorFlow'),
(48, 'UI/UX Design'),
(60, 'VS Code'),
(10, 'Vue.js'),
(56, 'Web Development'),
(46, 'WordPress');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `house_name` varchar(255) DEFAULT NULL,
  `place` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1,
  `photo` varchar(255) DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `aadhar_file` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `aadhar_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `first_name`, `last_name`, `gender`, `dob`, `email`, `phone`, `department`, `house_name`, `place`, `district`, `pincode`, `status`, `photo`, `certificate`, `aadhar_file`, `address`, `password`, `aadhar_number`) VALUES
(8, 'eduquest', '02', 'Female', '1999-05-03', 'aswinsudhan2004@gmail.com', '7907084848', 4, 'pattuvath house', 'Kanhangad', 'Kasaragod', '671315', 1, '1745153693_team-3.jpg', '1745153693_6730df2409b4ad6b492e7951-trend-certificate-of-excellence-classic.jpg', '1745153693_photo.webp', 'pattuvath house, Kanhangad, Kasaragod, 671315', '$2y$10$QWmUmSjdP/BiaGcHVP2PHO6Idt904XSZVJJpIbkI5DecehOog4N52', '987456321');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_complaints`
--

CREATE TABLE `teacher_complaints` (
  `id` int(11) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `teacher_email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `recipient` enum('admin','subadmin') NOT NULL,
  `status` enum('pending','resolved') DEFAULT 'pending',
  `submitted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_complaints`
--

INSERT INTO `teacher_complaints` (`id`, `teacher_name`, `teacher_email`, `subject`, `message`, `recipient`, `status`, `submitted_at`) VALUES
(4, 'eduquest 02', 'aswinsudhan2004@gmail.com', 'wdwdw', 'sdfsdfsdfsedfsdf', 'admin', 'resolved', '2025-04-21 00:37:58'),
(5, 'eduquest 02', 'aswinsudhan2004@gmail.com', 'dsfsdfsdfsd', 'fdasfafsasfasdfasdf', 'admin', 'resolved', '2025-04-21 00:38:03'),
(8, 'eduquest 02', 'aswinsudhan2004@gmail.com', 'fedssdfdfas', 'afasfasf', 'subadmin', 'resolved', '2025-04-21 02:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `video_title` varchar(255) NOT NULL,
  `video_description` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `video_duration` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`video_id`, `section_id`, `uploaded_by`, `video_title`, `video_description`, `video_url`, `video_duration`) VALUES
(2, 1, NULL, 'pyhon installetion', 'test1', 'uploads/1744957581.mp4', '12:47'),
(3, 2, NULL, 'Basic coding', 'Basic coding', 'uploads/1744958135.mp4', '10:47'),
(4, 5, 8, 'HTML foundation', 'basic tags and know how to run', 'uploads/1745175116.mp4', '18:41'),
(5, 6, 8, 'css besic', 'css basic', 'uploads/1745186931.mp4', '10:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin_messages`
--
ALTER TABLE `admin_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_name` (`course_name`),
  ADD KEY `fk_created_by` (`created_by`);

--
-- Indexes for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `course_tags`
--
ALTER TABLE `course_tags`
  ADD PRIMARY KEY (`course_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `aadhar_number` (`aadhar_number`);

--
-- Indexes for table `staff_complaints`
--
ALTER TABLE `staff_complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `aadhar_number` (`aadhar_number`),
  ADD KEY `department` (`department`);

--
-- Indexes for table `teacher_complaints`
--
ALTER TABLE `teacher_complaints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `admin_messages`
--
ALTER TABLE `admin_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `course_sections`
--
ALTER TABLE `course_sections`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `staff_complaints`
--
ALTER TABLE `staff_complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `teacher_complaints`
--
ALTER TABLE `teacher_complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `course_sections` (`section_id`) ON DELETE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_created_by` FOREIGN KEY (`created_by`) REFERENCES `admin` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `course_sections`
--
ALTER TABLE `course_sections`
  ADD CONSTRAINT `course_sections_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `course_tags`
--
ALTER TABLE `course_tags`
  ADD CONSTRAINT `course_tags_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`),
  ADD CONSTRAINT `course_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`video_id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`department`) REFERENCES `courses` (`course_id`);

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `course_sections` (`section_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `videos_ibfk_2` FOREIGN KEY (`uploaded_by`) REFERENCES `teachers` (`teacher_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

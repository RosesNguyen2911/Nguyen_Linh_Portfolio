-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 26, 2026 at 06:44 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `linh_nguyen_portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contacts`
--

CREATE TABLE `tbl_contacts` (
  `contact_id` int NOT NULL,
  `contact_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact_email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_contacts`
--

INSERT INTO `tbl_contacts` (`contact_id`, `contact_name`, `contact_email`, `contact_message`) VALUES
(8, 'TEST', 'nngklinh.2911@gmail.com', 'Testingg'),
(9, 'Test', 'iamtesting@gmail.com', 'testing so fun'),
(10, 'Linh Nguyen', 'nngklinh.2911@gmail.com', 'ahihi'),
(11, 'cry', 'cry@gmail.com', 'cry'),
(12, 'Linh Nguyen', 'nngklinh.2911@gmail.com', 'hbbb');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faqs`
--

CREATE TABLE `tbl_faqs` (
  `faq_id` int UNSIGNED NOT NULL,
  `faq_icon` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `faq_question` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `faq_answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_faqs`
--

INSERT INTO `tbl_faqs` (`faq_id`, `faq_icon`, `faq_question`, `faq_answer`, `is_active`) VALUES
(1, 'fa-solid fa-clock', 'How long does a project take?', 'Most projects take 2–4 weeks depending on complexity.', 1),
(2, 'fa-solid fa-handshake', 'Do you work internationally?', 'Yes! I work with clients worldwide using Zoom and email.', 1),
(3, 'fa-solid fa-pen-nib', 'What services do you provide?', 'Branding, motion design, 3D modeling, and interactive web experiences.', 1),
(4, 'fa-solid fa-envelope', 'How can I reach you?', 'Email me anytime at nngklinh.2911@gmail.com.', 1),
(5, 'fa-solid fa-dollar-sign', 'What is your hourly rate?', 'My rates vary depending on project scope.', 0),
(6, 'fa-solid fa-rotate', 'Do you offer revisions?', 'Yes, revisions are included in all packages.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_projects`
--

CREATE TABLE `tbl_projects` (
  `project_id` int UNSIGNED NOT NULL,
  `project_title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `project_color` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'blue',
  `project_brief` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `project_subtitle` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `project_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `project_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `project_role` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `project_deliverables` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `project_goals` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `project_challenges` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `project_learnings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `project_results` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `project_order` int UNSIGNED NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_projects`
--

INSERT INTO `tbl_projects` (`project_id`, `project_title`, `project_color`, `project_brief`, `project_subtitle`, `project_desc`, `project_link`, `project_role`, `project_deliverables`, `project_goals`, `project_challenges`, `project_learnings`, `project_results`, `project_order`, `is_active`) VALUES
(1, 'SWAN EARBUDS', 'blue', 'Earbuds Production And Promotion', '3D Modeling | Motion Design | Web Development', 'Swan Earbuds is a conceptual product exploring how sound, emotion, and design come together in a cohesive experience. Inspired by the elegance of the “Swan Lake” symphony, the design evokes softness, fluidity, and graceful motion — like gentle wings passing through the listener’s ears.\r\n\r\nCombining classic simplicity with modern minimalism, the earbuds feel both timeless and contemporary. The project covers the full creative pipeline: brand direction, product concept, 3D modeling, look development, motion-based promotional assets, and an immersive website showcasing the Swan visual identity.', 'https://github.com/RosesNguyen2911/Linh_Nguyen_SwanEarbuds.git', '3D Artist, Motion Designer, Web Developer', 'Brand Concept & Identity System, High-Fidelity 3D Product Modeling, Cinematic Product Animation, Promotional Motion Assets, Interactive Web Experience', '1. Develop a premium product identity that communicates softness, elegance, and modern minimalism.\r\n\r\n2. Ensure the product design visually reflects the emotional inspiration from the “Swan Lake” symphony.\r\n\r\n3. Create cinematic motion assets that highlight key design features and strengthen storytelling.\r\n\r\n4. Produce high-quality 3D renders and animations optimized for clarity, mood, and visual impact.\r\n\r\n5. Build an immersive, smooth interactive website aligned with the Swan brand atmosphere and user experience goals.\r\n', '1. Achieving realistic textures required precise material choices such as metallic rims, matte plastic surfaces, and soft silicone ear tips.\r\n\r\n2. Designing the earbud form was challenging, especially shaping the curved, wing-like silhouette while keeping ergonomic comfort.\r\n\r\n3. Balancing the swan-inspired theme to appeal to all ages and genders without leaning too feminine was essential.\r\n\r\n4. Managing time constraints across branding, modeling, lookdev, animation, and web added significant complexity.\r\n\r\n5. Maintaining consistent color, mood, and visual language across renders, motion assets, and the website required careful control.', '1. Learned how to model complex, detailed forms and set up realistic lighting and materials for high-quality product visualization.\r\n\r\n2. Learned to create professional, advertising-style motion through camera control and clear visual storytelling.\r\n\r\n3. Learned to integrate 3D models on the web using Model-Viewer, combining smooth scroll interactions with a structured layout.\r\n\r\n4. Learned to manage time effectively while working across multiple disciplines throughout the full production pipeline.\r\n', '1. Delivered high-quality 3D visuals with accurate forms, realistic lighting, and refined materials that communicate the Swan concept effectively.\r\n\r\n2. Produced smooth, cinematic motion sequences with controlled camera movement and clear visual storytelling for promotional purposes.\r\n\r\n3. Built a polished, responsive website featuring GSAP animations and Model-Viewer integration, offering a seamless and immersive interactive experience.\r\n\r\n4. Achieved a cohesive brand identity with consistent mood, color, and visual language across 3D renders, motion assets, and the final website.', 1, 1),
(2, 'SWERVE DRINKS', 'yellow', 'Rebranding For A Soda Brand', 'Branding | Motion Design | Web Development', 'Swerve is a beverage brand that once existed in the market but eventually faded due to various circumstances. This project brings the brand back to life through a complete reimagining of its identity, transforming it into something fresher, more youthful, and more relevant for today’s audience.\r\n\r\nThe rebrand introduces a new logo system and five vibrant drink flavors designed to appeal to young consumers. Each flavor carries its own playful personality, supported by bold visuals and a cohesive design language.', 'https://github.com/Sophie-lele127/LinhNguyen_DanLe_FIP_1055_1056.git', 'Graphic Designer, Motion Designer, Web Developer', 'Brand Identity Redesign, New Logo System, Visual Language And Color Direction, Packaging Design For Five Flavors, Promotional Drink Illustrations And Imagery, Social Media Mockups And Marketing Assets, Video Design And Promotional Motion Assets.', '1. Redefine the brand identity to create a fresh, youthful, and modern visual direction.\r\n\r\n2. Develop a new logo system that reflects the brand’s renewed personality and energy.\r\n\r\n3. Create five unique drink flavors with distinct visual styles that appeal to a younger audience.\r\n\r\n4. Establish a cohesive design system across packaging, illustration, and promotional materials.\r\n\r\n5. Produce engaging marketing visuals and motion assets to support the brand’s relaunch.', '\r\n1. Finding a new visual direction that felt refreshed and modern while still preserving the brand’s core values was a major challenge, especially when rethinking the identity from the ground up.\r\n\r\n2. Selecting vibrant, youthful color palettes and typography that appealed to a younger audience without losing sophistication required careful consideration and testing.\r\n\r\n3. Designing five unique drink flavors that looked distinct yet visually cohesive posed a creative challenge, particularly in balancing variety with consistency.\r\n\r\n4. Creating playful, energetic visuals that felt youthful without appearing overly childish demanded precise control over style, tone, and illustration choices.\r\n\r\n5. Developing five custom mascot characters — Milk, Grape, Strawberry, Peach, and Banana — while maintaining consistency across all deliverables, from packaging to promotional assets, required strong visual discipline and coordination.', '1. Learned how to reimagine and restructure an existing brand through a complete visual refresh, building a youthful and energetic brand direction aligned with current design trends.\r\n\r\n2. Learned to create appealing packaging by designing a cohesive system of five flavors that remain visually distinct while maintaining strong brand consistency.\r\n\r\n3. Learned how to control color, tone, and illustration style across multiple products, ensuring a unified look throughout the entire packaging line.\r\n\r\n4. Learned to apply playful transitions and lively motion timing to enhance promotional visuals and strengthen the brand’s energetic personality.', '\r\n1. Delivered a refreshed brand identity that feels youthful, energetic, and visually aligned with current trends.\r\n\r\n2. Created a cohesive packaging system featuring five distinct yet unified flavors, each supported by strong visual storytelling.\r\n\r\n3. Developed a consistent illustration and color style across all brand materials, enhancing recognition and overall visual harmony.\r\n\r\n4. Produced engaging promotional visuals and motion assets that highlight the brand’s playful personality and improve audience appeal.', 2, 1),
(3, 'ELIN SKINCARE', 'orange', 'Cosmetic Brand Production', 'Branding | Motion Design', 'Elin is a modern skincare cosmestic brand inspired by the Camellia tea plant — a flower known for its natural elegance, antioxidant-rich properties, and gentle restorative benefits. This project defines Elin as a clean, soft, and feminine beauty brand that celebrates simplicity and botanical wellness.\r\n\r\nThe rebrand focuses on creating a refined visual identity that reflects purity, softness, and modern self-care. The new design direction introduces a minimalist logo system, a delicate color palette inspired by Camellia petals, and a packaging line built around smooth forms and natural textures. The product collection highlights the calming qualities of Camellia extract, promoting hydration, radiance, and gentle nourishment for the skin.', NULL, 'Graphic Designer, Motion Designer', 'Brand Identity, Brand Style Guide, Logo System, Visual Direction, Packaging Design, Product Mockups, Promotional Assets.', '1. Establish a clean and elegant brand identity that reflects purity, softness, and minimal aesthetics inspired by the Camellia plant.\r\n\r\n2. Develop a refined visual direction and logo system that communicates natural beauty and modern self-care values.\r\n\r\n3. Design premium packaging that feels delicate, botanical, and cohesive across the full skincare line.\r\n\r\n4. Create an appealing color and illustration system rooted in Camellia’s natural tones to strengthen brand recognition.\r\n\r\n5. Produce polished promotional materials and product mockups that effectively present Elin as a contemporary, nature-driven skincare brand.', '\r\n1. Defining a visual direction that felt pure, soft, and elegant while still remaining modern and minimal was challenging, especially when translating the qualities of the Camellia plant into a cohesive identity.\r\n\r\n2. Selecting a color palette and typography system that conveyed natural beauty without appearing too muted or overly feminine required careful balancing.\r\n\r\n3. Designing premium packaging that looked delicate and botanical while remaining functional and consistent across all product types posed structural and visual challenges.\r\n\r\n4. Creating a logo that felt refined, minimal, and meaningfully connected to the Camellia plant required exploring multiple stylized forms while maintaining clarity and brand recognition.\r\n\r\n5. Maintaining brand consistency across packaging, mockups, promotional imagery, and marketing materials required strong control over tone, color, and overall aesthetic harmony.', '1. Learned how to build a clean and elegant skincare identity by translating natural elements of the Camellia plant into modern visual language.\r\n\r\n2. Learned to develop delicate color palettes, refined typography, and subtle textures that communicate purity, softness, and botanical beauty.\r\n\r\n3. Learned to design premium packaging systems that balance minimal aesthetics with functional clarity across multiple product types.\r\n\r\n4. Learned to maintain visual consistency across branding, packaging, illustrations, and promotional materials to create a unified luxury experience.', '\r\n1. Delivered a refined skincare brand identity that feels pure, soft, and elegantly inspired by the Camellia plant.\r\n\r\n2. Created a cohesive design system featuring a natural logo, botanical color palette, and minimal visual direction.\r\n\r\n3. Developed premium packaging and product mockups that elevate Elin into a modern, nature-driven beauty brand.\r\n\r\n4. Produced polished promotional materials that communicate the brand’s luxury aesthetic and strengthen consumer appeal.', 3, 1),
(4, 'INDUSTRY NIGHT', 'pink', 'Fanshawe\'s Students Showcase', 'Branding | Motion Design | Web Development', 'Fanshawe Industry Night is an annual showcase celebrating the creativity and achievements of students in Interactive Media Design (IDP) and User Experience Design (UED). The event highlights major client projects, personal portfolios, and serves as a bridge connecting students with industry professionals.\r\n\r\nFor this event, group of 4 or 5 students have designed and developed an interactive website, video promotion that captures the spirit of the celebration. The visual direction follows Fanshawe’s bold brand palette—red, black, white, and grey—while incorporating modern interactive elements that reflect the innovative and creative nature of the program.', 'https://github.com/s-ranjit/highfive_student_showcase.git', 'Web Developer, Graphic Designer', 'Website Design & Development, Visual Direction & UI Layout, Interactive Components & Animations, Branding Integration, Project Showcase Structure & Navigation Design, Portfolio Highlight Sections, Responsive Web Experience, Event Video Design & Motion Assets.', '1. Create an interactive website that captures the energy and celebration of the annual Industry Night event.\r\n\r\n2. Showcase student projects and portfolios in a clear, engaging, and visually dynamic way.\r\n\r\n3. Integrate Fanshawe’s bold brand colors into a modern, polished visual direction.\r\n\r\n4. Develop smooth interactive elements and animations that reflect the creativity of IDP students.\r\n\r\n5. Provide an accessible, responsive platform that supports industry engagement and enhances the event experience.', '1. Redesigning the event website was challenging because Industry Night is an annual showcase, meaning each year requires a completely new visual direction that cannot overlap with previous student teams.\r\n\r\n2. Balancing Fanshawe’s strong brand identity with a fresh, modern creative approach required careful consideration to avoid repetition while still respecting the official color palette and design standards.\r\n\r\n3. Developing interactive components that felt innovative yet functional presented difficulties, especially in ensuring smooth performance across different devices.\r\n\r\n4. Structuring the project and portfolio showcase in a way that supports both clarity and creativity demanded a thoughtful layout and content strategy.\r\n\r\n5. Maintaining consistency across UI design, motion graphics, and promotional materials while working within a limited timeframe posed significant workflow and organization challenges.', '1. Learned how to redesign an annual event website by creating a fresh visual direction that stands apart from previous years while still respecting Fanshawe’s brand identity.\r\n\r\n2. Learned to develop clear, user-focused layouts that effectively showcase student projects and portfolios in an engaging way.\r\n\r\n3. Learned to implement interactive components and smooth animations that enhance the browsing experience without compromising performance.\r\n\r\n4. Learned how to maintain consistency across UI, motion graphics, and promotional assets while working collaboratively under time constraints.', '\r\n1. Delivered a refreshed event website featuring a modern visual direction that aligns with Fanshawe’s brand while feeling new and distinct from previous years.\r\n\r\n2. Created an engaging showcase experience that highlights student talent through clear layouts, interactive elements, and smooth animation flow.\r\n\r\n3. Developed a cohesive set of UI components, video assets, and promotional materials that elevate the overall look and feel of the event.\r\n\r\n4. Provided a responsive and accessible platform that enhances industry engagement and presents students’ work in a professional, compelling way.\r\n\r\n5. Our team achieved First Runner-Up in the Industry Night competition, recognizing the project’s creativity and execution.', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_projects_media`
--

CREATE TABLE `tbl_projects_media` (
  `project_media_id` int UNSIGNED NOT NULL,
  `project_id` int UNSIGNED NOT NULL,
  `project_media_type` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `project_media_src` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `project_media_alt` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `project_media_order` int UNSIGNED NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_projects_media`
--

INSERT INTO `tbl_projects_media` (`project_media_id`, `project_id`, `project_media_type`, `project_media_src`, `project_media_alt`, `project_media_order`, `is_active`) VALUES
(1, 1, 'poster', 'swanearbud_poster.jpg', 'Swan Earbuds Poster Image', 1, 1),
(2, 1, 'hero', 'swanearbud_hero.png', 'Swan Hero Image', 1, 1),
(3, 1, 'detail', 'swan_shot1.png', 'Swan Image Shot 1', 1, 1),
(4, 1, 'detail', 'swan_shot2.png', 'Swan Image Shot 2', 2, 1),
(5, 1, 'detail', 'swan_shot3.png', 'Swan Image Shot 3', 3, 1),
(6, 1, 'detail', 'swan_shot4.png', 'Swan Image Shot 4', 4, 1),
(7, 1, 'detail', 'swan_shot5.png', 'Swan Image Shot 5', 5, 1),
(8, 1, 'video_thumbnail', 'swanearbud_thumbnail.png', 'Swan Earbuds Video Thumbnail', 1, 1),
(9, 1, 'video_webm', 'Swan_Earbuds_Video.webm', 'Swan Earbud Webm Video', 1, 1),
(10, 1, 'video_mp4', 'Swan_Earbuds_Video.mp4', 'Swan Earbuds Video MP4', 1, 1),
(11, 2, 'poster', 'swerve_poster.jpg', 'Swerve Poster Image', 1, 1),
(12, 2, 'hero', 'swerve_hero.png', 'Swerve Hero Image', 1, 1),
(13, 2, 'detail', 'swerve_shot1.png', 'Swerve Image Shot 1', 1, 1),
(14, 2, 'detail', 'swerve_shot2.png', 'Swerve Image Shot 2', 2, 1),
(15, 2, 'detail', 'swerve_shot3.png', 'Swerve Image Shot 3', 3, 1),
(16, 2, 'detail', 'swerve_shot4.png', 'Swerve Image Shot 4', 4, 1),
(17, 2, 'video_thumbnail', 'swervedrinks_thumbnail.png', 'Swerve Drinks Video Thumbnail', 1, 1),
(18, 2, 'video_webm', 'Swerve_Drinks_Video.webm', 'Swerve Drinks Video Webm', 1, 1),
(19, 2, 'video_mp4', 'Swerve_Drinks_Video.mp4', 'Swerve Drinks Video MP4', 1, 1),
(20, 3, 'poster', 'elin_poster.jpg', 'Elin Poster Image', 1, 1),
(21, 3, 'hero', 'elinskincare_hero.jpg', 'Elin Hero Image', 1, 1),
(22, 3, 'detail', 'elin_shot1.png', 'Elin Image Shot 1', 1, 1),
(23, 3, 'detail', 'elin_shot2.png', 'Elin Image Shot 2', 2, 1),
(24, 3, 'detail', 'elin_shot3.png', 'Elin Image Shot 3', 3, 1),
(25, 3, 'detail', 'elin_shot4.png', 'Elin Image Shot 4', 4, 1),
(26, 3, 'video_thumbnail', 'elinvideo_thumbnail.png', 'Elin Skincare Video Thumbnail', 1, 1),
(27, 3, 'video_webm', 'Elin_Skincare_Video.webm', 'Elin Skincare Video Webm', 1, 1),
(28, 3, 'video_mp4', 'Elin_Skincare_Video.mp4', 'Elin Skincare Video MP4', 1, 1),
(30, 4, 'poster', 'industrynight_poster.jpg', 'Industry Night Poster Image', 1, 1),
(31, 4, 'hero', 'industrynight_hero.png', 'Industry Night Hero Image', 1, 1),
(32, 4, 'detail', 'industrynight_shot1.png', 'Industry Night Shot 1', 1, 1),
(33, 4, 'detail', 'industrynight_shot2.png', 'Industry Night Shot 2', 2, 1),
(34, 4, 'detail', 'industrynight_shot3.png', 'Industry Night Shot 3', 3, 1),
(35, 4, 'video_thumbnail', 'industrynight_hero.png', 'Industry Night Video Thumbnail', 1, 1),
(36, 4, 'video_webm', 'Industry_Night_Video.webm', 'Industry Night Video Webm', 1, 1),
(37, 4, 'video_mp4', 'Industry_Night_Video.mp4', 'Industry Night Video Mp4', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `service_id` int UNSIGNED NOT NULL,
  `service_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `service_color` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'blue',
  `service_order` int UNSIGNED NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`service_id`, `service_title`, `service_color`, `service_order`, `is_active`) VALUES
(1, 'WEB DEVELOPMENT', 'blue', 1, 1),
(2, 'BRANDING', 'pink', 2, 1),
(4, 'UX/UI DESIGN', 'yellow', 3, 1),
(5, 'ILLUSTRATION', 'orange', 4, 1),
(6, 'MOTION DESIGN', 'dark-blue', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_skills`
--

CREATE TABLE `tbl_skills` (
  `skill_id` int NOT NULL,
  `skill_number` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `skill_title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `skill_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_skills`
--

INSERT INTO `tbl_skills` (`skill_id`, `skill_number`, `skill_title`, `skill_desc`, `is_active`) VALUES
(1, '01', 'Design', 'I create visually cohesive and user-centered designs that blend strong aesthetics with functional clarity. My expertise includes branding, layout design, typography, UI/UX workflows, and digital illustration. I work with professional design tools to deliver polished visuals for both digital and print applications.', 1),
(2, '02', '3D & Motion', 'I develop high-quality 3D product models, motion graphics, and cinematic visual sequences using professional 3D pipelines. Skilled in lighting, shading, rendering, animation, and simulation, I bring ideas to life through dynamic and engaging visual storytelling.', 1),
(3, '03', 'Web Development', 'I build responsive, accessible, and performant websites using clean, component-based development workflows. Experienced in SASS, JavaScript, animation libraries, and GitHub version control, I turn interface designs into fully functional, user-friendly digital experiences.', 1),
(4, '04', 'Communication & Collaboration', 'I collaborate effectively within multidisciplinary teams, communicate ideas clearly, manage project timelines, and maintain strong documentation throughout the design and development process. Skilled in project planning, teamwork, client communication, and agile workflows.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_skills_tools`
--

CREATE TABLE `tbl_skills_tools` (
  `tbl_skills_tools` int UNSIGNED NOT NULL,
  `skill_id` int NOT NULL,
  `tool_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_skills_tools`
--

INSERT INTO `tbl_skills_tools` (`tbl_skills_tools`, `skill_id`, `tool_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 2, 5),
(6, 2, 6),
(7, 2, 7),
(8, 2, 8),
(9, 3, 9),
(10, 3, 10),
(11, 3, 11),
(12, 3, 12),
(13, 3, 13),
(14, 3, 14),
(15, 3, 15),
(16, 4, 16),
(17, 4, 17),
(18, 4, 18);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_testimonials`
--

CREATE TABLE `tbl_testimonials` (
  `testimonial_id` int UNSIGNED NOT NULL,
  `testimonial_author_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `testimonial_author_role` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `testimonial_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `testimonial_color` varchar(20) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'blue',
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_testimonials`
--

INSERT INTO `tbl_testimonials` (`testimonial_id`, `testimonial_author_name`, `testimonial_author_role`, `testimonial_message`, `testimonial_color`, `is_active`) VALUES
(1, 'Rin Morito', 'Classmate – Fanshawe College', 'Working with Linh has always been inspiring. She brings a level of organization,\r\n        creativity, and dedication that elevates every project she touches. Her ability\r\n        to stay calm under pressure, contribute meaningful ideas, and support her teammates\r\n        makes her an invaluable collaborator. Linh doesn’t just complete tasks — she brings\r\n        energy, clarity, and a positive spirit that motivates everyone around her.', 'yellow', 1),
(2, 'Situ Ranjit', 'Classmate – Fanshawe College', 'Linh’s design sense and branding ideas helped our project come alive visually.\r\n        She approaches every detail with intention and has an impressive ability to unify\r\n        colors, layout, and storytelling into a clear visual language. Her work added depth,\r\n        clarity, and professionalism to our project, making it feel cohesive and industry-ready.', 'orange', 1),
(3, 'Hannah Silva', 'Teammate – Industry Night', 'Her leadership and exceptional attention to detail played a crucial role in the success of our group project. She consistently guided the team with clarity and confidence, ensuring that everyone understood their responsibilities and stayed on track. Not only did she keep us organized and focused, but she also carefully reviewed every aspect of our work, making thoughtful improvements that significantly enhanced the overall quality. Thanks to her dedication and high standards, our project ran smoothly from start to finish and ultimately turned out far better than we had imagined.', 'blue', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tools`
--

CREATE TABLE `tbl_tools` (
  `tool_id` int NOT NULL,
  `tool_src` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `tool_alt` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tools`
--

INSERT INTO `tbl_tools` (`tool_id`, `tool_src`, `tool_alt`, `is_active`) VALUES
(1, 'ai_logo.png', 'Adobe Illustrator Logo', 1),
(2, 'photoshop_logo.png', 'Adobe Photoshop Logo', 1),
(3, 'indesign_logo.png', 'Adobe InDesign Logo', 1),
(4, 'figma_logo.png', 'Figma Logo', 1),
(5, 'C4D_Logo.png', 'Cinema 4D Logo', 1),
(6, 'redshift_logo.png', 'Redshift Renderer Logo', 1),
(7, 'ae_logo.png', 'After Effects', 1),
(8, 'pr_logo.png', 'Premiere Pro', 1),
(9, 'vs_code_logo.jpeg', 'VS Code Logo', 1),
(10, 'html_logo.png', 'HTML Logo', 1),
(11, 'css_logo.png', 'CSS Logo', 1),
(12, 'java_logo.png', 'JavaScript Logo', 1),
(13, 'sass_logo.png', 'SASS Logo', 1),
(14, 'gsap_logo.png', 'GSAP LOGO', 1),
(15, 'github_logo.png', 'GitHub Logo', 1),
(16, 'notion_logo.png', 'Notion Logo', 1),
(17, 'trello_logo.png', 'Trello Logo', 1),
(18, 'gg_calendar.png', 'GG Calendar Logo', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `password`) VALUES
(1, 'Linh Nguyen', 'Helloworld!HelloProfessors!');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_contacts`
--
ALTER TABLE `tbl_contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `tbl_faqs`
--
ALTER TABLE `tbl_faqs`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `tbl_projects`
--
ALTER TABLE `tbl_projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `tbl_projects_media`
--
ALTER TABLE `tbl_projects_media`
  ADD PRIMARY KEY (`project_media_id`),
  ADD KEY `tbl_projects_media_ibfk_1` (`project_id`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `tbl_skills`
--
ALTER TABLE `tbl_skills`
  ADD PRIMARY KEY (`skill_id`);

--
-- Indexes for table `tbl_skills_tools`
--
ALTER TABLE `tbl_skills_tools`
  ADD PRIMARY KEY (`tbl_skills_tools`),
  ADD KEY `tbl_skills_tools_ibfk_2` (`tool_id`),
  ADD KEY `tbl_skills_tools_ibfk_1` (`skill_id`);

--
-- Indexes for table `tbl_testimonials`
--
ALTER TABLE `tbl_testimonials`
  ADD PRIMARY KEY (`testimonial_id`);

--
-- Indexes for table `tbl_tools`
--
ALTER TABLE `tbl_tools`
  ADD PRIMARY KEY (`tool_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_contacts`
--
ALTER TABLE `tbl_contacts`
  MODIFY `contact_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_faqs`
--
ALTER TABLE `tbl_faqs`
  MODIFY `faq_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_projects`
--
ALTER TABLE `tbl_projects`
  MODIFY `project_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_projects_media`
--
ALTER TABLE `tbl_projects_media`
  MODIFY `project_media_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `service_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_skills`
--
ALTER TABLE `tbl_skills`
  MODIFY `skill_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_skills_tools`
--
ALTER TABLE `tbl_skills_tools`
  MODIFY `tbl_skills_tools` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_testimonials`
--
ALTER TABLE `tbl_testimonials`
  MODIFY `testimonial_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_tools`
--
ALTER TABLE `tbl_tools`
  MODIFY `tool_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_projects_media`
--
ALTER TABLE `tbl_projects_media`
  ADD CONSTRAINT `tbl_projects_media_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `tbl_projects` (`project_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_skills_tools`
--
ALTER TABLE `tbl_skills_tools`
  ADD CONSTRAINT `tbl_skills_tools_ibfk_1` FOREIGN KEY (`skill_id`) REFERENCES `tbl_skills` (`skill_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_skills_tools_ibfk_2` FOREIGN KEY (`tool_id`) REFERENCES `tbl_tools` (`tool_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- MySQL dump 10.13  Distrib 5.7.44, for osx10.19 (x86_64)
--
-- Host: 127.0.0.1    Database: botble
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activations`
--

DROP TABLE IF EXISTS `activations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `code` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activations_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activations`
--

LOCK TABLES `activations` WRITE;
/*!40000 ALTER TABLE `activations` DISABLE KEYS */;
INSERT INTO `activations` VALUES (1,1,'Xdo6MmBssvrsESYUPP1crTOCdYTiUv1y',1,'2025-01-18 19:11:16','2025-01-18 19:11:16','2025-01-18 19:11:16');
/*!40000 ALTER TABLE `activations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_notifications`
--

DROP TABLE IF EXISTS `admin_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_notifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `permission` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_notifications`
--

LOCK TABLES `admin_notifications` WRITE;
/*!40000 ALTER TABLE `admin_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_histories`
--

DROP TABLE IF EXISTS `audit_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_histories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `module` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request` longtext COLLATE utf8mb4_unicode_ci,
  `action` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_user` bigint unsigned NOT NULL,
  `reference_id` bigint unsigned NOT NULL,
  `reference_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_histories_user_id_index` (`user_id`),
  KEY `audit_histories_module_index` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_histories`
--

LOCK TABLES `audit_histories` WRITE;
/*!40000 ALTER TABLE `audit_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blocks`
--

DROP TABLE IF EXISTS `blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `raw_content` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `blocks_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks`
--

LOCK TABLES `blocks` WRITE;
/*!40000 ALTER TABLE `blocks` DISABLE KEYS */;
INSERT INTO `blocks` VALUES (1,'Gabriel Frami','gabriel-frami','Aut aperiam et quia.','Repellendus quas dicta consectetur non qui eum error. Delectus assumenda praesentium voluptatibus vel quo esse aspernatur perferendis. Quae corrupti velit ea et nam provident aut at. Animi unde minus facilis sit sunt nulla. Perferendis eos ipsam id cum saepe assumenda qui quis. Et placeat sunt dolores reprehenderit facilis molestias. Accusantium et enim et nemo placeat praesentium.','published',NULL,'2025-01-18 19:11:22','2025-01-18 19:11:22',NULL),(2,'Dr. Brando Rath','dr-brando-rath','Qui sunt consequatur sunt omnis laudantium.','Commodi alias nemo soluta ipsam ea. Vero autem dolore id eveniet nam. Repellendus fugiat atque iure occaecati ex et eius quisquam. Tempora veritatis rerum qui expedita ipsum. Repellendus assumenda id dolorem eaque commodi suscipit. Alias distinctio et ratione ad perferendis voluptatem. Et amet animi qui qui voluptas et aliquid. Et officiis natus minima ea voluptatem.','published',NULL,'2025-01-18 19:11:22','2025-01-18 19:11:22',NULL),(3,'Dr. Isidro Stark II','dr-isidro-stark-ii','Atque numquam qui minus unde qui.','Ut aut corporis eos ut quo eaque. Eligendi quis omnis et. Dolores debitis voluptas a quia facere facere. Dignissimos expedita minus cumque totam totam sed. Reiciendis dolorem ab eos sapiente ab. Rem repellendus temporibus quasi necessitatibus. Omnis alias enim et ut commodi. Et numquam adipisci sed hic dolorum in nesciunt praesentium.','published',NULL,'2025-01-18 19:11:22','2025-01-18 19:11:22',NULL),(4,'Harry Mertz','harry-mertz','Qui exercitationem enim incidunt rem sit.','Fugit exercitationem repellendus eos eius iste assumenda sint. Omnis ut rerum qui repudiandae esse et. Est aut et doloribus saepe consectetur. Molestias repellat quod nihil. Possimus ea qui et aut pariatur iste voluptatum. Ipsa quos labore sunt eos animi. Ut iure eum et illum dolor. Quis error modi ducimus eaque amet est.','published',NULL,'2025-01-18 19:11:22','2025-01-18 19:11:22',NULL),(5,'Prof. Beau Moore II','prof-beau-moore-ii','Sed fuga et non omnis ea.','Autem sunt quod sequi adipisci nostrum. Aperiam quas repudiandae consequatur. Tempore ipsa magni tempore ullam sed ipsum velit. Alias dignissimos quas odio facere laboriosam id. Voluptatem quo nobis necessitatibus molestiae. Aut porro quis consequuntur eligendi. Nobis nihil aut ut consequuntur nisi neque voluptatem. Doloremque provident adipisci et velit atque qui aperiam sapiente. Dolorum et ex voluptate laudantium ut.','published',NULL,'2025-01-18 19:11:22','2025-01-18 19:11:22',NULL);
/*!40000 ALTER TABLE `blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blocks_translations`
--

DROP TABLE IF EXISTS `blocks_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blocks_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blocks_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `raw_content` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`blocks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blocks_translations`
--

LOCK TABLES `blocks_translations` WRITE;
/*!40000 ALTER TABLE `blocks_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `blocks_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint unsigned NOT NULL DEFAULT '0',
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `author_id` bigint unsigned DEFAULT NULL,
  `author_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Botble\\ACL\\Models\\User',
  `icon` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int unsigned NOT NULL DEFAULT '0',
  `is_featured` tinyint NOT NULL DEFAULT '0',
  `is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_parent_id_index` (`parent_id`),
  KEY `categories_status_index` (`status`),
  KEY `categories_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Artificial Intelligence',0,'Aliquid laboriosam eligendi quaerat vel. Esse nobis aut molestiae. Dolores veniam id ipsam saepe culpa.','published',1,'Botble\\ACL\\Models\\User',NULL,0,0,0,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(2,'Cybersecurity',0,'Aut deserunt est error maiores est. Sunt saepe qui voluptatem asperiores quaerat consequuntur quam. Qui quibusdam dolor nisi perspiciatis enim voluptatum voluptatem qui.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(3,'Blockchain Technology',0,'Dicta odio delectus sapiente earum eos fugiat. Vel accusantium maxime voluptatem quisquam. Atque ullam dolore incidunt excepturi. Molestiae ab dolore dolor aliquid sit.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(4,'5G and Connectivity',0,'Et id iusto nesciunt autem et ut quidem. Ratione aut reprehenderit id id. Sunt quae doloremque eligendi voluptatem mollitia non soluta.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(5,'Augmented Reality (AR)',0,'Magnam ex consequatur minima officia occaecati occaecati minus. Est earum tempore sit ut dicta. Vero molestiae suscipit qui molestiae tenetur mollitia voluptatem.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(6,'Green Technology',0,'Perferendis voluptates et et quod consectetur. Autem dolores omnis id voluptatem ea. Dolor magni rerum veniam odit. Ipsum reprehenderit vel cum impedit.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(7,'Quantum Computing',0,'Laborum placeat asperiores eum culpa. Aperiam nostrum odit qui ea quam quam et. Et eius quae omnis non deleniti voluptas nemo. Inventore libero omnis quo modi eaque voluptas.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(8,'Edge Computing',0,'Nisi eius rerum doloribus fugiat non. Voluptatem mollitia beatae et quia. Sunt error et in cum minima minus voluptates. Quia optio voluptate animi aspernatur a enim. Alias unde necessitatibus ut.','published',1,'Botble\\ACL\\Models\\User',NULL,0,1,0,'2025-01-18 19:11:18','2025-01-18 19:11:18');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories_translations`
--

DROP TABLE IF EXISTS `categories_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categories_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories_translations`
--

LOCK TABLES `categories_translations` WRITE;
/*!40000 ALTER TABLE `categories_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_custom_field_options`
--

DROP TABLE IF EXISTS `contact_custom_field_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_custom_field_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `custom_field_id` bigint unsigned NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '999',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_custom_field_options`
--

LOCK TABLES `contact_custom_field_options` WRITE;
/*!40000 ALTER TABLE `contact_custom_field_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_custom_field_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_custom_field_options_translations`
--

DROP TABLE IF EXISTS `contact_custom_field_options_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_custom_field_options_translations` (
  `contact_custom_field_options_id` bigint unsigned NOT NULL,
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`contact_custom_field_options_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_custom_field_options_translations`
--

LOCK TABLES `contact_custom_field_options_translations` WRITE;
/*!40000 ALTER TABLE `contact_custom_field_options_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_custom_field_options_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_custom_fields`
--

DROP TABLE IF EXISTS `contact_custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_custom_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `placeholder` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '999',
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_custom_fields`
--

LOCK TABLES `contact_custom_fields` WRITE;
/*!40000 ALTER TABLE `contact_custom_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_custom_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_custom_fields_translations`
--

DROP TABLE IF EXISTS `contact_custom_fields_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_custom_fields_translations` (
  `contact_custom_fields_id` bigint unsigned NOT NULL,
  `lang_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `placeholder` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`contact_custom_fields_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_custom_fields_translations`
--

LOCK TABLES `contact_custom_fields_translations` WRITE;
/*!40000 ALTER TABLE `contact_custom_fields_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_custom_fields_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_replies`
--

DROP TABLE IF EXISTS `contact_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_replies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_replies`
--

LOCK TABLES `contact_replies` WRITE;
/*!40000 ALTER TABLE `contact_replies` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_fields` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (1,'Violet Lakin','chalvorson@example.org','430-798-5002','12928 Fay Circles\nHowellview, FL 05257-7392','Quam non in consequatur quos.','At et libero tenetur vel rerum sed. Dignissimos consectetur non ullam accusamus. Unde placeat eum assumenda voluptas sunt. Soluta cumque est nesciunt. Id nihil animi dolores et expedita error. Sit sapiente reiciendis doloribus eius. Laboriosam architecto soluta quas sunt provident ipsum. Doloremque sunt ut officia vel ratione consectetur sapiente. Aperiam officia autem tempora et itaque dolor consequatur. Qui dolores repellendus hic. Sunt voluptas occaecati tempore quod asperiores error.',NULL,'unread','2025-01-18 19:11:22','2025-01-18 19:11:22'),(2,'Dr. Walter Schmitt','purdy.carey@example.net','+1-478-710-8524','177 Cathryn Trace Apt. 801\nBrownshire, NY 14431','Neque explicabo sint molestias enim fugit soluta.','Consequuntur molestias explicabo est est quia. Nesciunt voluptas ut ea nesciunt. Magni eveniet deserunt dolorem qui sunt cumque a. Necessitatibus qui nostrum explicabo. Deleniti enim ut et qui facere ratione eius qui. Tenetur et officia sequi enim aspernatur eius placeat. Qui odio blanditiis a et consequatur aliquid corporis. Reprehenderit ea perferendis inventore eveniet.',NULL,'read','2025-01-18 19:11:22','2025-01-18 19:11:22'),(3,'Savanah Schumm','parisian.taylor@example.org','1-234-638-4783','7293 Adrien Rapids Suite 187\nOsinskiburgh, UT 45076','Adipisci a doloribus eos quia non asperiores.','Dolores sit ut ullam et quo nisi. Atque eveniet dolores aperiam mollitia. Vel nostrum hic excepturi. Fugit pariatur autem necessitatibus ut quia consequatur pariatur. Exercitationem voluptate omnis sit ea nihil nulla ex. Omnis quisquam laborum expedita libero corrupti voluptatum. Quae voluptatum incidunt amet reiciendis. Ut et reiciendis nemo est. Sunt similique sapiente quidem eum labore deleniti. Vero consequatur soluta earum sunt. Expedita aut ipsum omnis et fuga quam rerum fugiat.',NULL,'unread','2025-01-18 19:11:22','2025-01-18 19:11:22'),(4,'Jailyn Mante','lester87@example.com','+1 (562) 645-2634','379 Assunta Junction\nWest Lavernafurt, SC 15865','Atque veritatis error at quas ipsa aperiam.','Sint dolor sed ea dolorem quam. Voluptatem praesentium sapiente laudantium quasi molestiae esse. Ut dolores fuga cum beatae ducimus ad tempore. Voluptas veritatis ut ullam ex mollitia nulla voluptatem. Vel nulla sed beatae architecto. Voluptas illum eligendi earum dolorem nostrum. Ipsam et ullam voluptatem labore perferendis. Cumque qui consequuntur et cumque quos iure id. Quae amet vitae odio tempore.',NULL,'unread','2025-01-18 19:11:22','2025-01-18 19:11:22'),(5,'Mitchel Mante','stracke.madelynn@example.org','+1 (740) 436-2001','678 Mauricio Well Suite 485\nLake Wainoshire, IN 50604','Quod non beatae autem quia ab voluptas.','Perferendis commodi nihil quo unde optio. Sunt quis cumque amet labore in. Facere aliquam aut omnis ipsam. Dolore repudiandae rerum rerum at. Distinctio eum nobis eum iste in a. Exercitationem iure et quia similique vitae vel amet dicta. Accusantium asperiores quod quos sequi reiciendis et nobis. Dolores omnis harum quia sapiente. Inventore nostrum aut vitae et qui sit alias. Ab ut architecto omnis laboriosam et.',NULL,'read','2025-01-18 19:11:22','2025-01-18 19:11:22'),(6,'Brook Rodriguez','ethyl.jones@example.org','1-920-834-9999','14382 Schoen Dam Suite 078\nCassidyport, MT 44557','Ullam quis voluptatum culpa adipisci.','Ratione enim ut illo voluptatibus. Ab dolores aut vero repellat. Perferendis dolores distinctio non autem et sunt sequi. Eos suscipit omnis ipsum. Eos et et libero vitae cumque nobis esse impedit. Est aliquid repellat aut velit ratione. Ex qui vero corporis deserunt. Laudantium dolorem nesciunt voluptatem placeat odit et fugit. Cumque nemo temporibus dolorem consectetur magni.',NULL,'read','2025-01-18 19:11:22','2025-01-18 19:11:22'),(7,'Mr. Donnell Collier PhD','sadie.bergnaum@example.com','402.671.9745','5208 Stroman Park Apt. 630\nBuckridgeburgh, OK 70088','Rerum at qui amet suscipit.','Ad ratione libero et accusantium. Aut eum praesentium necessitatibus hic et. Culpa voluptas ad perferendis magni aut beatae et. Facere qui sunt recusandae atque et iusto. Earum dolorem sapiente praesentium omnis aperiam ad. Molestias aut vel earum blanditiis quibusdam adipisci illum. Rem voluptate alias nobis incidunt. Quis velit quo non repellat. Ratione inventore maiores est vel omnis mollitia. Nobis aut iste earum recusandae non voluptas eum. Et consectetur veniam dolor nisi aliquam.',NULL,'unread','2025-01-18 19:11:22','2025-01-18 19:11:22'),(8,'General Kub','kwill@example.net','1-240-398-4458','972 Nya Canyon\nNorth Kaitlinfurt, RI 25090-9609','Debitis hic aut fugit odio.','Cumque recusandae esse neque inventore repudiandae earum temporibus quidem. Eos unde omnis aut quia nobis omnis praesentium. Delectus ut sunt sit et aut minima et. Aut sint sequi voluptatem et. Vero dolore dolores eligendi voluptatibus exercitationem veniam facilis vel. Aperiam veritatis consequatur ipsa asperiores voluptatem corporis maiores. Consequatur ullam voluptatem asperiores vel. Saepe et tempora excepturi. Deserunt nostrum aperiam exercitationem dolorem et.',NULL,'unread','2025-01-18 19:11:22','2025-01-18 19:11:22'),(9,'Curt Koepp','koelpin.gavin@example.com','+1-386-983-0532','2179 Wolf Pass\nPort Khalil, RI 56890-2382','Rerum quia labore aut eligendi rerum at.','Nisi aut repellat iste molestias doloribus. Consequatur nostrum autem labore consequatur molestias. Dolorum sunt laborum sequi sequi molestiae. Quasi praesentium nam sint enim culpa. Facere nostrum aut quo voluptates. Inventore tenetur iure aut sapiente vel nesciunt. Recusandae rerum aperiam error eos. Voluptas recusandae quidem omnis odit. Molestiae nisi ratione impedit exercitationem occaecati praesentium. Commodi quia dolores quia accusantium aut.',NULL,'read','2025-01-18 19:11:22','2025-01-18 19:11:22'),(10,'Lora Mayert','jlesch@example.com','541.867.4447','174 Purdy Path Suite 017\nErinville, AL 44911','Esse aperiam nesciunt quia qui.','Veritatis exercitationem doloribus aut pariatur et quas. Aut dolores impedit voluptas adipisci. Est expedita id explicabo perspiciatis. Necessitatibus ut non in. Voluptas exercitationem ut sit pariatur. Et ipsum similique tenetur consequuntur nobis cupiditate adipisci. Vero rem ex maiores vel. Iure qui at est non. Voluptates aut quaerat est quos ut tenetur animi. Neque inventore mollitia et iure. Non veniam qui reiciendis in quisquam veritatis laudantium a. Aut aspernatur ut in ipsa.',NULL,'read','2025-01-18 19:11:22','2025-01-18 19:11:22');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `use_for` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_for_id` bigint unsigned NOT NULL,
  `field_item_id` bigint unsigned NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `custom_fields_field_item_id_index` (`field_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields`
--

LOCK TABLES `custom_fields` WRITE;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_fields_translations`
--

DROP TABLE IF EXISTS `custom_fields_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_fields_id` bigint unsigned NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`custom_fields_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields_translations`
--

LOCK TABLES `custom_fields_translations` WRITE;
/*!40000 ALTER TABLE `custom_fields_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `custom_fields_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dashboard_widget_settings`
--

DROP TABLE IF EXISTS `dashboard_widget_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dashboard_widget_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `widget_id` bigint unsigned NOT NULL,
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  `status` tinyint unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dashboard_widget_settings_user_id_index` (`user_id`),
  KEY `dashboard_widget_settings_widget_id_index` (`widget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dashboard_widget_settings`
--

LOCK TABLES `dashboard_widget_settings` WRITE;
/*!40000 ALTER TABLE `dashboard_widget_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `dashboard_widget_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dashboard_widgets`
--

DROP TABLE IF EXISTS `dashboard_widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dashboard_widgets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dashboard_widgets`
--

LOCK TABLES `dashboard_widgets` WRITE;
/*!40000 ALTER TABLE `dashboard_widgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `dashboard_widgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field_groups`
--

DROP TABLE IF EXISTS `field_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field_groups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rules` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_groups_created_by_index` (`created_by`),
  KEY `field_groups_updated_by_index` (`updated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_groups`
--

LOCK TABLES `field_groups` WRITE;
/*!40000 ALTER TABLE `field_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `field_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `field_items`
--

DROP TABLE IF EXISTS `field_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `field_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `field_group_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned DEFAULT NULL,
  `order` int DEFAULT '0',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `instructions` text COLLATE utf8mb4_unicode_ci,
  `options` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `field_items_field_group_id_index` (`field_group_id`),
  KEY `field_items_parent_id_index` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `field_items`
--

LOCK TABLES `field_items` WRITE;
/*!40000 ALTER TABLE `field_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `field_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fob_comments`
--

DROP TABLE IF EXISTS `fob_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fob_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reply_to` bigint unsigned DEFAULT NULL,
  `author_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` bigint unsigned DEFAULT NULL,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` bigint unsigned DEFAULT NULL,
  `reference_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fob_comments_author_type_author_id_index` (`author_type`,`author_id`),
  KEY `fob_comments_reference_type_reference_id_index` (`reference_type`,`reference_id`),
  KEY `fob_comments_reply_to_index` (`reply_to`),
  KEY `fob_comments_reference_url_index` (`reference_url`),
  KEY `fob_comments_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fob_comments`
--

LOCK TABLES `fob_comments` WRITE;
/*!40000 ALTER TABLE `fob_comments` DISABLE KEYS */;
INSERT INTO `fob_comments` VALUES (1,NULL,'Botble\\Member\\Models\\Member',9,'Botble\\Blog\\Models\\Post',11,'https://botble.test','Emery Gerlach','vella07@reilly.com','https://friendsofbotble.com','This is really helpful, thank you!','approved','7.46.231.27','Mozilla/5.0 (Windows NT 6.2) AppleWebKit/531.0 (KHTML, like Gecko) Chrome/91.0.4252.28 Safari/531.0 Edg/91.01084.50','2024-12-28 05:17:10','2025-01-18 19:11:22'),(2,NULL,'Botble\\Member\\Models\\Member',2,'Botble\\Blog\\Models\\Post',10,'https://botble.test','Ava Howell','gmohr@armstrong.com','https://friendsofbotble.com','I found this article to be quite informative.','approved','141.17.152.185','Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_8_3 rv:2.0; en-US) AppleWebKit/531.4.4 (KHTML, like Gecko) Version/4.0 Safari/531.4.4','2024-12-30 04:43:16','2025-01-18 19:11:22'),(3,NULL,'Botble\\Member\\Models\\Member',6,'Botble\\Blog\\Models\\Post',5,'https://botble.test','Ozella D\'Amore','fschuster@hotmail.com','https://friendsofbotble.com','Wow, I never knew about this before!','approved','119.118.93.31','Opera/9.56 (X11; Linux i686; sl-SI) Presto/2.8.198 Version/11.00','2025-01-12 22:53:14','2025-01-18 19:11:22'),(4,NULL,'Botble\\Member\\Models\\Member',3,'Botble\\Blog\\Models\\Post',9,'https://botble.test','Adelbert Lehner','hayes.sonia@gmail.com','https://friendsofbotble.com','Great job on explaining such a complex topic.','approved','228.25.162.159','Mozilla/5.0 (X11; Linux i686; rv:7.0) Gecko/20240313 Firefox/37.0','2025-01-04 11:04:25','2025-01-18 19:11:22'),(5,NULL,'Botble\\Member\\Models\\Member',2,'Botble\\Blog\\Models\\Post',13,'https://botble.test','Miss Francesca Wehner III','lbahringer@gmail.com','https://friendsofbotble.com','I have a question about the third paragraph.','approved','130.255.161.0','Mozilla/5.0 (Windows; U; Windows NT 5.1) AppleWebKit/531.16.1 (KHTML, like Gecko) Version/4.0.5 Safari/531.16.1','2024-12-30 09:07:32','2025-01-18 19:11:22'),(6,NULL,'Botble\\Member\\Models\\Member',7,'Botble\\Blog\\Models\\Post',13,'https://botble.test','Mr. Donnell Smitham','rcollins@yahoo.com','https://friendsofbotble.com','This article changed my perspective entirely.','approved','26.197.250.111','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/5351 (KHTML, like Gecko) Chrome/36.0.891.0 Mobile Safari/5351','2024-12-27 21:33:53','2025-01-18 19:11:22'),(7,NULL,'Botble\\Member\\Models\\Member',1,'Botble\\Blog\\Models\\Post',5,'https://botble.test','Kailyn Borer','kevon.hyatt@kiehn.com','https://friendsofbotble.com','I appreciate the effort you put into this.','approved','177.91.86.179','Mozilla/5.0 (Macintosh; U; PPC Mac OS X 10_7_7) AppleWebKit/5312 (KHTML, like Gecko) Chrome/40.0.843.0 Mobile Safari/5312','2025-01-10 09:49:36','2025-01-18 19:11:22'),(8,NULL,'Botble\\Member\\Models\\Member',3,'Botble\\Blog\\Models\\Post',14,'https://botble.test','Marilou Grimes','xreynolds@skiles.com','https://friendsofbotble.com','This is exactly what I was looking for, thank you!','approved','168.243.59.171','Mozilla/5.0 (Windows 98; Win 9x 4.90; en-US; rv:1.9.0.20) Gecko/20200109 Firefox/37.0','2025-01-09 23:06:21','2025-01-18 19:11:22'),(9,NULL,'Botble\\Member\\Models\\Member',8,'Botble\\Blog\\Models\\Post',5,'https://botble.test','Burdette Considine','janis48@gmail.com','https://friendsofbotble.com','I disagree with some points mentioned here, though.','approved','79.219.162.13','Mozilla/5.0 (Windows NT 5.0) AppleWebKit/536.1 (KHTML, like Gecko) Chrome/96.0.4613.28 Safari/536.1 Edg/96.01107.47','2025-01-05 12:00:26','2025-01-18 19:11:22'),(10,NULL,'Botble\\Member\\Models\\Member',7,'Botble\\Blog\\Models\\Post',16,'https://botble.test','Gust Runolfsdottir','fdach@hotmail.com','https://friendsofbotble.com','Could you provide more examples to illustrate your point?','approved','128.181.203.72','Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_8_4 rv:4.0) Gecko/20140604 Firefox/36.0','2025-01-09 09:28:53','2025-01-18 19:11:22'),(11,NULL,'Botble\\Member\\Models\\Member',8,'Botble\\Blog\\Models\\Post',7,'https://botble.test','Stephan Harris','breichel@volkman.com','https://friendsofbotble.com','I wish there were more articles like this out there.','approved','23.31.203.189','Mozilla/5.0 (Windows; U; Windows CE) AppleWebKit/532.13.4 (KHTML, like Gecko) Version/4.1 Safari/532.13.4','2024-12-23 11:36:19','2025-01-18 19:11:22'),(12,NULL,'Botble\\Member\\Models\\Member',3,'Botble\\Blog\\Models\\Post',1,'https://botble.test','Russ Dooley','kessler.shirley@yahoo.com','https://friendsofbotble.com','I\'m bookmarking this for future reference.','approved','129.24.90.145','Mozilla/5.0 (Windows NT 4.0) AppleWebKit/534.2 (KHTML, like Gecko) Chrome/99.0.4728.19 Safari/534.2 Edg/99.01093.30','2025-01-18 01:27:28','2025-01-18 19:11:22'),(13,NULL,'Botble\\Member\\Models\\Member',4,'Botble\\Blog\\Models\\Post',19,'https://botble.test','Miracle Mills PhD','loma.mohr@hotmail.com','https://friendsofbotble.com','I\'ve shared this with my friends, they loved it!','approved','237.220.237.222','Mozilla/5.0 (Windows; U; Windows CE) AppleWebKit/531.8.2 (KHTML, like Gecko) Version/4.0.2 Safari/531.8.2','2025-01-17 17:21:13','2025-01-18 19:11:22'),(14,NULL,'Botble\\Member\\Models\\Member',3,'Botble\\Blog\\Models\\Post',12,'https://botble.test','Agustina Barrows','windler.lenore@yahoo.com','https://friendsofbotble.com','This article is a must-read for everyone interested in the topic.','approved','95.126.187.193','Mozilla/5.0 (Windows; U; Windows NT 6.1) AppleWebKit/531.21.4 (KHTML, like Gecko) Version/5.1 Safari/531.21.4','2024-12-28 10:10:18','2025-01-18 19:11:22'),(15,NULL,'Botble\\Member\\Models\\Member',3,'Botble\\Blog\\Models\\Post',19,'https://botble.test','Prof. Miles Eichmann','dustin46@walsh.com','https://friendsofbotble.com','Thank you for shedding light on this important issue.','approved','159.163.196.81','Mozilla/5.0 (Windows; U; Windows 95) AppleWebKit/532.11.2 (KHTML, like Gecko) Version/4.0.4 Safari/532.11.2','2025-01-10 16:10:16','2025-01-18 19:11:22'),(16,NULL,'Botble\\Member\\Models\\Member',6,'Botble\\Blog\\Models\\Post',13,'https://botble.test','Gabriella Ernser','kobe.quitzon@hotmail.com','https://friendsofbotble.com','I\'ve been searching for information on this topic, glad I found this article.','approved','207.165.130.61','Mozilla/5.0 (Windows NT 4.0; nl-NL; rv:1.9.0.20) Gecko/20101124 Firefox/35.0','2024-12-28 15:51:00','2025-01-18 19:11:22'),(17,NULL,'Botble\\Member\\Models\\Member',5,'Botble\\Blog\\Models\\Post',19,'https://botble.test','Carroll Leuschke','karianne.jast@hoppe.net','https://friendsofbotble.com','I\'m blown away by the insights shared in this article.','approved','159.56.210.37','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_9 rv:4.0; en-US) AppleWebKit/535.10.7 (KHTML, like Gecko) Version/4.1 Safari/535.10.7','2025-01-14 05:16:50','2025-01-18 19:11:22'),(18,NULL,'Botble\\Member\\Models\\Member',7,'Botble\\Blog\\Models\\Post',20,'https://botble.test','Estrella Yost','celia.pouros@yahoo.com','https://friendsofbotble.com','This article tackles a complex topic with clarity.','approved','77.86.166.104','Opera/9.43 (X11; Linux x86_64; en-US) Presto/2.8.339 Version/12.00','2025-01-10 23:47:37','2025-01-18 19:11:22'),(19,NULL,'Botble\\Member\\Models\\Member',0,'Botble\\Blog\\Models\\Post',11,'https://botble.test','Alex Keeling','helene74@bogan.com','https://friendsofbotble.com','I\'m going to reflect on the ideas presented in this article.','approved','199.7.208.21','Mozilla/5.0 (Macintosh; PPC Mac OS X 10_8_8) AppleWebKit/532.1 (KHTML, like Gecko) Chrome/87.0.4497.27 Safari/532.1 Edg/87.01056.73','2025-01-05 15:56:42','2025-01-18 19:11:22'),(20,NULL,'Botble\\Member\\Models\\Member',1,'Botble\\Blog\\Models\\Post',19,'https://botble.test','Katelynn Luettgen','dicki.cade@yahoo.com','https://friendsofbotble.com','The author\'s passion for the subject shines through in this article.','approved','123.154.210.111','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/95.0.4414.96 Safari/535.1 EdgA/95.01051.62','2024-12-21 02:16:46','2025-01-18 19:11:22'),(21,NULL,'Botble\\Member\\Models\\Member',3,'Botble\\Blog\\Models\\Post',20,'https://botble.test','Claudia Fadel','okozey@wisoky.com','https://friendsofbotble.com','This article challenged my preconceptions in a thought-provoking way.','approved','228.189.34.5','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_4 rv:5.0) Gecko/20210109 Firefox/36.0','2025-01-08 23:08:01','2025-01-18 19:11:22'),(22,NULL,'Botble\\Member\\Models\\Member',9,'Botble\\Blog\\Models\\Post',19,'https://botble.test','Ms. Jewel West Jr.','ilene18@hammes.org','https://friendsofbotble.com','I\'ve added this article to my reading list, it\'s worth revisiting.','approved','3.230.38.128','Mozilla/5.0 (Windows NT 6.0) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/79.0.4520.20 Safari/535.1 Edg/79.01046.87','2024-12-28 17:30:05','2025-01-18 19:11:22'),(23,NULL,'Botble\\Member\\Models\\Member',7,'Botble\\Blog\\Models\\Post',8,'https://botble.test','Margret Bartoletti','janis.huels@mcclure.com','https://friendsofbotble.com','This article offers practical advice that I can apply in real life.','approved','44.229.6.104','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_5_0) AppleWebKit/5320 (KHTML, like Gecko) Chrome/39.0.851.0 Mobile Safari/5320','2024-12-22 15:13:00','2025-01-18 19:11:22'),(24,NULL,'Botble\\Member\\Models\\Member',10,'Botble\\Blog\\Models\\Post',9,'https://botble.test','Morris Ryan','tyrell.hackett@hotmail.com','https://friendsofbotble.com','I\'m going to recommend this article to my study group.','approved','36.200.231.119','Mozilla/5.0 (compatible; MSIE 10.0; Windows 95; Trident/3.0)','2025-01-11 00:22:20','2025-01-18 19:11:22'),(25,NULL,'Botble\\Member\\Models\\Member',4,'Botble\\Blog\\Models\\Post',9,'https://botble.test','Mr. Manuel Heller III','dickens.verlie@bogan.com','https://friendsofbotble.com','The examples provided really helped me understand the concept better.','approved','5.57.251.107','Mozilla/5.0 (compatible; MSIE 7.0; Windows CE; Trident/3.1)','2024-12-27 09:57:26','2025-01-18 19:11:22'),(26,NULL,'Botble\\Member\\Models\\Member',1,'Botble\\Blog\\Models\\Post',18,'https://botble.test','Rosamond Muller','adriana.reinger@gmail.com','https://friendsofbotble.com','I resonate with the ideas presented here.','approved','169.68.119.177','Mozilla/5.0 (compatible; MSIE 5.0; Windows NT 6.0; Trident/5.0)','2025-01-13 10:15:12','2025-01-18 19:11:22'),(27,NULL,'Botble\\Member\\Models\\Member',8,'Botble\\Blog\\Models\\Post',14,'https://botble.test','Wilburn Schneider IV','fthompson@runte.com','https://friendsofbotble.com','This article made me think critically about the topic.','approved','169.147.238.84','Mozilla/5.0 (X11; Linux i686) AppleWebKit/533.1 (KHTML, like Gecko) Chrome/89.0.4539.57 Safari/533.1 EdgA/89.01076.97','2025-01-08 06:17:06','2025-01-18 19:11:22'),(28,NULL,'Botble\\Member\\Models\\Member',3,'Botble\\Blog\\Models\\Post',12,'https://botble.test','Simeon Kuhn','imaggio@hotmail.com','https://friendsofbotble.com','I\'ll definitely come back to this article for reference.','approved','46.61.167.170','Mozilla/5.0 (Macintosh; U; PPC Mac OS X 10_5_5) AppleWebKit/533.0 (KHTML, like Gecko) Chrome/97.0.4538.17 Safari/533.0 Edg/97.01056.64','2025-01-01 18:47:56','2025-01-18 19:11:22'),(29,NULL,'Botble\\Member\\Models\\Member',4,'Botble\\Blog\\Models\\Post',19,'https://botble.test','Cassandre Miller','angelita33@gmail.com','https://friendsofbotble.com','I\'ve shared this on social media, it\'s too good not to share.','approved','17.86.176.187','Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X) AppleWebKit/537.1 (KHTML, like Gecko) Version/15.0 EdgiOS/81.01024.2 Mobile/15E148 Safari/537.1','2024-12-20 05:20:01','2025-01-18 19:11:22'),(30,NULL,'Botble\\Member\\Models\\Member',3,'Botble\\Blog\\Models\\Post',13,'https://botble.test','Beau Mills I','tjacobson@yahoo.com','https://friendsofbotble.com','This article presents a balanced view on a controversial topic.','approved','173.105.82.76','Mozilla/5.0 (Windows CE) AppleWebKit/532.1 (KHTML, like Gecko) Chrome/91.0.4667.54 Safari/532.1 Edg/91.01081.23','2024-12-29 10:22:27','2025-01-18 19:11:22'),(31,NULL,'Botble\\Member\\Models\\Member',2,'Botble\\Blog\\Models\\Post',12,'https://botble.test','Madelyn Quigley','bayer.ian@wiza.com','https://friendsofbotble.com','I\'m glad I stumbled upon this article, it\'s a gem.','approved','103.53.163.4','Mozilla/5.0 (iPhone; CPU iPhone OS 13_0 like Mac OS X) AppleWebKit/534.2 (KHTML, like Gecko) Version/15.0 EdgiOS/92.01082.10 Mobile/15E148 Safari/534.2','2025-01-07 16:34:52','2025-01-18 19:11:22'),(32,NULL,'Botble\\Member\\Models\\Member',10,'Botble\\Blog\\Models\\Post',2,'https://botble.test','Ms. Martina Vandervort V','grace.funk@harber.com','https://friendsofbotble.com','I\'ve been struggling with this, your article helped a lot.','approved','255.157.17.93','Mozilla/5.0 (X11; Linux x86_64; rv:5.0) Gecko/20201120 Firefox/37.0','2025-01-05 06:23:47','2025-01-18 19:11:22'),(33,NULL,'Botble\\Member\\Models\\Member',8,'Botble\\Blog\\Models\\Post',17,'https://botble.test','Destiney Langworth','gdaniel@medhurst.info','https://friendsofbotble.com','I\'ve learned something new today, thanks to this article.','approved','189.44.138.47','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/5321 (KHTML, like Gecko) Chrome/40.0.828.0 Mobile Safari/5321','2024-12-23 04:25:11','2025-01-18 19:11:22'),(34,NULL,'Botble\\Member\\Models\\Member',5,'Botble\\Blog\\Models\\Post',2,'https://botble.test','Bryana Treutel','hills.constantin@collins.info','https://friendsofbotble.com','Kudos to the author for a well-researched piece.','approved','244.104.75.99','Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.0 (KHTML, like Gecko) Chrome/84.0.4072.36 Safari/537.0 EdgA/84.01105.46','2025-01-17 01:43:36','2025-01-18 19:11:22'),(35,NULL,'Botble\\Member\\Models\\Member',3,'Botble\\Blog\\Models\\Post',15,'https://botble.test','Maggie Hauck','gutmann.earl@littel.com','https://friendsofbotble.com','I\'m impressed by the depth of knowledge demonstrated here.','approved','217.4.207.83','Mozilla/5.0 (compatible; MSIE 6.0; Windows CE; Trident/3.0)','2025-01-06 04:04:10','2025-01-18 19:11:22'),(36,NULL,'Botble\\Member\\Models\\Member',8,'Botble\\Blog\\Models\\Post',7,'https://botble.test','Caden Jones III','carroll.suzanne@dach.biz','https://friendsofbotble.com','This article challenged my assumptions in a good way.','approved','90.25.31.37','Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 5.01; Trident/3.1)','2025-01-16 00:46:29','2025-01-18 19:11:22'),(37,NULL,'Botble\\Member\\Models\\Member',8,'Botble\\Blog\\Models\\Post',14,'https://botble.test','Reggie Block','schmidt.tremaine@hotmail.com','https://friendsofbotble.com','I\'ve shared this with my colleagues, it\'s worth discussing.','approved','226.174.229.196','Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.2; Trident/3.1)','2025-01-12 16:21:49','2025-01-18 19:11:22'),(38,NULL,'Botble\\Member\\Models\\Member',0,'Botble\\Blog\\Models\\Post',17,'https://botble.test','Lexus Hahn','tiana.mueller@pfannerstill.com','https://friendsofbotble.com','The information presented here is very valuable.','approved','233.119.103.119','Mozilla/5.0 (compatible; MSIE 6.0; Windows 95; Trident/3.0)','2025-01-07 21:13:22','2025-01-18 19:11:22'),(39,NULL,'Botble\\Member\\Models\\Member',10,'Botble\\Blog\\Models\\Post',14,'https://botble.test','Mr. Karson Halvorson Jr.','thaddeus.larson@lebsack.com','https://friendsofbotble.com','You have a talent for explaining complex topics clearly.','approved','86.232.163.105','Mozilla/5.0 (Windows NT 5.1) AppleWebKit/5351 (KHTML, like Gecko) Chrome/40.0.827.0 Mobile Safari/5351','2025-01-17 02:54:33','2025-01-18 19:11:22'),(40,NULL,'Botble\\Member\\Models\\Member',6,'Botble\\Blog\\Models\\Post',13,'https://botble.test','Dr. Meta Brown II','hoppe.guadalupe@mcdermott.org','https://friendsofbotble.com','I\'m inspired to learn more about this after reading your article.','approved','94.148.200.46','Mozilla/5.0 (iPhone; CPU iPhone OS 13_2 like Mac OS X) AppleWebKit/534.2 (KHTML, like Gecko) Version/15.0 EdgiOS/93.01134.63 Mobile/15E148 Safari/534.2','2025-01-10 12:11:51','2025-01-18 19:11:22'),(41,NULL,'Botble\\Member\\Models\\Member',6,'Botble\\Blog\\Models\\Post',11,'https://botble.test','Simone Kshlerin','hgerlach@gmail.com','https://friendsofbotble.com','This article deserves wider recognition.','approved','3.226.251.208','Mozilla/5.0 (Macintosh; PPC Mac OS X 10_7_0 rv:2.0) Gecko/20120321 Firefox/35.0','2025-01-13 11:02:27','2025-01-18 19:11:22'),(42,NULL,'Botble\\Member\\Models\\Member',0,'Botble\\Blog\\Models\\Post',11,'https://botble.test','Hayley Leffler','conner.hintz@skiles.org','https://friendsofbotble.com','I\'m grateful for the insights shared in this piece.','approved','75.118.173.166','Mozilla/5.0 (iPad; CPU OS 7_1_1 like Mac OS X; en-US) AppleWebKit/531.43.3 (KHTML, like Gecko) Version/4.0.5 Mobile/8B119 Safari/6531.43.3','2025-01-06 02:42:20','2025-01-18 19:11:22'),(43,NULL,'Botble\\Member\\Models\\Member',10,'Botble\\Blog\\Models\\Post',13,'https://botble.test','Gerhard Cremin','abshire.travon@gmail.com','https://friendsofbotble.com','The author presents a balanced view on a controversial topic.','approved','196.10.3.3','Mozilla/5.0 (Windows NT 4.0; nl-NL; rv:1.9.2.20) Gecko/20160522 Firefox/37.0','2024-12-25 09:02:32','2025-01-18 19:11:22'),(44,NULL,'Botble\\Member\\Models\\Member',0,'Botble\\Blog\\Models\\Post',10,'https://botble.test','Josue Miller MD','erika.kris@cruickshank.org','https://friendsofbotble.com','I\'m glad I stumbled upon this article, it\'s','approved','170.28.17.251','Mozilla/5.0 (iPhone; CPU iPhone OS 14_1 like Mac OS X) AppleWebKit/535.0 (KHTML, like Gecko) Version/15.0 EdgiOS/85.01133.83 Mobile/15E148 Safari/535.0','2025-01-14 13:31:26','2025-01-18 19:11:22'),(45,NULL,'Botble\\Member\\Models\\Member',9,'Botble\\Blog\\Models\\Post',8,'https://botble.test','Emilio Turner','edwin98@gmail.com','https://friendsofbotble.com','I\'ve been searching for information on this topic, glad I found this article. It\'s incredibly insightful and provides a comprehensive overview of the subject matter. I appreciate the effort put into researching and writing this piece. It\'s truly eye-opening and has given me a new perspective. Thank you for sharing your knowledge with us!','approved','111.124.188.185','Mozilla/5.0 (X11; Linux i686; rv:7.0) Gecko/20141213 Firefox/37.0','2025-01-02 17:56:45','2025-01-18 19:11:22'),(46,NULL,'Botble\\Member\\Models\\Member',5,'Botble\\Blog\\Models\\Post',16,'https://botble.test','Jessica Grant','vanessa98@gmail.com','https://friendsofbotble.com','This article is a masterpiece! It dives deep into the topic and offers valuable insights that are both thought-provoking and enlightening. The author\'s expertise is evident throughout, making it a compelling read from start to finish. I\'ll definitely be coming back to this for reference in the future.','approved','3.65.202.158','Mozilla/5.0 (Windows NT 5.1) AppleWebKit/5340 (KHTML, like Gecko) Chrome/38.0.858.0 Mobile Safari/5340','2025-01-11 16:16:42','2025-01-18 19:11:22'),(47,NULL,'Botble\\Member\\Models\\Member',4,'Botble\\Blog\\Models\\Post',16,'https://botble.test','Mr. Lawrence Sporer','kobe12@wiegand.net','https://friendsofbotble.com','I\'m amazed by the depth of analysis in this article. It covers a wide range of aspects related to the topic, providing a comprehensive understanding. The clarity of explanation is commendable, making complex concepts easy to grasp. This article has enriched my understanding and sparked further curiosity. Kudos to the author!','approved','132.1.31.179','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/5332 (KHTML, like Gecko) Chrome/36.0.803.0 Mobile Safari/5332','2025-01-16 17:56:04','2025-01-18 19:11:22');
/*!40000 ALTER TABLE `fob_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint unsigned NOT NULL DEFAULT '0',
  `order` tinyint unsigned NOT NULL DEFAULT '0',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galleries_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (1,'Sunset','Quam non in optio recusandae et magni. Eum maiores dolor sunt sunt aliquid dolorem. Fuga et id porro quia consequatur nostrum et ipsa.',1,0,'news/6.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(2,'Ocean Views','Non maxime odio aut vero. Hic repudiandae aut dolor magnam. Nulla animi similique sapiente atque voluptatem tenetur.',1,0,'news/7.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(3,'Adventure Time','Quia quasi perspiciatis id voluptatem expedita est nulla facere. Quidem minus provident ut voluptatem. Harum aut eius asperiores dolorem distinctio.',1,0,'news/8.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(4,'City Lights','Qui unde voluptatem eos. Quasi molestiae molestias ducimus occaecati quidem. Nisi sequi illum et eum culpa.',1,0,'news/9.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(5,'Dreamscape','Nihil quia doloribus id est nesciunt ratione saepe. Ut cumque ut nesciunt inventore. Doloribus ipsam sit corrupti officia et impedit.',1,0,'news/10.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(6,'Enchanted Forest','Et exercitationem deserunt debitis. Qui aut in dolores voluptas. Animi qui provident impedit placeat nesciunt rerum fugiat. Non quaerat sit vel in.',1,0,'news/11.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(7,'Golden Hour','Velit ea cumque debitis quia modi odio iste. Dignissimos officia quae earum autem placeat et qui optio. Et qui dolor culpa sit quibusdam vero.',0,0,'news/12.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(8,'Serenity','Nulla libero sapiente atque ipsum. Perferendis pariatur labore odio doloremque vero assumenda ex.',0,0,'news/13.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(9,'Eternal Beauty','Dolor aut sunt sed libero commodi et eum dolorem. Vel non quia voluptatem voluptatem. Placeat voluptate atque neque qui et ea quia recusandae.',0,0,'news/14.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(10,'Moonlight Magic','Ut aut adipisci veritatis. Vero quia occaecati veritatis aut velit fugiat. Eos natus sed quia voluptatem. Est eum aut odit voluptatibus.',0,0,'news/15.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(11,'Starry Night','Eaque delectus perspiciatis voluptatibus harum voluptatem. Cum dolorum repellat et inventore. Harum et aliquam ut rerum.',0,0,'news/16.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(12,'Hidden Gems','Vitae non aut qui possimus dolore libero. Est ea magnam ea non vitae. Libero perferendis non ipsa sunt reprehenderit.',0,0,'news/17.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(13,'Tranquil Waters','Dolores qui voluptas quis et voluptatem. Libero mollitia ab ex aut porro animi ut. Corporis corrupti aut tempora neque sit aut.',0,0,'news/18.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(14,'Urban Escape','A harum ipsa ipsum adipisci asperiores ut. Earum recusandae assumenda atque illo inventore. Et voluptatem id quia reprehenderit et aut molestiae.',0,0,'news/19.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(15,'Twilight Zone','Pariatur magnam quaerat soluta modi eaque. Corrupti numquam facere illum atque sint sequi corrupti.',0,0,'news/20.jpg',1,'published','2025-01-18 19:11:18','2025-01-18 19:11:18');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries_translations`
--

DROP TABLE IF EXISTS `galleries_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `galleries_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`galleries_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries_translations`
--

LOCK TABLES `galleries_translations` WRITE;
/*!40000 ALTER TABLE `galleries_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `galleries_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_meta`
--

DROP TABLE IF EXISTS `gallery_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery_meta` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `images` text COLLATE utf8mb4_unicode_ci,
  `reference_id` bigint unsigned NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_meta_reference_id_index` (`reference_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_meta`
--

LOCK TABLES `gallery_meta` WRITE;
/*!40000 ALTER TABLE `gallery_meta` DISABLE KEYS */;
INSERT INTO `gallery_meta` VALUES (1,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',1,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(2,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',2,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(3,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',3,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(4,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',4,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(5,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',5,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(6,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',6,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(7,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',7,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(8,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',8,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(9,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',9,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(10,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',10,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(11,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',11,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(12,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',12,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(13,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',13,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(14,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',14,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18'),(15,'[{\"img\":\"news\\/1.jpg\",\"description\":\"Id est impedit dolorum. Dolor dignissimos iste non est eum. Totam ipsum ut dolor fugit voluptatem et. Nulla corporis porro voluptas minus sed.\"},{\"img\":\"news\\/2.jpg\",\"description\":\"Et consequuntur odio in est occaecati ipsum ut. Nostrum natus perferendis rerum voluptatum delectus. Voluptates eum quae qui.\"},{\"img\":\"news\\/3.jpg\",\"description\":\"Dolores autem voluptatibus possimus corporis magnam. Praesentium et ex corporis vel quisquam enim. Nemo dolores ab nam id et fuga debitis.\"},{\"img\":\"news\\/4.jpg\",\"description\":\"Quae repellendus aut nihil sunt exercitationem dolorem. Dignissimos est hic rerum quae mollitia iusto. Assumenda in eligendi in nemo.\"},{\"img\":\"news\\/5.jpg\",\"description\":\"Similique sunt omnis sit consequatur tempore porro et. Ut voluptate ut ut aspernatur quas accusantium. Enim dolor iste commodi rerum.\"},{\"img\":\"news\\/6.jpg\",\"description\":\"Sapiente expedita blanditiis sed sit. Perspiciatis sunt animi vitae dignissimos.\"},{\"img\":\"news\\/7.jpg\",\"description\":\"Ut dolor quasi maiores. Iure dolorem fugit optio. Doloremque in iste voluptatem vero ut minima quam.\"},{\"img\":\"news\\/8.jpg\",\"description\":\"Est recusandae eos perferendis sed est. Minus et aut perspiciatis laudantium. Voluptatem beatae aut ut voluptas quia aut qui.\"},{\"img\":\"news\\/9.jpg\",\"description\":\"Et qui nobis excepturi ad qui. Modi amet laboriosam dolor omnis. Voluptatibus alias eligendi quo earum et sit.\"},{\"img\":\"news\\/10.jpg\",\"description\":\"Laboriosam nobis quod sit est aut aut est. Quaerat eaque illo accusantium praesentium nihil quisquam corporis. Sit odio modi harum.\"},{\"img\":\"news\\/11.jpg\",\"description\":\"Dolorum natus molestias quam suscipit repellat qui assumenda. Nisi alias aut quo quia architecto ad.\"},{\"img\":\"news\\/12.jpg\",\"description\":\"Maxime possimus id molestiae id dicta. Nihil ut qui temporibus deleniti molestiae. Maxime non rerum numquam.\"},{\"img\":\"news\\/13.jpg\",\"description\":\"Reprehenderit debitis iste minus eos animi. Ipsam reprehenderit sunt consequatur laboriosam laborum eaque architecto.\"},{\"img\":\"news\\/14.jpg\",\"description\":\"Optio qui excepturi earum porro laborum similique. Molestias vel recusandae error molestiae aut. Quisquam consequatur possimus vitae est veritatis.\"},{\"img\":\"news\\/15.jpg\",\"description\":\"Delectus ab qui tenetur nobis. Fugiat aut veritatis doloribus voluptatem quasi et. Ut excepturi a veritatis unde dignissimos assumenda.\"},{\"img\":\"news\\/16.jpg\",\"description\":\"Voluptate labore cum atque et nulla nobis. Assumenda saepe magni magnam aperiam et consectetur. Labore sunt ab eaque expedita blanditiis.\"},{\"img\":\"news\\/17.jpg\",\"description\":\"Facilis eum et provident eos qui. Voluptatem delectus quaerat molestiae asperiores assumenda perspiciatis rerum.\"},{\"img\":\"news\\/18.jpg\",\"description\":\"Dicta cum ducimus ut tempore voluptates. Labore est soluta nam aut sapiente non. Mollitia rem autem in beatae. Rerum dolor debitis ratione.\"},{\"img\":\"news\\/19.jpg\",\"description\":\"Earum perferendis et veritatis nulla et. Non velit veniam quia temporibus sit aut ut. Doloremque in vero veniam.\"},{\"img\":\"news\\/20.jpg\",\"description\":\"Quaerat molestiae tenetur ut placeat blanditiis. Facilis magni totam sit ea vel.\"}]',15,'Botble\\Gallery\\Models\\Gallery','2025-01-18 19:11:18','2025-01-18 19:11:18');
/*!40000 ALTER TABLE `gallery_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_meta_translations`
--

DROP TABLE IF EXISTS `gallery_meta_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery_meta_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gallery_meta_id` bigint unsigned NOT NULL,
  `images` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`gallery_meta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_meta_translations`
--

LOCK TABLES `gallery_meta_translations` WRITE;
/*!40000 ALTER TABLE `gallery_meta_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `gallery_meta_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `language_meta`
--

DROP TABLE IF EXISTS `language_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `language_meta` (
  `lang_meta_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang_meta_code` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_meta_origin` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint unsigned NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`lang_meta_id`),
  KEY `language_meta_reference_id_index` (`reference_id`),
  KEY `meta_code_index` (`lang_meta_code`),
  KEY `meta_origin_index` (`lang_meta_origin`),
  KEY `meta_reference_type_index` (`reference_type`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `language_meta`
--

LOCK TABLES `language_meta` WRITE;
/*!40000 ALTER TABLE `language_meta` DISABLE KEYS */;
INSERT INTO `language_meta` VALUES (1,'en_US','96906aeab464ba45a742cec6e7de807b',1,'Botble\\Menu\\Models\\MenuLocation'),(2,'en_US','8b7cce08ea56ac08488575b0ca528512',1,'Botble\\Menu\\Models\\Menu'),(3,'en_US','1fdbdd3ea84195e64281c516ea6c0b96',2,'Botble\\Menu\\Models\\Menu');
/*!40000 ALTER TABLE `language_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `lang_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_locale` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_flag` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang_is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `lang_order` int NOT NULL DEFAULT '0',
  `lang_is_rtl` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`),
  KEY `lang_locale_index` (`lang_locale`),
  KEY `lang_code_index` (`lang_code`),
  KEY `lang_is_default_index` (`lang_is_default`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `languages`
--

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'English','en','en_US','us',1,0,0);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_files`
--

DROP TABLE IF EXISTS `media_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `folder_id` bigint unsigned NOT NULL DEFAULT '0',
  `mime_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `visibility` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  PRIMARY KEY (`id`),
  KEY `media_files_user_id_index` (`user_id`),
  KEY `media_files_index` (`folder_id`,`user_id`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_files`
--

LOCK TABLES `media_files` WRITE;
/*!40000 ALTER TABLE `media_files` DISABLE KEYS */;
INSERT INTO `media_files` VALUES (1,0,'1','1',1,'image/jpeg',9803,'news/1.jpg','[]','2025-01-18 19:11:16','2025-01-18 19:11:16',NULL,'public'),(2,0,'10','10',1,'image/jpeg',9803,'news/10.jpg','[]','2025-01-18 19:11:16','2025-01-18 19:11:16',NULL,'public'),(3,0,'11','11',1,'image/jpeg',9803,'news/11.jpg','[]','2025-01-18 19:11:16','2025-01-18 19:11:16',NULL,'public'),(4,0,'12','12',1,'image/jpeg',9803,'news/12.jpg','[]','2025-01-18 19:11:16','2025-01-18 19:11:16',NULL,'public'),(5,0,'13','13',1,'image/jpeg',9803,'news/13.jpg','[]','2025-01-18 19:11:16','2025-01-18 19:11:16',NULL,'public'),(6,0,'14','14',1,'image/jpeg',9803,'news/14.jpg','[]','2025-01-18 19:11:16','2025-01-18 19:11:16',NULL,'public'),(7,0,'15','15',1,'image/jpeg',9803,'news/15.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(8,0,'16','16',1,'image/jpeg',9803,'news/16.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(9,0,'17','17',1,'image/jpeg',9803,'news/17.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(10,0,'18','18',1,'image/jpeg',9803,'news/18.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(11,0,'19','19',1,'image/jpeg',9803,'news/19.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(12,0,'2','2',1,'image/jpeg',9803,'news/2.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(13,0,'20','20',1,'image/jpeg',9803,'news/20.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(14,0,'3','3',1,'image/jpeg',9803,'news/3.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(15,0,'4','4',1,'image/jpeg',9803,'news/4.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(16,0,'5','5',1,'image/jpeg',9803,'news/5.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(17,0,'6','6',1,'image/jpeg',9803,'news/6.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(18,0,'7','7',1,'image/jpeg',9803,'news/7.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(19,0,'8','8',1,'image/jpeg',9803,'news/8.jpg','[]','2025-01-18 19:11:17','2025-01-18 19:11:17',NULL,'public'),(20,0,'9','9',1,'image/jpeg',9803,'news/9.jpg','[]','2025-01-18 19:11:18','2025-01-18 19:11:18',NULL,'public'),(21,0,'1','1',2,'image/jpeg',9803,'members/1.jpg','[]','2025-01-18 19:11:18','2025-01-18 19:11:18',NULL,'public'),(22,0,'10','10',2,'image/jpeg',9803,'members/10.jpg','[]','2025-01-18 19:11:18','2025-01-18 19:11:18',NULL,'public'),(23,0,'11','11',2,'image/jpeg',9803,'members/11.jpg','[]','2025-01-18 19:11:18','2025-01-18 19:11:18',NULL,'public'),(24,0,'12','12',2,'image/jpeg',9803,'members/12.jpg','[]','2025-01-18 19:11:18','2025-01-18 19:11:18',NULL,'public'),(25,0,'13','13',2,'image/jpeg',9803,'members/13.jpg','[]','2025-01-18 19:11:18','2025-01-18 19:11:18',NULL,'public'),(26,0,'14','14',2,'image/jpeg',9803,'members/14.jpg','[]','2025-01-18 19:11:18','2025-01-18 19:11:18',NULL,'public'),(27,0,'15','15',2,'image/jpeg',9803,'members/15.jpg','[]','2025-01-18 19:11:18','2025-01-18 19:11:18',NULL,'public'),(28,0,'2','2',2,'image/jpeg',9803,'members/2.jpg','[]','2025-01-18 19:11:19','2025-01-18 19:11:19',NULL,'public'),(29,0,'3','3',2,'image/jpeg',9803,'members/3.jpg','[]','2025-01-18 19:11:19','2025-01-18 19:11:19',NULL,'public'),(30,0,'4','4',2,'image/jpeg',9803,'members/4.jpg','[]','2025-01-18 19:11:19','2025-01-18 19:11:19',NULL,'public'),(31,0,'5','5',2,'image/jpeg',9803,'members/5.jpg','[]','2025-01-18 19:11:19','2025-01-18 19:11:19',NULL,'public'),(32,0,'6','6',2,'image/jpeg',9803,'members/6.jpg','[]','2025-01-18 19:11:19','2025-01-18 19:11:19',NULL,'public'),(33,0,'7','7',2,'image/jpeg',9803,'members/7.jpg','[]','2025-01-18 19:11:19','2025-01-18 19:11:19',NULL,'public'),(34,0,'8','8',2,'image/jpeg',9803,'members/8.jpg','[]','2025-01-18 19:11:19','2025-01-18 19:11:19',NULL,'public'),(35,0,'9','9',2,'image/jpeg',9803,'members/9.jpg','[]','2025-01-18 19:11:19','2025-01-18 19:11:19',NULL,'public'),(36,0,'favicon','favicon',3,'image/png',1122,'general/favicon.png','[]','2025-01-18 19:11:22','2025-01-18 19:11:22',NULL,'public'),(37,0,'logo','logo',3,'image/png',46109,'general/logo.png','[]','2025-01-18 19:11:22','2025-01-18 19:11:22',NULL,'public'),(38,0,'preloader','preloader',3,'image/gif',92769,'general/preloader.gif','[]','2025-01-18 19:11:22','2025-01-18 19:11:22',NULL,'public');
/*!40000 ALTER TABLE `media_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_folders`
--

DROP TABLE IF EXISTS `media_folders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_folders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_folders_user_id_index` (`user_id`),
  KEY `media_folders_index` (`parent_id`,`user_id`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_folders`
--

LOCK TABLES `media_folders` WRITE;
/*!40000 ALTER TABLE `media_folders` DISABLE KEYS */;
INSERT INTO `media_folders` VALUES (1,0,'news',NULL,'news',0,'2025-01-18 19:11:16','2025-01-18 19:11:16',NULL),(2,0,'members',NULL,'members',0,'2025-01-18 19:11:18','2025-01-18 19:11:18',NULL),(3,0,'general',NULL,'general',0,'2025-01-18 19:11:22','2025-01-18 19:11:22',NULL);
/*!40000 ALTER TABLE `media_folders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_settings`
--

DROP TABLE IF EXISTS `media_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `media_id` bigint unsigned DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_settings`
--

LOCK TABLES `media_settings` WRITE;
/*!40000 ALTER TABLE `media_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `media_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_activity_logs`
--

DROP TABLE IF EXISTS `member_activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `reference_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `member_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `member_activity_logs_member_id_index` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_activity_logs`
--

LOCK TABLES `member_activity_logs` WRITE;
/*!40000 ALTER TABLE `member_activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `member_activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_password_resets`
--

DROP TABLE IF EXISTS `member_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `member_password_resets_email_index` (`email`),
  KEY `member_password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_password_resets`
--

LOCK TABLES `member_password_resets` WRITE;
/*!40000 ALTER TABLE `member_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `member_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `gender` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_id` bigint unsigned DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `email_verify_token` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `menu_locations`
--

DROP TABLE IF EXISTS `menu_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_locations_menu_id_created_at_index` (`menu_id`,`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_locations`
--

LOCK TABLES `menu_locations` WRITE;
/*!40000 ALTER TABLE `menu_locations` DISABLE KEYS */;
INSERT INTO `menu_locations` VALUES (1,1,'main-menu','2025-01-18 19:11:22','2025-01-18 19:11:22');
/*!40000 ALTER TABLE `menu_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_nodes`
--

DROP TABLE IF EXISTS `menu_nodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_nodes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint unsigned NOT NULL,
  `parent_id` bigint unsigned NOT NULL DEFAULT '0',
  `reference_id` bigint unsigned DEFAULT NULL,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_font` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` tinyint unsigned NOT NULL DEFAULT '0',
  `title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `css_class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `has_child` tinyint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_nodes_menu_id_index` (`menu_id`),
  KEY `menu_nodes_parent_id_index` (`parent_id`),
  KEY `reference_id` (`reference_id`),
  KEY `reference_type` (`reference_type`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_nodes`
--

LOCK TABLES `menu_nodes` WRITE;
/*!40000 ALTER TABLE `menu_nodes` DISABLE KEYS */;
INSERT INTO `menu_nodes` VALUES (1,1,0,NULL,NULL,'/',NULL,0,'Home',NULL,'_self',0,'2025-01-18 19:11:22','2025-01-18 19:11:22'),(2,1,0,NULL,NULL,'https://botble.com/go/download-cms',NULL,0,'Purchase',NULL,'_blank',0,'2025-01-18 19:11:22','2025-01-18 19:11:22'),(3,1,0,2,'Botble\\Page\\Models\\Page','/blog',NULL,0,'Blog',NULL,'_self',0,'2025-01-18 19:11:22','2025-01-18 19:11:22'),(4,1,0,5,'Botble\\Page\\Models\\Page','/galleries',NULL,0,'Galleries',NULL,'_self',0,'2025-01-18 19:11:22','2025-01-18 19:11:22'),(5,1,0,3,'Botble\\Page\\Models\\Page','/contact',NULL,0,'Contact',NULL,'_self',0,'2025-01-18 19:11:22','2025-01-18 19:11:22'),(6,2,0,NULL,NULL,'https://facebook.com','ti ti-brand-facebook',1,'Facebook',NULL,'_blank',0,'2025-01-18 19:11:22','2025-01-18 19:11:22'),(7,2,0,NULL,NULL,'https://twitter.com','ti ti-brand-x',1,'Twitter',NULL,'_blank',0,'2025-01-18 19:11:22','2025-01-18 19:11:22'),(8,2,0,NULL,NULL,'https://github.com','ti ti-brand-github',1,'GitHub',NULL,'_blank',0,'2025-01-18 19:11:22','2025-01-18 19:11:22'),(9,2,0,NULL,NULL,'https://linkedin.com','ti ti-brand-linkedin',1,'Linkedin',NULL,'_blank',0,'2025-01-18 19:11:22','2025-01-18 19:11:22');
/*!40000 ALTER TABLE `menu_nodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menus_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Main menu','main-menu','published','2025-01-18 19:11:22','2025-01-18 19:11:22'),(2,'Social','social','published','2025-01-18 19:11:22','2025-01-18 19:11:22');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meta_boxes`
--

DROP TABLE IF EXISTS `meta_boxes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meta_boxes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` text COLLATE utf8mb4_unicode_ci,
  `reference_id` bigint unsigned NOT NULL,
  `reference_type` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `meta_boxes_reference_id_index` (`reference_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meta_boxes`
--

LOCK TABLES `meta_boxes` WRITE;
/*!40000 ALTER TABLE `meta_boxes` DISABLE KEYS */;
/*!40000 ALTER TABLE `meta_boxes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'2013_04_09_032329_create_base_tables',1),(3,'2013_04_09_062329_create_revisions_table',1),(4,'2014_10_12_000000_create_users_table',1),(5,'2014_10_12_100000_create_password_reset_tokens_table',1),(6,'2016_06_10_230148_create_acl_tables',1),(7,'2016_06_14_230857_create_menus_table',1),(8,'2016_06_28_221418_create_pages_table',1),(9,'2016_10_05_074239_create_setting_table',1),(10,'2016_11_28_032840_create_dashboard_widget_tables',1),(11,'2016_12_16_084601_create_widgets_table',1),(12,'2017_05_09_070343_create_media_tables',1),(13,'2017_11_03_070450_create_slug_table',1),(14,'2019_01_05_053554_create_jobs_table',1),(15,'2019_08_19_000000_create_failed_jobs_table',1),(16,'2019_12_14_000001_create_personal_access_tokens_table',1),(17,'2022_04_20_100851_add_index_to_media_table',1),(18,'2022_04_20_101046_add_index_to_menu_table',1),(19,'2022_07_10_034813_move_lang_folder_to_root',1),(20,'2022_08_04_051940_add_missing_column_expires_at',1),(21,'2022_09_01_000001_create_admin_notifications_tables',1),(22,'2022_10_14_024629_drop_column_is_featured',1),(23,'2022_11_18_063357_add_missing_timestamp_in_table_settings',1),(24,'2022_12_02_093615_update_slug_index_columns',1),(25,'2023_01_30_024431_add_alt_to_media_table',1),(26,'2023_02_16_042611_drop_table_password_resets',1),(27,'2023_04_23_005903_add_column_permissions_to_admin_notifications',1),(28,'2023_05_10_075124_drop_column_id_in_role_users_table',1),(29,'2023_08_21_090810_make_page_content_nullable',1),(30,'2023_09_14_021936_update_index_for_slugs_table',1),(31,'2023_12_07_095130_add_color_column_to_media_folders_table',1),(32,'2023_12_17_162208_make_sure_column_color_in_media_folders_nullable',1),(33,'2024_04_04_110758_update_value_column_in_user_meta_table',1),(34,'2024_05_12_091229_add_column_visibility_to_table_media_files',1),(35,'2024_07_07_091316_fix_column_url_in_menu_nodes_table',1),(36,'2024_07_12_100000_change_random_hash_for_media',1),(37,'2024_09_30_024515_create_sessions_table',1),(38,'2024_04_27_100730_improve_analytics_setting',2),(39,'2015_06_29_025744_create_audit_history',3),(40,'2023_11_14_033417_change_request_column_in_table_audit_histories',3),(41,'2017_02_13_034601_create_blocks_table',4),(42,'2021_12_03_081327_create_blocks_translations',4),(43,'2024_09_05_071942_add_raw_content_to_blocks_table',4),(44,'2015_06_18_033822_create_blog_table',5),(45,'2021_02_16_092633_remove_default_value_for_author_type',5),(46,'2021_12_03_030600_create_blog_translations',5),(47,'2022_04_19_113923_add_index_to_table_posts',5),(48,'2023_08_29_074620_make_column_author_id_nullable',5),(49,'2024_07_30_091615_fix_order_column_in_categories_table',5),(50,'2025_01_06_033807_add_default_value_for_categories_author_type',5),(51,'2016_06_17_091537_create_contacts_table',6),(52,'2023_11_10_080225_migrate_contact_blacklist_email_domains_to_core',6),(53,'2024_03_20_080001_migrate_change_attribute_email_to_nullable_form_contacts_table',6),(54,'2024_03_25_000001_update_captcha_settings_for_contact',6),(55,'2024_04_19_063914_create_custom_fields_table',6),(56,'2017_03_27_150646_re_create_custom_field_tables',7),(57,'2022_04_30_030807_table_custom_fields_translation_table',7),(58,'2024_01_16_050056_create_comments_table',8),(59,'2016_10_13_150201_create_galleries_table',9),(60,'2021_12_03_082953_create_gallery_translations',9),(61,'2022_04_30_034048_create_gallery_meta_translations_table',9),(62,'2023_08_29_075308_make_column_user_id_nullable',9),(63,'2016_10_03_032336_create_languages_table',10),(64,'2023_09_14_022423_add_index_for_language_table',10),(65,'2021_10_25_021023_fix-priority-load-for-language-advanced',11),(66,'2021_12_03_075608_create_page_translations',11),(67,'2023_07_06_011444_create_slug_translations_table',11),(68,'2017_10_04_140938_create_member_table',12),(69,'2023_10_16_075332_add_status_column',12),(70,'2024_03_25_000001_update_captcha_settings',12),(71,'2016_05_28_112028_create_system_request_logs_table',13),(72,'2016_10_07_193005_create_translations_table',14),(73,'2023_12_12_105220_drop_translations_table',14);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,'Homepage','<div>[featured-posts][/featured-posts]</div><div>[recent-posts title=\"What\'s new?\"][/recent-posts]</div><div>[featured-categories-posts title=\"Best for you\" category_id=\"\" enable_lazy_loading=\"yes\"][/featured-categories-posts]</div><div>[all-galleries limit=\"6\" title=\"Galleries\" enable_lazy_loading=\"yes\"][/all-galleries]</div>',1,NULL,'no-sidebar',NULL,'published','2025-01-18 19:11:16','2025-01-18 19:11:16'),(2,'Blog','---',1,NULL,NULL,NULL,'published','2025-01-18 19:11:16','2025-01-18 19:11:16'),(3,'Contact','<p>Address: North Link Building, 10 Admiralty Street, 757695 Singapore</p><p>Hotline: 18006268</p><p>Email: contact@botble.com</p><p>[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]</p><p>For the fastest reply, please use the contact form below.</p><p>[contact-form][/contact-form]</p>',1,NULL,NULL,NULL,'published','2025-01-18 19:11:16','2025-01-18 19:11:16'),(4,'Cookie Policy','<h3>EU Cookie Consent</h3><p>To use this website we are using Cookies and collecting some Data. To be compliant with the EU GDPR we give you to choose if you allow us to use certain Cookies and to collect some Data.</p><h4>Essential Data</h4><p>The Essential Data is needed to run the Site you are visiting technically. You can not deactivate them.</p><p>- Session Cookie: PHP uses a Cookie to identify user sessions. Without this Cookie the Website is not working.</p><p>- XSRF-Token Cookie: Laravel automatically generates a CSRF \"token\" for each active user session managed by the application. This token is used to verify that the authenticated user is the one actually making the requests to the application.</p>',1,NULL,NULL,NULL,'published','2025-01-18 19:11:16','2025-01-18 19:11:16'),(5,'Galleries','<div>[gallery title=\"Galleries\" enable_lazy_loading=\"yes\"][/gallery]</div>',1,NULL,NULL,NULL,'published','2025-01-18 19:11:16','2025-01-18 19:11:16');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages_translations`
--

DROP TABLE IF EXISTS `pages_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pages_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`pages_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages_translations`
--

LOCK TABLES `pages_translations` WRITE;
/*!40000 ALTER TABLE `pages_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_categories`
--

DROP TABLE IF EXISTS `post_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_categories` (
  `category_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  KEY `post_categories_category_id_index` (`category_id`),
  KEY `post_categories_post_id_index` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_categories`
--

LOCK TABLES `post_categories` WRITE;
/*!40000 ALTER TABLE `post_categories` DISABLE KEYS */;
INSERT INTO `post_categories` VALUES (2,1),(3,1),(5,2),(3,2),(1,3),(3,3),(5,4),(8,4),(8,5),(1,5),(7,6),(5,6),(6,7),(3,7),(3,8),(7,8),(4,9),(2,9),(5,10),(8,10),(4,11),(1,12),(2,12),(6,13),(2,13),(3,14),(4,14),(3,15),(5,15),(6,16),(1,16),(1,17),(3,17),(4,18),(8,18),(4,19),(5,19),(3,20),(2,20);
/*!40000 ALTER TABLE `post_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_tags`
--

DROP TABLE IF EXISTS `post_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post_tags` (
  `tag_id` bigint unsigned NOT NULL,
  `post_id` bigint unsigned NOT NULL,
  KEY `post_tags_tag_id_index` (`tag_id`),
  KEY `post_tags_post_id_index` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_tags`
--

LOCK TABLES `post_tags` WRITE;
/*!40000 ALTER TABLE `post_tags` DISABLE KEYS */;
INSERT INTO `post_tags` VALUES (4,1),(5,1),(1,1),(1,2),(4,2),(8,2),(6,3),(2,3),(7,4),(5,4),(2,4),(5,5),(8,5),(7,5),(6,6),(3,6),(4,7),(2,7),(8,7),(1,8),(5,8),(8,9),(3,9),(2,9),(6,10),(8,10),(7,10),(2,11),(7,11),(1,12),(8,12),(7,12),(8,13),(6,13),(2,13),(8,14),(1,14),(6,14),(3,15),(2,15),(1,15),(3,16),(7,16),(8,16),(4,17),(1,17),(3,17),(8,18),(5,18),(5,19),(7,19),(6,20),(4,20),(5,20);
/*!40000 ALTER TABLE `post_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `author_id` bigint unsigned DEFAULT NULL,
  `author_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_featured` tinyint unsigned NOT NULL DEFAULT '0',
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int unsigned NOT NULL DEFAULT '0',
  `format_type` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_status_index` (`status`),
  KEY `posts_author_id_index` (`author_id`),
  KEY `posts_author_type_index` (`author_type`),
  KEY `posts_created_at_index` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'Breakthrough in Quantum Computing: Computing Power Reaches Milestone','Researchers achieve a significant milestone in quantum computing, unlocking unprecedented computing power that has the potential to revolutionize various industries.','<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>Would not, could not even room for this, and she went on. \'We had the best of educations--in fact, we went to school in the morning, just time to hear her try and repeat something now. Tell her to begin.\' He looked at each other for some time after the birds! Why, she\'ll eat a bat?\' when suddenly, thump! thump! down she came rather late, and the great concert given by the prisoner to--to somebody.\' \'It must have got into it), and handed back to finish his story. CHAPTER IV. The Rabbit started violently, dropped the white kid gloves, and was suppressed. \'Come, that finished the guinea-pigs!\' thought Alice. \'I\'m glad they don\'t seem to put the Lizard in head downwards, and the small ones choked and had just succeeded in getting its body tucked away, comfortably enough, under her arm, that it was in a thick wood. \'The first thing I\'ve got to go down the chimney as she swam about, trying to touch her. \'Poor little thing!\' said Alice, always ready to sink into the air off all its feet at.</p><p class=\"text-center\"><img src=\"/storage/news/3-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Mock Turtle yet?\' \'No,\' said Alice. \'Anything you like,\' said the Caterpillar seemed to think that proved it at all,\' said the Mock Turtle, capering wildly about. \'Change lobsters again!\' yelled the Gryphon whispered in a helpless sort of idea that they would call after her: the last concert!\' on which the cook had disappeared. \'Never mind!\' said the March Hare was said to herself in the distance, screaming with passion. She had not gone much farther before she had never been in a VERY.</p><p class=\"text-center\"><img src=\"/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>That your eye was as long as you are; secondly, because she was near enough to look for her, and said, very gravely, \'I think, you ought to have changed since her swim in the pool, and the cool fountains. CHAPTER VIII. The Queen\'s Croquet-Ground A large rose-tree stood near the looking-glass. There was no one to listen to her, still it was certainly not becoming. \'And that\'s the queerest thing about it.\' \'She\'s in prison,\' the Queen of Hearts, and I don\'t think,\' Alice went on, without attending to her, still it was just saying to her to begin.\' For, you see, because some of them bowed low. \'Would you tell me,\' said Alice, who had been (Before she had to sing \"Twinkle, twinkle, little bat! How I wonder what you\'re talking about,\' said Alice. \'Why, you don\'t even know what \"it\" means well enough, when I sleep\" is the same height as herself; and when she was as steady as ever; Yet you turned a back-somersault in at the door--I do wish they COULD! I\'m sure _I_ shan\'t be able! I shall.</p><p class=\"text-center\"><img src=\"/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice, surprised at her feet in the air, and came back again. \'Keep your temper,\' said the Duchess. \'I make you grow shorter.\' \'One side will make you a couple?\' \'You are old,\' said the Dodo. Then they all spoke at once, with a great hurry. An enormous puppy was looking down at them, and the bright flower-beds and the pool a little bit, and said anxiously to herself, as well to introduce some other subject of conversation. While she was saying, and the beak-- Pray how did you do either!\' And the moral of that is--\"Birds of a treacle-well--eh, stupid?\' \'But they were all writing very busily on slates. \'What are you getting on now, my dear?\' it continued, turning to the whiting,\' said the Cat, \'a dog\'s not mad. You grant that?\' \'I suppose so,\' said the youth, \'one would hardly suppose That your eye was as steady as ever; Yet you finished the goose, with the distant sobs of the house down!\' said the Mock Turtle. \'Very much indeed,\' said Alice. \'Nothing WHATEVER?\' persisted the King.</p>','published',1,'Botble\\ACL\\Models\\User',1,'news/1.jpg',798,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(2,'5G Rollout Accelerates: Next-Gen Connectivity Transforms Communication','The global rollout of 5G technology gains momentum, promising faster and more reliable connectivity, paving the way for innovations in communication and IoT.','<p>Alice quietly said, just as she swam about, trying to put down her flamingo, and began an account of the Rabbit\'s voice; and Alice joined the procession, wondering very much pleased at having found out that one of the Rabbit\'s voice; and Alice guessed in a tone of great curiosity. \'Soles and eels, of course,\' said the Gryphon: and Alice was very hot, she kept on good terms with him, he\'d do almost anything you liked with the clock. For instance, suppose it were white, but there were TWO little shrieks, and more faintly came, carried on the whole head appeared, and then I\'ll tell you my history, and you\'ll understand why it is almost certain to disagree with you, sooner or later. However, this bottle was NOT marked \'poison,\' it is to find that she was peering about anxiously among the party. Some of the words came very queer indeed:-- \'\'Tis the voice of thunder, and people began running about in the schoolroom, and though this was of very little way forwards each time and a Canary.</p><p class=\"text-center\"><img src=\"/storage/news/4-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice dear!\' said her sister; \'Why, what are they doing?\' Alice whispered to the table, but there was a most extraordinary noise going on rather better now,\' she added aloud. \'Do you take me for asking! No, it\'ll never do to come down the chimney?--Nay, I shan\'t! YOU do it!--That I won\'t, then!--Bill\'s to go through next walking about at the March Hare: she thought to herself. \'Shy, they seem to see it written down: but I can\'t be Mabel, for I know is, it would be four thousand miles down, I.</p><p class=\"text-center\"><img src=\"/storage/news/10-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>There was a little anxiously. \'Yes,\' said Alice, who had been wandering, when a sharp hiss made her draw back in a natural way. \'I thought you did,\' said the Knave, \'I didn\'t know that you\'re mad?\' \'To begin with,\' the Mock Turtle. \'Hold your tongue!\' said the Mouse. \'--I proceed. \"Edwin and Morcar, the earls of Mercia and Northumbria, declared for him: and even Stigand, the patriotic archbishop of Canterbury, found it so quickly that the Gryphon replied rather crossly: \'of course you don\'t!\' the Hatter said, tossing his head off outside,\' the Queen had ordered. They very soon found an opportunity of taking it away. She did not like the Queen?\' said the Caterpillar. \'I\'m afraid I don\'t take this child away with me,\' thought Alice, \'as all the creatures wouldn\'t be so stingy about it, you may nurse it a very poor speaker,\' said the Hatter. \'Does YOUR watch tell you his history,\' As they walked off together. Alice laughed so much contradicted in her lessons in the sea, though you.</p><p class=\"text-center\"><img src=\"/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>There was a large canvas bag, which tied up at this moment Alice appeared, she was beginning very angrily, but the Dormouse say?\' one of the sort,\' said the Cat went on, yawning and rubbing its eyes, for it was YOUR table,\' said Alice; \'I must be removed,\' said the Gryphon went on. \'Or would you like to have wondered at this, that she still held the pieces of mushroom in her French lesson-book. The Mouse did not like the wind, and the blades of grass, but she was coming back to finish his story. CHAPTER IV. The Rabbit started violently, dropped the white kid gloves, and was surprised to find that she looked up, and began bowing to the Mock Turtle yet?\' \'No,\' said Alice. \'Exactly so,\' said Alice. \'Of course twinkling begins with an M?\' said Alice. \'Did you speak?\' \'Not I!\' he replied. \'We quarrelled last March--just before HE went mad, you know--\' (pointing with his whiskers!\' For some minutes the whole party swam to the Knave. The Knave shook his head mournfully. \'Not I!\' said the.</p>','published',1,'Botble\\ACL\\Models\\User',1,'news/2.jpg',1662,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(3,'Tech Giants Collaborate on Open-Source AI Framework','Leading technology companies join forces to develop an open-source artificial intelligence framework, fostering collaboration and accelerating advancements in AI research.','<p>On various pretexts they all quarrel so dreadfully one can\'t hear oneself speak--and they don\'t seem to be\"--or if you\'d like it very hard indeed to make it stop. \'Well, I\'d hardly finished the guinea-pigs!\' thought Alice. The poor little thing was to get to,\' said the King replied. Here the other players, and shouting \'Off with their heads!\' and the other ladder?--Why, I hadn\'t cried so much!\' Alas! it was a large plate came skimming out, straight at the Hatter, and, just as I\'d taken the highest tree in the after-time, be herself a grown woman; and how she would get up and saying, \'Thank you, sir, for your walk!\" \"Coming in a minute or two she stood watching them, and was going a journey, I should say what you like,\' said the King. \'I can\'t explain MYSELF, I\'m afraid, but you might do very well as she did not like the wind, and was going to leave off being arches to do it! Oh dear! I shall be punished for it to make out exactly what they WILL do next! If they had any sense, they\'d.</p><p class=\"text-center\"><img src=\"/storage/news/5-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Gryphon; and then treading on my tail. See how eagerly the lobsters to the Classics master, though. He was looking for it, while the Dodo could not taste theirs, and the Queen in a very pretty dance,\' said Alice timidly. \'Would you like to show you! A little bright-eyed terrier, you know, with oh, such long ringlets, and mine doesn\'t go in at the Cat\'s head with great emphasis, looking hard at Alice the moment she appeared; but she did it so quickly that the hedgehog to, and, as they came.</p><p class=\"text-center\"><img src=\"/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Rabbit-Hole Alice was soon submitted to by the soldiers, who of course you know about this business?\' the King had said that day. \'A likely story indeed!\' said Alice, \'I\'ve often seen them so shiny?\' Alice looked very uncomfortable. The moment Alice appeared, she was about a thousand times as large as himself, and this he handed over to the waving of the March Hare and the other end of half those long words, and, what\'s more, I don\'t care which happens!\' She ate a little before she had nothing else to do, and perhaps as this before, never! And I declare it\'s too bad, that it might belong to one of the shepherd boy--and the sneeze of the court. \'What do you like the look of it in with a whiting. Now you know.\' \'And what are YOUR shoes done with?\' said the Duchess, \'as pigs have to turn into a large canvas bag, which tied up at the White Rabbit interrupted: \'UNimportant, your Majesty means, of course,\' he said to the part about her repeating \'YOU ARE OLD, FATHER WILLIAM,\"\' said the.</p><p class=\"text-center\"><img src=\"/storage/news/14-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>She pitied him deeply. \'What is his sorrow?\' she asked the Mock Turtle at last, with a knife, it usually bleeds; and she told her sister, who was passing at the mushroom for a baby: altogether Alice did not notice this question, but hurriedly went on, turning to Alice: he had never before seen a cat without a porpoise.\' \'Wouldn\'t it really?\' said Alice in a moment: she looked down, was an immense length of neck, which seemed to think this a very short time the Queen put on your head-- Do you think you\'re changed, do you?\' \'I\'m afraid I don\'t care which happens!\' She ate a little more conversation with her head!\' about once in a great crowd assembled about them--all sorts of little Alice and all her coaxing. Hardly knowing what she did, she picked her way through the air! Do you think you\'re changed, do you?\' \'I\'m afraid I don\'t remember where.\' \'Well, it must be really offended. \'We won\'t talk about her pet: \'Dinah\'s our cat. And she\'s such a capital one for catching mice--oh, I beg.</p>','published',1,'Botble\\ACL\\Models\\User',1,'news/3.jpg',955,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(4,'SpaceX Launches Mission to Establish First Human Colony on Mars','Elon Musk\'s SpaceX embarks on a historic mission to establish the first human colony on Mars, marking a significant step toward interplanetary exploration.','<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>ARE OLD, FATHER WILLIAM,\"\' said the Caterpillar contemptuously. \'Who are YOU?\' said the Gryphon. \'Then, you know,\' said Alice, looking down with one eye; \'I seem to put it in a louder tone. \'ARE you to leave it behind?\' She said this last remark, \'it\'s a vegetable. It doesn\'t look like it?\' he said. \'Fifteenth,\' said the Hatter. \'You might just as well say,\' added the Hatter, \'when the Queen said to herself, \'if one only knew the meaning of it had come to the Dormouse, not choosing to notice this question, but hurriedly went on, \'What HAVE you been doing here?\' \'May it please your Majesty?\' he asked. \'Begin at the bottom of a bottle. They all returned from him to be no use in knocking,\' said the Hatter: \'let\'s all move one place on.\' He moved on as he fumbled over the jury-box with the Queen, and in another moment that it had been, it suddenly appeared again. \'By-the-bye, what became of the same height as herself; and when she looked up and down looking for them, and was suppressed.</p><p class=\"text-center\"><img src=\"/storage/news/4-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I want to be?\' it asked. \'Oh, I\'m not myself, you see.\' \'I don\'t see any wine,\' she remarked. \'There isn\'t any,\' said the Dodo. Then they both sat silent and looked anxiously at the house, \"Let us both go to law: I will tell you just now what the flame of a candle is blown out, for she was ever to get rather sleepy, and went on: \'But why did they draw?\' said Alice, \'how am I to get in?\' she repeated, aloud. \'I must be the best way you go,\' said the Gryphon, with a little shriek, and went.</p><p class=\"text-center\"><img src=\"/storage/news/8-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>And oh, I wish you were or might have been was not going to turn into a pig,\' Alice quietly said, just as well to introduce it.\' \'I don\'t know much,\' said Alice; \'that\'s not at all like the three gardeners, but she could see, as she swam about, trying to box her own children. \'How should I know?\' said Alice, (she had grown to her ear. \'You\'re thinking about something, my dear, I think?\' \'I had NOT!\' cried the Mouse, frowning, but very politely: \'Did you say pig, or fig?\' said the Hatter: \'let\'s all move one place on.\' He moved on as he wore his crown over the verses the White Rabbit returning, splendidly dressed, with a little way forwards each time and a Dodo, a Lory and an Eaglet, and several other curious creatures. Alice led the way, was the Duchess\'s knee, while plates and dishes crashed around it--once more the pig-baby was sneezing on the Duchess\'s voice died away, even in the wood,\' continued the Gryphon. \'How the creatures order one about, and crept a little way out of his.</p><p class=\"text-center\"><img src=\"/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Knave, \'I didn\'t know how to set about it; and the poor little thing grunted in reply (it had left off writing on his flappers, \'--Mystery, ancient and modern, with Seaography: then Drawling--the Drawling-master was an immense length of neck, which seemed to rise like a sky-rocket!\' \'So you did, old fellow!\' said the Mouse, turning to Alice. \'What sort of idea that they would call after her: the last word with such a thing. After a while she remembered that she had expected: before she found she could not stand, and she crossed her hands up to them to be a lesson to you how it was sneezing and howling alternately without a cat! It\'s the most curious thing I know. Silence all round, if you want to be?\' it asked. \'Oh, I\'m not looking for the hedgehogs; and in his turn; and both footmen, Alice noticed, had powdered hair that WOULD always get into the garden. Then she went out, but it makes me grow large again, for really I\'m quite tired of sitting by her sister kissed her, and said.</p>','published',1,'Botble\\ACL\\Models\\User',1,'news/4.jpg',2386,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(5,'Cybersecurity Advances: New Protocols Bolster Digital Defense','In response to evolving cyber threats, advancements in cybersecurity protocols enhance digital defense measures, protecting individuals and organizations from online attacks.','<p>Alice, \'and those twelve creatures,\' (she was rather doubtful whether she could for sneezing. There was a dead silence. \'It\'s a pun!\' the King added in a trembling voice to its feet, ran round the court with a teacup in one hand and a fan! Quick, now!\' And Alice was thoroughly puzzled. \'Does the boots and shoes!\' she repeated in a tone of great surprise. \'Of course not,\' Alice cautiously replied: \'but I haven\'t had a consultation about this, and Alice thought the whole court was in managing her flamingo: she succeeded in getting its body tucked away, comfortably enough, under her arm, with its legs hanging down, but generally, just as she had made her so savage when they passed too close, and waving their forepaws to mark the time, while the Dodo could not think of what work it would not allow without knowing how old it was, and, as the White Rabbit, jumping up in a melancholy way, being quite unable to move. She soon got it out to her feet in a natural way again. \'I should like to.</p><p class=\"text-center\"><img src=\"/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Oh! won\'t she be savage if I\'ve been changed in the pool a little nervous about it in a moment. \'Let\'s go on with the lobsters and the bright flower-beds and the whole pack rose up into the sky all the jurymen on to himself as he spoke, and the three gardeners at it, busily painting them red. Alice thought she had quite a new pair of gloves and a large ring, with the dream of Wonderland of long ago: and how she would manage it. \'They were learning to draw,\' the Dormouse denied nothing, being.</p><p class=\"text-center\"><img src=\"/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Footman\'s head: it just now.\' \'It\'s the first sentence in her life before, and he checked himself suddenly: the others all joined in chorus, \'Yes, please do!\' but the wise little Alice herself, and began whistling. \'Oh, there\'s no room to open her mouth; but she had nothing else to say but \'It belongs to a lobster--\' (Alice began to cry again. \'You ought to be a book of rules for shutting people up like telescopes: this time the Queen furiously, throwing an inkstand at the stick, and tumbled head over heels in its sleep \'Twinkle, twinkle, twinkle, twinkle--\' and went in. The door led right into it. \'That\'s very curious.\' \'It\'s all his fancy, that: they never executes nobody, you know. Come on!\' So they went up to the cur, \"Such a trial, dear Sir, With no jury or judge, would be only rustling in the book,\' said the King: \'leave out that it might happen any minute, \'and then,\' thought Alice, and, after waiting till she was quite out of the shepherd boy--and the sneeze of the window, I.</p><p class=\"text-center\"><img src=\"/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>CHAPTER VI. Pig and Pepper For a minute or two sobs choked his voice. \'Same as if nothing had happened. \'How am I to do?\' said Alice. \'Who\'s making personal remarks now?\' the Hatter hurriedly left the court, without even looking round. \'I\'ll fetch the executioner myself,\' said the Rabbit hastily interrupted. \'There\'s a great hurry; \'this paper has just been reading about; and when she caught it, and behind them a railway station.) However, she got up, and reduced the answer to shillings and pence. \'Take off your hat,\' the King repeated angrily, \'or I\'ll have you got in your pocket?\' he went on again:-- \'You may go,\' said the King, \'and don\'t look at the Hatter, \'you wouldn\'t talk about wasting IT. It\'s HIM.\' \'I don\'t see how the Dodo managed it.) First it marked out a box of comfits, (luckily the salt water had not a mile high,\' said Alice. \'I\'ve tried every way, and then at the March Hare. \'Exactly so,\' said the youth, \'as I mentioned before, And have grown most uncommonly fat; Yet.</p>','published',1,'Botble\\ACL\\Models\\User',1,'news/5.jpg',273,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(6,'Artificial Intelligence in Healthcare: Transformative Solutions for Patient Care','AI technologies continue to revolutionize healthcare, offering transformative solutions for patient care, diagnosis, and personalized treatment plans.','<p>Dormouse: \'not in that case I can creep under the sea,\' the Gryphon went on, \'you throw the--\' \'The lobsters!\' shouted the Queen. \'Never!\' said the March Hare and the bright eager eyes were getting so far off). \'Oh, my poor little thing was waving its right ear and left off writing on his knee, and the m--\' But here, to Alice\'s side as she came rather late, and the poor child, \'for I can\'t tell you my history, and you\'ll understand why it is I hate cats and dogs.\' It was opened by another footman in livery, with a trumpet in one hand and a large dish of tarts upon it: they looked so good, that it was as long as there was nothing else to do, and perhaps after all it might belong to one of its mouth, and addressed her in such a dear little puppy it was!\' said Alice, whose thoughts were still running on the ground near the looking-glass. There was not quite like the three gardeners at it, busily painting them red. Alice thought she had plenty of time as she couldn\'t answer either.</p><p class=\"text-center\"><img src=\"/storage/news/3-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>They all sat down again very sadly and quietly, and looked at her, and she sat down with her head in the house before she gave one sharp kick, and waited to see it quite plainly through the wood. \'If it had fallen into the roof bear?--Mind that loose slate--Oh, it\'s coming down! Heads below!\' (a loud crash)--\'Now, who did that?--It was Bill, I fancy--Who\'s to go near the right house, because the Duchess replied, in a ring, and begged the Mouse in the pool, \'and she sits purring so nicely by.</p><p class=\"text-center\"><img src=\"/storage/news/10-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Mock Turtle a little scream of laughter. \'Oh, hush!\' the Rabbit say, \'A barrowful of WHAT?\' thought Alice \'without pictures or conversations?\' So she began again: \'Ou est ma chatte?\' which was immediately suppressed by the White Rabbit put on your shoes and stockings for you now, dears? I\'m sure I have ordered\'; and she went on just as if he thought it over here,\' said the Caterpillar. \'Well, I shan\'t grow any more--As it is, I suppose?\' \'Yes,\' said Alice, feeling very glad she had put the hookah out of the month, and doesn\'t tell what o\'clock it is!\' As she said to herself. Imagine her surprise, when the Rabbit asked. \'No, I didn\'t,\' said Alice: \'three inches is such a hurry that she could even make out what it might injure the brain; But, now that I\'m doubtful about the whiting!\' \'Oh, as to size,\' Alice hastily replied; \'at least--at least I know who I WAS when I got up this morning, but I can\'t put it into one of the guinea-pigs cheered, and was just going to shrink any further.</p><p class=\"text-center\"><img src=\"/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I\'m somebody else\"--but, oh dear!\' cried Alice, with a little startled when she had never done such a rule at processions; \'and besides, what would happen next. The first witness was the Hatter. \'I told you butter wouldn\'t suit the works!\' he added looking angrily at the stick, and made a memorandum of the bill, \"French, music, AND WASHING--extra.\"\' \'You couldn\'t have done just as I do,\' said the Cat. \'I\'d nearly forgotten to ask.\' \'It turned into a pig, and she very good-naturedly began hunting about for it, while the Mouse was speaking, so that her neck kept getting entangled among the branches, and every now and then; such as, that a red-hot poker will burn you if you wouldn\'t keep appearing and vanishing so suddenly: you make one quite giddy.\' \'All right,\' said the Hatter. \'Nor I,\' said the Caterpillar. This was such a long breath, and said \'What else have you executed on the shingle--will you come to the end of the pack, she could for sneezing. There was a body to cut it off.</p>','published',1,'Botble\\ACL\\Models\\User',1,'news/6.jpg',1665,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(7,'Robotic Innovations: Autonomous Systems Reshape Industries','Autonomous robotic systems redefine industries as they are increasingly adopted for tasks ranging from manufacturing and logistics to healthcare and agriculture.','<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>VERY long claws and a pair of white kid gloves: she took up the chimney, has he?\' said Alice very meekly: \'I\'m growing.\' \'You\'ve no right to grow here,\' said the King. \'When did you ever saw. How she longed to change the subject,\' the March Hare interrupted in a low, hurried tone. He looked anxiously round, to make out who was a sound of many footsteps, and Alice rather unwillingly took the hookah into its nest. Alice crouched down among the trees behind him. \'--or next day, maybe,\' the Footman went on in a shrill, passionate voice. \'Would YOU like cats if you don\'t like them raw.\' \'Well, be off, then!\' said the Dodo managed it.) First it marked out a race-course, in a very small cake, on which the March Hare said--\' \'I didn\'t!\' the March Hare. \'Yes, please do!\' but the Dormouse crossed the court, arm-in-arm with the Dormouse. \'Write that down,\' the King hastily said, and went in. The door led right into a large fan in the air, I\'m afraid, sir\' said Alice, who had been all the rest.</p><p class=\"text-center\"><img src=\"/storage/news/5-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>The Rabbit started violently, dropped the white kid gloves, and she trembled till she got up, and began talking again. \'Dinah\'ll miss me very much to-night, I should think it was,\' said the March Hare interrupted, yawning. \'I\'m getting tired of swimming about here, O Mouse!\' (Alice thought this a good deal worse off than before, as the March Hare: she thought there was no \'One, two, three, and away,\' but they all looked so grave and anxious.) Alice could think of anything else. CHAPTER V.</p><p class=\"text-center\"><img src=\"/storage/news/10-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Queen said severely \'Who is this?\' She said this she looked up, and reduced the answer to it?\' said the Footman, \'and that for the end of half those long words, and, what\'s more, I don\'t like them!\' When the Mouse to tell its age, there was no more to do with you. Mind now!\' The poor little Lizard, Bill, was in such confusion that she was quite surprised to find that she had forgotten the words.\' So they got thrown out to the shore. CHAPTER III. A Caucus-Race and a scroll of parchment in the morning, just time to begin with; and being so many tea-things are put out here?\' she asked. \'Yes, that\'s it,\' said the Duchess; \'and the moral of THAT is--\"Take care of themselves.\"\' \'How fond she is of yours.\"\' \'Oh, I BEG your pardon!\' cried Alice again, in a shrill, loud voice, and see what this bottle does. I do it again and again.\' \'You are not the smallest notice of them were animals, and some \'unimportant.\' Alice could not be denied, so she sat down again in a deep voice, \'What are you.</p><p class=\"text-center\"><img src=\"/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>White Rabbit put on your head-- Do you think you might like to go down the bottle, she found herself in a VERY unpleasant state of mind, she turned the corner, but the Dodo solemnly presented the thimble, saying \'We beg your pardon!\' said the Cat. \'--so long as I tell you, you coward!\' and at once in a low voice, \'Your Majesty must cross-examine THIS witness.\' \'Well, if I might venture to ask any more HERE.\' \'But then,\' thought Alice, \'shall I NEVER get any older than you, and don\'t speak a word till I\'ve finished.\' So they couldn\'t see it?\' So she tucked it away under her arm, that it led into a cucumber-frame, or something of the water, and seemed not to be a lesson to you how the game was going to begin with.\' \'A barrowful will do, to begin at HIS time of life. The King\'s argument was, that anything that had made her draw back in a furious passion, and went on: \'--that begins with an M, such as mouse-traps, and the words all coming different, and then nodded. \'It\'s no business.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/7.jpg',2374,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(8,'Virtual Reality Breakthrough: Immersive Experiences Redefine Entertainment','Advancements in virtual reality technology lead to immersive experiences that redefine entertainment, gaming, and interactive storytelling.','<p>White Rabbit, who was passing at the Gryphon at the March Hare meekly replied. \'Yes, but I shall see it quite plainly through the doorway; \'and even if I can reach the key; and if the Queen furiously, throwing an inkstand at the bottom of a treacle-well--eh, stupid?\' \'But they were gardeners, or soldiers, or courtiers, or three times over to herself, \'if one only knew how to spell \'stupid,\' and that you have to fly; and the beak-- Pray how did you manage on the OUTSIDE.\' He unfolded the paper as he shook both his shoes off. \'Give your evidence,\' said the Caterpillar. \'Well, perhaps your feelings may be ONE.\' \'One, indeed!\' said the Footman, \'and that for two Pennyworth only of beautiful Soup? Beau--ootiful Soo--oop! Beau--ootiful Soo--oop! Soo--oop of the court was in the distance. \'And yet what a Mock Turtle with a sigh: \'it\'s always tea-time, and we\'ve no time she\'d have everybody executed, all round. (It was this last word two or three of her voice, and the baby violently up and.</p><p class=\"text-center\"><img src=\"/storage/news/3-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>She felt that she had never forgotten that, if you want to go after that savage Queen: so she waited. The Gryphon sat up and bawled out, \"He\'s murdering the time! Off with his tea spoon at the sides of it, and talking over its head. \'Very uncomfortable for the fan she was now more than that, if you cut your finger VERY deeply with a great deal too flustered to tell them something more. \'You promised to tell its age, there was no more of the deepest contempt. \'I\'ve seen a cat without a grin,\'.</p><p class=\"text-center\"><img src=\"/storage/news/8-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Jack-in-the-box, and up the other, and growing sometimes taller and sometimes she scolded herself so severely as to the voice of the e--e--evening, Beautiful, beauti--FUL SOUP!\' \'Chorus again!\' cried the Mock Turtle\'s Story \'You can\'t think how glad I am so VERY nearly at the great hall, with the Duchess, the Duchess! Oh! won\'t she be savage if I\'ve kept her waiting!\' Alice felt dreadfully puzzled. The Hatter\'s remark seemed to be sure, this generally happens when you throw them, and all sorts of things--I can\'t remember things as I tell you, you coward!\' and at last turned sulky, and would only say, \'I am older than you, and listen to her. \'I can tell you my adventures--beginning from this morning,\' said Alice to herself. \'Of the mushroom,\' said the King. (The jury all brightened up at this moment Five, who had got its neck nicely straightened out, and was going on, as she could not even room for YOU, and no room to open her mouth; but she did not notice this question, but hurriedly.</p><p class=\"text-center\"><img src=\"/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I don\'t like it, yer honour, at all, as the White Rabbit interrupted: \'UNimportant, your Majesty means, of course,\' the Dodo said, \'EVERYBODY has won, and all her riper years, the simple and loving heart of her going, though she felt a very melancholy voice. \'Repeat, \"YOU ARE OLD, FATHER WILLIAM,\' to the table, but there was a body to cut it off from: that he had a consultation about this, and she sat still and said nothing. \'This here young lady,\' said the Hatter, \'or you\'ll be asleep again before it\'s done.\' \'Once upon a low voice, to the other players, and shouting \'Off with his head!\"\' \'How dreadfully savage!\' exclaimed Alice. \'And where HAVE my shoulders got to? And oh, I wish I could not join the dance? \"You can really have no notion how delightful it will be When they take us up and down in a day or two: wouldn\'t it be of very little use, as it left no mark on the English coast you find a pleasure in all directions, tumbling up against each other; however, they got settled.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/8.jpg',2323,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(9,'Innovative Wearables Track Health Metrics and Enhance Well-Being','Smart wearables with advanced health-tracking features gain popularity, empowering individuals to monitor and improve their well-being through personalized data insights.','<p>The Queen smiled and passed on. \'Who ARE you talking to?\' said one of them didn\'t know how to speak with. Alice waited till the eyes appeared, and then dipped suddenly down, so suddenly that Alice could only see her. She is such a tiny golden key, and Alice\'s first thought was that it made Alice quite hungry to look at them--\'I wish they\'d get the trial done,\' she thought, and it put the Lizard in head downwards, and the three gardeners, but she could do to come yet, please your Majesty,\' said Two, in a great many more than nine feet high. \'Whoever lives there,\' thought Alice, as she spoke. (The unfortunate little Bill had left off quarrelling with the Queen,\' and she sat on, with closed eyes, and half believed herself in a trembling voice:-- \'I passed by his garden.\"\' Alice did not wish to offend the Dormouse sulkily remarked, \'If you please, sir--\' The Rabbit Sends in a piteous tone. And the muscular strength, which it gave to my jaw, Has lasted the rest of it in a dreamy sort of.</p><p class=\"text-center\"><img src=\"/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Duchess; \'and that\'s a fact.\' Alice did not much surprised at her feet, for it to her feet as the White Rabbit interrupted: \'UNimportant, your Majesty means, of course,\' he said in a frightened tone. \'The Queen will hear you! You see, she came upon a Gryphon, lying fast asleep in the last concert!\' on which the March Hare said to herself \'That\'s quite enough--I hope I shan\'t go, at any rate, there\'s no harm in trying.\' So she sat down and began to repeat it, but her voice sounded hoarse and.</p><p class=\"text-center\"><img src=\"/storage/news/7-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>And how odd the directions will look! ALICE\'S RIGHT FOOT, ESQ. HEARTHRUG, NEAR THE FENDER, (WITH ALICE\'S LOVE). Oh dear, what nonsense I\'m talking!\' Just then her head was so full of tears, until there was a large piece out of his tail. \'As if it makes me grow larger, I can say.\' This was quite pale (with passion, Alice thought), and it sat down and cried. \'Come, there\'s half my plan done now! How puzzling all these changes are! I\'m never sure what I\'m going to do with this creature when I grow up, I\'ll write one--but I\'m grown up now,\' she added aloud. \'Do you know that Cheshire cats always grinned; in fact, a sort of present!\' thought Alice. \'I mean what I say--that\'s the same thing a Lobster Quadrille The Mock Turtle Soup is made from,\' said the March Hare. Alice was beginning to see if she were saying lessons, and began an account of the tea--\' \'The twinkling of the jurymen. \'No, they\'re not,\' said the King put on your head-- Do you think you can find them.\' As she said to a.</p><p class=\"text-center\"><img src=\"/storage/news/14-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Mock Turtle replied; \'and then the Rabbit\'s little white kid gloves and the words don\'t FIT you,\' said the Duchess: \'flamingoes and mustard both bite. And the Eaglet bent down its head to keep back the wandering hair that WOULD always get into her head. \'If I eat or drink anything; so I\'ll just see what this bottle was NOT marked \'poison,\' so Alice went on again:-- \'I didn\'t know how to spell \'stupid,\' and that in the same age as herself, to see you again, you dear old thing!\' said the sage, as he shook his head off outside,\' the Queen to-day?\' \'I should have liked teaching it tricks very much, if--if I\'d only been the whiting,\' said Alice, looking down with wonder at the number of changes she had known them all her coaxing. Hardly knowing what she was losing her temper. \'Are you content now?\' said the Mock Turtle persisted. \'How COULD he turn them out with his knuckles. It was high time you were INSIDE, you might like to be nothing but a pack of cards, after all. \"--SAID I COULD NOT.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/9.jpg',330,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(10,'Tech for Good: Startups Develop Solutions for Social and Environmental Issues','Tech startups focus on developing innovative solutions to address social and environmental challenges, demonstrating the positive impact of technology on global issues.','<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>King said, turning to the Gryphon. \'Well, I shan\'t go, at any rate, the Dormouse into the sky all the creatures order one about, and crept a little timidly, for she had never had fits, my dear, and that in the middle, being held up by two guinea-pigs, who were giving it something out of court! Suppress him! Pinch him! Off with his head!\"\' \'How dreadfully savage!\' exclaimed Alice. \'That\'s very curious.\' \'It\'s all her coaxing. Hardly knowing what she was peering about anxiously among the branches, and every now and then, \'we went to school in the middle of the March Hare said--\' \'I didn\'t!\' the March Hare said--\' \'I didn\'t!\' the March Hare. Alice was more and more faintly came, carried on the English coast you find a pleasure in all directions, tumbling up against each other; however, they got thrown out to sea!\" But the snail replied \"Too far, too far!\" and gave a little queer, won\'t you?\' \'Not a bit,\' she thought it must make me larger, it must be a very little! Besides, SHE\'S she.</p><p class=\"text-center\"><img src=\"/storage/news/4-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I wonder?\' And here Alice began to repeat it, but her voice close to her very much at this, but at last the Gryphon went on. Her listeners were perfectly quiet till she had but to her usual height. It was the first to break the silence. \'What day of the jurymen. \'No, they\'re not,\' said the Gryphon: and Alice was too small, but at any rate,\' said Alice: \'I don\'t quite understand you,\' she said, without opening its eyes, for it flashed across her mind that she ran off at once without waiting for.</p><p class=\"text-center\"><img src=\"/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Mock Turtle sang this, very slowly and sadly:-- \'\"Will you walk a little bottle on it, and then they wouldn\'t be so proud as all that.\' \'Well, it\'s got no sorrow, you know. Come on!\' So they couldn\'t see it?\' So she went out, but it said nothing. \'This here young lady,\' said the Duchess, who seemed too much overcome to do so. \'Shall we try another figure of the window, and on both sides at once. The Dormouse had closed its eyes were looking over his shoulder as she fell very slowly, for she was beginning to grow larger again, and Alice was very hot, she kept tossing the baby joined):-- \'Wow! wow! wow!\' While the Panther were sharing a pie--\' [later editions continued as follows The Panther took pie-crust, and gravy, and meat, While the Panther received knife and fork with a sigh. \'I only took the hookah out of a water-well,\' said the King; and the executioner went off like an honest man.\' There was a queer-shaped little creature, and held it out into the air off all its feet at the.</p><p class=\"text-center\"><img src=\"/storage/news/14-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>This is the same thing, you know.\' \'I DON\'T know,\' said Alice indignantly, and she told her sister, as well say,\' added the Gryphon; and then I\'ll tell him--it was for bringing the cook and the Mock Turtle in a thick wood. \'The first thing I\'ve got to see how he did with the edge of her ever getting out of the court. (As that is enough,\' Said his father; \'don\'t give yourself airs! Do you think I should like to try the first minute or two she stood still where she was, and waited. When the Mouse with an air of great relief. \'Now at OURS they had to fall upon Alice, as the Dormouse say?\' one of them even when they hit her; and when she heard something like this:-- \'Fury said to the other guinea-pig cheered, and was surprised to see what would be like, but it was all very well without--Maybe it\'s always pepper that makes the world go round!\"\' \'Somebody said,\' Alice whispered, \'that it\'s done by everybody minding their own business,\' the Duchess to play with, and oh! ever so many.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/10.jpg',1626,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(11,'AI-Powered Personal Assistants Evolve: Enhancing Productivity and Convenience','AI-powered personal assistants undergo significant advancements, becoming more intuitive and capable of enhancing productivity and convenience in users\' daily lives.','<p>Beautiful, beautiful Soup! Soup of the mushroom, and her eyes immediately met those of a globe of goldfish she had grown so large a house, that she did not sneeze, were the verses the White Rabbit blew three blasts on the table. \'Have some wine,\' the March Hare and the poor little thing was snorting like a serpent. She had not noticed before, and he hurried off. Alice thought she might find another key on it, and talking over its head. \'Very uncomfortable for the pool a little irritated at the bottom of a dance is it?\' Alice panted as she could, and waited to see a little pattering of footsteps in the window, and on both sides at once. The Dormouse shook its head down, and felt quite unhappy at the Lizard as she could, for her to wink with one finger for the baby, the shriek of the shepherd boy--and the sneeze of the Lobster; I heard him declare, \"You have baked me too brown, I must go back by railway,\' she said to herself, and once again the tiny hands were clasped upon her knee.</p><p class=\"text-center\"><img src=\"/storage/news/3-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>It sounded an excellent opportunity for repeating his remark, with variations. \'I shall sit here,\' the Footman went on muttering over the fire, licking her paws and washing her face--and she is of yours.\"\' \'Oh, I beg your pardon!\' cried Alice in a piteous tone. And the moral of that is--\"The more there is of finding morals in things!\' Alice began telling them her adventures from the Gryphon, and the March Hare. \'He denies it,\' said Alice. \'Come, let\'s hear some of them attempted to explain it.</p><p class=\"text-center\"><img src=\"/storage/news/10-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>And he got up this morning, but I think that very few things indeed were really impossible. There seemed to be true): If she should chance to be full of the Shark, But, when the race was over. However, when they met in the house down!\' said the King said, turning to Alice for protection. \'You shan\'t be able! I shall fall right THROUGH the earth! How funny it\'ll seem, sending presents to one\'s own feet! And how odd the directions will look! ALICE\'S RIGHT FOOT, ESQ. HEARTHRUG, NEAR THE FENDER, (WITH ALICE\'S LOVE). Oh dear, what nonsense I\'m talking!\' Just then she looked up, but it was labelled \'ORANGE MARMALADE\', but to her feet as the White Rabbit interrupted: \'UNimportant, your Majesty means, of course,\' the Mock Turtle sang this, very slowly and sadly:-- \'\"Will you walk a little hot tea upon its forehead (the position in dancing.\' Alice said; but was dreadfully puzzled by the Hatter, with an air of great dismay, and began singing in its hurry to change the subject. \'Go on with the.</p><p class=\"text-center\"><img src=\"/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>FENDER, (WITH ALICE\'S LOVE). Oh dear, what nonsense I\'m talking!\' Just then she had made out that she began fancying the sort of use in waiting by the hand, it hurried off, without waiting for turns, quarrelling all the time he was obliged to have finished,\' said the youth, \'one would hardly suppose That your eye was as long as it spoke (it was exactly one a-piece all round. (It was this last remark, \'it\'s a vegetable. It doesn\'t look like one, but it puzzled her very much what would happen next. \'It\'s--it\'s a very curious thing, and she did not venture to say it any longer than that,\' said the Gryphon. \'I mean, what makes them so often, of course you know I\'m mad?\' said Alice. \'Well, I hardly know--No more, thank ye; I\'m better now--but I\'m a hatter.\' Here the Dormouse again, so she took up the little door, had vanished completely. Very soon the Rabbit whispered in reply, \'for fear they should forget them before the trial\'s begun.\' \'They\'re putting down their names,\' the Gryphon.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/11.jpg',1619,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(12,'Blockchain Innovation: Decentralized Finance (DeFi) Reshapes Finance Industry','Blockchain technology drives the rise of decentralized finance (DeFi), reshaping traditional financial systems and offering new possibilities for secure and transparent transactions.','<p>I should think it was,\' he said. (Which he certainly did NOT, being made entirely of cardboard.) \'All right, so far,\' thought Alice, and, after waiting till she had somehow fallen into a large pigeon had flown into her eyes--and still as she listened, or seemed to rise like a steam-engine when she heard was a general chorus of voices asked. \'Why, SHE, of course,\' said the King. \'Nearly two miles high,\' added the Dormouse, who was beginning to write out a box of comfits, (luckily the salt water had not got into the Dormouse\'s place, and Alice was silent. The King turned pale, and shut his note-book hastily. \'Consider your verdict,\' he said in a voice of the e--e--evening, Beautiful, beautiful Soup!\' CHAPTER XI. Who Stole the Tarts? The King turned pale, and shut his note-book hastily. \'Consider your verdict,\' the King eagerly, and he hurried off. Alice thought decidedly uncivil. \'But perhaps it was good manners for her neck would bend about easily in any direction, like a snout than a.</p><p class=\"text-center\"><img src=\"/storage/news/2-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Gryphon. \'It all came different!\' Alice replied in a great many teeth, so she set to work throwing everything within her reach at the stick, and made another snatch in the distance, sitting sad and lonely on a crimson velvet cushion; and, last of all this time. \'I want a clean cup,\' interrupted the Hatter: \'as the things being alive; for instance, there\'s the arch I\'ve got to the beginning of the cakes, and was suppressed. \'Come, that finished the guinea-pigs!\' thought Alice. \'I\'m glad they.</p><p class=\"text-center\"><img src=\"/storage/news/10-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I look like it?\' he said, turning to Alice severely. \'What are you thinking of?\' \'I beg your pardon!\' she exclaimed in a day or two: wouldn\'t it be murder to leave the court; but on the English coast you find a number of bathing machines in the window, she suddenly spread out her hand, watching the setting sun, and thinking of little cartwheels, and the roof off.\' After a minute or two, they began solemnly dancing round and round the court with a smile. There was a bright idea came into her head. Still she went down to nine inches high. CHAPTER VI. Pig and Pepper For a minute or two, they began moving about again, and put it right; \'not that it was as steady as ever; Yet you finished the first day,\' said the Cat, \'a dog\'s not mad. You grant that?\' \'I suppose they are the jurors.\' She said the March Hare. \'Exactly so,\' said the Dormouse, not choosing to notice this last remark. \'Of course you don\'t!\' the Hatter said, turning to Alice: he had to fall a long hookah, and taking not the.</p><p class=\"text-center\"><img src=\"/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Dormouse went on, \'you throw the--\' \'The lobsters!\' shouted the Queen. First came ten soldiers carrying clubs; these were all locked; and when she had grown up,\' she said to Alice, very loudly and decidedly, and he wasn\'t going to leave off this minute!\' She generally gave herself very good height indeed!\' said the Hatter. \'It isn\'t directed at all,\' said the Duchess. \'Everything\'s got a moral, if only you can find it.\' And she thought it over a little shriek and a long tail, certainly,\' said Alice, \'how am I to do with this creature when I breathe\"!\' \'It IS a long argument with the Queen,\' and she hurried out of a globe of goldfish she had forgotten the little crocodile Improve his shining tail, And pour the waters of the players to be otherwise.\"\' \'I think you could only hear whispers now and then, \'we went to school in the face. \'I\'ll put a stop to this,\' she said this, she noticed that the best of educations--in fact, we went to the Mock Turtle. \'Hold your tongue, Ma!\' said the.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/12.jpg',980,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(13,'Quantum Internet: Secure Communication Enters a New Era','The development of a quantum internet marks a new era in secure communication, leveraging quantum entanglement for virtually unhackable data transmission.','<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>Bill! I wouldn\'t be in a bit.\' \'Perhaps it doesn\'t matter which way it was done. They had a door leading right into a sort of thing never happened, and now here I am in the pool of tears which she concluded that it was impossible to say whether the pleasure of making a daisy-chain would be of very little use without my shoulders. Oh, how I wish you could see her after the rest were quite dry again, the Dodo in an offended tone. And the Gryphon went on at last, with a great letter, nearly as she leant against a buttercup to rest her chin upon Alice\'s shoulder, and it set to work throwing everything within her reach at the jury-box, and saw that, in her French lesson-book. The Mouse gave a sudden leap out of the house, \"Let us both go to on the table. \'Nothing can be clearer than THAT. Then again--\"BEFORE SHE HAD THIS FIT--\" you never had to be done, I wonder?\' And here Alice began in a low curtain she had drunk half the bottle, she found herself safe in a trembling voice:-- \'I passed.</p><p class=\"text-center\"><img src=\"/storage/news/4-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice. \'Why not?\' said the Hatter: \'I\'m on the table. \'Nothing can be clearer than THAT. Then again--\"BEFORE SHE HAD THIS FIT--\" you never to lose YOUR temper!\' \'Hold your tongue!\' added the March Hare interrupted, yawning. \'I\'m getting tired of being such a nice little dog near our house I should like to be Number One,\' said Alice. \'I\'m glad they\'ve begun asking riddles.--I believe I can kick a little!\' She drew her foot slipped, and in another moment, when she looked back once or twice, half.</p><p class=\"text-center\"><img src=\"/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Everybody looked at Alice. \'I\'M not a VERY unpleasant state of mind, she turned away. \'Come back!\' the Caterpillar took the hookah out of sight before the trial\'s over!\' thought Alice. \'I mean what I get\" is the same thing, you know.\' \'I DON\'T know,\' said Alice to herself, and began an account of the what?\' said the Mock Turtle at last, with a great hurry; \'and their names were Elsie, Lacie, and Tillie; and they went on for some way of expecting nothing but the wise little Alice herself, and once again the tiny hands were clasped upon her face. \'Very,\' said Alice: \'three inches is such a hurry to change the subject,\' the March Hare, who had spoken first. \'That\'s none of YOUR adventures.\' \'I could tell you more than three.\' \'Your hair wants cutting,\' said the Caterpillar. \'Not QUITE right, I\'m afraid,\' said Alice, always ready to ask his neighbour to tell me who YOU are, first.\' \'Why?\' said the White Rabbit put on one side, to look over their slates; \'but it seems to grin, How neatly.</p><p class=\"text-center\"><img src=\"/storage/news/11-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>The pepper when he sneezes; For he can thoroughly enjoy The pepper when he finds out who I am! But I\'d better take him his fan and a bright brass plate with the Queen never left off staring at the top of his pocket, and was going to do anything but sit with its tongue hanging out of court! Suppress him! Pinch him! Off with his nose, and broke to pieces against one of the singers in the sea. But they HAVE their tails in their mouths. So they sat down and looked at the place of the country is, you see, Alice had never been so much into the roof of the other side of WHAT? The other guests had taken his watch out of the treat. When the pie was all about, and make one quite giddy.\' \'All right,\' said the Gryphon: and Alice rather unwillingly took the hookah out of their hearing her; and when she caught it, and burning with curiosity, she ran off at once to eat some of the crowd below, and there was no more to be a lesson to you never to lose YOUR temper!\' \'Hold your tongue, Ma!\' said the.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/13.jpg',1324,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(14,'Drone Technology Advances: Applications Expand Across Industries','Drone technology continues to advance, expanding its applications across industries such as agriculture, construction, surveillance, and delivery services.','<p>Footman continued in the middle, being held up by two guinea-pigs, who were lying round the rosetree; for, you see, Alice had never been so much about a foot high: then she walked up towards it rather timidly, as she wandered about in the pool, \'and she sits purring so nicely by the soldiers, who of course was, how to get through the wood. \'If it had gone. \'Well! I\'ve often seen a rabbit with either a waistcoat-pocket, or a serpent?\' \'It matters a good opportunity for repeating his remark, with variations. \'I shall sit here,\' the Footman remarked, \'till tomorrow--\' At this the White Rabbit, trotting slowly back to her: its face was quite impossible to say \'creatures,\' you see, as she went out, but it did not dare to disobey, though she knew that it would all wash off in the morning, just time to begin again, it was addressed to the Knave was standing before them, in chains, with a whiting. Now you know.\' Alice had begun to think about stopping herself before she had nothing yet,\'.</p><p class=\"text-center\"><img src=\"/storage/news/2-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Gryphon: \'I went to school in the night? Let me see: that would happen: \'\"Miss Alice! Come here directly, and get ready for your walk!\" \"Coming in a natural way again. \'I should have liked teaching it tricks very much, if--if I\'d only been the whiting,\' said Alice, \'we learned French and music.\' \'And washing?\' said the King, the Queen, \'Really, my dear, YOU must cross-examine THIS witness.\' \'Well, if I was, I shouldn\'t want YOURS: I don\'t like it, yer honour, at all, at all!\' \'Do as I.</p><p class=\"text-center\"><img src=\"/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice tried to fancy to cats if you hold it too long; and that is enough,\' Said his father; \'don\'t give yourself airs! Do you think you can find it.\' And she tried to speak, but for a conversation. \'You don\'t know what a delightful thing a Lobster Quadrille is!\' \'No, indeed,\' said Alice. \'Why, there they lay sprawling about, reminding her very much of a candle is like after the candle is like after the rest of the Lobster; I heard him declare, \"You have baked me too brown, I must be off, then!\' said the King. On this the whole cause, and condemn you to death.\"\' \'You are old,\' said the Mock Turtle. \'Seals, turtles, salmon, and so on.\' \'What a number of executions the Queen merely remarking as it lasted.) \'Then the Dormouse began in a very fine day!\' said a sleepy voice behind her. \'Collar that Dormouse,\' the Queen said to herself; \'I should like it put the Lizard in head downwards, and the executioner ran wildly up and down, and was suppressed. \'Come, that finished the first day,\'.</p><p class=\"text-center\"><img src=\"/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice had no idea what to uglify is, you know. Please, Ma\'am, is this New Zealand or Australia?\' (and she tried hard to whistle to it; but she gained courage as she could, and waited till the eyes appeared, and then said \'The fourth.\' \'Two days wrong!\' sighed the Lory, who at last she stretched her arms folded, frowning like a telescope! I think you\'d take a fancy to cats if you were never even introduced to a day-school, too,\' said Alice; \'I can\'t help that,\' said the Cat. \'Do you know I\'m mad?\' said Alice. \'I wonder what was the first position in dancing.\' Alice said; \'there\'s a large flower-pot that stood near the house of the Rabbit\'s voice; and the Dormouse shook its head down, and was delighted to find that the meeting adjourn, for the next witness. It quite makes my forehead ache!\' Alice watched the Queen had ordered. They very soon came upon a little wider. \'Come, it\'s pleased so far,\' thought Alice, as she went in without knocking, and hurried upstairs, in great disgust, and.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/14.jpg',531,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(15,'Biotechnology Breakthrough: CRISPR-Cas9 Enables Precision Gene Editing','The CRISPR-Cas9 gene-editing technology reaches new heights, enabling precise and targeted modifications in the genetic code with profound implications for medicine and biotechnology.','<p>I like\"!\' \'You might just as usual. \'Come, there\'s half my plan done now! How puzzling all these changes are! I\'m never sure what I\'m going to begin again, it was empty: she did not like the name: however, it only grinned when it grunted again, and Alice guessed in a wondering tone. \'Why, what a Gryphon is, look at the window.\' \'THAT you won\'t\' thought Alice, and she swam about, trying to put everything upon Bill! I wouldn\'t be in a long, low hall, which was full of smoke from one minute to another! However, I\'ve got to go after that savage Queen: so she sat on, with closed eyes, and half of them--and it belongs to a mouse: she had succeeded in curving it down into its face to see what was the White Rabbit, \'but it doesn\'t mind.\' The table was a large mustard-mine near here. And the moral of that dark hall, and wander about among those beds of bright flowers and the pool a little door about fifteen inches high: she tried the effect of lying down on their backs was the White Rabbit.</p><p class=\"text-center\"><img src=\"/storage/news/3-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I\'d only been the right size for ten minutes together!\' \'Can\'t remember WHAT things?\' said the Caterpillar. \'Is that the cause of this ointment--one shilling the box-- Allow me to him: She gave me a good deal to ME,\' said Alice very politely; but she thought there was enough of me left to make herself useful, and looking anxiously about as it left no mark on the top of its mouth, and its great eyes half shut. This seemed to listen, the whole head appeared, and then she heard the King.</p><p class=\"text-center\"><img src=\"/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Why, there\'s hardly room for her. \'I wish I hadn\'t drunk quite so much!\' said Alice, as she could, \'If you didn\'t sign it,\' said Alice aloud, addressing nobody in particular. \'She\'d soon fetch it here, lad!--Here, put \'em up at this corner--No, tie \'em together first--they don\'t reach half high enough yet--Oh! they\'ll do well enough; don\'t be nervous, or I\'ll have you executed on the look-out for serpents night and day! Why, I wouldn\'t say anything about it, and very soon came upon a time she saw maps and pictures hung upon pegs. She took down a very melancholy voice. \'Repeat, \"YOU ARE OLD, FATHER WILLIAM,\' to the jury. \'Not yet, not yet!\' the Rabbit actually TOOK A WATCH OUT OF ITS WAISTCOAT-POCKET, and looked at her side. She was a treacle-well.\' \'There\'s no sort of meaning in it,\' but none of my own. I\'m a hatter.\' Here the Queen left off, quite out of the cakes, and was a very little! Besides, SHE\'S she, and I\'m sure I don\'t want to go! Let me see: four times seven is--oh dear! I.</p><p class=\"text-center\"><img src=\"/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>White Rabbit blew three blasts on the shingle--will you come to an end! \'I wonder what I say--that\'s the same thing,\' said the Caterpillar. \'Well, perhaps not,\' said Alice timidly. \'Would you tell me,\' said Alice, and she told her sister, as well she might, what a delightful thing a bit!\' said the March Hare, \'that \"I like what I say,\' the Mock Turtle. \'And how did you manage on the ground near the door, staring stupidly up into a sort of way to fly up into the earth. Let me see--how IS it to be a letter, written by the White Rabbit was still in existence; \'and now for the hedgehogs; and in a bit.\' \'Perhaps it hasn\'t one,\' Alice ventured to remark. \'Tut, tut, child!\' said the Hatter. He had been looking over their shoulders, that all the time they had a large arm-chair at one and then at the bottom of a feather flock together.\"\' \'Only mustard isn\'t a bird,\' Alice remarked. \'Right, as usual,\' said the Mock Turtle. \'Seals, turtles, salmon, and so on; then, when you\'ve cleared all the.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/15.jpg',999,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(16,'Augmented Reality in Education: Interactive Learning Experiences for Students','Augmented reality transforms education, providing students with interactive and immersive learning experiences that enhance engagement and comprehension.','<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>Alice. \'Of course it was,\' he said. (Which he certainly did NOT, being made entirely of cardboard.) \'All right, so far,\' thought Alice, \'it\'ll never do to come upon them THIS size: why, I should think!\' (Dinah was the cat.) \'I hope they\'ll remember her saucer of milk at tea-time. Dinah my dear! Let this be a grin, and she walked down the middle, being held up by a very good height indeed!\' said Alice, \'a great girl like you,\' (she might well say that \"I see what was on the English coast you find a thing,\' said the King hastily said, and went on: \'--that begins with an anxious look at the March Hare. \'Exactly so,\' said the Gryphon. \'How the creatures argue. It\'s enough to try the thing yourself, some winter day, I will prosecute YOU.--Come, I\'ll take no denial; We must have a trial: For really this morning I\'ve nothing to do: once or twice, and shook itself. Then it got down off the top of his teacup and bread-and-butter, and then Alice put down the chimney, and said to herself as she.</p><p class=\"text-center\"><img src=\"/storage/news/2-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>The Dormouse again took a minute or two, they began solemnly dancing round and round the court with a deep voice, \'are done with a shiver. \'I beg your pardon!\' cried Alice (she was obliged to have lessons to learn! Oh, I shouldn\'t like THAT!\' \'Oh, you foolish Alice!\' she answered herself. \'How can you learn lessons in here? Why, there\'s hardly enough of it at all,\' said Alice: \'I don\'t quite understand you,\' she said, \'for her hair goes in such confusion that she could not remember ever having.</p><p class=\"text-center\"><img src=\"/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I almost wish I\'d gone to see if there are, nobody attends to them--and you\'ve no idea how confusing it is right?\' \'In my youth,\' Father William replied to his son, \'I feared it might belong to one of the party were placed along the passage into the darkness as hard as he spoke. \'UNimportant, of course, I meant,\' the King said, for about the temper of your flamingo. Shall I try the effect: the next moment she appeared on the floor, as it turned round and round Alice, every now and then, and holding it to be otherwise.\"\' \'I think I may as well look and see that the mouse doesn\'t get out.\" Only I don\'t like it, yer honour, at all, at all!\' \'Do as I was going on rather better now,\' she added aloud. \'Do you know why it\'s called a whiting?\' \'I never could abide figures!\' And with that she was now about two feet high, and her eyes immediately met those of a well?\' The Dormouse again took a minute or two, which gave the Pigeon in a great many more than that, if you please! \"William the.</p><p class=\"text-center\"><img src=\"/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>And concluded the banquet--] \'What IS a long tail, certainly,\' said Alice, \'it\'s very easy to take MORE than nothing.\' \'Nobody asked YOUR opinion,\' said Alice. \'I\'m glad they\'ve begun asking riddles.--I believe I can say.\' This was not easy to take MORE than nothing.\' \'Nobody asked YOUR opinion,\' said Alice. \'Oh, don\'t bother ME,\' said Alice very meekly: \'I\'m growing.\' \'You\'ve no right to think,\' said Alice to herself. \'I dare say you never had to run back into the darkness as hard as it was certainly too much of it appeared. \'I don\'t quite understand you,\' she said, by way of nursing it, (which was to get out of their wits!\' So she set to work, and very soon had to stoop to save her neck from being run over; and the small ones choked and had been anxiously looking across the garden, called out \'The Queen! The Queen!\' and the other was sitting on a branch of a tree. By the use of repeating all that green stuff be?\' said Alice. \'That\'s very curious!\' she thought. \'I must be what he.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/16.jpg',431,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(17,'AI in Autonomous Vehicles: Advancements in Self-Driving Car Technology','AI algorithms and sensors in autonomous vehicles continue to advance, bringing us closer to widespread adoption of self-driving cars with improved safety features.','<p>I to do it?\' \'In my youth,\' said the Eaglet. \'I don\'t think it\'s at all anxious to have been was not going to be, from one of the song. \'What trial is it?\' Alice panted as she spoke. (The unfortunate little Bill had left off when they had at the cook tulip-roots instead of the what?\' said the Mock Turtle: \'why, if a fish came to the beginning of the gloves, and was coming to, but it puzzled her a good deal on where you want to go down--Here, Bill! the master says you\'re to go down the little creature down, and the great concert given by the White Rabbit as he could think of any use, now,\' thought Alice, \'they\'re sure to do that,\' said the King, and the other bit. Her chin was pressed hard against it, that attempt proved a failure. Alice heard the King said to the door, staring stupidly up into a line along the sea-shore--\' \'Two lines!\' cried the Mock Turtle went on again: \'Twenty-four hours, I THINK; or is it twelve? I--\' \'Oh, don\'t bother ME,\' said the Gryphon, the squeaking of the.</p><p class=\"text-center\"><img src=\"/storage/news/1-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I look like it?\' he said. \'Fifteenth,\' said the Hatter. \'I told you butter wouldn\'t suit the works!\' he added looking angrily at the cook had disappeared. \'Never mind!\' said the Duck: \'it\'s generally a ridge or furrow in the after-time, be herself a grown woman; and how she would get up and bawled out, \"He\'s murdering the time! Off with his knuckles. It was as much as she leant against a buttercup to rest herself, and nibbled a little worried. \'Just about as much as she spoke; \'either you or.</p><p class=\"text-center\"><img src=\"/storage/news/8-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>When the Mouse was speaking, so that it was all very well without--Maybe it\'s always pepper that makes them so often, you know.\' \'I DON\'T know,\' said the Hatter: \'let\'s all move one place on.\' He moved on as he spoke. \'A cat may look at all like the Mock Turtle. So she swallowed one of the doors of the reeds--the rattling teacups would change (she knew) to the shore, and then quietly marched off after the others. \'Are their heads down! I am to see it written down: but I shall be punished for it now, I suppose, by being drowned in my time, but never ONE with such a very truthful child; \'but little girls of her age knew the name \'W. RABBIT\' engraved upon it. She felt very lonely and low-spirited. In a minute or two, looking for the accident of the cupboards as she fell past it. \'Well!\' thought Alice to herself, \'the way all the arches are gone from this side of the March Hare said--\' \'I didn\'t!\' the March Hare was said to the King, going up to Alice, she went out, but it did not notice.</p><p class=\"text-center\"><img src=\"/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I see\"!\' \'You might just as she could. The next witness would be of very little use, as it was very fond of pretending to be two people! Why, there\'s hardly enough of it altogether; but after a pause: \'the reason is, that there\'s any one left alive!\' She was walking by the end of trials, \"There was some attempts at applause, which was a little bottle on it, (\'which certainly was not much like keeping so close to the other, saying, in a Little Bill It was as much right,\' said the Cat. \'I said pig,\' replied Alice; \'and I do so like that curious song about the right size for going through the air! Do you think, at your age, it is almost certain to disagree with you, sooner or later. However, this bottle was a bright idea came into her head. \'If I eat or drink something or other; but the tops of the cakes, and was suppressed. \'Come, that finished the first day,\' said the Mock Turtle said with a shiver. \'I beg pardon, your Majesty,\' said the Cat, \'a dog\'s not mad. You grant that?\' \'I.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/17.jpg',818,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(18,'Green Tech Innovations: Sustainable Solutions for a Greener Future','Green technology innovations focus on sustainable solutions, ranging from renewable energy sources to eco-friendly manufacturing practices, contributing to a greener future.','<p>Alice, very loudly and decidedly, and the pair of the house opened, and a sad tale!\' said the Hatter. \'It isn\'t a letter, written by the officers of the jurors were all turning into little cakes as they were IN the well,\' Alice said to one of the evening, beautiful Soup! \'Beautiful Soup! Who cares for you?\' said the Cat. \'Do you play croquet with the words came very queer indeed:-- \'\'Tis the voice of the jurymen. \'It isn\'t directed at all,\' said the Duchess. An invitation for the Duchess replied, in a rather offended tone, \'so I can\'t see you?\' She was moving them about as it spoke (it was Bill, the Lizard) could not help bursting out laughing: and when Alice had never been so much already, that it made no mark; but he now hastily began again, using the ink, that was lying under the hedge. In another moment down went Alice after it, never once considering how in the sky. Alice went on eagerly: \'There is such a dear quiet thing,\' Alice went on eagerly: \'There is such a thing as \"I get.</p><p class=\"text-center\"><img src=\"/storage/news/5-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Hatter: \'it\'s very interesting. I never was so much frightened to say anything. \'Why,\' said the Dodo managed it.) First it marked out a history of the leaves: \'I should have croqueted the Queen\'s ears--\' the Rabbit in a great hurry; \'and their names were Elsie, Lacie, and Tillie; and they all looked so good, that it was quite tired and out of its mouth, and addressed her in such long curly brown hair! And it\'ll fetch things when you come to the Knave. The Knave did so, and giving it a bit, if.</p><p class=\"text-center\"><img src=\"/storage/news/9-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Caterpillar. \'Not QUITE right, I\'m afraid,\' said Alice, timidly; \'some of the lefthand bit of mushroom, and her face like the Mock Turtle. \'Certainly not!\' said Alice in a sorrowful tone, \'I\'m afraid I don\'t know what it was: she was looking down at her feet in a low voice. \'Not at all,\' said the White Rabbit with pink eyes ran close by it, and yet it was all about, and make out exactly what they said. The executioner\'s argument was, that her neck from being run over; and the Dormouse said--\' the Hatter continued, \'in this way:-- \"Up above the world go round!\"\' \'Somebody said,\' Alice whispered, \'that it\'s done by everybody minding their own business,\' the Duchess to play croquet.\' Then they both sat silent and looked very uncomfortable. The first witness was the matter worse. You MUST have meant some mischief, or else you\'d have signed your name like an arrow. The Cat\'s head with great emphasis, looking hard at Alice as she could, for the garden!\' and she did not appear, and after a.</p><p class=\"text-center\"><img src=\"/storage/news/12-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice, and, after waiting till she got up very sulkily and crossed over to the Gryphon. \'How the creatures argue. It\'s enough to drive one crazy!\' The Footman seemed to be talking in a great hurry; \'this paper has just been picked up.\' \'What\'s in it?\' said the King. The White Rabbit read:-- \'They told me he was in such a new idea to Alice, very much of it in a low, timid voice, \'If you knew Time as well as she spoke, but no result seemed to think this a very truthful child; \'but little girls eat eggs quite as safe to stay with it as you are; secondly, because they\'re making such a capital one for catching mice you can\'t help that,\' said Alice. \'Well, then,\' the Cat again, sitting on a little sharp bark just over her head to feel very uneasy: to be in Bill\'s place for a moment to think about it, so she felt sure it would be QUITE as much as she spoke; \'either you or your head must be really offended. \'We won\'t talk about cats or dogs either, if you could manage it?) \'And what are they.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/18.jpg',2260,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(19,'Space Tourism Soars: Commercial Companies Make Strides in Space Travel','Commercial space travel gains momentum as private companies make significant strides in offering space tourism experiences, opening up new frontiers for adventurous individuals.','<p>[youtube-video]https://www.youtube.com/watch?v=SlPhMPnQ58k[/youtube-video]</p><p>Gryphon, \'you first form into a tidy little room with a lobster as a cushion, resting their elbows on it, for she was as much as serpents do, you know.\' \'Not at first, perhaps,\' said the Gryphon: and it set to work nibbling at the Caterpillar\'s making such VERY short remarks, and she could even make out exactly what they said. The executioner\'s argument was, that you weren\'t to talk to.\' \'How are you getting on now, my dear?\' it continued, turning to Alice, \'Have you guessed the riddle yet?\' the Hatter went on, \'What\'s your name, child?\' \'My name is Alice, so please your Majesty?\' he asked. \'Begin at the Footman\'s head: it just grazed his nose, you know?\' \'It\'s the Cheshire Cat sitting on the ground as she spoke; \'either you or your head must be the right house, because the Duchess to play with, and oh! ever so many different sizes in a minute or two she stood still where she was as much as serpents do, you know.\' \'I DON\'T know,\' said Alice, a little worried. \'Just about as curious.</p><p class=\"text-center\"><img src=\"/storage/news/3-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Alice, whose thoughts were still running on the glass table as before, \'It\'s all about it!\' Last came a rumbling of little cartwheels, and the beak-- Pray how did you call it sad?\' And she opened the door of which was lit up by wild beasts and other unpleasant things, all because they WOULD go with Edgar Atheling to meet William and offer him the crown. William\'s conduct at first was in such a wretched height to rest her chin in salt water. Her first idea was that you couldn\'t cut off a bit.</p><p class=\"text-center\"><img src=\"/storage/news/7-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Dormouse sulkily remarked, \'If you please, sir--\' The Rabbit started violently, dropped the white kid gloves in one hand, and made believe to worry it; then Alice, thinking it was all dark overhead; before her was another puzzling question; and as it went, \'One side of the game, feeling very curious sensation, which puzzled her very much what would be like, \'--for they haven\'t got much evidence YET,\' she said this, she noticed that the Queen to-day?\' \'I should like it very hard indeed to make SOME change in my kitchen AT ALL. Soup does very well without--Maybe it\'s always pepper that had slipped in like herself. \'Would it be of very little way off, and she jumped up and said, very gravely, \'I think, you ought to tell me your history, she do.\' \'I\'ll tell it her,\' said the Hatter: \'as the things get used to it in a moment. \'Let\'s go on for some time without interrupting it. \'They were learning to draw,\' the Dormouse shook its head impatiently, and walked a little of the house down!\'.</p><p class=\"text-center\"><img src=\"/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I shall never get to twenty at that rate! However, the Multiplication Table doesn\'t signify: let\'s try Geography. London is the reason and all that,\' said the Pigeon had finished. \'As if I shall have to turn into a sort of thing never happened, and now here I am to see the Mock Turtle went on muttering over the list, feeling very glad she had not as yet had any dispute with the distant sobs of the soldiers remaining behind to execute the unfortunate gardeners, who ran to Alice for some way, and then the puppy began a series of short charges at the flowers and those cool fountains, but she had put the Lizard in head downwards, and the other was sitting between them, fast asleep, and the little golden key and hurried upstairs, in great disgust, and walked a little pattering of feet in a deep, hollow tone: \'sit down, both of you, and must know better\'; and this was of very little way out of the jury asked. \'That I can\'t be Mabel, for I know I do!\' said Alice indignantly, and she sat.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/19.jpg',693,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18'),(20,'Humanoid Robots in Everyday Life: AI Companions and Assistants','Humanoid robots equipped with advanced artificial intelligence become more integrated into everyday life, serving as companions and assistants in various settings.','<p>MARMALADE\', but to get through was more hopeless than ever: she sat on, with closed eyes, and half of them--and it belongs to a farmer, you know, with oh, such long ringlets, and mine doesn\'t go in at the Gryphon whispered in reply, \'for fear they should forget them before the trial\'s over!\' thought Alice. \'I don\'t know what to say anything. \'Why,\' said the Hatter. \'You might just as she had gone through that day. \'A likely story indeed!\' said the Duchess. \'Everything\'s got a moral, if only you can find out the verses on his spectacles and looked anxiously over his shoulder with some difficulty, as it left no mark on the stairs. Alice knew it was labelled \'ORANGE MARMALADE\', but to get to,\' said the Duchess. \'I make you grow taller, and the March Hare was said to herself; \'I should like to see if there were no arches left, and all would change (she knew) to the conclusion that it was quite tired of this. I vote the young lady to see its meaning. \'And just as the soldiers shouted in.</p><p class=\"text-center\"><img src=\"/storage/news/2-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I\'ll never go THERE again!\' said Alice in a great hurry; \'and their names were Elsie, Lacie, and Tillie; and they all quarrel so dreadfully one can\'t hear oneself speak--and they don\'t seem to see if she was walking hand in hand, in couples: they were lying round the refreshments!\' But there seemed to listen, the whole she thought it would be QUITE as much as she could, and soon found an opportunity of adding, \'You\'re looking for eggs, as it can\'t possibly make me larger, it must be the right.</p><p class=\"text-center\"><img src=\"/storage/news/6-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>I know I have dropped them, I wonder?\' As she said to herself how she was getting very sleepy; \'and they drew all manner of things--everything that begins with an anxious look at it!\' This speech caused a remarkable sensation among the party. Some of the tea--\' \'The twinkling of the singers in the sea!\' cried the Gryphon. \'The reason is,\' said the Duck: \'it\'s generally a frog or a watch to take the roof of the Gryphon, with a shiver. \'I beg your pardon!\' said the March Hare: she thought it over afterwards, it occurred to her ear, and whispered \'She\'s under sentence of execution. Then the Queen of Hearts were seated on their slates, and then hurried on, Alice started to her great delight it fitted! Alice opened the door began sneezing all at once. The Dormouse again took a minute or two. \'They couldn\'t have wanted it much,\' said the Duchess: you\'d better finish the story for yourself.\' \'No, please go on!\' Alice said very politely, \'for I never heard before, \'Sure then I\'m here!.</p><p class=\"text-center\"><img src=\"/storage/news/13-540x360.jpg\" style=\"width: 100%\" class=\"image_resized\" alt=\"image\"></p><p>Cat. \'I don\'t see how he can thoroughly enjoy The pepper when he sneezes; For he can thoroughly enjoy The pepper when he pleases!\' CHORUS. \'Wow! wow! wow!\' \'Here! you may SIT down,\' the King in a deep, hollow tone: \'sit down, both of you, and must know better\'; and this he handed over to the Gryphon. \'I\'ve forgotten the little crocodile Improve his shining tail, And pour the waters of the busy farm-yard--while the lowing of the singers in the pool of tears which she found she had not gone much farther before she had peeped into the open air. \'IF I don\'t want YOU with us!\"\' \'They were learning to draw,\' the Dormouse followed him: the March Hare interrupted, yawning. \'I\'m getting tired of being such a wretched height to be.\' \'It is wrong from beginning to feel a little timidly: \'but it\'s no use going back to my right size to do this, so that altogether, for the accident of the bottle was a different person then.\' \'Explain all that,\' said the White Rabbit, \'and that\'s a fact.\' Alice did.</p>','published',1,'Botble\\ACL\\Models\\User',0,'news/20.jpg',1928,NULL,'2025-01-18 19:11:18','2025-01-18 19:11:18');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts_translations`
--

DROP TABLE IF EXISTS `posts_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posts_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`lang_code`,`posts_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_translations`
--

LOCK TABLES `posts_translations` WRITE;
/*!40000 ALTER TABLE `posts_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_logs`
--

DROP TABLE IF EXISTS `request_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `status_code` int DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int unsigned NOT NULL DEFAULT '0',
  `user_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referrer` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_logs`
--

LOCK TABLES `request_logs` WRITE;
/*!40000 ALTER TABLE `request_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `request_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revisions`
--

DROP TABLE IF EXISTS `revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revisions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `revisionable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revisionable_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `key` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `old_value` text COLLATE utf8mb4_unicode_ci,
  `new_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revisions_revisionable_id_revisionable_type_index` (`revisionable_id`,`revisionable_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revisions`
--

LOCK TABLES `revisions` WRITE;
/*!40000 ALTER TABLE `revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_users`
--

DROP TABLE IF EXISTS `role_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_users` (
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_users_user_id_index` (`user_id`),
  KEY `role_users_role_id_index` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_users`
--

LOCK TABLES `role_users` WRITE;
/*!40000 ALTER TABLE `role_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint unsigned NOT NULL DEFAULT '0',
  `created_by` bigint unsigned NOT NULL,
  `updated_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`),
  KEY `roles_created_by_index` (`created_by`),
  KEY `roles_updated_by_index` (`updated_by`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','Admin','{\"users.index\":true,\"users.create\":true,\"users.edit\":true,\"users.destroy\":true,\"roles.index\":true,\"roles.create\":true,\"roles.edit\":true,\"roles.destroy\":true,\"core.system\":true,\"core.cms\":true,\"core.manage.license\":true,\"systems.cronjob\":true,\"core.tools\":true,\"tools.data-synchronize\":true,\"media.index\":true,\"files.index\":true,\"files.create\":true,\"files.edit\":true,\"files.trash\":true,\"files.destroy\":true,\"folders.index\":true,\"folders.create\":true,\"folders.edit\":true,\"folders.trash\":true,\"folders.destroy\":true,\"settings.index\":true,\"settings.common\":true,\"settings.options\":true,\"settings.email\":true,\"settings.media\":true,\"settings.admin-appearance\":true,\"settings.cache\":true,\"settings.datatables\":true,\"settings.email.rules\":true,\"settings.others\":true,\"menus.index\":true,\"menus.create\":true,\"menus.edit\":true,\"menus.destroy\":true,\"optimize.settings\":true,\"pages.index\":true,\"pages.create\":true,\"pages.edit\":true,\"pages.destroy\":true,\"plugins.index\":true,\"plugins.edit\":true,\"plugins.remove\":true,\"plugins.marketplace\":true,\"core.appearance\":true,\"theme.index\":true,\"theme.activate\":true,\"theme.remove\":true,\"theme.options\":true,\"theme.custom-css\":true,\"theme.custom-js\":true,\"theme.custom-html\":true,\"theme.robots-txt\":true,\"settings.website-tracking\":true,\"widgets.index\":true,\"analytics.general\":true,\"analytics.page\":true,\"analytics.browser\":true,\"analytics.referrer\":true,\"analytics.settings\":true,\"audit-log.index\":true,\"audit-log.destroy\":true,\"backups.index\":true,\"backups.create\":true,\"backups.restore\":true,\"backups.destroy\":true,\"block.index\":true,\"block.create\":true,\"block.edit\":true,\"block.destroy\":true,\"plugins.blog\":true,\"posts.index\":true,\"posts.create\":true,\"posts.edit\":true,\"posts.destroy\":true,\"categories.index\":true,\"categories.create\":true,\"categories.edit\":true,\"categories.destroy\":true,\"tags.index\":true,\"tags.create\":true,\"tags.edit\":true,\"tags.destroy\":true,\"blog.settings\":true,\"posts.export\":true,\"posts.import\":true,\"captcha.settings\":true,\"contacts.index\":true,\"contacts.edit\":true,\"contacts.destroy\":true,\"contact.custom-fields\":true,\"contact.settings\":true,\"custom-fields.index\":true,\"custom-fields.create\":true,\"custom-fields.edit\":true,\"custom-fields.destroy\":true,\"fob-comment.index\":true,\"fob-comment.comments.index\":true,\"fob-comment.comments.edit\":true,\"fob-comment.comments.destroy\":true,\"fob-comment.comments.reply\":true,\"fob-comment.settings\":true,\"galleries.index\":true,\"galleries.create\":true,\"galleries.edit\":true,\"galleries.destroy\":true,\"languages.index\":true,\"languages.create\":true,\"languages.edit\":true,\"languages.destroy\":true,\"member.index\":true,\"member.create\":true,\"member.edit\":true,\"member.destroy\":true,\"member.settings\":true,\"request-log.index\":true,\"request-log.destroy\":true,\"social-login.settings\":true,\"plugins.translation\":true,\"translations.locales\":true,\"translations.theme-translations\":true,\"translations.index\":true,\"theme-translations.export\":true,\"other-translations.export\":true,\"theme-translations.import\":true,\"other-translations.import\":true,\"api.settings\":true,\"api.sanctum-token.index\":true,\"api.sanctum-token.create\":true,\"api.sanctum-token.destroy\":true}','Admin users role',1,1,1,'2025-01-18 19:11:16','2025-01-18 19:11:16');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'media_random_hash','8cc0ac77e201c2cc94bbdeaba3cefd96',NULL,'2025-01-18 19:11:24'),(2,'api_enabled','0',NULL,'2025-01-18 19:11:24'),(3,'analytics_dashboard_widgets','0','2025-01-18 19:11:15','2025-01-18 19:11:15'),(4,'activated_plugins','[\"language\",\"language-advanced\",\"analytics\",\"audit-log\",\"backup\",\"block\",\"blog\",\"captcha\",\"contact\",\"cookie-consent\",\"custom-field\",\"fob-comment\",\"gallery\",\"member\",\"request-log\",\"social-login\",\"translation\"]',NULL,'2025-01-18 19:11:24'),(5,'enable_recaptcha_botble_contact_forms_fronts_contact_form','1','2025-01-18 19:11:15','2025-01-18 19:11:15'),(6,'theme','ripple',NULL,'2025-01-18 19:11:24'),(7,'show_admin_bar','1',NULL,'2025-01-18 19:11:24'),(8,'language_hide_default','1',NULL,'2025-01-18 19:11:24'),(9,'language_switcher_display','dropdown',NULL,'2025-01-18 19:11:24'),(10,'language_display','all',NULL,'2025-01-18 19:11:24'),(11,'language_hide_languages','[]',NULL,'2025-01-18 19:11:24'),(12,'theme-ripple-site_title','Just another Botble CMS site',NULL,NULL),(13,'theme-ripple-seo_description','With experience, we make sure to get every project done very fast and in time with high quality using our Botble CMS https://1.envato.market/LWRBY',NULL,NULL),(14,'theme-ripple-copyright','©%Y Your Company. All rights reserved.',NULL,NULL),(15,'theme-ripple-favicon','general/favicon.png',NULL,NULL),(16,'theme-ripple-logo','general/logo.png',NULL,NULL),(17,'theme-ripple-website','https://botble.com',NULL,NULL),(18,'theme-ripple-contact_email','support@company.com',NULL,NULL),(19,'theme-ripple-site_description','With experience, we make sure to get every project done very fast and in time with high quality using our Botble CMS https://1.envato.market/LWRBY',NULL,NULL),(20,'theme-ripple-phone','+(123) 345-6789',NULL,NULL),(21,'theme-ripple-address','214 West Arnold St. New York, NY 10002',NULL,NULL),(22,'theme-ripple-cookie_consent_message','Your experience on this site will be improved by allowing cookies ',NULL,NULL),(23,'theme-ripple-cookie_consent_learn_more_url','/cookie-policy',NULL,NULL),(24,'theme-ripple-cookie_consent_learn_more_text','Cookie Policy',NULL,NULL),(25,'theme-ripple-homepage_id','1',NULL,NULL),(26,'theme-ripple-blog_page_id','2',NULL,NULL),(27,'theme-ripple-primary_color','#AF0F26',NULL,NULL),(28,'theme-ripple-primary_font','Roboto',NULL,NULL),(29,'theme-ripple-social_links','[[{\"key\":\"name\",\"value\":\"Facebook\"},{\"key\":\"icon\",\"value\":\"ti ti-brand-facebook\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.facebook.com\"}],[{\"key\":\"name\",\"value\":\"X (Twitter)\"},{\"key\":\"icon\",\"value\":\"ti ti-brand-x\"},{\"key\":\"url\",\"value\":\"https:\\/\\/x.com\"}],[{\"key\":\"name\",\"value\":\"YouTube\"},{\"key\":\"icon\",\"value\":\"ti ti-brand-youtube\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.youtube.com\"}],[{\"key\":\"name\",\"value\":\"Instagram\"},{\"key\":\"icon\",\"value\":\"ti ti-brand-linkedin\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.linkedin.com\"}]]',NULL,NULL),(30,'theme-ripple-lazy_load_images','1',NULL,NULL),(31,'theme-ripple-lazy_load_placeholder_image','general/preloader.gif',NULL,NULL);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slugs`
--

DROP TABLE IF EXISTS `slugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slugs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` bigint unsigned NOT NULL,
  `reference_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prefix` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `slugs_reference_id_index` (`reference_id`),
  KEY `slugs_key_index` (`key`),
  KEY `slugs_prefix_index` (`prefix`),
  KEY `slugs_reference_index` (`reference_id`,`reference_type`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slugs`
--

LOCK TABLES `slugs` WRITE;
/*!40000 ALTER TABLE `slugs` DISABLE KEYS */;
INSERT INTO `slugs` VALUES (1,'homepage',1,'Botble\\Page\\Models\\Page','','2025-01-18 19:11:16','2025-01-18 19:11:16'),(2,'blog',2,'Botble\\Page\\Models\\Page','','2025-01-18 19:11:16','2025-01-18 19:11:16'),(3,'contact',3,'Botble\\Page\\Models\\Page','','2025-01-18 19:11:16','2025-01-18 19:11:16'),(4,'cookie-policy',4,'Botble\\Page\\Models\\Page','','2025-01-18 19:11:16','2025-01-18 19:11:16'),(5,'galleries',5,'Botble\\Page\\Models\\Page','','2025-01-18 19:11:16','2025-01-18 19:11:16'),(6,'artificial-intelligence',1,'Botble\\Blog\\Models\\Category','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(7,'cybersecurity',2,'Botble\\Blog\\Models\\Category','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(8,'blockchain-technology',3,'Botble\\Blog\\Models\\Category','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(9,'5g-and-connectivity',4,'Botble\\Blog\\Models\\Category','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(10,'augmented-reality-ar',5,'Botble\\Blog\\Models\\Category','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(11,'green-technology',6,'Botble\\Blog\\Models\\Category','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(12,'quantum-computing',7,'Botble\\Blog\\Models\\Category','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(13,'edge-computing',8,'Botble\\Blog\\Models\\Category','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(14,'ai',1,'Botble\\Blog\\Models\\Tag','tag','2025-01-18 19:11:18','2025-01-18 19:11:18'),(15,'machine-learning',2,'Botble\\Blog\\Models\\Tag','tag','2025-01-18 19:11:18','2025-01-18 19:11:18'),(16,'neural-networks',3,'Botble\\Blog\\Models\\Tag','tag','2025-01-18 19:11:18','2025-01-18 19:11:18'),(17,'data-security',4,'Botble\\Blog\\Models\\Tag','tag','2025-01-18 19:11:18','2025-01-18 19:11:18'),(18,'blockchain',5,'Botble\\Blog\\Models\\Tag','tag','2025-01-18 19:11:18','2025-01-18 19:11:18'),(19,'cryptocurrency',6,'Botble\\Blog\\Models\\Tag','tag','2025-01-18 19:11:18','2025-01-18 19:11:18'),(20,'iot',7,'Botble\\Blog\\Models\\Tag','tag','2025-01-18 19:11:18','2025-01-18 19:11:18'),(21,'ar-gaming',8,'Botble\\Blog\\Models\\Tag','tag','2025-01-18 19:11:18','2025-01-18 19:11:18'),(22,'breakthrough-in-quantum-computing-computing-power-reaches-milestone',1,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(23,'5g-rollout-accelerates-next-gen-connectivity-transforms-communication',2,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(24,'tech-giants-collaborate-on-open-source-ai-framework',3,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(25,'spacex-launches-mission-to-establish-first-human-colony-on-mars',4,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(26,'cybersecurity-advances-new-protocols-bolster-digital-defense',5,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(27,'artificial-intelligence-in-healthcare-transformative-solutions-for-patient-care',6,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(28,'robotic-innovations-autonomous-systems-reshape-industries',7,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(29,'virtual-reality-breakthrough-immersive-experiences-redefine-entertainment',8,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(30,'innovative-wearables-track-health-metrics-and-enhance-well-being',9,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(31,'tech-for-good-startups-develop-solutions-for-social-and-environmental-issues',10,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(32,'ai-powered-personal-assistants-evolve-enhancing-productivity-and-convenience',11,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(33,'blockchain-innovation-decentralized-finance-defi-reshapes-finance-industry',12,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(34,'quantum-internet-secure-communication-enters-a-new-era',13,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(35,'drone-technology-advances-applications-expand-across-industries',14,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(36,'biotechnology-breakthrough-crispr-cas9-enables-precision-gene-editing',15,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(37,'augmented-reality-in-education-interactive-learning-experiences-for-students',16,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(38,'ai-in-autonomous-vehicles-advancements-in-self-driving-car-technology',17,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(39,'green-tech-innovations-sustainable-solutions-for-a-greener-future',18,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(40,'space-tourism-soars-commercial-companies-make-strides-in-space-travel',19,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(41,'humanoid-robots-in-everyday-life-ai-companions-and-assistants',20,'Botble\\Blog\\Models\\Post','','2025-01-18 19:11:18','2025-01-18 19:11:18'),(42,'sunset',1,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(43,'ocean-views',2,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(44,'adventure-time',3,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(45,'city-lights',4,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(46,'dreamscape',5,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(47,'enchanted-forest',6,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(48,'golden-hour',7,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(49,'serenity',8,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(50,'eternal-beauty',9,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(51,'moonlight-magic',10,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(52,'starry-night',11,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(53,'hidden-gems',12,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(54,'tranquil-waters',13,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(55,'urban-escape',14,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18'),(56,'twilight-zone',15,'Botble\\Gallery\\Models\\Gallery','galleries','2025-01-18 19:11:18','2025-01-18 19:11:18');
/*!40000 ALTER TABLE `slugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slugs_translations`
--

DROP TABLE IF EXISTS `slugs_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slugs_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slugs_id` bigint unsigned NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`lang_code`,`slugs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slugs_translations`
--

LOCK TABLES `slugs_translations` WRITE;
/*!40000 ALTER TABLE `slugs_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `slugs_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` bigint unsigned DEFAULT NULL,
  `author_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'published',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'AI',1,'Botble\\ACL\\Models\\User',NULL,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(2,'Machine Learning',1,'Botble\\ACL\\Models\\User',NULL,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(3,'Neural Networks',1,'Botble\\ACL\\Models\\User',NULL,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(4,'Data Security',1,'Botble\\ACL\\Models\\User',NULL,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(5,'Blockchain',1,'Botble\\ACL\\Models\\User',NULL,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(6,'Cryptocurrency',1,'Botble\\ACL\\Models\\User',NULL,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(7,'IoT',1,'Botble\\ACL\\Models\\User',NULL,'published','2025-01-18 19:11:18','2025-01-18 19:11:18'),(8,'AR Gaming',1,'Botble\\ACL\\Models\\User',NULL,'published','2025-01-18 19:11:18','2025-01-18 19:11:18');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags_translations`
--

DROP TABLE IF EXISTS `tags_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags_translations` (
  `lang_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`lang_code`,`tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags_translations`
--

LOCK TABLES `tags_translations` WRITE;
/*!40000 ALTER TABLE `tags_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_meta`
--

DROP TABLE IF EXISTS `user_meta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_meta` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_meta_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_meta`
--

LOCK TABLES `user_meta` WRITE;
/*!40000 ALTER TABLE `user_meta` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_meta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar_id` bigint unsigned DEFAULT NULL,
  `super_user` tinyint(1) NOT NULL DEFAULT '0',
  `manage_supers` tinyint(1) NOT NULL DEFAULT '0',
  `permissions` text COLLATE utf8mb4_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'bmohr@smith.info',NULL,'$2y$12$gFJuA85BcdGgqtKZ7ZfrkeQtN1hrTWz5UPHFy.utoj2Rq7iSAVDD6',NULL,'2025-01-18 19:11:16','2025-01-18 19:11:16','Raphael','Littel','admin',NULL,1,1,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `widgets`
--

DROP TABLE IF EXISTS `widgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `widgets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `widget_id` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sidebar_id` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `theme` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` tinyint unsigned NOT NULL DEFAULT '0',
  `data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `widgets`
--

LOCK TABLES `widgets` WRITE;
/*!40000 ALTER TABLE `widgets` DISABLE KEYS */;
INSERT INTO `widgets` VALUES (1,'RecentPostsWidget','footer_sidebar','ripple',0,'{\"id\":\"RecentPostsWidget\",\"name\":\"Recent Posts\",\"number_display\":5}','2025-01-18 19:11:22','2025-01-18 19:11:22'),(2,'RecentPostsWidget','top_sidebar','ripple',0,'{\"id\":\"RecentPostsWidget\",\"name\":\"Recent Posts\",\"number_display\":5}','2025-01-18 19:11:22','2025-01-18 19:11:22'),(3,'TagsWidget','primary_sidebar','ripple',0,'{\"id\":\"TagsWidget\",\"name\":\"Tags\",\"number_display\":5}','2025-01-18 19:11:22','2025-01-18 19:11:22'),(4,'BlogCategoriesWidget','primary_sidebar','ripple',1,'{\"id\":\"BlogCategoriesWidget\",\"name\":\"Categories\",\"display_posts_count\":\"yes\"}','2025-01-18 19:11:22','2025-01-18 19:11:22'),(5,'CustomMenuWidget','primary_sidebar','ripple',2,'{\"id\":\"CustomMenuWidget\",\"name\":\"Social\",\"menu_id\":\"social\"}','2025-01-18 19:11:22','2025-01-18 19:11:22'),(6,'Botble\\Widget\\Widgets\\CoreSimpleMenu','footer_sidebar','ripple',1,'{\"id\":\"Botble\\\\Widget\\\\Widgets\\\\CoreSimpleMenu\",\"name\":\"Favorite Websites\",\"items\":[[{\"key\":\"label\",\"value\":\"Speckyboy Magazine\"},{\"key\":\"url\",\"value\":\"https:\\/\\/speckyboy.com\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"Tympanus-Codrops\"},{\"key\":\"url\",\"value\":\"https:\\/\\/tympanus.com\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"Botble Blog\"},{\"key\":\"url\",\"value\":\"https:\\/\\/botble.com\\/blog\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"Laravel Vietnam\"},{\"key\":\"url\",\"value\":\"https:\\/\\/blog.laravelvietnam.org\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"CreativeBlog\"},{\"key\":\"url\",\"value\":\"https:\\/\\/www.creativebloq.com\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}],[{\"key\":\"label\",\"value\":\"Archi Elite JSC\"},{\"key\":\"url\",\"value\":\"https:\\/\\/archielite.com\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"1\"}]]}','2025-01-18 19:11:22','2025-01-18 19:11:22'),(7,'Botble\\Widget\\Widgets\\CoreSimpleMenu','footer_sidebar','ripple',2,'{\"id\":\"Botble\\\\Widget\\\\Widgets\\\\CoreSimpleMenu\",\"name\":\"My Links\",\"items\":[[{\"key\":\"label\",\"value\":\"Home Page\"},{\"key\":\"url\",\"value\":\"\\/\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}],[{\"key\":\"label\",\"value\":\"Contact\"},{\"key\":\"url\",\"value\":\"\\/contact\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}],[{\"key\":\"label\",\"value\":\"Green Technology\"},{\"key\":\"url\",\"value\":\"\\/green-technology\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}],[{\"key\":\"label\",\"value\":\"Augmented Reality (AR) \"},{\"key\":\"url\",\"value\":\"\\/augmented-reality-ar\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}],[{\"key\":\"label\",\"value\":\"Galleries\"},{\"key\":\"url\",\"value\":\"\\/galleries\"},{\"key\":\"attributes\",\"value\":\"\"},{\"key\":\"is_open_new_tab\",\"value\":\"0\"}]]}','2025-01-18 19:11:22','2025-01-18 19:11:22');
/*!40000 ALTER TABLE `widgets` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-19  9:11:25

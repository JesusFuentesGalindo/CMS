-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: geascientific
-- ------------------------------------------------------
-- Server version	5.7.32

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
-- Table structure for table `acl`
--

DROP TABLE IF EXISTS `acl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`ai`),
  KEY `action_id` (`action_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `acl_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `acl_actions` (`action_id`) ON DELETE CASCADE,
  CONSTRAINT `acl_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl`
--

LOCK TABLES `acl` WRITE;
/*!40000 ALTER TABLE `acl` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_actions`
--

DROP TABLE IF EXISTS `acl_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_actions` (
  `action_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `action_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `action_desc` varchar(100) NOT NULL COMMENT 'Human readable description',
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`action_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `acl_actions_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `acl_categories` (`category_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_actions`
--

LOCK TABLES `acl_actions` WRITE;
/*!40000 ALTER TABLE `acl_actions` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_categories`
--

DROP TABLE IF EXISTS `acl_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_categories` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_code` varchar(100) NOT NULL COMMENT 'No periods allowed!',
  `category_desc` varchar(100) NOT NULL COMMENT 'Human readable description',
  PRIMARY KEY (`category_id`),
  UNIQUE KEY `category_code` (`category_code`),
  UNIQUE KEY `category_desc` (`category_desc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_categories`
--

LOCK TABLES `acl_categories` WRITE;
/*!40000 ALTER TABLE `acl_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aplications`
--

DROP TABLE IF EXISTS `aplications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aplications` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `a_name` varchar(100) NOT NULL,
  `a_description` text NOT NULL,
  `a_img` varchar(100) NOT NULL,
  PRIMARY KEY (`a_id`),
  UNIQUE KEY `a_name` (`a_name`),
  KEY `fk_user_id_aplications` (`user_id`),
  CONSTRAINT `fk_user_id_aplications` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aplications`
--

LOCK TABLES `aplications` WRITE;
/*!40000 ALTER TABLE `aplications` DISABLE KEYS */;
INSERT INTO `aplications` VALUES (4,1743257340,'Alimentos y Bebidas','La industria de alimentos y bebidas en México ha crecido considerablemente en los últimos años, principalmente por su productividad, disponibilidad de materias primas, y las capacidades del país para fungir como plataforma de exportación hacia más de 40 países con los que se tiene acuerdos comerciales.\nPor ello es cada vez mayor la exigencia de obtener análisis más rápidos y de calidad por normativa que de acuerdo con el tipo de alimento y bebida, se requieren análisis fisicoquímicos, tiempos de vida en anaquel, análisis microbiológicos, pruebas de toxicología y viscosidad, entre otros','assets/img/aplicaciones/alimentos_y_bebidas.jpg'),(6,1743257340,'Farmaceutíca','Las industrias farmacéuticas realizan el control de calidad que proceda en materias primas, los productos intermedios de fabricación y el producto terminado o final, así como la validación de los procesos de fabricación de acuerdo con métodos y técnicas generalmente aceptadas, que entre muchas otras, involucran la determinación del peso de las materias primas y excipientes, temperaturas de disolución, tiempos de agitación, tiempos de mezclado, volumen de aforo, pH, densidades, pesos promedio, peso individual, dureza, friabilidad, determinación de humedad, volumen de llenado, peso neto,  torque,  etc.','assets/img/aplicaciones/farmaceutica.jpg');
/*!40000 ALTER TABLE `aplications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_sessions`
--

DROP TABLE IF EXISTS `auth_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_sessions` (
  `id` varchar(128) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `login_time` datetime DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_sessions`
--

LOCK TABLES `auth_sessions` WRITE;
/*!40000 ALTER TABLE `auth_sessions` DISABLE KEYS */;
INSERT INTO `auth_sessions` VALUES ('qh2c4heorn3h1g8c8otdvlp9grkgi53s',1204132034,'2021-02-11 02:16:39','2021-02-11 09:09:10','127.0.0.1','Chrome 87.0.4280.88 on Linux'),('eonm0lsnkjebgb2acvuck28mdem3clai',3660773520,'2020-06-28 23:25:28','2020-06-29 09:11:33','127.0.0.1','Chrome 81.0.4044.138 on Linux'),('d2sched9od25gu4877uupuhm4kc3cckq',1743257340,'2020-06-22 20:19:06','2020-06-23 03:14:33','127.0.0.1','Chrome 81.0.4044.138 on Linux');
/*!40000 ALTER TABLE `auth_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `b_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `b_name` varchar(100) NOT NULL,
  `b_img` varchar(100) NOT NULL,
  `b_description` text,
  `b_equipments` text,
  `b_aplication` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`b_id`),
  UNIQUE KEY `b_name` (`b_name`),
  KEY `fk_brands_user_id` (`user_id`),
  CONSTRAINT `fk_brands_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (18,3660773520,'Eppendorf','assets/img/marcas/eppendorf.jpg','es una empresa líder en el área de las Ciencias de la Vida que desarrolla y comercializa instrumentos, consumibles y servicios para el tratamiento de líquidos, muestras y células, en laboratorios de todo el mundo.','Pipetas, Micropipetas, Puntas de Micropipeta, Tubos, Microtubos, Placas, Pipetas Automáticas, Centrifugas, Incubadoras de CO2, Fotómetros, PCR, Congeladores, Biorreactores y Agitadores.','Aplican para laboratorios de investigación y desarrollo, así como laboratorios nivel industrial y centros de investigación.'),(19,3660773520,'HACH','assets/img/marcas/hach.jpg','tiene la velocidad que la rutina de análisis necesita, con programas de análisis avanzados. Todos los instrumentos colorimétricos y espectrofotométricos tanto de laboratorio como portátiles están diseñados para simplificar las tareas de análisis rutinarios tanto como sea posible.','Medidores de pH, Conductividad, Oxígeno Disuelto, Ion Selectivo, Espectrofotómetros, Kit de Pruebas Rápidas y Tiras, Colorímetros, Analizadores de Metales, Turbidímetros y Tituladores.','Aplican para laboratorios de investigación y desarrollo, así como laboratorios nivel industrial y centros de investigación.');
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consumables`
--

DROP TABLE IF EXISTS `consumables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consumables` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `c_name` varchar(100) NOT NULL,
  `c_img` varchar(100) NOT NULL,
  PRIMARY KEY (`c_id`),
  UNIQUE KEY `c_name` (`c_name`),
  KEY `fk_user_id_comsumables` (`user_id`),
  CONSTRAINT `fk_user_id_comsumables` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consumables`
--

LOCK TABLES `consumables` WRITE;
/*!40000 ALTER TABLE `consumables` DISABLE KEYS */;
INSERT INTO `consumables` VALUES (4,1743257340,'Filtros','assets/img/consumibles/cristaleria_estandar.png'),(5,1743257340,'Puntas para pipetas y microtubos','assets/img/consumibles/puntas_para_pipetas_y_microtubos.jpg'),(6,1743257340,'Cristalería estándar','assets/img/consumibles/cristaleria_estandar.jpg');
/*!40000 ALTER TABLE `consumables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `denied_access`
--

DROP TABLE IF EXISTS `denied_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denied_access` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  `reason_code` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `denied_access`
--

LOCK TABLES `denied_access` WRITE;
/*!40000 ALTER TABLE `denied_access` DISABLE KEYS */;
INSERT INTO `denied_access` VALUES (1,'127.0.0.1','2020-05-26 13:52:43',1),(2,'127.0.0.1','2020-05-26 13:54:48',1),(3,'127.0.0.1','2020-05-26 13:57:11',1);
/*!40000 ALTER TABLE `denied_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ips_on_hold`
--

DROP TABLE IF EXISTS `ips_on_hold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ips_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ips_on_hold`
--

LOCK TABLES `ips_on_hold` WRITE;
/*!40000 ALTER TABLE `ips_on_hold` DISABLE KEYS */;
/*!40000 ALTER TABLE `ips_on_hold` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_errors`
--

DROP TABLE IF EXISTS `login_errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_errors` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_errors`
--

LOCK TABLES `login_errors` WRITE;
/*!40000 ALTER TABLE `login_errors` DISABLE KEYS */;
INSERT INTO `login_errors` VALUES (31,'usuario_prueba','127.0.0.1','2021-02-11 02:08:37'),(32,'usuario_prueba','127.0.0.1','2021-02-11 02:16:04');
/*!40000 ALTER TABLE `login_errors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `meta_consumables`
--

DROP TABLE IF EXISTS `meta_consumables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `meta_consumables` (
  `mc_description` text,
  `mc_speach_venta` text,
  `user_id` int(10) unsigned NOT NULL,
  KEY `fk_user_id_mc_consumables` (`user_id`),
  CONSTRAINT `fk_user_id_mc_consumables` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meta_consumables`
--

LOCK TABLES `meta_consumables` WRITE;
/*!40000 ALTER TABLE `meta_consumables` DISABLE KEYS */;
/*!40000 ALTER TABLE `meta_consumables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notices`
--

DROP TABLE IF EXISTS `notices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notices` (
  `n_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `n_name` varchar(50) NOT NULL,
  `n_text` text,
  `n_text_position` tinyint(4) NOT NULL,
  `n_img` varchar(100) NOT NULL,
  `n_text_color` varchar(45) DEFAULT NULL,
  `n_product` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`n_id`),
  UNIQUE KEY `n_name` (`n_name`),
  KEY `fk_notices_user_id` (`user_id`),
  CONSTRAINT `fk_notices_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notices`
--

LOCK TABLES `notices` WRITE;
/*!40000 ALTER TABLE `notices` DISABLE KEYS */;
INSERT INTO `notices` VALUES (7,3660773520,'Medición de pH','',3,'assets/img/avisos/medicion_de_ph.jpg','#000000','7'),(8,3660773520,'Pesajes exactos','Resultados confiables',1,'assets/img/avisos/pesajes_exactos.jpg','#E71414','6');
/*!40000 ALTER TABLE `notices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_aplication`
--

DROP TABLE IF EXISTS `product_aplication`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_aplication` (
  `pa_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_id` int(11) NOT NULL,
  `pa_name` varchar(100) NOT NULL,
  PRIMARY KEY (`a_id`,`pa_name`),
  UNIQUE KEY `pa_id` (`pa_id`),
  CONSTRAINT `fk_product_aplication` FOREIGN KEY (`a_id`) REFERENCES `aplications` (`a_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_aplication`
--

LOCK TABLES `product_aplication` WRITE;
/*!40000 ALTER TABLE `product_aplication` DISABLE KEYS */;
INSERT INTO `product_aplication` VALUES (1,4,'Balanzas'),(2,4,'Densímetros'),(3,4,'Centrifugas'),(4,4,'Medidores de grados brix'),(5,4,'Parrillas de calentamiento y agitación'),(6,4,'Medidores de pH, conductividad y Oxígeno disuelto'),(7,4,'Termobalanzas'),(8,4,'Refractómetros'),(9,4,'Medidores de Ion selectivo'),(11,6,'Balanzas');
/*!40000 ALTER TABLE `product_aplication` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_equipments` text NOT NULL,
  `p_offer` text NOT NULL,
  `p_img` varchar(100) NOT NULL,
  PRIMARY KEY (`p_id`),
  UNIQUE KEY `p_name` (`p_name`),
  KEY `fk_products_user_id` (`user_id`),
  CONSTRAINT `fk_products_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (6,3660773520,'Balanzas','Balanzas portátiles, granatarias, de precisión, analíticas, semimicro, industriales, marcos de pesas y accesorios.','Ofrecemos Balanzas de marcas distinguidas por su alta calidad para múltiples aplicaciones, industrias y para todo tipo de muestras de acuerdo a sus requerimientos en cumplimiento de normativas internas, nacionales e internacionales.','assets/img/productos/balanzas.jpg'),(7,3660773520,'Potenciómetros (pH, Conductividad, OD, ISE)','Medidores de pH, conductividad, temperatura, oxígeno disuelto, ion selectivo, soluciones buffer y electrodos.','Ofrecemos potenciómetros para la medición de un solo parámetro (pH. Conductividad, OD ó ISE,) y equipos multiparámetros de marcas distinguidas por su alta calidad para múltiples aplicaciones, industrias y para todo tipo de muestras de acuerdo a sus requerimientos en cumplimiento de normativas internas, nacionales e internacionales.','assets/img/productos/potenciometros_(ph,_conductividad,_od,_ise).jpg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(40) DEFAULT NULL,
  `photo` varchar(100) NOT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `fk_profile_user_id` (`user_id`),
  CONSTRAINT `fk_profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (11,3660773520,NULL,NULL,'assets/img/user/3660773520.jpeg'),(14,1743257340,NULL,NULL,'assets/img/user/defaultMan.png'),(15,1204132034,NULL,NULL,'assets/img/user/defaultMan.png'),(16,497252491,NULL,NULL,'assets/img/user/defaultMan.png');
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `s_title` varchar(100) NOT NULL,
  `s_description` text NOT NULL,
  `s_img` varchar(100) NOT NULL,
  PRIMARY KEY (`s_id`),
  KEY `fk_services_user_id` (`user_id`),
  CONSTRAINT `fk_services_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (2,3660773520,'Distribución de Equipos de Laboratorio e Industrial','Venta y comercialización de equipos, instrumentos y consumibles para laboratorios, industrias, centros de investigación y escuelas.','assets/img/servicios/distribucion_de_equipos_de_laboratorio_e_industrial.jpg'),(3,3660773520,'Cursos de Buenas Prácticas y Capacitación','Impartición de Cursos de actualización, técnicas de análisis, de cumplimiento normativo, de Buenas prácticas y capacitaciones en todos los niveles.','assets/img/servicios/cursos_de_buenas_practicas_y_capacitacion.jpg');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `username_or_email_on_hold`
--

DROP TABLE IF EXISTS `username_or_email_on_hold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `username_or_email_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `username_or_email_on_hold`
--

LOCK TABLES `username_or_email_on_hold` WRITE;
/*!40000 ALTER TABLE `username_or_email_on_hold` DISABLE KEYS */;
/*!40000 ALTER TABLE `username_or_email_on_hold` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL,
  `username` varchar(12) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `auth_level` tinyint(3) unsigned NOT NULL,
  `banned` enum('0','1') NOT NULL DEFAULT '0',
  `passwd` varchar(60) NOT NULL,
  `passwd_recovery_code` varchar(60) DEFAULT NULL,
  `passwd_recovery_date` datetime DEFAULT NULL,
  `passwd_modified_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (497252491,'prueba3','prueba2@gmail.com',9,'0','$2y$11$Bv70KM5EpHoqQZmcSeaBHu0/t8ITBrxA29b9zN4ZcyL2pQtgeYpnC',NULL,NULL,NULL,NULL,'2021-02-11 02:22:28','2021-02-11 08:22:28'),(1204132034,'usuario_prue','jesus@unmail.com',9,'0','$2y$11$NLE8FRvmu9uOqaa87WdFGu.OgrJrpy/npzn0aQhoAbhSBfwRRNz7a',NULL,NULL,NULL,'2021-02-11 02:16:39','2021-02-11 02:15:28','2021-02-11 08:16:39'),(1743257340,'admin','prueba@gmail.com',9,'0','$2y$11$9A/TrWACsgU6URWWMLM6D..Xu7sycV52qXqE6AzgITGocKjeEUOWG',NULL,NULL,NULL,'2020-06-22 20:19:06','2020-06-15 16:36:35','2020-06-23 01:19:06'),(3660773520,'Jesus','jesusfuentesgalindo@gmail.com',9,'0','$2y$11$1Z9j/Z9csJWEMI0imLLkQO6xqAizw68wx1s/0kg0QbkkyEt8MnS1S',NULL,NULL,NULL,'2020-06-28 23:25:28','2020-05-26 14:04:23','2020-06-29 04:25:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`administrador`@`%`*/ /*!50003 TRIGGER ca_passwd_trigger BEFORE UPDATE ON users
FOR EACH ROW
BEGIN
    IF ((NEW.passwd <=> OLD.passwd) = 0) THEN
        SET NEW.passwd_modified_at = NOW();
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Dumping routines for database 'geascientific'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-11  3:43:35

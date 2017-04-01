-- MySQL dump 10.13  Distrib 5.5.40, for Linux (x86_64)
--
-- Host: localhost    Database: praes_main
-- ------------------------------------------------------
-- Server version	5.5.40-cll

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
-- Table structure for table `activiteiten`
--

DROP TABLE IF EXISTS `activiteiten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activiteiten` (
  `transactie` int(11) NOT NULL,
  `datum` date NOT NULL,
  `opmerking` text NOT NULL,
  `werkgroep` text NOT NULL,
  `bank` decimal(10,2) DEFAULT NULL,
  `kas` decimal(10,2) DEFAULT NULL,
  `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transactie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activiteiten`
--

LOCK TABLES `activiteiten` WRITE;
/*!40000 ALTER TABLE `activiteiten` DISABLE KEYS */;
/*!40000 ALTER TABLE `activiteiten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activiteiten2013-2014`
--

DROP TABLE IF EXISTS `activiteiten2013-2014`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activiteiten2013-2014` (
  `transactie` int(11) NOT NULL,
  `datum` date NOT NULL,
  `opmerking` text NOT NULL,
  `werkgroep` text NOT NULL,
  `bank` decimal(10,2) DEFAULT NULL,
  `kas` decimal(10,2) DEFAULT NULL,
  `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transactie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activiteiten2013-2014`
--

LOCK TABLES `activiteiten2013-2014` WRITE;
/*!40000 ALTER TABLE `activiteiten2013-2014` DISABLE KEYS */;
/*!40000 ALTER TABLE `activiteiten2013-2014` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms`
--

DROP TABLE IF EXISTS `cms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `page` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms`
--

LOCK TABLES `cms` WRITE;
/*!40000 ALTER TABLE `cms` DISABLE KEYS */;
INSERT INTO `cms` (`id`, `title`, `text`, `author`, `created`, `updated`, `page`, `weight`) VALUES (1,'Welkom','&lt;p&gt;Het Praesidium is een enthousiaste groep leerlingen van het 4de, 5de en 6de jaar die ervoor zorgt dat de dagelijkse sleur van het schoolleven af en toe doorbroken wordt. We zijn opgedeeld in verschillende werkgroepen die elk hun eigen specialiteit hebben. Samen organiseren wij tal van leuke activiteiten voor de leerlingen: een film over de middag, een fietsdag waarop we extra aandacht schenken aan het milieu, een spannend spel voor de eerste graad, een vrij podium, een galabal en ga zo maar door!&lt;br /&gt;&lt;br /&gt;School is wat je er zelf van maakt, en wij hopen alvast dat we er dit jaar weer een topjaar van kunnen maken.&lt;br /&gt;&lt;br /&gt;Share the passion!&lt;br /&gt;greets Tom en Arthur&amp;nbsp;&lt;/p&gt;','Achim Vandierendonck','2014-11-16 10:36:21','2014-11-16 10:36:21','index.php',-49),(7,'Welkom','&lt;p&gt;Wij zijn...&lt;/p&gt;','Achim Vandierendonck','2014-03-08 10:49:32','0000-00-00 00:00:00','kern.php',-49),(8,'Welkom','&lt;p&gt;De 25e editie van de Kleine Kunst Avond of KKA, georganiseerd door het praesidium van het Sint-Lodewijkscollege, is alweer in aantocht! Een spetterende show voor jong en oud, vol muziek, dans, toneel, kunst, gevuld met talent uit onze eigen school, wacht op jullie. Dit jaar staat alles in het teken van onze vijfentwintigste editie of beter gezegd onze \'Silver edition\'. Het KKA gaat door op 28 februari en 1 maart 2015.&amp;nbsp;&lt;br /&gt;&lt;br /&gt;Wil jij meemaken hoe onze eigen leerlingen het beste van zichzelf geven on stage? Kom dan zeker af! Op deze groep zal alle info i.v.m. ticketverkoop, uren, foto\'s, programma enzovoort verschijnen, hou ons dus goed in de gaten en we hopen jullie allen te kunnen verwelkomen op 28 februari of 1 maart in het auditorium van onze school.&amp;nbsp;&lt;br /&gt;&lt;br /&gt;Creatieve groeten,&lt;br /&gt;Lilian Tavernier &amp;amp; Arnout Debucquoy&lt;/p&gt;','Achim Vandierendonck','2014-11-16 10:40:35','2014-11-16 10:40:35','kka.php',-49),(9,'Welkom','&lt;p&gt;Middagactiviteiten is een werkgroep van het praesidium (eigenlijk de leukste) die over de middag activiteiten organiseert. Dit gaat van een toffe film tot een voetbaltoernooi en zelfs tot een quiz! Voor ieder wat wils bij ons!&amp;nbsp;&lt;br /&gt;&lt;br /&gt;Leontien Beernaert en Esther Beel !&lt;/p&gt;','Achim Vandierendonck','2014-11-16 10:41:24','2014-11-16 10:41:24','atnoon.php',-49),(10,'Welkom','&lt;p&gt;Wij zijn de werkgroep In-Team en onze opdracht is heel simpel: feesten! In het praesidium wordt heel veel gewerkt, maar natuurlijk moet er ook een plaats zijn voor ontspanning. Onze werkgroep organiseert dan ook interne activiteiten voor het Praesidium, omdat ze dat verdienen! Dit gaat van heuse Halloweentochten, barbeques en spaghettie-avonden tot fancy casino\'s!&amp;nbsp;&lt;br /&gt;&lt;br /&gt;Linde Lust en Manon Van Caenegem!&lt;/p&gt;','Achim Vandierendonck','2014-11-16 10:42:36','2014-11-16 10:42:36','inteam.php',-49),(11,'Welkom','&lt;p&gt;Wij zijn...&lt;/p&gt;','Achim Vandierendonck','2014-03-08 10:52:56','0000-00-00 00:00:00','techniek.php',-49),(12,'Welkom','&lt;p&gt;Wij zijn...&lt;/p&gt;','Achim Vandierendonck','2014-03-08 10:53:48','0000-00-00 00:00:00','mos.php',-49),(13,'Welkom','&lt;p&gt;Wij, De Melkherberg, zijn de redders in nood wanneer je mama vergeten is een koekje in je boekentas te steken. Wij zorgen steeds voor een ruim aanbod aan smakelijke versnaperingen in de speeltijd. Wanneer je goede idee&amp;euml;n hebt over wat jij en je vrienden graag zouden willen eten op de speelplaats, mag je altijd een mail sturen naar&amp;nbsp;&lt;a href=&quot;mailto:melkherberg@hetpraesidium.be&quot;&gt;melkherberg@hetpraesidium.be&lt;/a&gt;. Smakelijk!&amp;nbsp;&lt;br /&gt;&lt;br /&gt;Julie Beausaert en Fauve Vandenberghe !&lt;/p&gt;','Achim Vandierendonck','2014-11-16 10:44:06','2014-11-16 10:44:06','melkherberg.php',-49),(14,'Under Construction','&lt;p&gt;&lt;img src=&quot;images/underconstruction.jpg&quot; alt=&quot;Under Construction&quot; width=&quot;500&quot; height=&quot;400&quot; /&gt;&lt;/p&gt;','Achim Vandierendonck','2014-03-08 10:57:30','0000-00-00 00:00:00','member.php',-49),(15,'BabbelBox','&lt;p&gt;&lt;iframe src=&quot;http://www.youtube.com/embed/5fPExqUv5eQ&quot; width=&quot;100%&quot; height=&quot;350&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;<br />\r\n&lt;p&gt;&lt;iframe src=&quot;http://www.youtube.com/embed/XC24efrKoVc&quot; width=&quot;100%&quot; height=&quot;350&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;','Achim Vandierendonck','2014-03-09 11:58:09','2014-03-09 10:58:09','kka.php',-40),(16,'Optredens KKA 2014','&lt;p&gt;&lt;iframe src=&quot;//www.youtube.com/embed/videoseries?list=PLU07PE-w-ePHqZeB9Y48ubHARbWGI5wKd&amp;amp;vq=hd720&quot; width=&quot;600&quot; height=&quot;338&quot; frameborder=&quot;0&quot; allowfullscreen=&quot;allowfullscreen&quot;&gt;&lt;/iframe&gt;&lt;/p&gt;','Achim Vandierendonck','2014-03-16 11:58:27','2014-03-16 11:58:27','kka.php',-45),(17,'Bal van Sint-Lodewijks','&lt;h2&gt;Het Bal van Sint-Lodewijks 2014 werd mede mogelijk gemaakt door:&lt;/h2&gt;<br />\r\n&lt;div&gt;<br />\r\n&lt;div&gt;&lt;img style=&quot;max-width: 100%;&quot; src=&quot;images/sponsors/Devlieger.png&quot; alt=&quot;&quot; /&gt; &lt;img style=&quot;max-width: 100%;&quot; src=&quot;images/sponsors/Clasal.png&quot; alt=&quot;&quot; /&gt; &lt;img style=&quot;max-width: 100%;&quot; src=&quot;images/sponsors/generalstores.png&quot; alt=&quot;&quot; /&gt; &lt;img style=&quot;max-width: 100%;&quot; src=&quot;images/sponsors/vives.png&quot; alt=&quot;&quot; /&gt; &lt;img style=&quot;height: 139px;&quot; src=&quot;images/sponsors/ladolcemaremma.png&quot; alt=&quot;&quot; /&gt; &lt;img style=&quot;height: 139px;&quot; src=&quot;images/sponsors/Belfius.png&quot; alt=&quot;&quot; /&gt; &lt;img style=&quot;height: 190px;&quot; src=&quot;images/sponsors/bocca.png&quot; alt=&quot;&quot; /&gt; &lt;img style=&quot;float: right;&quot; src=&quot;images/sponsors/PastaDelizia.png&quot; alt=&quot;&quot; /&gt;&lt;/div&gt;<br />\r\n&lt;br /&gt; En natuurlijk ook de KERN van het Praesidium: Charlotte Peters, Cl&amp;eacute;mence Clarysse, Achim Vandierendonck, Alec Buyse, Eva Decroos, Arnout Debucqouy, Friederike Debrabandere, Lo&amp;iuml;c Declerck, Robbe Wille, Hendrik Cornette, Artur Fonteyne.&lt;/div&gt;','Achim Vandierendonck','2014-05-15 20:12:23','2014-04-20 06:32:37','show.php?event=galabal&year=2014',0);
/*!40000 ALTER TABLE `cms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) NOT NULL,
  `full` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` (`id`, `event`, `full`) VALUES (9,'galabal','galabal');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galabal`
--

DROP TABLE IF EXISTS `galabal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galabal` (
  `transactie` int(11) NOT NULL,
  `datum` date NOT NULL,
  `opmerking` text NOT NULL,
  `bank` decimal(10,2) NOT NULL,
  `kas` decimal(10,2) NOT NULL,
  `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transactie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galabal`
--

LOCK TABLES `galabal` WRITE;
/*!40000 ALTER TABLE `galabal` DISABLE KEYS */;
/*!40000 ALTER TABLE `galabal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galabal2013-2014`
--

DROP TABLE IF EXISTS `galabal2013-2014`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galabal2013-2014` (
  `transactie` int(11) NOT NULL,
  `datum` date NOT NULL,
  `opmerking` text NOT NULL,
  `bank` decimal(10,2) NOT NULL,
  `kas` decimal(10,2) NOT NULL,
  `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transactie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galabal2013-2014`
--

LOCK TABLES `galabal2013-2014` WRITE;
/*!40000 ALTER TABLE `galabal2013-2014` DISABLE KEYS */;
/*!40000 ALTER TABLE `galabal2013-2014` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galabalEvent`
--

DROP TABLE IF EXISTS `galabalEvent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galabalEvent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galabalEvent`
--

LOCK TABLES `galabalEvent` WRITE;
/*!40000 ALTER TABLE `galabalEvent` DISABLE KEYS */;
INSERT INTO `galabalEvent` (`id`, `year`) VALUES (1,2014);
/*!40000 ALTER TABLE `galabalEvent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`, `permissions`) VALUES (1,'Standard user','{\"user\": 1, \"admin\": 0, \"voorzitter\": 0, \"master\": 0, \"kka\": 0, \"editor\": 0}'),(2,'Voorzitter','{\"user\": 1, \"admin\": 0, \"voorzitter\": 1, \"master\": 0, \"kka\": 0, \"editor\": 0}'),(3,'Voorzitter_KKA','{\"user\": 1, \"admin\": 0, \"voorzitter\": 1, \"master\": 0, \"kka\": 1, \"editor\": 0}'),(4,'Voorzitter_TECHNIEK','{\"user\": 1, \"admin\": 0, \"voorzitter\": 1, \"master\": 0, \"kka\": 0, \"editor\": 1}'),(5,'Voorzitter_KKA_TECHNIEK','{\"user\": 1, \"admin\": 0, \"voorzitter\": 1, \"master\": 0, \"kka\": 1, \"editor\": 1}'),(6,'Administrator','{\"user\": 1, \"admin\": 1, \"voorzitter\": 1, \"master\": 0, \"kka\": 0, \"editor\": 0}'),(7,'Master','{\"user\": 1, \"admin\": 1, \"voorzitter\": 1, \"master\": 1, \"kka\": 0, \"editor\": 1}');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kka`
--

DROP TABLE IF EXISTS `kka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kka` (
  `transactie` int(11) NOT NULL,
  `datum` date NOT NULL,
  `opmerking` text NOT NULL,
  `bank` decimal(10,2) NOT NULL,
  `kas` decimal(10,2) NOT NULL,
  `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transactie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kka`
--

LOCK TABLES `kka` WRITE;
/*!40000 ALTER TABLE `kka` DISABLE KEYS */;
/*!40000 ALTER TABLE `kka` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kka2013-2014`
--

DROP TABLE IF EXISTS `kka2013-2014`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kka2013-2014` (
  `transactie` int(11) NOT NULL,
  `datum` date NOT NULL,
  `opmerking` text NOT NULL,
  `bank` decimal(10,2) NOT NULL,
  `kas` decimal(10,2) NOT NULL,
  `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transactie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kka2013-2014`
--

LOCK TABLES `kka2013-2014` WRITE;
/*!40000 ALTER TABLE `kka2013-2014` DISABLE KEYS */;
/*!40000 ALTER TABLE `kka2013-2014` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gsm` varchar(255) NOT NULL,
  `werkgroep` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members2012-2013`
--

DROP TABLE IF EXISTS `members2012-2013`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members2012-2013` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gsm` varchar(255) NOT NULL,
  `werkgroep` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members2012-2013`
--

LOCK TABLES `members2012-2013` WRITE;
/*!40000 ALTER TABLE `members2012-2013` DISABLE KEYS */;
/*!40000 ALTER TABLE `members2012-2013` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `page`) VALUES (1,'index.php'),(2,'activiteiten.php'),(3,'atnoon.php'),(5,'inteam.php'),(6,'kern.php'),(7,'kka.php'),(8,'melkherberg.php'),(9,'techniek.php'),(10,'mos.php'),(11,'member.php'),(12,'show.php?event=galabal');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `praesidiumlokaal`
--

DROP TABLE IF EXISTS `praesidiumlokaal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `praesidiumlokaal` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `moment` varchar(255) NOT NULL,
  `werkgroep` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `praesidiumlokaal`
--

LOCK TABLES `praesidiumlokaal` WRITE;
/*!40000 ALTER TABLE `praesidiumlokaal` DISABLE KEYS */;
/*!40000 ALTER TABLE `praesidiumlokaal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets` (
  `transactie` int(11) NOT NULL,
  `datum` date NOT NULL,
  `opmerking` text NOT NULL,
  `bank` decimal(10,2) NOT NULL,
  `kas` decimal(10,2) NOT NULL,
  `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transactie`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets2013-2014`
--

DROP TABLE IF EXISTS `tickets2013-2014`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tickets2013-2014` (
  `transactie` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `opmerking` text NOT NULL,
  `bank` decimal(10,2) NOT NULL,
  `kas` decimal(10,2) NOT NULL,
  `startkapitaalAftrekken` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`transactie`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets2013-2014`
--

LOCK TABLES `tickets2013-2014` WRITE;
/*!40000 ALTER TABLE `tickets2013-2014` DISABLE KEYS */;
/*!40000 ALTER TABLE `tickets2013-2014` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `joined` datetime NOT NULL,
  `group` int(11) NOT NULL,
  `werkgroep` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_session`
--

DROP TABLE IF EXISTS `users_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `hash` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_session`
--

LOCK TABLES `users_session` WRITE;
/*!40000 ALTER TABLE `users_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `werkgroepen`
--

DROP TABLE IF EXISTS `werkgroepen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `werkgroepen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `werkgroep` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `werkgroepen`
--

LOCK TABLES `werkgroepen` WRITE;
/*!40000 ALTER TABLE `werkgroepen` DISABLE KEYS */;
INSERT INTO `werkgroepen` (`id`, `werkgroep`) VALUES (1,'MOS'),(2,'MELKHERBERG'),(3,'MIDDAGACTIVITEITEN'),(4,'KKA'),(5,'TECHNIEK'),(6,'INTEAM'),(7,'KERN');
/*!40000 ALTER TABLE `werkgroepen` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'praes_main'
--

--
-- Dumping routines for database 'praes_main'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-10 12:24:29

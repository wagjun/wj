-- MySQL dump 10.13  Distrib 5.1.73, for redhat-linux-gnu (x86_64)
--
-- Host: localhost    Database: fw
-- ------------------------------------------------------
-- Server version	5.1.73
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,POSTGRESQL' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table "menu"
--

DROP TABLE IF EXISTS "menu";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "menu" (
  "id" int(11) NOT NULL,
  "name" varchar(50) NOT NULL,
  "module" int(11) DEFAULT NULL,
  "id_main" int(11) DEFAULT NULL,
  "level" int(11) NOT NULL,
  "sequence" int(11) NOT NULL,
  "visible" char(1) NOT NULL,
  PRIMARY KEY ("id"),
  KEY "module_menu_idx" ("module"),
  CONSTRAINT "module_menu" FOREIGN KEY ("module") REFERENCES "modules" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "menu"
--

LOCK TABLES "menu" WRITE;
/*!40000 ALTER TABLE "menu" DISABLE KEYS */;
INSERT INTO "menu" VALUES (1,'Soxs',1,0,0,0,''),(2,'Alertas',2,0,0,0,''),(3,'Coletas',3,0,0,0,''),(4,'Problemas',4,0,0,0,''),(5,'Sox filho1',1,1,1,1,''),(6,'Sox filho2',1,1,1,2,''),(7,'Coleta Filha',3,3,1,1,'');
/*!40000 ALTER TABLE "menu" ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table "modules"
--

DROP TABLE IF EXISTS "modules";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "modules" (
  "id" int(11) NOT NULL,
  "name" varchar(100) NOT NULL,
  "link" varchar(45) NOT NULL,
  "controller" varchar(45) NOT NULL,
  "action" varchar(45) NOT NULL,
  PRIMARY KEY ("id")
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "modules"
--

LOCK TABLES "modules" WRITE;
/*!40000 ALTER TABLE "modules" DISABLE KEYS */;
INSERT INTO "modules" VALUES (1,'Soxs','sox','sox',''),(2,'Alertas','alerta','alerta',''),(3,'Coletas','coletas','coleta',''),(4,'Problemas','problemas','problema','');
/*!40000 ALTER TABLE "modules" ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table "permissions"
--

DROP TABLE IF EXISTS "permissions";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "permissions" (
  "id" int(11) NOT NULL,
  "profile" int(11) NOT NULL,
  "module" int(11) NOT NULL,
  PRIMARY KEY ("id"),
  KEY "profile_idx" ("profile"),
  KEY "module_idx" ("module"),
  KEY "profile_fk_idx" ("profile"),
  CONSTRAINT "module_fk" FOREIGN KEY ("module") REFERENCES "modules" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT "profile_fk" FOREIGN KEY ("profile") REFERENCES "profiles" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "permissions"
--

LOCK TABLES "permissions" WRITE;
/*!40000 ALTER TABLE "permissions" DISABLE KEYS */;
INSERT INTO "permissions" VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4);
/*!40000 ALTER TABLE "permissions" ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table "profiles"
--

DROP TABLE IF EXISTS "profiles";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "profiles" (
  "id" int(11) NOT NULL,
  "initials" varchar(5) NOT NULL,
  "name" varchar(100) NOT NULL,
  PRIMARY KEY ("id")
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "profiles"
--

LOCK TABLES "profiles" WRITE;
/*!40000 ALTER TABLE "profiles" DISABLE KEYS */;
INSERT INTO "profiles" VALUES (1,'ADM','ADMINISTRADOR'),(2,'USER','USUARIO');
/*!40000 ALTER TABLE "profiles" ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table "users"
--

DROP TABLE IF EXISTS "users";
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE "users" (
  "id" int(11) NOT NULL,
  "login" varchar(100) NOT NULL,
  "password" varchar(255) NOT NULL,
  "full_name" varchar(255) NOT NULL,
  "profile" int(11) NOT NULL,
  "status" char(1) NOT NULL,
  PRIMARY KEY ("id"),
  KEY "profile_idx" ("profile"),
  CONSTRAINT "profile" FOREIGN KEY ("profile") REFERENCES "profiles" ("id") ON DELETE NO ACTION ON UPDATE NO ACTION
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table "users"
--

LOCK TABLES "users" WRITE;
/*!40000 ALTER TABLE "users" DISABLE KEYS */;
INSERT INTO "users" VALUES (2,'jr','123','WAGNER JR',1,'A');
/*!40000 ALTER TABLE "users" ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-08 13:52:35

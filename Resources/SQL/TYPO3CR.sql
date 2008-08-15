CREATE TABLE "namespaces" ("prefix" VARCHAR(255) PRIMARY KEY NOT NULL, "uri" TEXT UNIQUE NOT NULL);
CREATE TABLE "nodetypes" ("name" VARCHAR(255) PRIMARY KEY NOT NULL);
CREATE TABLE "nodes" ("identifier" VARCHAR(36) PRIMARY KEY NOT NULL, "name" VARCHAR(255) NOT NULL, "parent" VARCHAR(36) NOT NULL, "nodetype" VARCHAR(255));
CREATE TABLE "properties" ("parent" VARCHAR(36) NOT NULL, "name" VARCHAR(255) NOT NULL, "value" TEXT NOT NULL, "namespace" VARCHAR(255) NOT NULL DEFAULT '', "multivalue" BOOLEAN NOT NULL DEFAULT '0', "type" INTEGER NOT NULL DEFAULT 0);
CREATE TABLE "multivalueproperties" ("parent" VARCHAR(36) NOT NULL, "name" VARCHAR(255) NOT NULL, "index" INTEGER NOT NULL, "value" TEXT NOT NULL, UNIQUE ("parent", "name","index"));

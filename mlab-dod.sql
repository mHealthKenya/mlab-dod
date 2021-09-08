/*
 Navicat Premium Data Transfer

 Source Server         : OFFICE POSTGRES 82
 Source Server Type    : PostgreSQL
 Source Server Version : 120008
 Source Host           : 197.232.82.136:5432
 Source Catalog        : mlab-dod-old
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 120008
 File Encoding         : 65001

 Date: 08/09/2021 11:27:38
*/


-- ----------------------------
-- Sequence structure for api_users_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."api_users_id_seq";
CREATE SEQUENCE "public"."api_users_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 32767
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for clients_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."clients_id_seq";
CREATE SEQUENCE "public"."clients_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 10
CACHE 1;

-- ----------------------------
-- Sequence structure for health_facilities_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."health_facilities_id_seq";
CREATE SEQUENCE "public"."health_facilities_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 11398
CACHE 1;

-- ----------------------------
-- Sequence structure for hts_results_hts_result_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."hts_results_hts_result_id_seq";
CREATE SEQUENCE "public"."hts_results_hts_result_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for hts_results_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."hts_results_id_seq";
CREATE SEQUENCE "public"."hts_results_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 25
CACHE 1;

-- ----------------------------
-- Sequence structure for il_facilities_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."il_facilities_id_seq";
CREATE SEQUENCE "public"."il_facilities_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 33
CACHE 1;

-- ----------------------------
-- Sequence structure for inbox2_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."inbox2_id_seq";
CREATE SEQUENCE "public"."inbox2_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 91542
CACHE 1;

-- ----------------------------
-- Sequence structure for inbox_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."inbox_id_seq";
CREATE SEQUENCE "public"."inbox_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 33
CACHE 1;

-- ----------------------------
-- Sequence structure for oauth_clients_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."oauth_clients_id_seq";
CREATE SEQUENCE "public"."oauth_clients_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for oauth_personal_access_clients_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."oauth_personal_access_clients_id_seq";
CREATE SEQUENCE "public"."oauth_personal_access_clients_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for partner_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."partner_id_seq";
CREATE SEQUENCE "public"."partner_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 52
CACHE 1;

-- ----------------------------
-- Sequence structure for results_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."results_id_seq";
CREATE SEQUENCE "public"."results_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1949746
CACHE 1;

-- ----------------------------
-- Sequence structure for send_log_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."send_log_id_seq";
CREATE SEQUENCE "public"."send_log_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for sms_gateway_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."sms_gateway_id_seq";
CREATE SEQUENCE "public"."sms_gateway_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for srl_eid_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."srl_eid_id_seq";
CREATE SEQUENCE "public"."srl_eid_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for srl_hts_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."srl_hts_id_seq";
CREATE SEQUENCE "public"."srl_hts_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for srl_viral_loads_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."srl_viral_loads_id_seq";
CREATE SEQUENCE "public"."srl_viral_loads_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 2147483647
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for tbresult_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."tbresult_id_seq";
CREATE SEQUENCE "public"."tbresult_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 11
CACHE 1;

-- ----------------------------
-- Sequence structure for users_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."users_id_seq";
CREATE SEQUENCE "public"."users_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 767
CACHE 1;

-- ----------------------------
-- Table structure for api_users
-- ----------------------------
DROP TABLE IF EXISTS "public"."api_users";
CREATE TABLE "public"."api_users" (
  "created_at" timestamp(0) NOT NULL DEFAULT now(),
  "updated_at" timestamp(0) NOT NULL DEFAULT now(),
  "id" int2 NOT NULL DEFAULT nextval('api_users_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "password" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "status" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "user_level" int2 NOT NULL DEFAULT 1
)
;

-- ----------------------------
-- Table structure for clients
-- ----------------------------
DROP TABLE IF EXISTS "public"."clients";
CREATE TABLE "public"."clients" (
  "id" int4 NOT NULL DEFAULT nextval('clients_id_seq'::regclass),
  "f_name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "l_name" varchar(255) COLLATE "pg_catalog"."default",
  "kdod_number" varchar(32) COLLATE "pg_catalog"."default",
  "phone" varchar(255) COLLATE "pg_catalog"."default",
  "facility_id" int4,
  "notification" int4,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now(),
  "status" text COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'Active'::text
)
;

-- ----------------------------
-- Table structure for county
-- ----------------------------
DROP TABLE IF EXISTS "public"."county";
CREATE TABLE "public"."county" (
  "id" int4 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "status" varchar(255) COLLATE "pg_catalog"."default",
  "time_stamp" timestamp(6) NOT NULL
)
;

-- ----------------------------
-- Table structure for health_facilities
-- ----------------------------
DROP TABLE IF EXISTS "public"."health_facilities";
CREATE TABLE "public"."health_facilities" (
  "id" int4 NOT NULL DEFAULT nextval('health_facilities_id_seq'::regclass),
  "code" int4 NOT NULL,
  "name" text COLLATE "pg_catalog"."default",
  "keph_level" varchar(255) COLLATE "pg_catalog"."default",
  "facility_type" varchar(255) COLLATE "pg_catalog"."default",
  "Sub_County_ID" int4,
  "unit_id" int4,
  "mobile" varchar(100) COLLATE "pg_catalog"."default",
  "modified" timestamp(6),
  "lat" varchar(255) COLLATE "pg_catalog"."default",
  "lng" varchar(255) COLLATE "pg_catalog"."default",
  "active" varchar(5) COLLATE "pg_catalog"."default" NOT NULL,
  "active_last_month" varchar(5) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now()
)
;

-- ----------------------------
-- Table structure for health_facilities_old
-- ----------------------------
DROP TABLE IF EXISTS "public"."health_facilities_old";
CREATE TABLE "public"."health_facilities_old" (
  "id" int4 NOT NULL DEFAULT nextval('health_facilities_id_seq'::regclass),
  "code" int4 NOT NULL,
  "name" text COLLATE "pg_catalog"."default",
  "keph_level" varchar(255) COLLATE "pg_catalog"."default",
  "facility_type" varchar(255) COLLATE "pg_catalog"."default",
  "Sub_County_ID" int4,
  "partner_id" int4,
  "mobile" varchar(100) COLLATE "pg_catalog"."default",
  "modified" timestamp(6),
  "lat" varchar(255) COLLATE "pg_catalog"."default",
  "lng" varchar(255) COLLATE "pg_catalog"."default",
  "active" varchar(5) COLLATE "pg_catalog"."default" NOT NULL,
  "active_last_month" varchar(5) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now()
)
;

-- ----------------------------
-- Table structure for hts_results
-- ----------------------------
DROP TABLE IF EXISTS "public"."hts_results";
CREATE TABLE "public"."hts_results" (
  "nhrl_lab_id" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "kdod_number" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "age" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "gender" varchar(10) COLLATE "pg_catalog"."default" NOT NULL,
  "test" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "result_value" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "status" varchar(255) COLLATE "pg_catalog"."default",
  "component" varchar(255) COLLATE "pg_catalog"."default",
  "mfl_code" int4 NOT NULL,
  "submit_date" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "date_released" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now(),
  "processed" int4 NOT NULL DEFAULT 0,
  "sample_id" varchar(20) COLLATE "pg_catalog"."default" NOT NULL,
  "date_sent" timestamp(6),
  "date_delivered" timestamp(6),
  "date_read" timestamp(6),
  "hts_result_id" int4 NOT NULL DEFAULT nextval('hts_results_hts_result_id_seq'::regclass)
)
;

-- ----------------------------
-- Table structure for il_facilities
-- ----------------------------
DROP TABLE IF EXISTS "public"."il_facilities";
CREATE TABLE "public"."il_facilities" (
  "id" int4 NOT NULL DEFAULT nextval('il_facilities_id_seq'::regclass),
  "mfl_code" int4 NOT NULL,
  "phone_no" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now(),
  "internet" varchar(5) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'No'::character varying
)
;

-- ----------------------------
-- Table structure for inbox
-- ----------------------------
DROP TABLE IF EXISTS "public"."inbox";
CREATE TABLE "public"."inbox" (
  "id" int4 NOT NULL DEFAULT nextval('inbox2_id_seq'::regclass),
  "shortCode" varchar(255) COLLATE "pg_catalog"."default",
  "MSISDN" varchar(255) COLLATE "pg_catalog"."default",
  "message" text COLLATE "pg_catalog"."default",
  "msgDateCreated" varchar(255) COLLATE "pg_catalog"."default",
  "createdOn" varchar(255) COLLATE "pg_catalog"."default",
  "message_id" varchar(255) COLLATE "pg_catalog"."default",
  "processed" int4 DEFAULT 0,
  "LinkId" varchar(255) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6)
)
;

-- ----------------------------
-- Table structure for new_facilities
-- ----------------------------
DROP TABLE IF EXISTS "public"."new_facilities";
CREATE TABLE "public"."new_facilities" (
  "Code" varchar(255) COLLATE "pg_catalog"."default",
  "Name" varchar(255) COLLATE "pg_catalog"."default",
  "Officialname" varchar(255) COLLATE "pg_catalog"."default",
  "Registration_number" varchar(255) COLLATE "pg_catalog"."default",
  "Keph level" varchar(255) COLLATE "pg_catalog"."default",
  "Facility type" varchar(255) COLLATE "pg_catalog"."default",
  "Facility_type_category" varchar(255) COLLATE "pg_catalog"."default",
  "Owner" varchar(255) COLLATE "pg_catalog"."default",
  "Owner type" varchar(255) COLLATE "pg_catalog"."default",
  "Regulatory body" varchar(255) COLLATE "pg_catalog"."default",
  "Beds" varchar(255) COLLATE "pg_catalog"."default",
  "Cots" varchar(255) COLLATE "pg_catalog"."default",
  "County" varchar(255) COLLATE "pg_catalog"."default",
  "Constituency" varchar(255) COLLATE "pg_catalog"."default",
  "Sub county" varchar(255) COLLATE "pg_catalog"."default",
  "Ward" varchar(255) COLLATE "pg_catalog"."default",
  "Operation status" varchar(255) COLLATE "pg_catalog"."default",
  "Open_whole_day" varchar(255) COLLATE "pg_catalog"."default",
  "Open_public_holidays" varchar(255) COLLATE "pg_catalog"."default",
  "Open_weekends" varchar(255) COLLATE "pg_catalog"."default",
  "Open_late_night" varchar(255) COLLATE "pg_catalog"."default",
  "Service_names" varchar(255) COLLATE "pg_catalog"."default",
  "Approved" varchar(255) COLLATE "pg_catalog"."default",
  "Public visible" varchar(255) COLLATE "pg_catalog"."default",
  "Closed" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for oauth_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_access_tokens";
CREATE TABLE "public"."oauth_access_tokens" (
  "id" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "user_id" int4,
  "client_id" int4 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "scopes" text COLLATE "pg_catalog"."default",
  "revoked" bool NOT NULL,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "expires_at" timestamp(0)
)
;

-- ----------------------------
-- Table structure for oauth_auth_codes
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_auth_codes";
CREATE TABLE "public"."oauth_auth_codes" (
  "id" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "user_id" int4 NOT NULL,
  "client_id" int4 NOT NULL,
  "scopes" text COLLATE "pg_catalog"."default",
  "revoked" bool NOT NULL,
  "expires_at" timestamp(0)
)
;

-- ----------------------------
-- Table structure for oauth_clients
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_clients";
CREATE TABLE "public"."oauth_clients" (
  "user_id" int4,
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "secret" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "redirect" text COLLATE "pg_catalog"."default" NOT NULL,
  "personal_access_client" bool NOT NULL,
  "password_client" bool NOT NULL,
  "revoked" bool NOT NULL,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "id" int4 NOT NULL DEFAULT nextval('oauth_clients_id_seq'::regclass)
)
;

-- ----------------------------
-- Table structure for oauth_personal_access_clients
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_personal_access_clients";
CREATE TABLE "public"."oauth_personal_access_clients" (
  "client_id" int4 NOT NULL,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "id" int4 NOT NULL DEFAULT nextval('oauth_personal_access_clients_id_seq'::regclass)
)
;

-- ----------------------------
-- Table structure for oauth_refresh_tokens
-- ----------------------------
DROP TABLE IF EXISTS "public"."oauth_refresh_tokens";
CREATE TABLE "public"."oauth_refresh_tokens" (
  "id" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "access_token_id" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "revoked" bool NOT NULL,
  "expires_at" timestamp(0)
)
;

-- ----------------------------
-- Table structure for oldfacility
-- ----------------------------
DROP TABLE IF EXISTS "public"."oldfacility";
CREATE TABLE "public"."oldfacility" (
  "id" int4,
  "code" int4,
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "reg_number" varchar(255) COLLATE "pg_catalog"."default",
  "keph_level" varchar(255) COLLATE "pg_catalog"."default",
  "facility_type" varchar(255) COLLATE "pg_catalog"."default",
  "owner" varchar(255) COLLATE "pg_catalog"."default",
  "regulatory_body" varchar(255) COLLATE "pg_catalog"."default",
  "beds" varchar(255) COLLATE "pg_catalog"."default",
  "cots" varchar(255) COLLATE "pg_catalog"."default",
  "county_id" varchar(255) COLLATE "pg_catalog"."default",
  "consituency_id" varchar(255) COLLATE "pg_catalog"."default",
  "Sub_County_ID" int4,
  "Ward_id" varchar(255) COLLATE "pg_catalog"."default",
  "operational_status" varchar(255) COLLATE "pg_catalog"."default",
  "Open_whole_day" varchar(255) COLLATE "pg_catalog"."default",
  "Open_public_holidays" varchar(255) COLLATE "pg_catalog"."default",
  "Open_weekends" varchar(255) COLLATE "pg_catalog"."default",
  "Open_late_night" varchar(255) COLLATE "pg_catalog"."default",
  "Service_names" varchar(255) COLLATE "pg_catalog"."default",
  "Approved" varchar(255) COLLATE "pg_catalog"."default",
  "Public_visible" varchar(255) COLLATE "pg_catalog"."default",
  "Closed" varchar(255) COLLATE "pg_catalog"."default",
  "assigned" varchar(255) COLLATE "pg_catalog"."default",
  "created_by" varchar(255) COLLATE "pg_catalog"."default",
  "updated_by" varchar(255) COLLATE "pg_catalog"."default",
  "lat" varchar(255) COLLATE "pg_catalog"."default",
  "lng" varchar(255) COLLATE "pg_catalog"."default",
  "created_at" varchar(255) COLLATE "pg_catalog"."default",
  "updated_at" varchar(255) COLLATE "pg_catalog"."default",
  "ushauri_id" varchar(255) COLLATE "pg_catalog"."default",
  "db_source" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for results
-- ----------------------------
DROP TABLE IF EXISTS "public"."results";
CREATE TABLE "public"."results" (
  "id" int4 NOT NULL DEFAULT nextval('results_id_seq'::regclass),
  "source" varchar(5) COLLATE "pg_catalog"."default",
  "result_id" varchar(100) COLLATE "pg_catalog"."default",
  "result_type" varchar(10) COLLATE "pg_catalog"."default",
  "request_id" varchar(50) COLLATE "pg_catalog"."default",
  "kdod_number" varchar(100) COLLATE "pg_catalog"."default",
  "age" varchar(10) COLLATE "pg_catalog"."default",
  "gender" varchar(10) COLLATE "pg_catalog"."default",
  "result_content" varchar(100) COLLATE "pg_catalog"."default",
  "units" varchar(50) COLLATE "pg_catalog"."default",
  "data_key" int4,
  "mfl_code" int4,
  "lab_id" int4,
  "cst" varchar(10) COLLATE "pg_catalog"."default",
  "cj" varchar(10) COLLATE "pg_catalog"."default",
  "csr" varchar(10) COLLATE "pg_catalog"."default",
  "date_collected" varchar(50) COLLATE "pg_catalog"."default",
  "lab_order_date" varchar(50) COLLATE "pg_catalog"."default",
  "sys_code" int4 DEFAULT 1,
  "date_sent" timestamp(6),
  "date_delivered" timestamp(6),
  "date_read" timestamp(6),
  "processed" int4 DEFAULT 0,
  "il_send" int4 DEFAULT 0,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now(),
  "lab_name" varchar(255) COLLATE "pg_catalog"."default",
  "client_notified" bool NOT NULL DEFAULT false
)
;

-- ----------------------------
-- Table structure for send_log
-- ----------------------------
DROP TABLE IF EXISTS "public"."send_log";
CREATE TABLE "public"."send_log" (
  "send_log_id" int4 NOT NULL DEFAULT nextval('send_log_id_seq'::regclass),
  "number" varchar(25) COLLATE "pg_catalog"."default" NOT NULL,
  "message" text COLLATE "pg_catalog"."default" NOT NULL,
  "status" varchar(25) COLLATE "pg_catalog"."default" NOT NULL,
  "statusCode" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "messageId" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "cost" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
  "updated_at" timestamp(6),
  "created_at" timestamp(6)
)
;

-- ----------------------------
-- Table structure for service
-- ----------------------------
DROP TABLE IF EXISTS "public"."service";
CREATE TABLE "public"."service" (
  "id" int4 NOT NULL DEFAULT nextval('partner_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "status" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now()
)
;

-- ----------------------------
-- Table structure for sms_gateway
-- ----------------------------
DROP TABLE IF EXISTS "public"."sms_gateway";
CREATE TABLE "public"."sms_gateway" (
  "id" int4 NOT NULL DEFAULT nextval('sms_gateway_id_seq'::regclass),
  "user_id" int4 NOT NULL,
  "phone_no" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
  "message" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "delivery_status" varchar(20) COLLATE "pg_catalog"."default" NOT NULL,
  "cost" varchar(20) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(0) DEFAULT now()
)
;

-- ----------------------------
-- Table structure for srl_eid
-- ----------------------------
DROP TABLE IF EXISTS "public"."srl_eid";
CREATE TABLE "public"."srl_eid" (
  "id" int4 NOT NULL DEFAULT nextval('srl_eid_id_seq'::regclass),
  "selected_sex" varchar(255) COLLATE "pg_catalog"."default",
  "selected_regimen" varchar(255) COLLATE "pg_catalog"."default",
  "selected_alive" varchar(255) COLLATE "pg_catalog"."default",
  "hein_number" varchar COLLATE "pg_catalog"."default",
  "patient_name" varchar(255) COLLATE "pg_catalog"."default",
  "dob" varchar(255) COLLATE "pg_catalog"."default",
  "entry_point" varchar(255) COLLATE "pg_catalog"."default",
  "date_collected" varchar(255) COLLATE "pg_catalog"."default" DEFAULT ''::character varying,
  "prophylaxis_code" varchar(255) COLLATE "pg_catalog"."default",
  "infant_feeding" varchar(255) COLLATE "pg_catalog"."default",
  "pcr" varchar(255) COLLATE "pg_catalog"."default",
  "alive_dead" varchar(255) COLLATE "pg_catalog"."default",
  "mother_age" varchar(255) COLLATE "pg_catalog"."default",
  "haart_date" varchar COLLATE "pg_catalog"."default",
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6),
  "processed" int2 NOT NULL DEFAULT 0,
  "facility" int4,
  "lab_id" int4,
  "lab_name" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for srl_hts
-- ----------------------------
DROP TABLE IF EXISTS "public"."srl_hts";
CREATE TABLE "public"."srl_hts" (
  "id" int4 NOT NULL DEFAULT nextval('srl_hts_id_seq'::regclass),
  "sample_number" varchar(255) COLLATE "pg_catalog"."default",
  "client_name" varchar(255) COLLATE "pg_catalog"."default",
  "dob" varchar(255) COLLATE "pg_catalog"."default",
  "selected_sex" varchar(255) COLLATE "pg_catalog"."default",
  "telephone" varchar(255) COLLATE "pg_catalog"."default",
  "test_date" varchar(255) COLLATE "pg_catalog"."default",
  "selected_delivery_point" varchar(255) COLLATE "pg_catalog"."default",
  "selected_test_kit1" varchar(255) COLLATE "pg_catalog"."default",
  "lot_number1" varchar(255) COLLATE "pg_catalog"."default",
  "expiry_date1" varchar(255) COLLATE "pg_catalog"."default",
  "selected_test_kit2" varchar(255) COLLATE "pg_catalog"."default",
  "lot_number2" varchar(255) COLLATE "pg_catalog"."default",
  "expiry_date2" varchar(255) COLLATE "pg_catalog"."default",
  "selected_final_result" varchar(255) COLLATE "pg_catalog"."default",
  "sample_tester_name" varchar(255) COLLATE "pg_catalog"."default",
  "dbs_date" varchar(255) COLLATE "pg_catalog"."default",
  "dbs_dispatch_date" varchar(255) COLLATE "pg_catalog"."default",
  "requesting_provider" varchar(255) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6),
  "processed" int2 NOT NULL DEFAULT 0,
  "facility" int4,
  "lab_id" int4,
  "lab_name" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for srl_viral_loads
-- ----------------------------
DROP TABLE IF EXISTS "public"."srl_viral_loads";
CREATE TABLE "public"."srl_viral_loads" (
  "id" int4 NOT NULL DEFAULT nextval('srl_viral_loads_id_seq'::regclass),
  "kdod_number" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "patient_name" varchar(255) COLLATE "pg_catalog"."default",
  "dob" varchar(255) COLLATE "pg_catalog"."default",
  "date_collected" varchar(255) COLLATE "pg_catalog"."default",
  "art_start_date" varchar(255) COLLATE "pg_catalog"."default",
  "current_regimen" varchar(255) COLLATE "pg_catalog"."default",
  "date_art_regimen" varchar(255) COLLATE "pg_catalog"."default",
  "art_line" varchar(255) COLLATE "pg_catalog"."default",
  "justification_code" varchar(255) COLLATE "pg_catalog"."default",
  "selected_type" varchar(255) COLLATE "pg_catalog"."default",
  "selected_sex" varchar(255) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6),
  "processed" int2 NOT NULL DEFAULT 0,
  "facility" int4,
  "lab_id" int4,
  "lab_name" varchar(255) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Table structure for sub_county
-- ----------------------------
DROP TABLE IF EXISTS "public"."sub_county";
CREATE TABLE "public"."sub_county" (
  "id" int4 NOT NULL,
  "name" varchar(255) COLLATE "pg_catalog"."default",
  "county_id" int4 NOT NULL,
  "status" varchar(255) COLLATE "pg_catalog"."default",
  "time_stamp" timestamp(6) NOT NULL
)
;

-- ----------------------------
-- Table structure for tb_results
-- ----------------------------
DROP TABLE IF EXISTS "public"."tb_results";
CREATE TABLE "public"."tb_results" (
  "tb_result_id" int4 NOT NULL DEFAULT nextval('tbresult_id_seq'::regclass),
  "sample_id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "kdod_number" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "age" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "gender" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "test1" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "result_value1" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "test2" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "result_value2" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "test3" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "result_value3" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "mfl_code" int4 NOT NULL,
  "login_date" timestamp(6) NOT NULL,
  "date_reviewed" timestamp(6) NOT NULL,
  "record_date" timestamp(6) NOT NULL,
  "testing_lab" int4 NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now(),
  "processed" int4 DEFAULT 0
)
;

-- ----------------------------
-- Table structure for unit
-- ----------------------------
DROP TABLE IF EXISTS "public"."unit";
CREATE TABLE "public"."unit" (
  "id" int4 NOT NULL DEFAULT nextval('partner_id_seq'::regclass),
  "name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "status" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now(),
  "service_id" int4
)
;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "id" int4 NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  "f_name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "l_name" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "phone_no" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "status" varchar(20) COLLATE "pg_catalog"."default" NOT NULL,
  "county_id" int4,
  "service_id" int4,
  "facility_id" int4,
  "user_level" int4,
  "first_login" text COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL DEFAULT now(),
  "updated_at" timestamp(6) NOT NULL DEFAULT now(),
  "password" varchar(255) COLLATE "pg_catalog"."default",
  "remember_token" varchar(255) COLLATE "pg_catalog"."default",
  "unit_id" int4
)
;

-- ----------------------------
-- View structure for printers_data
-- ----------------------------
DROP VIEW IF EXISTS "public"."printers_data";
CREATE VIEW "public"."printers_data" AS  SELECT results.result_type,
    results.age,
    results.gender,
    results.data_key,
    results.mfl_code,
    results.created_at,
    results.date_collected,
    results.date_sent,
    results.lab_id,
    health_facilities."Sub_County_ID",
    sub_county.county_id,
    health_facilities.unit_id,
    service.id
   FROM ((((results
     JOIN health_facilities ON ((health_facilities.code = results.mfl_code)))
     LEFT JOIN unit ON ((health_facilities.unit_id = unit.id)))
     LEFT JOIN service ON ((service.id = unit.service_id)))
     JOIN sub_county ON ((health_facilities."Sub_County_ID" = sub_county.id)))
  WHERE ((health_facilities.unit_id IS NULL) AND (NOT (results.mfl_code IN ( SELECT il_facilities.mfl_code
           FROM il_facilities))));

-- ----------------------------
-- View structure for mlab_active_facilities
-- ----------------------------
DROP VIEW IF EXISTS "public"."mlab_active_facilities";
CREATE VIEW "public"."mlab_active_facilities" AS  SELECT health_facilities.code
   FROM health_facilities
  WHERE ((health_facilities.mobile IS NOT NULL) OR (health_facilities.code IN ( SELECT il_facilities.mfl_code
           FROM il_facilities)));

-- ----------------------------
-- View structure for hts_summary
-- ----------------------------
DROP VIEW IF EXISTS "public"."hts_summary";
CREATE VIEW "public"."hts_summary" AS  SELECT hts_results.hts_result_id,
    hts_results.kdod_number,
    service.name AS service,
    unit.name AS unit,
    county.name AS county,
    sub_county.name AS sub_county,
    health_facilities.name AS facility,
        CASE
            WHEN (health_facilities.lat IS NULL) THEN 'NAN'::character varying
            ELSE health_facilities.lat
        END AS lat,
        CASE
            WHEN (health_facilities.lng IS NULL) THEN 'NAN'::character varying
            ELSE health_facilities.lng
        END AS lng,
    hts_results.test,
    hts_results.result_value,
        CASE
            WHEN ((hts_results.gender)::text = 'F'::text) THEN 'Female'::text
            WHEN ((hts_results.gender)::text = 'M'::text) THEN 'Male'::text
            ELSE 'Not Available'::text
        END AS gender,
        CASE
            WHEN (hts_results.age IS NOT NULL) THEN hts_results.age
            ELSE 'Not Available'::character varying
        END AS age,
    hts_results.submit_date,
    hts_results.date_released,
    hts_results.date_sent,
    hts_results.date_delivered,
    hts_results.date_read,
        CASE
            WHEN ((hts_results.submit_date IS NULL) OR ((hts_results.date_released)::text ~~ '%000%'::text)) THEN 'NAN'::text
            ELSE (((hts_results.submit_date)::date - (hts_results.date_released)::date))::text
        END AS submitted_released_tat,
        CASE
            WHEN (hts_results.date_read IS NULL) THEN 'NAN'::text
            ELSE (((hts_results.date_read)::date - (hts_results.date_sent)::date))::text
        END AS sent_read_tat,
        CASE
            WHEN ((hts_results.submit_date IS NULL) OR ((hts_results.submit_date)::text ~~ '%000%'::text) OR (hts_results.date_read IS NULL)) THEN 'NAN'::text
            ELSE (((hts_results.date_read)::date - (hts_results.submit_date)::date))::text
        END AS overall_tat,
    hts_results.updated_at AS updated
   FROM (((((hts_results
     JOIN health_facilities ON ((hts_results.mfl_code = health_facilities.code)))
     LEFT JOIN unit ON ((unit.id = health_facilities.unit_id)))
     LEFT JOIN service ON ((service.id = unit.service_id)))
     JOIN sub_county ON ((sub_county.id = health_facilities."Sub_County_ID")))
     JOIN county ON ((county.id = sub_county.county_id)));

-- ----------------------------
-- View structure for srl_vl_summary
-- ----------------------------
DROP VIEW IF EXISTS "public"."srl_vl_summary";
CREATE VIEW "public"."srl_vl_summary" AS  SELECT srl_viral_loads.id,
    srl_viral_loads.kdod_number,
    srl_viral_loads.patient_name,
    srl_viral_loads.lab_name,
    srl_viral_loads.selected_sex AS gender,
    srl_viral_loads.current_regimen,
    srl_viral_loads.date_art_regimen,
    srl_viral_loads.selected_type,
    srl_viral_loads.justification_code,
    srl_viral_loads.date_collected,
    health_facilities.name AS facility,
    county.name AS county,
    sub_county.name AS sub_county,
    service.name AS service,
    unit.name AS unit,
    srl_viral_loads.created_at,
    srl_viral_loads.updated_at
   FROM (((((srl_viral_loads
     LEFT JOIN health_facilities ON ((srl_viral_loads.facility = health_facilities.code)))
     LEFT JOIN unit ON ((unit.id = health_facilities.unit_id)))
     LEFT JOIN service ON ((service.id = unit.service_id)))
     LEFT JOIN sub_county ON ((sub_county.id = health_facilities."Sub_County_ID")))
     LEFT JOIN county ON ((county.id = sub_county.county_id)));

-- ----------------------------
-- View structure for srl_eid_summary
-- ----------------------------
DROP VIEW IF EXISTS "public"."srl_eid_summary";
CREATE VIEW "public"."srl_eid_summary" AS  SELECT srl_eid.id,
    srl_eid.hein_number,
    srl_eid.patient_name,
    srl_eid.lab_name,
    srl_eid.prophylaxis_code,
    srl_eid.entry_point,
    srl_eid.date_collected,
    health_facilities.unit_id AS partner_id,
    health_facilities.name AS facility,
    county.name AS county,
    sub_county.name AS sub_county,
    service.name AS service,
    unit.name AS unit,
    srl_eid.created_at,
    srl_eid.updated_at
   FROM (((((srl_eid
     LEFT JOIN health_facilities ON ((srl_eid.facility = health_facilities.code)))
     LEFT JOIN unit ON ((unit.id = health_facilities.unit_id)))
     LEFT JOIN service ON ((service.id = unit.service_id)))
     LEFT JOIN sub_county ON ((sub_county.id = health_facilities."Sub_County_ID")))
     LEFT JOIN county ON ((county.id = sub_county.county_id)));

-- ----------------------------
-- View structure for il_facilities_summary
-- ----------------------------
DROP VIEW IF EXISTS "public"."il_facilities_summary";
CREATE VIEW "public"."il_facilities_summary" AS  SELECT health_facilities.code AS mfl_code,
    health_facilities.name AS facility,
    sub_county.name AS sub_county,
    county.name AS county,
        CASE
            WHEN (health_facilities.unit_id IS NOT NULL) THEN unit.name
            ELSE 'NONE'::character varying
        END AS unit,
        CASE
            WHEN (unit.service_id IS NOT NULL) THEN service.name
            ELSE 'NONE'::character varying
        END AS service,
    (il_facilities.created_at)::date AS activated
   FROM (((((il_facilities
     JOIN health_facilities ON ((health_facilities.code = il_facilities.mfl_code)))
     JOIN sub_county ON ((sub_county.id = health_facilities."Sub_County_ID")))
     JOIN county ON ((county.id = sub_county.county_id)))
     JOIN unit ON ((health_facilities.unit_id = unit.id)))
     JOIN service ON ((service.id = unit.service_id)));

-- ----------------------------
-- View structure for facilities_summary
-- ----------------------------
DROP VIEW IF EXISTS "public"."facilities_summary";
CREATE VIEW "public"."facilities_summary" AS  SELECT health_facilities.code AS mfl,
    health_facilities.name,
    unit.name AS unit,
    service.name AS service,
    sub_county.name AS sub_county,
    county.name AS county,
    count(results.id) AS results_sent,
    max(results.date_sent) AS last_sent_date
   FROM (((((health_facilities
     LEFT JOIN unit ON ((unit.id = health_facilities.unit_id)))
     LEFT JOIN service ON ((service.id = unit.service_id)))
     LEFT JOIN results ON ((results.mfl_code = health_facilities.code)))
     LEFT JOIN sub_county ON ((sub_county.id = health_facilities."Sub_County_ID")))
     LEFT JOIN county ON ((county.id = sub_county.county_id)))
  GROUP BY health_facilities.code, health_facilities.name, service.name, unit.name, sub_county.name, county.name;

-- ----------------------------
-- View structure for summary
-- ----------------------------
DROP VIEW IF EXISTS "public"."summary";
CREATE VIEW "public"."summary" AS  SELECT results.id,
    results.result_content,
    results.kdod_number AS client_id,
        CASE
            WHEN (health_facilities.unit_id IS NULL) THEN 'Empty'::character varying
            ELSE unit.name
        END AS unit,
        CASE
            WHEN (unit.service_id IS NULL) THEN 'Empty'::character varying
            ELSE service.name
        END AS service,
    county.name AS county,
    sub_county.name AS sub_county,
    health_facilities.name AS facility,
        CASE
            WHEN (health_facilities.lat IS NULL) THEN 'NAN'::character varying
            ELSE health_facilities.lat
        END AS lat,
        CASE
            WHEN (health_facilities.lng IS NULL) THEN 'NAN'::character varying
            ELSE health_facilities.lng
        END AS lng,
        CASE
            WHEN ((results.result_type)::text = '1'::text) THEN 'Viral Load'::text
            WHEN ((results.result_type)::text = '2'::text) THEN 'EID'::text
            ELSE 'Indeterminate'::text
        END AS result_type,
        CASE
            WHEN (results.data_key = 1) THEN 'Suppressed'::text
            WHEN (results.data_key = 2) THEN 'Unsuppresed'::text
            WHEN (results.data_key = 3) THEN 'Invalid'::text
            WHEN (results.data_key = 4) THEN 'Negative'::text
            WHEN (results.data_key = 5) THEN 'Positive'::text
            WHEN (results.data_key = 6) THEN 'Invalid'::text
            ELSE 'Indeterminate'::text
        END AS data_key,
        CASE
            WHEN ((results.data_key = 3) OR (results.data_key = 6)) THEN 'No'::text
            ELSE 'Yes'::text
        END AS isvalid,
        CASE
            WHEN ((results.gender)::text = 'F'::text) THEN 'Female'::text
            WHEN ((results.gender)::text = 'M'::text) THEN 'Male'::text
            ELSE 'Not Available'::text
        END AS gender,
        CASE
            WHEN (results.age IS NOT NULL) THEN results.age
            ELSE 'Not Available'::character varying
        END AS age,
        CASE
            WHEN ((results.result_type)::text = '2'::text) THEN
            CASE
                WHEN ((results.age)::text > '0'::text) THEN
                CASE
                    WHEN ((results.age)::text < '2'::text) THEN 'less than 2 Months'::text
                    WHEN (('2'::text <= (results.age)::text) AND ((results.age)::text < '9'::text)) THEN '2-9 Months'::text
                    WHEN (('9'::text <= (results.age)::text) AND ((results.age)::text < '12'::text)) THEN '9-12 Months'::text
                    WHEN (('12'::text <= (results.age)::text) AND ((results.age)::text < '24'::text)) THEN '12-24 Months'::text
                    WHEN ((results.age)::text > '24'::text) THEN '> 24 Months'::text
                    ELSE 'No Data'::text
                END
                ELSE 'No Data'::text
            END
            ELSE
            CASE
                WHEN (results.age IS NOT NULL) THEN
                CASE
                    WHEN ((results.age)::text < '2'::text) THEN '< 2 Years'::text
                    WHEN (('2'::text <= (results.age)::text) AND ((results.age)::text < '10'::text)) THEN '2-9 Years'::text
                    WHEN (('10'::text <= (results.age)::text) AND ((results.age)::text < '15'::text)) THEN '10-14 Years'::text
                    WHEN (('15'::text <= (results.age)::text) AND ((results.age)::text < '20'::text)) THEN '15-19 Years'::text
                    WHEN (('20'::text <= (results.age)::text) AND ((results.age)::text < '25'::text)) THEN '20-24 Years'::text
                    WHEN ((results.age)::text >= '25'::text) THEN '25+ Years'::text
                    ELSE NULL::text
                END
                ELSE 'No Data'::text
            END
        END AS age_group,
        CASE
            WHEN (results.date_collected IS NULL) THEN 'Empty'::character varying
            ELSE results.date_collected
        END AS date_collected,
    results.date_sent,
    results.date_delivered,
    results.date_read,
        CASE
            WHEN ((results.date_collected IS NULL) OR ((results.date_collected)::text ~~ '%000%'::text)) THEN 'NAN'::text
            ELSE (((results.date_sent)::date - (results.date_collected)::date))::text
        END AS collected_sent_tat,
        CASE
            WHEN (results.date_read IS NULL) THEN 'NAN'::text
            ELSE (((results.date_read)::date - (results.date_sent)::date))::text
        END AS sent_read_tat,
        CASE
            WHEN ((results.date_collected IS NULL) OR ((results.date_collected)::text ~~ '%000%'::text) OR (results.date_read IS NULL)) THEN 'NAN'::text
            ELSE (((results.date_read)::date - (results.date_collected)::date))::text
        END AS overall_tat,
    results.created_at AS date_received_by_mlab,
    results.updated_at AS updated
   FROM (((((results
     JOIN health_facilities ON ((results.mfl_code = health_facilities.code)))
     LEFT JOIN unit ON ((health_facilities.unit_id = unit.id)))
     LEFT JOIN service ON ((service.id = unit.service_id)))
     JOIN sub_county ON ((sub_county.id = health_facilities."Sub_County_ID")))
     JOIN county ON ((county.id = sub_county.county_id)))
  WHERE (health_facilities.code IN ( SELECT facilities_summary.mfl
           FROM facilities_summary));

-- ----------------------------
-- View structure for srl_hts_summary
-- ----------------------------
DROP VIEW IF EXISTS "public"."srl_hts_summary";
CREATE VIEW "public"."srl_hts_summary" AS  SELECT srl_hts.id,
    srl_hts.sample_number,
    srl_hts.client_name,
    srl_hts.dob,
    srl_hts.selected_sex AS gender,
    srl_hts.telephone,
    srl_hts.test_date,
    srl_hts.selected_delivery_point,
    srl_hts.selected_test_kit1,
    srl_hts.lot_number1,
    srl_hts.expiry_date1,
    srl_hts.selected_test_kit2,
    srl_hts.lot_number2,
    srl_hts.expiry_date2,
    srl_hts.selected_final_result,
    srl_hts.sample_tester_name,
    srl_hts.dbs_date,
    srl_hts.dbs_dispatch_date,
    srl_hts.requesting_provider,
    srl_hts.lab_id,
    srl_hts.lab_name,
    health_facilities.name AS facility,
    county.name AS county,
    sub_county.name AS sub_county,
    service.name AS service,
    unit.name AS unit,
    srl_hts.created_at,
    srl_hts.updated_at
   FROM (((((srl_hts
     LEFT JOIN health_facilities ON ((srl_hts.facility = health_facilities.code)))
     LEFT JOIN unit ON ((unit.id = health_facilities.unit_id)))
     LEFT JOIN service ON ((service.id = unit.service_id)))
     LEFT JOIN sub_county ON ((sub_county.id = health_facilities."Sub_County_ID")))
     LEFT JOIN county ON ((county.id = sub_county.county_id)));

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."api_users_id_seq"', 9, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."clients_id_seq"', 13, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."health_facilities_id_seq"', 13785, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."hts_results_hts_result_id_seq"', 3151, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."hts_results_id_seq"', 28, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."il_facilities_id_seq"', 121, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."inbox2_id_seq"', 120092, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."inbox_id_seq"', 95546, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."oauth_clients_id_seq"', 7, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."oauth_personal_access_clients_id_seq"', 5, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."partner_id_seq"', 72, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."results_id_seq"', 3746807, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."send_log_id_seq"', 343076, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."sms_gateway_id_seq"
OWNED BY "public"."sms_gateway"."id";
SELECT setval('"public"."sms_gateway_id_seq"', 20187, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."srl_eid_id_seq"', 13, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."srl_hts_id_seq"', 4, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."srl_viral_loads_id_seq"', 191, true);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."tbresult_id_seq"', 14, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
SELECT setval('"public"."users_id_seq"', 813, true);

-- ----------------------------
-- Uniques structure for table health_facilities
-- ----------------------------
ALTER TABLE "public"."health_facilities" ADD CONSTRAINT "health_facilities_code_key" UNIQUE ("code");

-- ----------------------------
-- Uniques structure for table health_facilities_old
-- ----------------------------
ALTER TABLE "public"."health_facilities_old" ADD CONSTRAINT "health_facilities_copy1_code_key" UNIQUE ("code");

-- ----------------------------
-- Primary Key structure for table inbox
-- ----------------------------
ALTER TABLE "public"."inbox" ADD CONSTRAINT "inbox_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table results
-- ----------------------------
CREATE INDEX "results_created_at_idx" ON "public"."results" USING btree (
  "created_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
);
CREATE INDEX "results_data_key_idx" ON "public"."results" USING btree (
  "data_key" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "results_date_collected_idx" ON "public"."results" USING btree (
  "date_collected" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE INDEX "results_date_sent_idx" ON "public"."results" USING btree (
  "date_sent" "pg_catalog"."timestamp_ops" ASC NULLS LAST
);
CREATE INDEX "results_gender_idx" ON "public"."results" USING btree (
  "gender" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);
CREATE UNIQUE INDEX "results_id_idx" ON "public"."results" USING btree (
  "id" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "results_mfl_code_idx" ON "public"."results" USING btree (
  "mfl_code" "pg_catalog"."int4_ops" ASC NULLS LAST
);
CREATE INDEX "results_result_type_idx" ON "public"."results" USING btree (
  "result_type" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table results
-- ----------------------------
ALTER TABLE "public"."results" ADD CONSTRAINT "results_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table sms_gateway
-- ----------------------------
ALTER TABLE "public"."sms_gateway" ADD CONSTRAINT "sms_gateway_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table clients
-- ----------------------------
ALTER TABLE "public"."clients" ADD CONSTRAINT "clients_facility_id_fkey" FOREIGN KEY ("facility_id") REFERENCES "public"."health_facilities" ("code") ON DELETE CASCADE ON UPDATE CASCADE;

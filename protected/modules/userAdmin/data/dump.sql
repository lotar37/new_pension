--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- Name: auth; Type: SCHEMA; Schema: -; Owner: pens
--

CREATE SCHEMA auth;


ALTER SCHEMA auth OWNER TO pens;

SET search_path = auth, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: AuthAssignment; Type: TABLE; Schema: auth; Owner: pens; Tablespace: 
--

CREATE TABLE "AuthAssignment" (
    itemname character varying(64) NOT NULL,
    userid character varying(64) NOT NULL,
    bizrule text,
    data text
);


ALTER TABLE auth."AuthAssignment" OWNER TO pens;

--
-- Name: AuthItem; Type: TABLE; Schema: auth; Owner: pens; Tablespace: 
--

CREATE TABLE "AuthItem" (
    name character varying(64) NOT NULL,
    type integer NOT NULL,
    description text,
    bizrule text,
    data text
);


ALTER TABLE auth."AuthItem" OWNER TO pens;

--
-- Name: AuthItemChild; Type: TABLE; Schema: auth; Owner: pens; Tablespace: 
--

CREATE TABLE "AuthItemChild" (
    parent character varying(64) NOT NULL,
    child character varying(64) NOT NULL
);


ALTER TABLE auth."AuthItemChild" OWNER TO pens;

--
-- Name: users; Type: TABLE; Schema: auth; Owner: adm; Tablespace: 
--

CREATE TABLE users (
    id integer NOT NULL,
    username character varying NOT NULL,
    password character varying,
    system integer DEFAULT 0 NOT NULL,
    connect_time timestamp(0) with time zone,
    create_time timestamp(0) with time zone DEFAULT now() NOT NULL,
    title character varying NOT NULL,
    CONSTRAINT users_name_check CHECK ((btrim((username)::text) <> ''::text)),
    CONSTRAINT users_system_check CHECK ((system = ANY (ARRAY[0, 1]))),
    CONSTRAINT users_title_check CHECK ((btrim((title)::text) <> ''::text))
);


ALTER TABLE auth.users OWNER TO adm;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: auth; Owner: adm
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE auth.users_id_seq OWNER TO adm;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: auth; Owner: adm
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: auth; Owner: adm
--

SELECT pg_catalog.setval('users_id_seq', 7, true);


--
-- Name: id; Type: DEFAULT; Schema: auth; Owner: adm
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Data for Name: AuthAssignment; Type: TABLE DATA; Schema: auth; Owner: pens
--

INSERT INTO "AuthAssignment" VALUES ('terminatedCases', 'admin', NULL, 'N;');
INSERT INTO "AuthAssignment" VALUES ('userAdmin', 'admin', NULL, 'N;');


--
-- Data for Name: AuthItem; Type: TABLE DATA; Schema: auth; Owner: pens
--

INSERT INTO "AuthItem" VALUES ('userAdmin', 1, 'Администратор пользователей', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('administrator', 1, 'Администратор БД', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('readOnly', 1, 'Правa на просмотр', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('activeCases', 1, 'Действующие дела', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('terminatedCases', 1, 'Прекращенные дела', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('spetzPosobie', 1, 'Специальное пособие', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('naznachPens', 1, 'Назначение пенсий', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('compensOzdorov', 1, 'Компенсации на оздоровление (6+3)', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('putevkiCo', 1, 'Выдача путевок и компенсаций за них инвалидам', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('compensProdtovar', 1, 'Компенсации на приобретение продтоваров', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('vidachaMatpomosh', 1, 'Выдача материальной помощи', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('vidachaBlankov', 1, 'Выдача удостоверений и прочих бланков', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('modifPereraschet', 1, 'Модификация справочника перерасчетов', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('ritual', 1, 'Ритуальные услуги', NULL, 'N;');
INSERT INTO "AuthItem" VALUES ('doplataSotsnorm', 1, 'Назначение доплат до соцнормы', NULL, 'N;');


--
-- Data for Name: AuthItemChild; Type: TABLE DATA; Schema: auth; Owner: pens
--



--
-- Data for Name: users; Type: TABLE DATA; Schema: auth; Owner: adm
--

INSERT INTO users VALUES (7, 'demo', '$2y$13$ZRsPjMOlvSF6pECgozsNju//8bV6xu26NJF3xPxRLDiF6.CPFItlq', 0, '2015-05-26 11:24:19+04', '2015-05-23 06:32:56+04', 'Demo');
INSERT INTO users VALUES (1, 'admin', '$2y$13$HmHVtlJGU.jtuEF5oZcmPefmhcoUQQjyveNGYA9dKwWSt9kI.TvsC', 1, '2015-05-26 11:31:57+04', '2015-05-21 14:13:09+04', 'Administrator');


--
-- Name: AuthAssignment_pkey; Type: CONSTRAINT; Schema: auth; Owner: pens; Tablespace: 
--

ALTER TABLE ONLY "AuthAssignment"
    ADD CONSTRAINT "AuthAssignment_pkey" PRIMARY KEY (itemname, userid);


--
-- Name: AuthItemChild_pkey; Type: CONSTRAINT; Schema: auth; Owner: pens; Tablespace: 
--

ALTER TABLE ONLY "AuthItemChild"
    ADD CONSTRAINT "AuthItemChild_pkey" PRIMARY KEY (parent, child);


--
-- Name: AuthItem_pkey; Type: CONSTRAINT; Schema: auth; Owner: pens; Tablespace: 
--

ALTER TABLE ONLY "AuthItem"
    ADD CONSTRAINT "AuthItem_pkey" PRIMARY KEY (name);


--
-- Name: users_name_key; Type: CONSTRAINT; Schema: auth; Owner: adm; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_name_key UNIQUE (username);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: auth; Owner: adm; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: users_title_key; Type: CONSTRAINT; Schema: auth; Owner: adm; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_title_key UNIQUE (title);


--
-- Name: AuthAssignment_itemname_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: pens
--

ALTER TABLE ONLY "AuthAssignment"
    ADD CONSTRAINT "AuthAssignment_itemname_fkey" FOREIGN KEY (itemname) REFERENCES "AuthItem"(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: AuthItemChild_child_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: pens
--

ALTER TABLE ONLY "AuthItemChild"
    ADD CONSTRAINT "AuthItemChild_child_fkey" FOREIGN KEY (child) REFERENCES "AuthItem"(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: AuthItemChild_parent_fkey; Type: FK CONSTRAINT; Schema: auth; Owner: pens
--

ALTER TABLE ONLY "AuthItemChild"
    ADD CONSTRAINT "AuthItemChild_parent_fkey" FOREIGN KEY (parent) REFERENCES "AuthItem"(name) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--


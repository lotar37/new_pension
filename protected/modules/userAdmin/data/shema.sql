set search_path to auth;
CREATE TABLE users 
(
     id              serial PRIMARY KEY
    ,username            varchar NOT NULL UNIQUE CHECK (trim(username) != '') 
    ,title            varchar NOT NULL UNIQUE CHECK (trim(title) != '') 
--    ,type        	 varchar NOT NULL CHECK (type = 'role' OR type = 'user' OR type = 'capab') 
    ,password        varchar
    ,system          integer NOT NULL DEFAULT 0 CHECK (system IN (0, 1)) -- признак системной записи
--    ,owner           integer NOT NULL DEFAULT 0 CHECK (owner IN (0, 1))  -- признак владельца (должен быть только один владелец)
    ,connect_time 	 timestamp(0) with time zone
    ,create_time   	 timestamp(0) with time zone NOT NULL DEFAULT now()
);

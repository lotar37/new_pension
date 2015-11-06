-- create a schema named "audit"
CREATE schema audit;
REVOKE CREATE ON schema audit FROM public;
set search_path to audit;

create or replace view sys_tables as
  SELECT  table_schema, table_name, obj_description((table_schema||'."'||table_name||'"')::regclass) as comment
    FROM information_schema.tables
    WHERE table_type = 'BASE TABLE' AND table_schema NOT IN ('pg_catalog', 'information_schema') ;

create or replace view sys_tab_columns as
  SELECT table_schema, table_name, column_name, ordinal_position, data_type, col_description((table_schema||'."'||table_name||'"')::regclass, ordinal_position::int) as comment
    FROM information_schema.columns
    where table_schema||table_name in (select table_schema||table_name from sys_tables);

------------------------------
drop table logged_sessions cascade;
create table logged_sessions
(
	id			serial primary key,
	pid			int not null default pg_backend_pid(),
    user_name	varchar(64),
	begin_time	timestamp not null default now(),
	end_time	timestamp
);
--insert into logged_sessions (id,pid,username,begin_time,end_time)values(0,0,'undefined','1.1.2015','1.1.2015'); 

drop table logged_actions cascade;
CREATE TABLE logged_actions 
(
	id	serial	primary key,
	id_session	integer not null references logged_sessions,
    schema_name	varchar(32) NOT NULL,
    table_name	varchar(32) NOT NULL,
    pk_name		varchar,
    pk_val		varchar,
--    user_name	varchar(64),
    action_tstamp	timestamp WITH time zone NOT NULL DEFAULT current_timestamp,
    action		varchar(1) NOT NULL CHECK (action IN ('I','D','U')),
    query		text
);

REVOKE ALL ON logged_values FROM public;


drop table logged_values;
CREATE TABLE logged_values 
(
	id_action	integer not null references logged_actions,
	field_name	varchar(32),
    old_data	varchar,
    new_data	varchar
);
 
REVOKE ALL ON logged_values FROM public;
 
-- You may wish to use different permissions; this lets anybody
-- see the full audit data. In Pg 9.0 and above you can use column
-- permissions for fine-grained control.
--GRANT SELECT ON logged_actions TO public;
 
CREATE INDEX logged_actions_schema_table_idx ON logged_actions(((schema_name||'.'||table_name)::TEXT));

CREATE INDEX logged_actions_action_tstamp_idx ON logged_actions(action_tstamp);
 
CREATE INDEX logged_actions_action_idx ON logged_actions(action);
 

---------- --------------------

create or replace view audit_actions as
	select a.*, case action when 'I' then 'Добавление' when 'U' then 'Изменение' when 'D' then 'Удаление' end as action1, coalesce(comment, '('||a.table_name||')') as table_comment from audit.logged_actions as a
	left join audit.sys_tables as t on (t.table_name=a.table_name and t.table_schema=a.schema_name); 

create or replace view audit_values as
	select a1.*, coalesce(comment, '('||field_name||')') as column_comment from (
		select v.*, table_name, schema_name from audit.logged_values as v, audit.logged_actions as a where a.id=v.id_action) as a1
	left join audit.sys_tab_columns as c on (a1.table_name=c.table_name and c.table_schema=a1.schema_name and c.column_name=a1.field_name); 

create or replace view audit_1 as
select --*
coalesce(title, user_name) as user_name, s.id as id_session, begin_time, end_time, id_action, a.table_name, table_comment, pk_name, pk_val, action_tstamp, action, field_name, column_comment, old_data, new_data
 from audit.logged_sessions as s
left join 
(
	select --*
		id as id_action, a1.table_name, table_comment, pk_name, pk_val, action_tstamp, action, action1, field_name, column_comment, old_data, new_data, id_session
		from audit.audit_actions as a1
	left join audit.audit_values as v on (v.id_action=a1.id)
) as a on (a.id_session=s.id)
left join auth.users as au on(user_name=username)
order by s.id, a.id_action



--
-- Now, define the actual trigger function:
--

CREATE OR REPLACE FUNCTION close_session() RETURNS int AS $body$
DECLARE
	k int;
BEGIN
	update audit.logged_sessions
		set end_time=now()
		where pid=pg_backend_pid() and end_time is null;
	return 1;
END;
$body$
LANGUAGE plpgsql
SECURITY DEFINER;

--
CREATE OR REPLACE FUNCTION check_session(int, text) RETURNS int AS $body$
DECLARE
	k int;
	u text;
BEGIN
	update audit.logged_sessions
		set end_time=now()
		where age(begin_time)>interval '1 day' and end_time is null;
	begin
		select id, user_name
			into strict k, u
			from audit.logged_sessions
			where pid=$1 and age(begin_time)<interval '1 day' and end_time is null;
		if $2 <> session_user then
			u := $2;
		else
			u := 'noapp:'||session_user;
		end if;
		raise notice '[session][update] u: % , k: % ', u, k;
		update audit.logged_sessions
			set pid=pg_backend_pid(), user_name = u
			where id=k;
	exception
		when no_data_found then
			raise notice '[session][insert] username: % ', $2;
			if $2 <> session_user then
				u := $2;
			else
				u := 'noapp:'||$2;
			end if;
			insert into audit.logged_sessions (user_name) values (u);
	end;
	return pg_backend_pid();
		
END;
$body$
LANGUAGE plpgsql
SECURITY DEFINER;
	
--	
CREATE OR REPLACE FUNCTION audit() RETURNS TRIGGER AS $body$
DECLARE
	r text;
	r1 text;
	r2 text;
	o text[];
	n text[];
	i int;
	k int;
	s int;
	p int;
	pk_n text;
	pk_v text;
	pks text[];
	pksv text[];
BEGIN
	begin
		select id
			into strict s
			from audit.logged_sessions
			where pid = pg_backend_pid();
	exception when no_data_found then
		select audit.check_session(pg_backend_pid(), session_user)
			into p;
		select id
			into strict s
			from audit.logged_sessions
			where pid = p;
	end;
	SELECT array_agg(column_name::text)
		into pks
		FROM INFORMATION_SCHEMA.CONSTRAINT_COLUMN_USAGE
		where table_schema=TG_TABLE_SCHEMA and table_name=TG_TABLE_NAME and constraint_name=TG_TABLE_NAME||'_pkey';
	pk_n:= trim('{}' from array_to_string(pks,','));
	raise notice 'pk: %', pk_n;
	IF (TG_OP = 'UPDATE') THEN

		i:=1; pksv:=null;
		for r1 in select unnest(pks) loop
			execute 'select $1.'||r1 into r2 using new;
			pksv[i]:=''''||r2||'''';
			i:=i+1;
			raise notice 'pkv: % -> %', r1, r2;
		end loop;
		pk_v := array_to_string(pksv,',');
--		execute 'select array_agg(select $.)'
--		for zz in array_agg(column_name///)
		o:=string_to_array(trim('()' from old::text),',');
		n:=string_to_array(trim('()' from new::text),',');
		INSERT INTO audit.logged_actions (id_session, schema_name,table_name,action,query,pk_name,pk_val) 
			select s, TG_TABLE_SCHEMA::TEXT,TG_TABLE_NAME::TEXT, 'U',current_query(), pk_n, pk_v
				from audit.logged_sessions
				where pid =  pg_backend_pid();
		select max(id) into k from audit.logged_actions;
		i:=1;
		for r in select attname from pg_attribute where attnum>0 and attrelid=(select relfilenode from pg_class where relname = lower(trim(TG_TABLE_NAME::TEXT)) and relkind = 'r')
		loop
			if o[i]<>n[i] then
				raise notice '% update %: % -> %', i, r, o[i], n[i];
				insert into audit.logged_values (id_action, field_name, old_data, new_data)
					values(k, r, o[i], n[i]);
			else
				raise notice '% skip %:>> %', i, r, o[i];
			end if;
			i:=i+1;
		end loop;
		RETURN NEW;
	ELSIF (TG_OP = 'INSERT') THEN
		n:=string_to_array(trim('()' from new::text),',');
		i:=1; pksv:=null;
		for r1 in select unnest(pks) loop
			execute 'select $1.'||r1 into r2 using new;
			pksv[i]:=''''||r2||'''';
			i:=i+1;
			raise notice 'pkv: % -> %', r1, r2;
		end loop;
		pk_v := array_to_string(pksv,',');
		INSERT INTO audit.logged_actions (id_session, schema_name,table_name,action,query,pk_name,pk_val)
			select s, TG_TABLE_SCHEMA::TEXT,TG_TABLE_NAME::TEXT,'I', current_query(), pk_n, pk_v
				from audit.logged_sessions
				where pid =  pg_backend_pid();
		select max(id) into k from audit.logged_actions;
		i:=1;
		for r in select attname from pg_attribute where attnum>0 and attrelid=(select relfilenode from pg_class where relname = lower(trim(TG_TABLE_NAME::TEXT)) and relkind = 'r')
		loop
		raise notice '% insert %: % ', i, r, n[i];
		insert into audit.logged_values (id_action, field_name, new_data)
			values(k, r, n[i]);
		i:=i+1;
		end loop;
		RETURN OLD;
	ELSIF (TG_OP = 'DELETE') THEN
		o:=string_to_array(trim('()' from old::text),',');
		i:=1; pksv:=null;
		for r1 in select unnest(pks) loop
			execute 'select $1.'||r1 into r2 using old;
			pksv[i]:=''''||r2||'''';
			i:=i+1;
			raise notice 'pkv: % -> %', r1, r2;
		end loop;
		pk_v := array_to_string(pksv,',');
		INSERT INTO audit.logged_actions (id_session, schema_name,table_name,action,query,pk_name,pk_val)
			select s, TG_TABLE_SCHEMA::TEXT,TG_TABLE_NAME::TEXT,'D', current_query(), pk_n, pk_v
				from audit.logged_sessions
				where pid =  pg_backend_pid();
		select max(id) into k from audit.logged_actions;
		i:=1;
		for r in select attname from pg_attribute where attnum>0 and attrelid=(select relfilenode from pg_class where relname = lower(trim(TG_TABLE_NAME::TEXT)) and relkind = 'r')
		loop
		raise notice '% delete %: % ', i, r, o[i];
		insert into audit.logged_values (id_action, field_name, old_data)
			values(k, r, o[i]);
		i:=i+1;
		end loop;
		RETURN OLD;
	ELSE
        RAISE WARNING '[AUDIT.IF_MODIFIED_FUNC] - Other action occurred: %, at %',TG_OP,now();
        RETURN NULL;
    END IF;
 
EXCEPTION
    WHEN data_exception THEN
        RAISE WARNING '[AUDIT.IF_MODIFIED_FUNC] - UDF ERROR [DATA EXCEPTION] - SQLSTATE: %, SQLERRM: %',SQLSTATE,SQLERRM;
        RETURN NULL;
    WHEN unique_violation THEN
        RAISE WARNING '[AUDIT.IF_MODIFIED_FUNC] - UDF ERROR [UNIQUE] - SQLSTATE: %, SQLERRM: %',SQLSTATE,SQLERRM;
        RETURN NULL;
    WHEN OTHERS THEN
        RAISE WARNING '[AUDIT.IF_MODIFIED_FUNC] - UDF ERROR [OTHER] - SQLSTATE: %, SQLERRM: %',SQLSTATE,SQLERRM;
        RETURN NULL;
END;
$body$
LANGUAGE plpgsql
SECURITY DEFINER;

--SET search_path = pg_catalog, audit;

--
-- To add this trigger to a table, use:
-- CREATE TRIGGER tablename_audit
-- AFTER INSERT OR UPDATE OR DELETE ON tablename
-- FOR EACH ROW EXECUTE PROCEDURE audit.if_modified_func();
-- CREATE TRIGGER t1_audit
-- AFTER INSERT OR UPDATE OR DELETE ON t1
-- FOR EACH ROW EXECUTE PROCEDURE audit.audit();
--
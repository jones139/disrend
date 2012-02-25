drop table queue;
create table queue (
                 jobNo serial primary key,
                 status int,
                 title varchar(256),
		 originLat float,
		 originLon float,
                 subDate timestamp,
                 statusDate timestamp,
		 renderer int,
                 xml varchar(10000)
                 );
grant all privileges on queue to www;
grant all privileges on queue_jobno_seq to www;

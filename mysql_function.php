//序列的实现利用自定义函数

DROP FUNCTION IF EXISTS currval;
DELIMITER //
create function currval(seq_name varchar(50)) returns int(11)
	reads sql DATA
	deterministic
begin
	declare value integer;
	set value=0;
	select current_value into value from sequence where name=seq_name;
	return value;
end//
DELIMITER ;

DROP FUNCTION IF EXISTS nextval;
DELIMITER //
create function nextval(seq_name varchar(50)) returns int(11)
	deterministic
begin
	update sequence set current_value=current_value+increment where name = seq_name;
	return currval(seq_name);
end //
DELIMITER ;

--table squence
drop table if exists sequence;
create table if not exists sequence(
	name varchar(50) not null,
	current_value int(11) not null,
	increment int(11) not null default '1'
)engine=myisam default charset=utf8 checksum=1 delay_key_write=1 row_format=dynamic comment='序列';
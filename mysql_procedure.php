//存储过程  通过存储过程和事件 实现对一个log已读记录的删除
create table log(
	id int(10) not null auto_increment,
	message varchar(200) null default '0',
	isread int(11) null default '0',
	primary key(`id`)
)collate=utf8_general_ci;

drop procedure utable;
delimiter //
create procedure utable(in $tname varchar(20),in $field varchar(10))
begin
set @sqlcmd = concat("delete from ",$tname," where ",$field,"=1");
prepare stmt from @sqlcmd;
execute stmt;
	deallocate prepare stmt;
end //
delimiter ;

//调度
create event if not exists event_log on schedule
every 100 second
on completion preserve
do call utable ('log','isread');

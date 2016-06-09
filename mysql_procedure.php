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

CREATE PROCEDURE `test`.`new_procedure` ()
BEGIN
-- 需要定义接收游标数据的变量 
  DECLARE a CHAR(16);
  -- 游标
  DECLARE cur CURSOR FOR SELECT i FROM test.t;
  -- 遍历数据结束标志
  DECLARE done INT DEFAULT FALSE;
  -- 将结束标志绑定到游标
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
  -- 打开游标
  OPEN cur;
  
  -- 开始循环
  read_loop: LOOP
    -- 提取游标里的数据，这里只有一个，多个的话也一样；
    FETCH cur INTO a;
    -- 声明结束的时候
    IF done THEN
      LEAVE read_loop;
    END IF;
    -- 这里做你想做的循环的事件

    INSERT INTO test.t VALUES (a);

  END LOOP;
  -- 关闭游标
  CLOSE cur;

END
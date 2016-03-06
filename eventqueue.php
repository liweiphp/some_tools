drop table if exists eventqueue;
create table eventqueue(
	qid int(11) not null auto_increment comment '消息序列',
	topic tinyint(4) not null comment '应用类别',
	status tinyint(4) not null comment '状态，标识0未分发，1分发',
	data varchar(1024) collate gbk_bin default null comment '消息内容',
	uid int(11) not null comment '动态生产者uid',
	create_date timestamp not null default current_timestamp on update current_timestamp comment '发送时间',
	primary key(qid)
) engine=memory charset=gbk comment'消息队列';

--发送消息procedure

drop procedure  if exists proc_msg_receiver_friend;
delimiter //
create definter="root@ " procedure proc_msg_receiver_friend;
comment "消息队列中好友分发存储过程"
begin
declare continue handler for sqlexception rollback;
start transaction;
inert into feed_broadcast 
select feed_id,ef.fri_uid,temp.create_date,app_id,src_type from (select * from eventqueue eq where eq.status=0 and eq.topic=1 order by create_date desc limit 100) temp,friend ef where temp.uid=ef.uid;
update eventqueue eq set status=1 where eq.status=0 and eq.topic=1 order by create_date desc limit 100;
commit;
end//
delimiter ;

--消息清除器
drop event if exists event_msg_cleaner;
delimiter //
create event event_msg_cleaner on schedule every 1 hour starts "2011-0101" on completion not preserve enable comment '删除已经处理的消息' do delete from ens_eventqueue where status=1;
delimiter //


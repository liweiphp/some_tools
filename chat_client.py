#coding:utf-8
import socket,select

sock1 = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
sock2 = socket.socket(socket.AF_INET,socket.SOCK_STREAM)

sock1.connect( ('192.168.199.200',3333) )
sock2.connect( ('192.168.199.200',3333) )

while True:
	rlist,wlist,elist = select.select([sock1,sock2],[],[],5)

	if [rlist,wlist,elist]==[[],[],[]]:
		print 'five second elapsed \n'
	else:
		for sock in rlist:
			print sock.recv(100)
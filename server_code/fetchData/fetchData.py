# python2
# bash: python mysqlconn.py

import mysql.connector
import random
from time import sleep, time
import datetime

REFRESH_INTERVAL = 2

def insert_value(tableName, amps, watts, wattHours,timestamp, nowTS):

	#print("{},{}").format(tableName, value1)
	
	print ("connecting to local")
	mydb = mysql.connector.connect(host='localhost', database='capstone_login', user='capstone_login',password='capstone_login')

	mycursor = mydb.cursor()

	print("making local query")
	sql = "INSERT INTO "+tableName+" (amps, watts, wattHours, nowTS) VALUES ("+str(amps)+", "+str(watts)+", "+str(wattHours)+", "+nowTS+" )"
	print("executing local query")
	mycursor.execute(sql)

	mydb.commit()




#get the ip addresses from the teams table
numTeams = 0
mydb = mysql.connector.connect(host='localhost', database='capstone_login', user='capstone_login',password='capstone_login')
mycursor = mydb.cursor()
sql = "SELECT * FROM `teams` ORDER BY id"
mycursor.execute(sql)
myresult = mycursor.fetchall()

ipList = []

for x in myresult:
	print(x)
	currIP = x[2]
	ipList.append(currIP)
	numTeams+=1
#store the numTeams
print("numTeams:{}".format(numTeams))

lastTSVal = [0]*numTeams

while(1):
	ts = time()
	nowTimestamp = datetime.datetime.fromtimestamp(ts).strftime("'%Y-%m-%d %H:%M:%S'")
	valuesToInsert = []
	#for each pi
	print ("looping over teams")
	for i in range(0,numTeams):
		currTableName = "team"+(str(i+1))+"_data"
		print("on team:{}".format(i))
		ip = ipList[i]

		print("Connecting to db")
		mydb = mysql.connector.connect(host=ip, database='capstone_pi_readings', user='capstone_pi_readings',password='capstone_pi_readings')
		mycursor = mydb.cursor()
		print ("About to make query")
		sql = "SELECT * FROM `data` ORDER BY id desc LIMIT 1"
		print("executing sql")
		mycursor.execute(sql)
		myresult = mycursor.fetchall()
		for x in myresult:
			print (x)
			
			amps = x[1]
			watts = x[2]
			wattHours = x[3]
			timestamp = x[4]
			valuesToInsert.append([amps,watts, wattHours, timestamp, nowTimestamp])

	print("Looping to insert locally")
	for i in range(0, numTeams):
		currTableName = "team"+(str(i+1))+"_data"
		print("calling insert for "+currTableName)
		insert_value(currTableName, valuesToInsert[i][0],valuesToInsert[i][1],valuesToInsert[i][2],valuesToInsert[i][3],valuesToInsert[i][4])

	#fetch the information from each team
	#if it is dont insert into table
	print ("Calculating endTS")
	endTS = time()

	sleepTime = (REFRESH_INTERVAL - (endTS-ts))
	if (sleepTime > 0):
			print ("Sleeping for:{}".format(sleepTime))
			sleep(sleepTime)
	else:
		print("Took longer than REFRESH_INTERVAL")

# python2
# bash: python mysqlconn.py

import mysql.connector
import random
from time import sleep, time
import datetime

energy = 0
dt = datetime.datetime.now()

sleep(2)

def insert_value(value1, tableName, nowVal):

	global dt 
	global energy
	print("{},{}").format(tableName, value1)
	energy += ((value1 * float((datetime.datetime.now() - dt).seconds)) + (float((datetime.datetime.now() - dt).microseconds) / 1000000.0)) / 3600.0
	dt = datetime.datetime.now()

	mydb = mysql.connector.connect(host='localhost', database='capstone_login', user='capstone_login',password='capstone_login')

	mycursor = mydb.cursor()

	sql = "INSERT INTO "+tableName+" (watts, amps, wattHours, nowTS) VALUES ("+str(value1)+", "+str(float(value1)/120)+", "+str(energy)+", "+nowVal+" )"
	mycursor.execute(sql)

	mydb.commit()

   
 

print("starting...")
count = 1
while(1):
    ts = time()
    nowTimestamp = datetime.datetime.fromtimestamp(ts).strftime("'%Y-%m-%d %H:%M:%S'")
    a = round(random.uniform(1.500, 10.900), 3)
    insert_value(a, "team1_data", nowTimestamp)
    a = round(random.uniform(1.500, 10.900), 3)
    insert_value(a, "team2_data", nowTimestamp)
    a = round(random.uniform(1.500, 10.900), 3)
    insert_value(a, "team3_data", nowTimestamp)
    a = round(random.uniform(1.500, 10.900), 3)
    #if (count % 17 != 0):
    insert_value(a, "team4_data", nowTimestamp)
    a = round(random.uniform(1.500, 10.900), 3)
    insert_value(a, "team5_data", nowTimestamp)
    a = round(random.uniform(1.500, 10.900), 3)
    insert_value(a, "team6_data", nowTimestamp)
    #else:
    #    print("I SLEEP")
    #    sleep(5)
    a = round(random.uniform(1.500, 10.900), 3)
    insert_value(a, "team7_data", nowTimestamp)
    a = round(random.uniform(1.500, 10.900), 3)
    insert_value(a, "team8_data", nowTimestamp)
    timeSleep = round(random.uniform(1.9, 2.1), 1)
    print("sleep ", timeSleep)
    sleep(timeSleep)
    count+=1
print("end")

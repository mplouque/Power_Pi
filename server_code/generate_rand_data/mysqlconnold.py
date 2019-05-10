# python2
# bash: python mysqlconn.py

import mysql.connector
import random
from time import sleep, time
import datetime


def insert_value(value1, tableName, nowVal):
    print(tableName, value1)
    mydb = mysql.connector.connect(host='localhost', database='capstone_login', user='capstone_login',password='capstone_login')

    mycursor = mydb.cursor()

    sql = "INSERT INTO "+tableName+" (watts, amps, nowTS) VALUES ("+str(value1)+", "+str(value1)+", "+nowVal+" )"
    mycursor.execute(sql)

    mydb.commit()

   
 

print("starting...")

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
    insert_value(a, "team4_data", nowTimestamp)
    a = round(random.uniform(1.500, 10.900), 3)
    insert_value(a, "team5_data", nowTimestamp)
    a = round(random.uniform(1.500, 10.900), 3)
    insert_value(a, "team6_data", nowTimestamp)
   # a = round(random.uniform(1.500, 10.900), 3)
   # insert_value(a, "team7_data", nowTimestamp)
   # a = round(random.uniform(1.500, 10.900), 3)
   # insert_value(a, "team8_data", nowTimestamp)
    timeSleep = round(random.uniform(1.9, 2.1), 1)
    print("sleep ", timeSleep)
    sleep(timeSleep)

print("end")

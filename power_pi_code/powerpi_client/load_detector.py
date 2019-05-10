import mysql.connector
import time
from gpiozero import LED

led = LED(17)

on = "on"
off = "off"

db = mysql.connector.connect(
        host="localhost",
        user="capstone_pi_readings",
        passwd="capstone_pi_readings",
        database="capstone_pi_readings",
)

last = ""

while (True):
    cursor = db.cursor()
    cursor.execute("select state from power_load ORDER BY id DESC LIMIT 1;")
    #db.commit()
    #myresult = cursor.fetchall()
    for x in cursor:#myresult:
        if last != x[0]:
            print "SSR has been turned " + x[0]
        last = x[0]
        if (x[0] == on):
            led.on()
        elif (x[0] == off):
            led.off()
        else:
            print "INVALID READING"            
    db.commit()
    #print "done printing"
    time.sleep(1)

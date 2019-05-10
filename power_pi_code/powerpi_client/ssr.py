from gpiozero import LED
from time import sleep

led = LED(17)


on = "on"
off = "off"



while True:
    userinput = raw_input("On or off: ")
    '''if userinput != on and userinput != off:
        print "Not a valid command!"''' 
    if userinput == on:
        led.on()
        print "Load turned on"
    elif userinput == off:
        led.off()
        print "Load turned off"
    else:
        print "Not a valid command"

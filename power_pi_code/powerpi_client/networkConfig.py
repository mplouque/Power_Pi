#!/usr/bin/env python

import subprocess

wifi_ssid = wifi_wpa2_key = wifi_ip = ''

# Address configuration

with open('/home/chrootjail/home/powerpi/config/wifi/address', 'rw+') as wifi_address_config:
    wifi_address = wifi_address_config.read().strip()
    location = wifi_address.find('#')
    if location != -1:
        wifi_address = wifi_address[:location].strip()
    if wifi_address != '':
        location = wifi_address.find('/')
        if location == -1:
            if wifi_address[:7] == '192.168':
                mask = '/24'
            else:
                mask = '/8'
            print 'Warning: Could not parse subnet mask in /home/chrootjail/home/powerpi/config/wifi/address, using "' + mask + '"'
            wifi_address = wifi_address + mask
        #subprocess.call(['ip', 'addr', 'flush', 'dev', 'wlan0'])
        #subprocess.call(['ip', 'addr', 'add', wifi_address, 'dev', 'wlan0'])

with open('/home/chrootjail/home/powerpi/config/wifi/gateway', 'rw+') as wifi_gateway_config:
    wifi_gateway = wifi_gateway_config.read().strip()
    location = wifi_gateway.find('#')
    if location != -1:
        wifi_gateway = wifi_gateway[:location].strip()

with open('/etc/dhcpcd.conf', 'rw+') as dhcpcd_config:
    found_wlan0_flag = False
    working_dhcpcd_config = dhcpcd_config.readlines()
    for i, line in enumerate(working_dhcpcd_config):
        location = line.find('interface wlan0')
        if location != -1:
            found_wlan0_flag = 3
        location = line.find('static ip_address=')
        if location != -1 and found_wlan0_flag > 0:
            print 'found string: static ip_address= on line: ' + line
            if wifi_address != '':
                working_dhcpcd_config[i] = line[:location+18].replace('#', '') + wifi_address + '\n'
                print 'un-commenting...'
                print working_dhcpcd_config[i]
            elif line.find('#') == -1 or line.find('#') > location:
                working_dhcpcd_config[i] = '#' + line
                print 'commenting...'
                print working_dhcpcd_config[i]
            found_wlan0_flag -= 1
        location = line.find('static routers=')
        if location != -1 and found_wlan0_flag > 0:
            if wifi_gateway != '':
                working_dhcpcd_config[i] = line[:location+15].replace('#', '') + wifi_gateway + '\n'
            elif line.find('#') == -1 or line.find('#') > location:
                working_dhcpcd_config[i] = '#' + line
            found_wlan0_flag -= 1
        location = line.find('static domain_name_servers=')
        if location != -1 and found_wlan0_flag > 0:
            if wifi_gateway != '':
                working_dhcpcd_config[i] = line[:location+27].replace('#', '') + wifi_gateway + ' 8.8.8.8 8.8.4.4\n'
            elif line.find('#') == -1 or line.find('#') > location:
                working_dhcpcd_config[i] = '#' + line

    dhcpcd_config.seek(0)
    dhcpcd_config.writelines(working_dhcpcd_config)
    dhcpcd_config.truncate()

# Wifi association configuration

with open('/home/chrootjail/home/powerpi/config/wifi/ssid', 'rw+') as wifi_ssid_config:
    wifi_ssid = wifi_ssid_config.read().strip()
    location = wifi_ssid.find('#')
    if location != -1:
        wifi_ssid = wifi_ssid[:location].strip()
    if wifi_ssid != '':
        wifi_ssid_config.seek(0)
        wifi_ssid_config.write('#' + wifi_ssid)
        wifi_ssid_config.truncate()
    else:
        print 'No new ssid or key given at /home/chrootjail/home/powerpi/config/wifi/ssid, so not changing wifi association settings.'
        quit()

with open('/home/chrootjail/home/powerpi/config/wifi/wpa2key', 'rw+') as wifi_wpa2_config:
    wifi_wpa2_key = wifi_wpa2_config.read()[:-1] # remove mandatory ending newline
    wifi_wpa2_config.seek(0)
    wifi_wpa2_config.truncate()

if wifi_wpa2_key == '':
    using_wifi_wpa2_key = False
else:
    using_wifi_wpa2_key = True

with open('/etc/wpa_supplicant/wpa_supplicant.conf', 'r') as wpa_conf_file:
    working_config = wpa_conf_file.readlines()

for i, line in enumerate(working_config):
    location = line.find('ssid=')
    if location != -1:
        working_config[i] = line[:location+5] + '"' + wifi_ssid + '"\n'
    else:
        location = line.find('psk=')
        if location != -1:
            if using_wifi_wpa2_key:
                working_config[i] = line[:location+4].replace('#','') + '"' + wifi_wpa2_key + '"\n'
            elif line[:location].find('#') == -1:
                working_config[i] = '#' + line
        else:
            location = line.find('key_mgmt=')
            if location != -1:
                if not using_wifi_wpa2_key:
                    working_config[i] = line[:location+9].replace('#','') + 'NONE\n'
                elif line[:location].find('#') == -1:
                    working_config[i] = '#' + line

with open('/etc/wpa_supplicant/wpa_supplicant.conf', 'rw+') as wpa_conf_file:
    wpa_conf_file.writelines(working_config)
    wpa_conf_file.truncate()

#subprocess.call(['ip', 'addr', 'flush', 'dev', 'wlan0'])
subprocess.call(['systemctl', 'restart', 'dhcpcd'])
#if wifi_address != '':
    #subprocess.call(['ip', 'addr', 'add', wifi_address, 'dev', 'wlan0'])


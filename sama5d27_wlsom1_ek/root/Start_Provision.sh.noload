#!/bin/sh
if ps | grep -q "wpa_supplicant"; then
	killall wpa_supplicant
fi

ifconfig wlan0 down

at now + 2 minutes -f /home/root/Start_AP.sh

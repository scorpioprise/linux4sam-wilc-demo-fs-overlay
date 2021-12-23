#!/bin/sh
if ps | grep -q "wpa_supplicant"; then
	killall wpa_supplicant
fi

ifconfig wlan0 down
/home/root/Start_AP.sh


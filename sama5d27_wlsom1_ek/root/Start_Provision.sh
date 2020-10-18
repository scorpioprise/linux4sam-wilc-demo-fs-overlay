#!/bin/sh
if ps | grep -q "wpa_supplicant"; then
	killall wpa_supplicant

ifconfig wlan0 down
./Start_AP


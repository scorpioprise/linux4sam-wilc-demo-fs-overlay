#!/bin/sh
echo "---------------------------------------------------"
echo "  #####  #######    #            "
echo " #     #    #      # #           "
echo "  #          #     #   #         "
echo "  #####     #    #     #         "
echo "       #    #    #######         "
echo " #     #    #    #     #         "
echo "  #####     #    #     #         "
echo "---------------------------------------------------"
echo " ######  ####### #     # ####### "
echo " #     # #       ##   ## #     # "
echo " #     # #       # # # # #     # "
echo " #     # #####   #  #  # #     # "
echo " #     # #       #     # #     # "
echo " #     # #       #     # #     # "
echo " ######  ####### #     # ####### "
echo "---------------------------------------------------"
echo "---------------------------------------------------"
                                 

if lsmod | grep -q "wilc_sdio" ; then
        echo "1.############## WILC-SDIO module is available ##############"
else
        echo "1.############## Inserting the wilc-sdio module ##############" 
        modprobe wilc-sdio 
        if lsmod | grep -q "wilc_sdio";  then
                echo "WILC-SDIO module insterted successfully"
        else
                echo "WILC-SDIO module insert failed"
        fi
fi

if test -f /etc/wpa_supplicant.conf; then
	if grep -q "ssid" /etc/wpa_supplicant.conf; then
		echo "Connecting to router:-" 
		sed -n "/ssid/p" /etc/wpa_supplicant.conf
		sleep 2
	else
		echo "Input the SSID of the router/AP"
		read newSsid
		echo "New SSID " $newSsid
		echo "Input the passphrase(if non-secured, enter 'NONE'"
		read passPhrase
		echo "New Passphrase " $passPhrase
		sed -i "s/{.*/& \n\tssid=\"$newSsid\"/gI" /etc/wpa_supplicant.conf
		if $passPhrase | grep -q "NONE"; then
			sed -i "s/\bkey_mgmt\b.*/\tkey_mgmt=\"NONE\"/gI" /etc/wpa_supplicant.conf
		else
			sed -i "s/ssid.*/& \n\tpsk=\"$passPhrase\"/gI" /etc/wpa_supplicant.conf
			sed -i "/key_mgmt/d" /etc/wpa_supplicant.conf
		fi

	fi
fi


echo "2.############## Connecting to configured AP ##############"
ifdown wlan0
ifup wlan0
echo "---------------------------------------------------"
echo "---------------------------------------------------"

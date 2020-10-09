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
        modprobe wilc-sdio > wilc-sdio_module.log
        if lsmod | grep -q "wilc_sdio";  then
                echo "WILC-SDIO module insterted successfully"
        else
                echo "WILC-SDIO module insert failed"
        fi
fi
echo "2.############## Connecting to configured AP ##############"
ifup wlan0
echo "---------------------------------------------------"
echo "---------------------------------------------------"


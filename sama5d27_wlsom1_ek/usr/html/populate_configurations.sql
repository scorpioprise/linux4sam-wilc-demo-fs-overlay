use wallbox;


INSERT IGNORE INTO configuration VALUES(0,'minimum_current_available_vehicle','float','1.0','Ampere','dsp', 'minima corrente in uscita al veicolo per considerare la colonnina in carica', 2);
INSERT IGNORE INTO configuration VALUES(1,'minimum_available_power','float','300.0','Watt','dsp', 'minima potenza misurata per ...', 2);
INSERT IGNORE INTO configuration VALUES(2,'rfid_validity_timeout','uint32_t','60000','msec','dsp', 'durata in stato di standby oltre la quale la colonnina esegue il logout', 2);
INSERT IGNORE INTO configuration VALUES(3,'rfid_swipe_validity_timeout','uint32_t','3000','msec','dsp', 'durata della procedura di validazione/aggiunta nuova card, entro la quale led lampeggiano veloci e viene richiesto di passare una nuova card sul lettore', 2);
INSERT IGNORE INTO configuration VALUES(4,'userstop_short_press','uint16_t','500','msec','dsp', 'durata pressione tasto per fine carica', 2);
INSERT IGNORE INTO configuration VALUES(5,'userstop_long_press','uint16_t','5000','msec','dsp', 'durata pressione tasto per reset allarmi', 2);
INSERT IGNORE INTO configuration VALUES(6,'userstop_verylong_press','uint16_t','10000','msec','dsp', 'durata pressione tasto per reset factory default', 2);
INSERT IGNORE INTO configuration VALUES(7,'led_light_on_time','uint16_t','1000','msec','dsp', 'durata led acceso in stato lampeggiante normale', 2);
INSERT IGNORE INTO configuration VALUES(8,'led_light_off_time','uint16_t','1000','msec','dsp', 'durata led spento in stato lampeggiante normale', 2);
INSERT IGNORE INTO configuration VALUES(9,'led_light_on_time_fast','uint16_t','150','msec','dsp', 'durata led acceso in stato lampeggiante veloce', 2);
INSERT IGNORE INTO configuration VALUES(10,'led_light_off_time_fast','uint16_t','150','msec','dsp', 'durata led spento in stato lampeggiante veloce', 2);
INSERT IGNORE INTO configuration VALUES(11,'short_circuit_current','float','100','Ampere','dsp', 'corrente minima per considerare corto circuito', 2);
INSERT IGNORE INTO configuration VALUES(13,'customer_username','string','','','microchip', 'nome utente colonnina (future)', 2);
INSERT IGNORE INTO configuration VALUES(14,'customer_password','string','','','microchip', 'password utente colonnina (future)', 2);
INSERT IGNORE INTO configuration VALUES(15,'facility_configuration_id','int','1','','dsp', 'identificativo della installazione (puo' essere condiviso da piu' colonnine) (future)', 2);
INSERT IGNORE INTO configuration VALUES(16,'builder_name','string','','','microchip', 'nome builder (future)', 2);
INSERT IGNORE INTO configuration VALUES(18,'unused_1','uint16_t','0x00','','microchip', '', 2);
INSERT IGNORE INTO configuration VALUES(19,'meter_power_rating','uint32_t','14000','Watt','dsp', 'potenza di impianto da contatore', 2);
INSERT IGNORE INTO configuration VALUES(20,'modbus_address','int','','','microchip', 'indirizzo modbus (future)', 2);
INSERT IGNORE INTO configuration VALUES(21,'activation_timestamp','uint32_t','','sec','dsp', 'data di attivazione (future)', 2);
INSERT IGNORE INTO configuration VALUES(22,'language','string','it-IT','','microchip', 'lingua configurata (future)', 2);
INSERT IGNORE INTO configuration VALUES(23,'polling_period_realtime_mqtt_data','int','5','sec','dsp', 'frequenza di invio messaggi mqtt verso cloud', 2);
INSERT IGNORE INTO configuration VALUES(25,'wallbox_id','string','','','microchip', 'Identificativo wallbox (future)', 2);
INSERT IGNORE INTO configuration VALUES(26,'wallbox_serial_number','string','','','microchip', 'serial number wallbox (future)', 2);
INSERT IGNORE INTO configuration VALUES(27,'wallbox_rated_power','uint32_t','14000','Watt','dsp', 'potenza di impianto da contatore', 2);
INSERT IGNORE INTO configuration VALUES(28,'max_temperature_on','float','60.0','celsius','dsp', 'temperatura oltre la quale generare allarme', 2);
INSERT IGNORE INTO configuration VALUES(29,'min_temperature_off','float','40.0','celsius','dsp', 'temperatura al di sotto la quale resettare allarme', 2);
INSERT IGNORE INTO configuration VALUES(30,'min_voltage','float','180.0','Volt','dsp', 'tensione di rete minima sotto la quale generare un allarme', 2);
INSERT IGNORE INTO configuration VALUES(31,'max_voltage','float','280.0','Volt','dsp', 'tensione di rete massima oltre la quale generare un allarme', 2);
INSERT IGNORE INTO configuration VALUES(32,'wallbox_connection_timeout','int','','sec','microchip', 'timeout wallbox (future)', 2);
INSERT IGNORE INTO configuration VALUES(33,'wallbox_modbus_address','int','','','microchip', 'indirizzo modbus walbox (future)', 2);
INSERT IGNORE INTO configuration VALUES(34,'wallbox_ocpp_server_ip_address','uint32_t','','IP','microchip', 'occp ip (future)', 2);
INSERT IGNORE INTO configuration VALUES(35,'wallbox_ocpp_ip_server_port','int','','IP','microchip', 'ocpp port (future)', 2);
INSERT IGNORE INTO configuration VALUES(36,'wallbox_ocpp_url_server','string','','url','microchip', 'ocpp url (future)', 2);
INSERT IGNORE INTO configuration VALUES(37,'powermeter_vehicle_baudrate','uint16_t','0','baud','dsp', 'powermeter baudrate, 0 per lasciare il default (9600) (todo)', 2);
INSERT IGNORE INTO configuration VALUES(38,'powermeter_domestic_baudrate','uint16_t','0','baud','dsp', 'powermeter baudrate, 0 per lasciare il default (9600) (todo)', 2);
INSERT IGNORE INTO configuration VALUES(39,'phase_is_triphase','bool','False','','dsp', 'forzatura modo di funzionamento colonnina (valido solo se force_phase è true)', 2);
INSERT IGNORE INTO configuration VALUES(40,'force_phase','bool','False','','dsp', 'se true forza la colonnina a funzionare in monofase/trifase a seconda del flag phase_is_triphase', 2);
INSERT IGNORE INTO configuration VALUES(41,'has_plug_lockengine','bool','True','','dsp', 'set modalità funzionamento senza motorino di chiusura cavo (valido solo se force_plug_lockengine true', 2);
INSERT IGNORE INTO configuration VALUES(42,'force_plug_lockengine','bool','False','','dsp', 'forzatura modalità funzionamento con/senza motorino di chiusura cavo secondo flag has_plug_lockengine', 2);
INSERT IGNORE INTO configuration VALUES(43,'has_rfid_reader','bool','True','','dsp', 'presenza rfid reader, se false colonnina funziona in modalità senza 'login'', 2);
INSERT IGNORE INTO configuration VALUES(44,'has_car_powermeter_mid','bool','True','','dsp', 'presenza powermeter veicolo, se false colonnina utilizza solo sensori di corrente', 2);
INSERT IGNORE INTO configuration VALUES(45,'has_domestic_powermeter','bool','False','','dsp', 'presenza powermeter connesso al contatore domestico, se false la colonnina non usa i dati di consumo domestico', 2);
INSERT IGNORE INTO configuration VALUES(46,'enable_fixed_power_inhibit_mid','bool','False','','dsp', 'set modalità funzionamento a potenza fissa (viene esclusa la lettura del powermeter domestico', 2);
INSERT IGNORE INTO configuration VALUES(47,'inverter_presence','bool','False','','dsp', "presenza di sistema di accumulo/inverter nell'impianto", 2);

describe configuration;
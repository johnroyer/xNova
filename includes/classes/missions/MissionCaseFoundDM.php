<?php

class MissionCaseFoundDM extends MissionFunctions
{
    const CHANCE = 30;
    const CHANCE_SHIP = 0.25;
    const MIN_FOUND = 423;
    const MAX_FOUND = 1278;
    const MAX_CHANCE = 50;

    function __construct($Fleet)
    {
        $this->_fleet   = $Fleet;
    }

    function TargetEvent()
    {
        $this->UpdateFleet('fleet_mess', 2);
        $this->SaveFleet();
    }

    function EndStayEvent()
    {
        global $LANG;
        $LNG            = $LANG->GetUserLang($this->_fleet['fleet_owner']);
        $chance         = mt_rand(0, 100);
        if ($chance <= min(self::MAX_CHANCE, (self::CHANCE + $this->_fleet['fleet_amount'] * self::CHANCE_SHIP))) {
            $FoundDark  = mt_rand(self::MIN_FOUND, self::MAX_FOUND);
            $this->UpdateFleet('fleet_resource_darkmatter', $FoundDark);
            $Message    = $LNG['sys_expe_found_dm_' . mt_rand(1, 3) . '_' . mt_rand(1, 2) . ''];
        } else {
            $Message    = $LNG['sys_expe_nothing_' . mt_rand(1, 9)];
        }
        $this->UpdateFleet('fleet_mess', 1);
        $this->SaveFleet();
        SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_stay'], 15, $LNG['sys_mess_tower'], $LNG['sys_expe_report'], $Message);
    }

    function ReturnEvent()
    {
        global $LANG;
        $LNG            = $LANG->GetUserLang($this->_fleet['fleet_owner']);
        if ($this->_fleet['fleet_resource_darkmatter'] > 0) {
            SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_time'], 15, $LNG['sys_mess_tower'], $LNG['sys_expe_report'], sprintf($LNG['sys_expe_back_home_with_dm'], $LNG['Darkmatter'], pretty_number($this->_fleet['fleet_resource_darkmatter']), $LNG['Darkmatter']));
            #$this->UpdateFleet('fleet_array', '220,0;');
        } else {
            SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_time'], 15, $LNG['sys_mess_tower'], $LNG['sys_expe_report'], $LNG['sys_expe_back_home_without_dm']);
        }
        $this->RestoreFleet();
    }
}

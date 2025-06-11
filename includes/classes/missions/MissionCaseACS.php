<?php

class MissionCaseACS extends MissionFunctions
{
    function __construct($Fleet)
    {
        $this->_fleet   = $Fleet;
    }

    function TargetEvent()
    {
        return;
    }

    function EndStayEvent()
    {
        return;
    }

    function ReturnEvent()
    {
        global $LANG;
        $LNG        = $LANG->GetUserLang($this->_fleet['fleet_owner']);

        $Message    = sprintf($LNG['sys_fleet_won'], $TargetName, GetTargetAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium'], pretty_number($this->_fleet['fleet_resource_norio']), $LNG['Norio']);
        SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_time'], 3, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);

        $this->RestoreFleet();
    }
}

<?php

class MissionCaseStayAlly extends MissionFunctions
{
    function __construct($Fleet)
    {
        $this->_fleet   = $Fleet;
    }

    function TargetEvent()
    {
        global $db, $LANG;
        $StartPlanet      = $db->uniquequery("SELECT name FROM " . PLANETS . " WHERE `id` = '" . $this->_fleet['fleet_start_id'] . "';");
        $StartName        = $StartPlanet['name'];
        $StartOwner       = $this->_fleet['fleet_owner'];

        $TargetPlanet     = $db->uniquequery("SELECT name FROM " . PLANETS . " WHERE `id` = '" . $this->_fleet['fleet_end_id'] . "';");
        $TargetName       = $TargetPlanet['name'];
        $TargetOwner      = $this->_fleet['fleet_target_owner'];

        $LNG              = $LANG->GetUserLang($this->_fleet['fleet_owner']);

        $Message = sprintf($LNG['sys_tran_mess_owner'], $TargetName, GetTargetAdressLink($this->_fleet, ''), $this->_fleet['fleet_resource_metal'], $LNG['Metal'], $this->_fleet['fleet_resource_crystal'], $LNG['Crystal'], $this->_fleet['fleet_resource_deuterium'], $LNG['Deuterium'], $this->_fleet['fleet_resource_norio'], $LNG['Norio']);
        SendSimpleMessage($StartOwner, 0, $this->_fleet['fleet_start_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_transport'], $Message);

        $Message = sprintf($LNG['sys_tran_mess_user'], $StartName, GetStartAdressLink($this->_fleet, ''), $TargetName, GetTargetAdressLink($this->_fleet, ''), $this->_fleet['fleet_resource_metal'], $LNG['Metal'], $this->_fleet['fleet_resource_crystal'], $LNG['Crystal'], $this->_fleet['fleet_resource_deuterium'], $LNG['Deuterium'], $this->_fleet['fleet_resource_norio'], $LNG['Norio']);
        SendSimpleMessage($TargetOwner, 0, $this->_fleet['fleet_start_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_transport'], $Message);

        $this->UpdateFleet('fleet_mess', 2);
        $this->SaveFleet();
    }

    function EndStayEvent()
    {
        $this->UpdateFleet('fleet_mess', 1);
        $this->SaveFleet();
    }

    function ReturnEvent()
    {
        global $LANG;
        $LNG                = $LANG->GetUserLang($this->_fleet['fleet_owner']);

        $Message            = sprintf($LNG['sys_tran_mess_back'], $StartName, GetStartAdressLink($this->_fleet, ''));
        SendSimpleMessage($this->_fleet['fleet_owner'], 0, $this->_fleet['fleet_end_time'], 5, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);

        $this->RestoreFleet();
    }
}

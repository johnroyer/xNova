<?php

if (!defined('INSIDE')) {
    die(header("location:../../"));
}

class FlyingFleetHandler
{
    function __construct($fleetquery)
    {
        global $db;
        $MissionsPattern    = array(
            1   => 'MissionCaseAttack',
            2   => 'MissionCaseACS',
            3   => 'MissionCaseTransport',
            4   => 'MissionCaseStay',
            5   => 'MissionCaseStayAlly',
            6   => 'MissionCaseSpy',
            7   => 'MissionCaseColonisation',
            8   => 'MissionCaseRecycling',
            9   => 'MissionCaseDestruction',
            10  => 'MissionCaseMIP',
            11  => 'MissionCaseFoundDM',
            15  => 'MissionCaseExpedition',
        );

        require_once(ROOT_PATH . 'includes/classes/class.MissionFunctions.php');
        while ($CurrentFleet = $db->fetch_array($fleetquery)) {
            if (!$this->IfFleetBusy($CurrentFleet['fleet_id'])) {
                continue;
            }

            if (!isset($GLOBALS['CONFIG'][$CurrentFleet['fleet_universe']])) {
                $GLOBALS['CONFIG'][$CurrentFleet['fleet_universe']] = $db->uniquequery("SELECT * FROM `" . CONFIG . "` WHERE `uni` = '" . $CurrentFleet['fleet_universe'] . "';");
            }

            require_once(ROOT_PATH . 'includes/classes/missions/' . $MissionsPattern[$CurrentFleet['fleet_mission']] . '.php');
            $Mission    = new $MissionsPattern[$CurrentFleet['fleet_mission']]($CurrentFleet);

            if ($CurrentFleet['fleet_mess'] == 0 && $CurrentFleet['fleet_start_time'] <= TIMESTAMP) {
                $Mission->TargetEvent();
            } elseif ($CurrentFleet['fleet_mess'] == 2 && $CurrentFleet['fleet_end_stay'] <= TIMESTAMP) {
                $Mission->EndStayEvent();
            } elseif ($CurrentFleet['fleet_mess'] == 1 && $CurrentFleet['fleet_end_time'] <= TIMESTAMP) {
                $Mission->ReturnEvent();
            }

            $Mission = null;
            unset($Mission);

            $db->query("UPDATE " . FLEETS . " SET `fleet_busy` = '0' WHERE `fleet_id` = '" . $CurrentFleet['fleet_id'] . "';");
        }
    }

    function IfFleetBusy($FleetID)
    {
        global $db;
        $FleetInfo  = $db->uniquequery("SELECT fleet_busy FROM " . FLEETS . " WHERE `fleet_id` = '" . $FleetID . "';");
        if ($FleetInfo['fleet_busy'] == 1) {
            return false;
        } else {
            $db->query("UPDATE " . FLEETS . " SET `fleet_busy` = '1' WHERE `fleet_id` = '" . $FleetID . "';");
            return true;
        }
    }
}

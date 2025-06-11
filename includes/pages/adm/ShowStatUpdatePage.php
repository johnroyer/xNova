<?php

if (!allowedTo(str_replace(array(dirname(__FILE__), '\\', '/', '.php'), '', __FILE__))) {
    exit;
}

function ShowStatUpdatePage()
{
    global $LNG;
    require_once(ROOT_PATH . 'includes/classes/class.statbuilder.php');
    $stat           = new statbuilder();
    $result         = $stat->MakeStats();
    $memory_p       = str_replace(array("%p", "%m"), $result['memory_peak'], $LNG['sb_top_memory']);
    $memory_e       = str_replace(array("%e", "%m"), $result['end_memory'], $LNG['sb_final_memory']);
    $memory_i       = str_replace(array("%i", "%m"), $result['initial_memory'], $LNG['sb_start_memory']);
    $stats_end_time = sprintf($LNG['sb_stats_update'], $result['totaltime']);
    $stats_sql      = sprintf($LNG['sb_sql_counts'], $result['sql_count']);

    update_config(array('stat_last_update' => $result['stats_time']), true);

    $template = new template();
    $template->message($LNG['sb_stats_updated'] . $stats_end_time . $memory_i . $memory_e . $memory_p . $stats_sql, false, 0, true);
}

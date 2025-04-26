<?php

/**
 * Query Monitor OPcache status
 *
 * @wordpress-plugin
 * Plugin Name:       Query Monitor OPcache status
 * Plugin URI:        https://github.com/szepeviktor/qm-opcache-status
 * Description:       Add OPcache status panel to Query Monitor
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Requires Plugins:  query-monitor
 * Author:            Viktor Szépe
 * Author URI:        https://github.com/szepeviktor
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

declare(strict_types=1);

namespace SzepeViktor\WordPress\QueryMonitor;

use QM_Collectors;

require_once __DIR__.'/src/Collector.php';
require_once __DIR__.'/src/Data.php';
require_once __DIR__.'/src/Output.php';

add_filter(
    'qm/collectors',
    static function (array $collectors): array
    {
        $collectors['opcache'] = new Collector();

        return $collectors;
    },
    20,
    1
);

add_filter(
    'qm/outputter/html',
    static function (array $output, QM_Collectors $collectors) {
        $collector = QM_Collectors::get('opcache');
        if ($collector) {
            $output['opcache'] = new Output($collector);
        }

        return $output;
    },
    10,
    2
);

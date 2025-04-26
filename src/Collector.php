<?php

declare(strict_types=1);

namespace SzepeViktor\WordPress\QueryMonitor;

use QM_Data;

class Collector extends \QM_DataCollector
{
    public $id = 'opcache';

    public function get_storage(): QM_Data
    {
        return new Data();
    }

    public function process(): void
    {
        $status = opcache_get_status();

        if ($status === false) {
            $this->data->opcache = ['OPcache' => 'not available'];
            return;
        }

        $status['scripts'] = count($status['scripts']);

        $this->data->opcache = $this->dot($status);
    }

    /**
     * @see https://github.com/laravel/framework/blob/12.x/src/Illuminate/Collections/Arr.php#L111
     */
    protected function dot(array $array, string $prepend = ''): array
    {
        $results = [];

        $flatten = function ($data, $prefix) use (&$results, &$flatten): void {
            foreach ($data as $key => $value) {
                $newKey = $prefix.$key;

                if (is_array($value) && ! empty($value)) {
                    $flatten($value, $newKey.'.');
                } else {
                    $results[$newKey] = $value;
                }
            }
        };

        $flatten($array, $prepend);

        return $results;
    }
}

<?php

declare(strict_types=1);

namespace SzepeViktor\WordPress\QueryMonitor;

use QM_Collector;

class Output extends \QM_Output_Html
{
    protected $collector;

    public function __construct(QM_Collector $collector)
    {
        parent::__construct($collector);
        add_filter('qm/output/menus', [$this, 'admin_menu'], 15, 1);
    }

    public function name(): string
    {
        return 'OPcache status';
    }

    public function output(): void
    {
        /** @var Collector $data */
        $data = $this->collector->get_data()->opcache;

        $this->before_non_tabular_output();

        echo '<table>';
        echo '<tbody>';

        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Name</th>';
        echo '<th scope="col">Value</th>';
        echo '</tr>';
        echo '</thead>';


        echo '<tbody>';
        echo '<tr>';

        foreach ($data as $name => $value) {
            echo '<tr>';
            echo '<th scope="row">'.esc_html($name).'</th>';
            echo '<td>';
            echo esc_html(is_bool($value) ? ($value ? 'TRUE' : 'FALSE') : $value);
            echo '</td>';
            echo '</tr>';
        }

        echo '</tr>';
        echo '</tbody>';
        echo '</table>';

        $this->after_non_tabular_output();
    }
}

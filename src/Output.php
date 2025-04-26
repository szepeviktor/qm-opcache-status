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

        $this->before_tabular_output();

        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">Name</th>';
        echo '<th scope="col">Value</th>';
        echo '</tr>';
        echo '</thead>';

        echo '<tbody>';

        foreach ($data as $name => $value) {
            echo '<tr>';
            echo '<th scope="row"><code>'.esc_html($name).'<code></th>';
            echo '<td>';
            echo esc_html(is_bool($value) ? ($value ? 'TRUE' : 'FALSE') : (is_int($value) ? number_format_i18n($value) : $value));
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';

        $this->after_tabular_output();
    }
}

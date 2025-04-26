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
            echo '<th scope="row"><code>';
            echo esc_html($name);
            echo '<code></th>';
            echo '<td>';
            echo esc_html($this->formatValue($value));
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';

        $this->after_tabular_output();
    }

    protected function formatValue($value): string
    {
        switch (true) {
            case is_bool($value):
                return $value ? 'TRUE' : 'FALSE';
            case is_int($value):
                return number_format_i18n($value);
            default:
                return (string)$value;
        }
    }
}

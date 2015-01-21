<?php

return array(
    /**
     * The table that contains the settings column.
     */
    'table' => 'users',

    /**
     * The column in the above table to use.
     */
    'column' => 'settings',

    /**
     * Constrait to add to all clauses.
     */
    'constraint' => 'id = ' . Auth::user()->id,
);

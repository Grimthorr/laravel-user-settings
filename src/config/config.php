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
     * Custom constrait to add to all clauses.
     */
    'custom_constraint' => 'id = ' . (Auth::check() ? Auth::id() : null),

    /**
     * Constrait key
     */
    'constraint_key' => 'id',

    /**
     * Default constraint value
     */
    'default_constraint_value' => (Auth::check() ? Auth::id() : null)

);

<?php

return array(
    /**
     * The connection to the database that contains our table (if different then our default).
     */
    'connection' => env('DB_CONNECTION', 'mysql'),

    /**
     * The table that contains the settings column.
     */
    'table' => 'users',

    /**
     * The column in the above table to use.
     */
    'column' => 'settings',

    /**
     * Constraint key.
     */
    'constraint_key' => 'id',

    /**
     * Default constraint value. Leave this null to use the current user's ID.
     */
    'default_constraint_value' => null,

    /**
     * Custom constraint query to add to all clauses, set to null to use constraint_key and constraint_value above.
     */
    'custom_constraint' => null,

);

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chat Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains settings related to the chat system, including
    | URL prefix, pagination limits, and user name column references.
    |
    */

    // URL prefix for chat-related routes
    'prefix' => 'chat',

    // Number of records per page for pagination
    'paginate_records' => 25,

    // Columns used for retrieving user names from the users table
    'name_cols_in_users_table' => [
        'name',
        // 'first_name',
        // 'last_name',
    ],
];
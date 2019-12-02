<?php

return [
    'index' => [
        'header' => 'users list',
    ],
    'show' => [
        'header' => 'User profile ":name"',
        'no_auth' => 'To view the user profile ":name", please go through the procedure 
            <a href="\\register">registration</a> or 
            <a href="\\login">log in</a> to your profile.'
    ],
    'edit' => [
        'header' => 'Chenging profile of ":name"'
    ]
];
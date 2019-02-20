<?php

return [

    'authters' => [

        'default' => [

            'service' => \Authters\Tracker\DefaultTracker::class,

            'events' => [
                \Authters\Tracker\Event\Named\OnDispatched::class,
                \Authters\Tracker\Event\Named\OnFinalized::class
            ],

            'subscribers' => []
        ]
    ]
];
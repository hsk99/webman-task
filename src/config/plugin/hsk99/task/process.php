<?php

use Hsk99\WebmanTask\Server;

return [
    'task' => [
        'handler'     => Server::class,
        'count'       => config('plugin.hsk99.task.app.count'),
        'reloadable'  => config('plugin.hsk99.task.app.reloadable'),
        'constructor' => [
            'start_dir' => config('plugin.hsk99.task.app.start_dir'),
            'stop_dir'  => config('plugin.hsk99.task.app.stop_dir'),
        ],
        'bootstrap' => config('plugin.hsk99.task.app.bootstrap')
    ]
];

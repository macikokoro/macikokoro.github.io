<?php

use lithium\analysis\Logger;
use lithium\data\Connections;
use lithium\core\Environment;
use lithium\action\Dispatcher;


/**
 * This filter intercepts the `run()` method of the `Dispatcher`
 * and apply filters to `read()` method of the `Connection` to log in a file,
 * all the queries passed to the database.
 *
 * @see lithium\core\Environment
 * @see lithium\data\Connections
 * @see lithium\analysis\Logger
 */

Logger::config(array(
    'default' => array(
        'production' => array(
            'adapter' => 'File',
            'file' => function($data, $config) {
                return "{$data['priority']}.prod.log"; }
        )
    )));

Dispatcher::applyFilter('run', function($self, $params, $chain) {

    if (Environment::is('production')) {

        Connections::get('default')->applyFilter('read', function($self, $params, $chain) {
            $query = $params['query'];
//            Logger::debug('Read:   ' . $query->source() . ': ' . json_encode($query->conditions()));
            return $chain->next($self, $params, $chain);
        });

    }

    return $chain->next($self, $params, $chain);
});

?>
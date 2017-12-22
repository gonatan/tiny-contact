<?php

use Monolog\Logger;
use Monolog\Handler;

/**
 * Api
 *
 * @author magna
 */
class Api
{
    /**
     * @param Base $f3 F3 base object
     */
    public function beforeRoute(Base $f3)
    {
        // prepare logger
        $filename = $f3->get('LOGS') . 'info.log';
        $handler  = new Handler\StreamHandler($filename, Logger::DEBUG);
        $f3->set('logger', new Logger('Controller'));
        $f3->get('logger')->pushHandler($handler);
        $f3->logger->addDebug(__METHOD__, func_get_args());

        // prepare model
        try {
            $f3->set('model', new Model($f3));
        } catch (Exception $e) {
            $f3->logger->addCritical($e->getMessage());
            $f3->logger->addCritical($e->getTraceAsString());
            throw $e;
        }
    }

//    /**
//     * @param Base $f3 F3 base object
//     */
//    public function afterRoute(Base $f3)
//    {
//        return true;
//    }

    /**
     * @param Base $f3 F3 base object
     */
    public function get(Base $f3)
    {
        $f3->logger->addDebug(__METHOD__, func_get_args());
        $id = (int)$f3->get('PARAMS.id');
        $row = $f3->get('model')->findById($id);
        echo json_encode($row);
    }

    /**
     * @param Base $f3 F3 base object
     */
    public function post(Base $f3)
    {
        echo '';
    }

    /**
     * @param Base $f3 F3 base object
     */
    public function put(Base $f3)
    {
        echo '';
    }

    /**
     * @param Base $f3 F3 base object
     */
    public function delete(Base $f3)
    {
        echo '';
    }
}

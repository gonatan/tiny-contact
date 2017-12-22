<?php

use Monolog\Logger;
use Monolog\Handler;

/**
 * Description of AbstractController
 *
 * @author magna
 */
abstract class AbstractController
{
    /**
     * @param Base $f3 F3 base object
     */
    abstract public function beforeRoute(Base $f3);

    /**
     * @param Base $f3 F3 base object
     */
    protected function _prepareLogger(Base $f3)
    {
        // prepare logger
        $filename = $f3->get('LOGS') . 'info.log';
        $handler  = new Handler\StreamHandler($filename, Logger::DEBUG);
        $f3->set('logger', new Logger('Controller'));
        $f3->get('logger')->pushHandler($handler);
        $f3->logger->addDebug(__METHOD__, func_get_args());
    }

    /**
     * @param Base $f3 F3 base object
     */
    abstract public function afterRoute(Base $f3);

    /**
     * @param Base $f3 F3 base object
     */
    protected function _handlePartial(Base $f3)
    {
        if ($f3->exists('partial')) {
            $view    = new View();
            $content = $view->render($f3->get('partial'));
            $f3->set('content', $content);
            echo $view->render('html/layout.phtml');
        }
        return true;
    }

//    /**
//     * Basic action template.
//     * @param Base $f3 F3 base object
//     */
//    public function index(Base $f3)
//    {
//        $f3->logger->addDebug(__METHOD__, func_get_args());
//        $f3->set('partial', 'html/index.phtml');
//        $f3->set('data', [
//        ]);
//    }
}

<?php

namespace Chr15k\Core\Bootstrap;

use ErrorException;
use Chr15k\Core\View\View;

class HandleExceptions
{
    /**
     * Bootstrap error handling.
     *
     * @return void
     */
    public function bootstrap()
    {
        error_reporting(-1);

        set_error_handler([$this, 'handleError']);

        set_exception_handler([$this, 'handleException']);

        if (! config('app')['debug']) {
            ini_set('display_errors', 'Off');
        }
    }

    /**
     * Convert PHP errors to ErrorException instances.
     *
     * @param  int  $level
     * @param  string  $message
     * @param  string  $file
     * @param  int  $line
     * @param  array  $context
     * @return void
     *
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = [])
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handle an uncaught exception from the application.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function handleException($e)
    {
        $code = $e->getCode();

        if ($code !== 404) {
            $code = 500;
        }

        http_response_code($code);

        if (config('app')['debug']) {
            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception: '" . get_class($e) . "'</p>";
            echo "<p>Message: '" . $e->getMessage() . "'</p>";
            echo "<p>Stack trace:<pre>" . $e->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $e->getFile() . "' on line " . $e->getLine() . "</p>";
        } else {
            $log = root_path() . '/logs/' . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);

            $message = "Uncaught exception: '" . get_class($e) . "'";
            $message .= " with message '" . $e->getMessage() . "'";
            $message .= "\nStack trace: " . $e->getTraceAsString();
            $message .= "\nThrown in '" . $e->getFile() . "' on line " . $e->getLine();

            error_log($message);

            View::make("$code.html");
        }
    }
}
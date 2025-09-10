<?php

namespace Lumite\Exception;

/**
 * Centralized logger for Larite exceptions and errors.
 *
 * Usage:
 *   Log::error($exception); // For uncaught or caught exceptions
 *   Log::error($exception, 'CAUGHT'); // For caught exceptions with context
 *
 * Log file is determined by config('app.log_channel'):
 *   - 'single': logs/Larite.log
 *   - 'daily':  logs/Larite-YYYY-MM-DD.log
 */
class Log
{
    /**
     * Log an exception or error to the appropriate log file.
     *
     * @param \Throwable|string $exception Handler, error, or message to log
     * @param string $context   Context label (e.g., 'EXCEPTION', 'CAUGHT', 'WHOOPS')
     */
    public static function error(\Throwable|string $exception, string $context = 'EXCEPTION')
    {
        $logChannel = config('app.log_channel');
        $logFile = self::getLogFile($logChannel);

        // Ensure the log directory exists
        $logDir = dirname($logFile);
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true); // recursively create directory
        }

        $logEntry = "====================\n";
        $logEntry .= "[" . date('Y-m-d H:i:s') . "] [{$context}]\n";
        if ($exception instanceof \Throwable) {
            $logEntry .= "Type: " . get_class($exception) . "\n";
            $logEntry .= "Message: " . $exception->getMessage() . "\n";
            $logEntry .= "File: " . $exception->getFile() . " (Line " . $exception->getLine() . ")\n";
            $logEntry .= "Trace:\n" . $exception->getTraceAsString() . "\n";
        } else {
            $logEntry .= "Message: " . print_r($exception, true) . "\n";
        }
        $logEntry .= "====================\n\n";

        file_put_contents($logFile, $logEntry, FILE_APPEND);
    }


    /**
     * Get the log file path based on the log channel.
     *
     * @param string $logChannel 'single' or 'daily'
     * @return string
     */
    protected static function getLogFile($logChannel): string
    {
        $logDir = ROOT_PATH . '/storage/logs/';
        if ($logChannel === 'daily') {
            $date = date('Y-m-d');
            return $logDir . "Larite-{$date}.log";
        }
        // Default to single file
        return $logDir . "Larite.log";
    }
} 
<?php

// Forces PHP to use exact data types and stops automatic type conversion.
declare(strict_types=1);

trait Logger
{
    private string $logFile = __DIR__ . '/../../operations.log';

    public function logOperation(string $operationType, string $message): void
    {
        // date: Formats the current timestamp into a readable date and time string.
        $currentTime = date('Y-m-d H:i:s');
        $logLine = "[" . $currentTime . "] [" . $operationType . "] " . $message . PHP_EOL;

        // file_put_contents: Writes data to a file and creates it if it does not exist.
        file_put_contents($this->logFile, $logLine, FILE_APPEND);
    }
}
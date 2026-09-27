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
        /* I Get This Function From https://www.php.net/manual/en/function.file-put-contents.php
        And This Function Is Used Writes Data To A File On Disk, Creating The File If It Does Not Exist. */
    }
}
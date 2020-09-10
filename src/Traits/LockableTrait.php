<?php

namespace App\Traits;

trait LockableTrait
{
    /**
     * @param string $name
     *
     * @return bool
     */
    public function lock(string $name = 'LockFile'): bool
    {
        $lockFile = APP_DIR . "/var/cache/{$name}.lock";

        $lockFp = fopen($lockFile, 'w');

        if (!flock($lockFp, LOCK_EX | LOCK_NB)) {
            return true;
        }

        register_shutdown_function(function() use ($lockFp, $lockFile) {
            flock($lockFp, LOCK_UN);
            unlink($lockFile);
        });

        return false;
    }
}
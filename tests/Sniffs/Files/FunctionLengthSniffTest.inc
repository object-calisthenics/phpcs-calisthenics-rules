<?php

/**
 * Removes pre-existing target directory and copy a source directory into target directory.
 *
 * @param string $source The source path to copy.
 * @param string $target The target path to copy to.
 */
function removeAndCopyDirectory($source, $target)
{
    /** @var $iterator \RecursiveIteratorIterator|\RecursiveDirectoryIterator */
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($target, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $file) {
        /** @var $file SplFileInfo */
        if ($file->isDir()) {
            rmdir($file->getRealPath());

            continue;
        }

        unlink($file->getRealPath());
    }

    rmdir($target);

    /** @var $iterator \RecursiveIteratorIterator|\RecursiveDirectoryIterator */
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $file) {
        /** @var $file SplFileInfo */
        if ($file->isDir()) {
            mkdir($target . '/' . $iterator->getSubPathName());

            continue;
        }

        copy($file, $target . '/' . $iterator->getSubPathName());
    }
}

/**
 * Removes a directory recursively.
 *
 * @param string $directory The path to the directory to remove.
 */
function removeDirectory($directory)
{
    /** @var $iterator \RecursiveIteratorIterator|\RecursiveDirectoryIterator */
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $file) {
        /** @var $file SplFileInfo */
        if ($file->isDir()) {
            rmdir($file->getRealPath());

            continue;
        }

        unlink($file->getRealPath());
    }

    rmdir($directory);
}

class FileSystem
{
    /**
     * Removes pre-existing target directory and copy a source directory into target directory.
     *
     * @param string $source The source path to copy.
     * @param string $target The target path to copy to. 
     */
    public function function removeAndCopyDirectory($source, $target)
    {
        /** @var $iterator \RecursiveIteratorIterator|\RecursiveDirectoryIterator */
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($target, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $file) {
            /** @var $file SplFileInfo */
            if ($file->isDir()) {
                rmdir($file->getRealPath());

                continue;
            }

            unlink($file->getRealPath());
        }

        rmdir($target);

        /** @var $iterator \RecursiveIteratorIterator|\RecursiveDirectoryIterator */
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            /** @var $file SplFileInfo */
            if ($file->isDir()) {
                mkdir($target . '/' . $iterator->getSubPathName());

                continue;
            }

            copy($file, $target . '/' . $iterator->getSubPathName());
        }
    }

    /**
     * Removes a directory recursively.
     *
     * @param string $directory The path to the directory to remove.
     */
    pubilc function removeDirectory($directory)
    {
        /** @var $iterator \RecursiveIteratorIterator|\RecursiveDirectoryIterator */
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $file) {
            /** @var $file SplFileInfo */
            if ($file->isDir()) {
                rmdir($file->getRealPath());

                continue;
            }

            unlink($file->getRealPath());
        }

        rmdir($directory);
    }
}

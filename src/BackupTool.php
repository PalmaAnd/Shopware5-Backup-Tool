#!/usr/bin/env php
<?php

namespace Palmaand\Shopware5BackupTool;

use Palmaand\Shopware5BackupTool\Components\Color;


class Shopware5BackupTool
{

    private $stop;
    private $commandList = "
        Type 'help' to see this list \n
        Type 'back - <foldername>' with the wished folder you want to backup \n
        Type 'li' to get a list of all folders \n
        Type 'f' to finish the backup \n";

    public function __construct()
    {
        $this->stop = false;
        $this->startOptions();
    }

    function startOptions()
    {
        echo "-e"  . (new Color)->colorMessage("test123", Color::$RED);
        $backupFolder = __DIR__ . "/../backup";
        if (file_exists($backupFolder)) {
            echo "Do you want to delete the already existing backup folder? Y=[yes] N=[no]\n";
            $handle = fopen("php://stdin", "r");
            $line = fgets($handle);
            $command = trim($line);
            if ($command == 'Y') {
                $this->clearBackup();
                echo "Existing backup and all subfolders removed \n";
                mkdir($backupFolder);
            }
        } else {
            mkdir($backupFolder);
        }

        echo "Would you like to create backup of the custom folder? Y=[yes] N=[no]\n";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        $command = trim($line);
        if ($command == 'Y') {
            $this->syncFolder('custom');
        }
        fclose($handle);
        while (!$this->stop) {
            $this->userInteraction();
        }
        echo "\n";
        return false;
    }

    function userInteraction()
    {
        echo "Waiting for next command. For help simply write 'help' \n";

        $handle = fopen("php://stdin", "r");

        $line = fgets($handle);
        $command = trim($line);

        if ($command == 'help') {
            echo $this->commandList;
        } elseif ($command == 'f') {
            echo "Finished backup\n";
            $this->stop = true;
            exit;
        } elseif ($command == 'li')
            echo shell_exec('ls -d */');
        elseif (substr($command, 0, 6) === 'back -') {
            $foldername = substr($command, 6);
            if ($foldername == 'backup') {
                echo "You can not backup the backup-folder, please try again";
            } else {
                $this->syncFolder($foldername);
            }
        }
        fclose($handle);
    }

    function syncFolder($foldername)
    {
        echo "Backup: " . $foldername . "\n";
        shell_exec('cd ..');
        shell_exec('cp -r ' . $foldername . ' backup/');
    }

    function clearBackup()
    {
        shell_exec('cd ..');
        shell_exec('rm -rf backup/');
    }
}

new Shopware5BackupTool();

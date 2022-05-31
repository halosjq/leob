<?php 
namespace App\Cli;

class Printer
{

    public function Out(string $text)
    {
        echo $text;
        return $this;
    }

    public function NewLine()
    {
        $this->Out(PHP_EOL);
        return $this;
    }

    public function Clear()
    {
        if (PHP_OS == 'WINNT') {
            system('cls');
        } else {
            system('clear');
        }
        $this->Out("\e[H\e[J");
        return $this;
    }

    public function Read(?string $text)
    {
        $txt = trim(readline($text));
        readline_add_history($txt);
        return $txt;
    }

    public function Display(string $message)
    {
        $this->NewLine();
        $this->Out($message);
        $this->NewLine();
        $this->NewLine();
        return $this;
    }
}
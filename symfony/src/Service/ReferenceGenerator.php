<?php

namespace App\Service;

class ReferenceGenerator
{
    public function generate()
    {
        return "LM-" . strtoupper(substr(bin2hex(random_bytes(3)),0,5));
    }
}
<?php
// src/Message/SyncWithAmoCrm.php
namespace App\Message;

class SyncWithAmoCrm
{
    public function __construct(
        public string $dealId,
    ) {}
}
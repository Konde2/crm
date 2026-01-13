<?php
// src/Message/ExportDealsToExcel.php
namespace App\Message;

class ExportDealsToExcel
{
    public function __construct(
        public array $dealIds,
        public string $userId,
    ) {}
}
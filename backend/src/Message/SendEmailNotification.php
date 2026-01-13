<?php
// src/Message/SendEmailNotification.php
namespace App\Message;

class SendEmailNotification
{
    public function __construct(
        public int $dealId,
        public string $eventType, // 'stage_changed', 'comment_added'
    ) {}
}
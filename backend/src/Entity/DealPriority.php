<?php
// src/Entity/DealPriority.php
namespace App\Entity;

enum DealPriority: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
}
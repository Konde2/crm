<?php
// src/Entity/DealStage.php
namespace App\Entity;

enum DealStage: string
{
    case CONTACT = 'contact';          // 1. Установление контакта
    case NEEDS = 'needs';              // 2. Выявление потребностей
    case PRESENTATION = 'presentation'; // 3. Презентация продукта
    case OBJECTIONS = 'objections';    // 4. Работа с возражениями
    case CLOSED = 'closed';            // 5. Закрытие сделки
}
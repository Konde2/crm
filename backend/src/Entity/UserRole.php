<?php
// src/Entity/UserRole.php
namespace App\Entity;

enum UserRole: string
{
    case ADMIN = 'ROLE_ADMIN';
    case SALES_MANAGER = 'ROLE_SALES_MANAGER';
    case DEPARTMENT_HEAD = 'ROLE_DEPARTMENT_HEAD';
    case ANALYST = 'ROLE_ANALYST';
}
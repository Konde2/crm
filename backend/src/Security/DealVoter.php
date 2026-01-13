<?php
// src/Security/DealVoter.php
namespace App\Security;

use App\Entity\Deal;
use App\Entity\User;
use App\Entity\UserRole;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;

class DealVoter extends Voter
{
    public const VIEW = 'DEAL_VIEW';
    public const EDIT = 'DEAL_EDIT';

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT]) && $subject instanceof Deal;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        /** @var Deal $deal */
        $deal = $subject;

        // Админ — всё может
        if ($user->getRole() === UserRole::ADMIN) {
            return true;
        }

        // Руководитель и аналитик — видят всё (но не редактируют, если не свои)
        if (in_array($user->getRole(), [UserRole::DEPARTMENT_HEAD, UserRole::ANALYST])) {
            return $attribute === self::VIEW;
        }

        // Менеджер — только свои
        return $deal->getAssignedTo()->getId()->equals($user->getId());
    }
}
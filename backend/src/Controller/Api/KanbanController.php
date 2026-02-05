<?php
// src/Controller/Api/KanbanController.php
namespace App\Controller\Api;

use App\Entity\Deal;
use App\Entity\DealStage;
use ApiPlatform\Metadata\Get;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

#[Get(
    uriTemplate: '/kanban',
    controller: KanbanController::class,
    read: false, // отключаем стандартный ридер
    normalizationContext: ['groups' => ['kanban']]
)]
class KanbanController extends AbstractController
{
    public function __invoke(
        EntityManagerInterface $em,
        UserInterface $user
    ): array {
        $stages = DealStage::cases();

        // Получаем сделки (с RBAC)
        $qb = $em->createQueryBuilder()
            ->select('d')
            ->from(Deal::class, 'd');

        if ($user->getRoles() === ['ROLE_SALES_MANAGER']) {
            $qb->where('d.assignedTo = :user')
               ->setParameter('user', $user);
        }

        $deals = $qb->getQuery()->getResult();

        $columns = [];
        foreach ($stages as $stage) {
            $columns[] = [
                'stage' => $stage->value,
                'title' => $this->getStageTitle($stage),
                'deals' => array_values(array_filter($deals, fn($d) => $d->getStage() === $stage)),
            ];
        }

        return ['columns' => $columns];
    }

    private function getStageTitle(DealStage $stage): string
    {
        return match ($stage) {
            DealStage::CONTACT => 'Установление контакта',
            DealStage::NEEDS => 'Выявление потребностей',
            DealStage::PRESENTATION => 'Презентация продукта',
            DealStage::OBJECTIONS => 'Работа с возражениями',
            DealStage::CLOSED => 'Закрытие сделки',
        };
    }
}
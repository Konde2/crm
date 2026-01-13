<?php

namespace ContainerCZrcamn;
include_once \dirname(__DIR__, 4).'/vendor/knplabs/knp-components/src/Knp/Component/Pager/PaginatorInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/knplabs/knp-components/src/Knp/Component/Pager/Paginator.php';

class PaginatorProxyBa079e5 implements \Knp\Component\Pager\PaginatorInterface, \Symfony\Component\VarExporter\LazyObjectInterface
{
    use \Symfony\Component\VarExporter\Internal\LazyDecoratorTrait;

    private const LAZY_OBJECT_PROPERTY_SCOPES = [];

    public function initializeLazyObject(): \Knp\Component\Pager\PaginatorInterface
    {
        return $this->lazyObjectState->realInstance;
    }

    public function paginate(mixed $target, int $page = 1, ?int $limit = null, array $options = []): \Knp\Component\Pager\Pagination\PaginationInterface
    {
        return $this->lazyObjectState->realInstance->paginate(...\func_get_args());
    }
}

// Help opcache.preload discover always-needed symbols
class_exists(\Symfony\Component\VarExporter\Internal\Hydrator::class);
class_exists(\Symfony\Component\VarExporter\Internal\LazyObjectRegistry::class);

if (!\class_exists('PaginatorProxyBa079e5', false)) {
    \class_alias(__NAMESPACE__.'\\PaginatorProxyBa079e5', 'PaginatorProxyBa079e5', false);
}

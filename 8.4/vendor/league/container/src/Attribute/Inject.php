<?php

declare (strict_types=1);
namespace Odigos\League\Container\Attribute;

use Attribute;
use Odigos\League\Container\ContainerAwareInterface;
use Odigos\League\Container\ContainerAwareTrait;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
#[Attribute(Attribute::TARGET_PARAMETER | Attribute::IS_REPEATABLE)]
class Inject implements AttributeInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;
    public function __construct(protected string $id)
    {
    }
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function resolve(): mixed
    {
        return $this->getContainer()->get($this->id);
    }
}

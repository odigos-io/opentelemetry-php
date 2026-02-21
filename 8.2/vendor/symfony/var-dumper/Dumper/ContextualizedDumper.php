<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Symfony\Component\VarDumper\Dumper;

use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Dumper\ContextProvider\ContextProviderInterface;
/**
 * @author Kévin Thérage <therage.kevin@gmail.com>
 */
class ContextualizedDumper implements \Symfony\Component\VarDumper\Dumper\DataDumperInterface
{
    /**
     * @param ContextProviderInterface[] $contextProviders
     */
    public function __construct(private \Symfony\Component\VarDumper\Dumper\DataDumperInterface $wrappedDumper, private array $contextProviders)
    {
    }
    public function dump(Data $data): ?string
    {
        $context = $data->getContext();
        foreach ($this->contextProviders as $contextProvider) {
            $context[$contextProvider::class] = $contextProvider->getContext();
        }
        return $this->wrappedDumper->dump($data->withContext($context));
    }
}

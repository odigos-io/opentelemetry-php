<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Containers\Files;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type ContainerFileDeleteType array{id: string, object: string, deleted: bool}
 *
 * @implements ResponseContract<ContainerFileDeleteType>
 */
final class ContainerFileDeleteResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ContainerFileDeleteType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    private function __construct(public readonly string $id, public readonly string $object, public readonly bool $deleted, private readonly MetaInformation $meta)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  ContainerFileDeleteType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(id: $attributes['id'], object: $attributes['object'], deleted: $attributes['deleted'], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['id' => $this->id, 'object' => $this->object, 'deleted' => $this->deleted];
    }
}

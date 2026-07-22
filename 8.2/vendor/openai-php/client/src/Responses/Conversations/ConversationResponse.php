<?php

declare (strict_types=1);
namespace Odigos\OpenAI\Responses\Conversations;

use Odigos\OpenAI\Contracts\ResponseContract;
use Odigos\OpenAI\Contracts\ResponseHasMetaInformationContract;
use Odigos\OpenAI\Responses\Concerns\ArrayAccessible;
use Odigos\OpenAI\Responses\Concerns\HasMetaInformation;
use Odigos\OpenAI\Responses\Meta\MetaInformation;
use Odigos\OpenAI\Testing\Responses\Concerns\Fakeable;
/**
 * @phpstan-type ConversationType array{id: string, object: 'conversation', created_at: int, metadata?: array<string, mixed>}
 *
 * @implements ResponseContract<ConversationType>
 */
final class ConversationResponse implements ResponseContract, ResponseHasMetaInformationContract
{
    /**
     * @use ArrayAccessible<ConversationType>
     */
    use ArrayAccessible;
    use Fakeable;
    use HasMetaInformation;
    /**
     * @param  'conversation'  $object
     * @param  array<string, mixed>  $metadata
     */
    private function __construct(public readonly string $id, public readonly string $object, public readonly int $createdAt, public readonly array $metadata, private readonly MetaInformation $meta)
    {
    }
    /**
     * Acts as static factory, and returns a new Response instance.
     *
     * @param  ConversationType  $attributes
     */
    public static function from(array $attributes, MetaInformation $meta): self
    {
        return new self(id: $attributes['id'], object: $attributes['object'], createdAt: $attributes['created_at'], metadata: $attributes['metadata'] ?? [], meta: $meta);
    }
    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return ['id' => $this->id, 'object' => $this->object, 'created_at' => $this->createdAt, 'metadata' => $this->metadata];
    }
}

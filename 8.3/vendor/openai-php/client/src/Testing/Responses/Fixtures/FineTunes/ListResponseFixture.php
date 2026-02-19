<?php

namespace OpenAI\Testing\Responses\Fixtures\FineTunes;

final class ListResponseFixture
{
    public const ATTRIBUTES = ['object' => 'list', 'data' => [\OpenAI\Testing\Responses\Fixtures\FineTunes\RetrieveResponseFixture::ATTRIBUTES]];
}

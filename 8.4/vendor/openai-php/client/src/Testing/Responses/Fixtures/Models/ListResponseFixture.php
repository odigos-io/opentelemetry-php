<?php

namespace OpenAI\Testing\Responses\Fixtures\Models;

final class ListResponseFixture
{
    public const ATTRIBUTES = ['object' => 'list', 'data' => [\OpenAI\Testing\Responses\Fixtures\Models\RetrieveResponseFixture::ATTRIBUTES]];
}

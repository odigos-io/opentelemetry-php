<?php

namespace OpenAI\Testing\Responses\Fixtures\Conversations;

final class ConversationItemListFixture
{
    public const ATTRIBUTES = ['object' => 'list', 'data' => [\OpenAI\Testing\Responses\Fixtures\Conversations\ConversationItemFixture::ATTRIBUTES, \OpenAI\Testing\Responses\Fixtures\Conversations\ConversationItemFixture::ATTRIBUTES], 'first_id' => 'msg_abc', 'last_id' => 'msg_abc', 'has_more' => \false];
}

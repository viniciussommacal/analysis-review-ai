<?php

namespace App\Services;

use App\Gateways\OpenAiGateway;

class ProcessCommentService
{
    private OpenAiGateway $openAiGateway;

    public function __construct(OpenAiGateway $openAiGateway)
    {
        $this->openAiGateway = $openAiGateway;
    }

    public function processComment(object $review)
    {
        return $this->openAiGateway->processComment($review);
    }
}

<?php
// src/Message/IndexDealInElasticsearch.php
namespace App\Message;

class IndexDealInElasticsearch
{
    public function __construct(
        public string $dealId,
    ) {}
}
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Bus;
use Spatie\WebhookServer\CallWebhookJob;
use Spatie\WebhookServer\WebhookCall;

class WebhookTest extends TestCase {
    public function testWebhookCalled() {
        Bus::fake();

        WebhookCall::create()
        ->url('https://github.com/spatie/laravel-webhook-server')
        ->payload(['name' => 'webhook 1'])
        ->useSecret('secret')
        ->dispatch();

        Bus::assertDispatched(CallWebhookJob::class);
    }
}
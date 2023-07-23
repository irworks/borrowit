<?php

namespace Tests\Feature;

use App\Models\RegisterDomain;
use App\Services\RegisterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterServiceTest extends TestCase
{
    use RefreshDatabase;

    private RegisterService $registerService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->registerService = new RegisterService();
    }

    public function testRegistrationDisabled()
    {
        config(['auth.registration.enabled' => false]);

        $result = $this->registerService->isRegistrationAllowed('test@example.com');
        $this->assertFalse($result);
    }

    public function testRegistrationAllAllowed()
    {
        config(['auth.registration.enabled' => true]);
        config(['auth.registration.restricted' => false]);
        $result = $this->registerService->isRegistrationAllowed('test@example.com');
        $this->assertTrue($result);
    }

    public function testRegistrationDomainsAllowed()
    {
        config(['auth.registration.enabled' => true]);
        config(['auth.registration.restricted' => true]);

        RegisterDomain::factory(['domain' => 'example.org'])->create();

        $result = $this->registerService->isRegistrationAllowed('test@example.com');
        $this->assertFalse($result);

        $result = $this->registerService->isRegistrationAllowed('user.name@example.org');
        $this->assertTrue($result);
    }

    public function testRegistrationNotValidDomain()
    {
        config(['auth.registration.enabled' => true]);
        config(['auth.registration.restricted' => true]);

        RegisterDomain::factory(['domain' => 'example.org'])->create();

        $result = $this->registerService->isRegistrationAllowed('te@st@example.org');
        $this->assertFalse($result);

        $result = $this->registerService->isRegistrationAllowed('@example.org');
        $this->assertFalse($result);

        $result = $this->registerService->isRegistrationAllowed('user@example.test@example.org');
        $this->assertFalse($result);
    }
}

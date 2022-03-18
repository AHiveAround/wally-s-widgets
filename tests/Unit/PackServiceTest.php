<?php

namespace Tests\Unit;

use App\Models\Pack;
use App\Services\PackService;
use Database\Seeders\PackSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PackServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var PackService
     */
    private PackService $packService;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(PackSeeder::class);
        $this->packService = resolve(PackService::class);
    }

    public function testValidatePackInputSuccessful()
    {
        $request = Request::create('/', 'POST', ["ordered-packs" => "1"]);
        $result = $this->packService->validatePackInput($request);
        $this->assertEquals(["ordered-packs" => "1"], $result);
    }

    public function testValidatePackInputZero()
    {
        $request = Request::create('/', 'POST', ["ordered-packs" => "0"]);
        $this->expectException(ValidationException::class);
        $this->packService->validatePackInput($request);
    }

    public function testValidatePackInputMinus()
    {
        $request = Request::create('/', 'POST', ["ordered-packs" => "-1"]);
        $this->expectException(ValidationException::class);
        $this->packService->validatePackInput($request);
    }

    public function testValidatePackInputCharacter()
    {
        $request = Request::create('/', 'POST', ["ordered-packs" => "abcde"]);
        $this->expectException(ValidationException::class);
        $this->packService->validatePackInput($request);
    }

    public function testGetPacksToSendOnNoPacks()
    {
        //reset db to null values
        Pack::query()->delete();

        $result = $this->packService->getPacksToSend(1);
        $this->assertEquals(null, $result);
    }

    public function testGetPacksToSendOnSuccess()
    {
        $result = $this->packService->getPacksToSend(1);
        $this->assertEquals([250 => 1], $result);
        $result = $this->packService->getPacksToSend(250);
        $this->assertEquals([250 => 1], $result);
        $result = $this->packService->getPacksToSend(501);
        $this->assertEquals([500 => 1, 250 => 1], $result);
        $result = $this->packService->getPacksToSend(12001);
        $this->assertEquals([5000 => 2, 2000 => 1, 250 => 1], $result);
    }
}

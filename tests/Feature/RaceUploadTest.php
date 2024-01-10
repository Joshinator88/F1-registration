<?php

namespace Tests\Feature;

use App\Models\Race;
use App\Models\RaceResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RaceUploadTest extends TestCase
{
    use RefreshDatabase;
    private Race $race;
    private UploadedFile $uploadedFakeFile;

    // The setup method is called foreach testcase.
    // setup the fake storage, create a logged in user, create a fake race and a fake uploadedfile.
    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('local');
        $this->login();
        $this->race = $this->createRace();
        $this->uploadedFakeFile = UploadedFile::fake()->image('avatar.jpg');
    }

    public function testRaceUpload(): void
    {
        $response = $this->post('/uploadrace', [
            'minutes' => 1,
            'seconds' => 22,
            'thousands' => 123,
            'race_id' => $this->race->id,
            'controlPicture' => $this->uploadedFakeFile
        ]);

        $response->assertStatus(302)->assertSessionDoesntHaveErrors();
        $this->assertDatabaseCount('race_results', 1);
        $this->assertRaceResultProofUploaded();
    }

    public function testShouldReturnBackWithErrorsWhenRaceResultIsGreaterThanPreviousRaceResult(): void
    {
        RaceResult::factory()->create([
            'race_id' => $this->race->id,
            'user_id' => $this->loggedInUser->id,
            'seconds' => 1,
        ]);
        $response = $this->post('/uploadrace', [
            'minutes' => 1,
            'seconds' => 22,
            'thousands' => 123,
            'race_id' => $this->race->id,
            'controlPicture' => $this->uploadedFakeFile
        ]);

        $response->assertStatus(302)
            ->assertSessionHasErrors('error');
        $this->assertDatabaseCount('race_results', 1);
    }

    public function testShouldUpdateRaceResultWhenNewResultIsFasterThanPreviousRaceResult(): void
    {
        $raceResult = RaceResult::factory()->create([
            'race_id' => $this->race->id,
            'user_id' => $this->loggedInUser->id,
            'seconds' => 999,
        ]);
        $response = $this->post('/uploadrace', [
            'minutes' => 1,
            'seconds' => 22,
            'thousands' => 123,
            'race_id' => $this->race->id,
            'controlPicture' => $this->uploadedFakeFile
        ]);

        $response->assertStatus(302)
            ->assertSessionHasNoErrors();

        $raceResult->refresh();

        $this->assertEquals(82.123, $raceResult->seconds);
        $this->assertDatabaseCount('race_results', 1);
        $this->assertRaceResultProofUploaded();
    }

    private function assertRaceResultProofUploaded(): void
    {
        $expectedRaceResultFileName = 'raceResultProof/'. $this->race->id . '.' . 'jpg';
        Storage::assertExists($expectedRaceResultFileName);
    }
}

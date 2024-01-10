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
        $this->withoutExceptionHandling();
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
        $this->assertRaceResultProofUploaded(1);
    }

    public function testShouldCreateRaceResultWhenNewResultIsFasterThanPreviousRaceResult(): void
    {
        $raceResult = RaceResult::factory()->create([
            'race_id' => $this->race->id,
            'user_id' => $this->loggedInUser->id,
            'seconds' => 999,
            'points' => 25,
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

        $raceResults = RaceResult::where('race_id', $this->race->id)->orderBy('seconds', 'asc')->get();

        $this->assertFalse($raceResults[0]->is_valid);
        $this->assertTrue($raceResults[1]->is_valid);

        $this->assertEquals(999, $raceResult->seconds);
        $this->assertEquals(25, $raceResult->points);
        $this->assertDatabaseCount('race_results', 2);
        $this->assertRaceResultProofUploaded($raceResults[0]->id);
    }

    private function assertRaceResultProofUploaded($raceResult): void
    {
        $expectedRaceResultFileName = 'raceResultProof/'. $raceResult . '.' . 'jpg';
        Storage::assertExists($expectedRaceResultFileName);
    }
}

<?php


use App\Models\Race;
use App\Models\RaceResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RaceResultUpdateTest extends TestCase
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

    public function testApproveUploadedRaceResultByAdmin(): void
    {
        $picturePath = 'controlPictures/avatar.jpg';
        $initialRaceResult = RaceResult::factory()->create([
            'is_valid' => false,
            'picture_name' => 'avatar.jpg',
        ]);
        Storage::disk('local')->put($picturePath, $this->uploadedFakeFile->getContent());

        $response = $this->post(route('admin.update'), [
            'id' => $initialRaceResult->id,
            'goedgekeurd' => true
        ]);

        $response->assertStatus(302)->assertSessionHas('success');
        Storage::assertMissing($picturePath);
        $initialRaceResult->refresh();
        $this->assertTrue($initialRaceResult->is_valid);
    }

    public function testDeclineUploadedRaceResultByAdmin(): void
    {
        $picturePath = 'controlPictures/avatar.jpg';
        $initialRaceResult = RaceResult::factory()->create([
            'is_valid' => false,
            'picture_name' => 'avatar.jpg',
        ]);
        Storage::disk('local')->put($picturePath, $this->uploadedFakeFile->getContent());

        $response = $this->post(route('admin.update'), [
            'id' => $initialRaceResult->id,
            'afgekeurd' => false
        ]);

        $response->assertStatus(302)->assertSessionHas('success');
        Storage::assertMissing($picturePath);
        $this->assertDatabaseMissing('race_results', ['id' => $initialRaceResult->id]);
    }

    public function testApproveUploadedRaceResultByAdminWenProvidedGoedGekeurdAndAfGekeurd(): void
    {
        $picturePath = 'controlPictures/avatar.jpg';
        $initialRaceResult = RaceResult::factory()->create([
            'is_valid' => false,
            'picture_name' => 'avatar.jpg',
        ]);
        Storage::disk('local')->put($picturePath, $this->uploadedFakeFile->getContent());

        $response = $this->post(route('admin.update'), [
            'id' => $initialRaceResult->id,
            'afgekeurd' => true,
            'goedgekeurd' => true
        ]);

        $response->assertStatus(302)->assertSessionHas('success');
        Storage::assertMissing($picturePath);
        $initialRaceResult->refresh();
        $this->assertTrue($initialRaceResult->is_valid);
    }
}

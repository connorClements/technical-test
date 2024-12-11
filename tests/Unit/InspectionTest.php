<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Component;
use App\Models\Inspection;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InspectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Summary of test_assert_can_create_an_inspection
     * This test is intended to check whether inspections can be created,
     * and when they are that they will return the correct
     * json information
     * @return void
     */
    public function test_assert_can_create_an_inspection()
    {
        $component = Component::factory()->create();
        $data = [
            'component_id' => $component->id,
            'inspection_date' => '2024-12-11',
            'score' => 4,
        ];

        $response = $this->postJson(route('inspections.store'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Inspection created successfully.',
            ])->assertJsonStructure([
                'message',
                'turbines',
            ]);;
    }

    /**
     * Summary of test_assert_inspection_creation_fails_with_invalid_data
     * This test is created to ensure that validation errors will be 
     * returned when data is invalid upon inspection creation
     * @return void
     */
    public function test_assert_inspection_creation_fails_with_invalid_data()
    {
        $data = [
            'component_id' => null, // Missing component_id
            'inspection_date' => 'invalid-date', // Invalid date format
            'score' => 10, // Out of range (1-5)
        ];

        $response = $this->postJson(route('inspections.store'), $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['component_id', 'inspection_date', 'score']);
    }


    /**
     * Summary of test_assert_can_update_an_inspection
     * This test is intended to check whether inspections can be updated, 
     * and when they are that they will return the correct
     * json information
     * @return void
     */
    /** @test */
    public function test_assert_can_update_an_inspection()
    {
        $inspection = Inspection::factory()->create([
            'inspection_date' => '2024-12-01',
            'score' => 3,
        ]);

        $data = [
            'inspection_date' => '2024-12-11',
            'score' => 4,
        ];

        $response = $this->putJson(route('inspections.update', $inspection), $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Inspection updated successfully.',
            ])
            ->assertJsonStructure([
                'message',
                'turbines',
            ]);

        // Verify that the inspection was updated in the database
        $this->assertDatabaseHas('inspections', [
            'id' => $inspection->id,
            'inspection_date' => '2024-12-11',
            'score' => 4,
        ]);
    }

    /**
     * Summary of test_assert_inspection_update_fails_with_invalid_data
     * This test is created to ensure that validation errors will be 
     * returned when data is invalid upon inspection update
     * @return void
     */
    public function test_assert_inspection_update_fails_with_invalid_data()
    {
        $inspection = Inspection::factory()->create();

        $data = [
            'inspection_date' => 'invalid-date', // Invalid date format
            'score' => 10, // Out of range (1-5)
        ];

        $response = $this->putJson(route('inspections.update', $inspection), $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['inspection_date', 'score']);
    }

    /**
     * Summary of test_assert_can_delete_an_inspection
     * This test is intended to check whether inspections can be deleted, 
     * and when they are that they will return the correct
     * json information
     * @return void
     */
    public function test_assert_can_delete_an_inspection()
    {
        // Arrange
        $inspection = Inspection::factory()->create(); // Create a sample inspection

        // Act
        $response = $this->deleteJson(route('inspections.destroy', $inspection));

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Inspection deleted successfully.',
            ])
            ->assertJsonStructure([
                'message',
                'turbines',
            ]);

        // Verify that the inspection no longer exists in the database
        $this->assertDatabaseMissing('inspections', [
            'id' => $inspection->id,
        ]);
    }

    /**
     * Summary of test_assert_inspection_deletion_fails_when_inspection_does_not_exist
     * This test is intended to check that a 404 error will return when an inspection is deleted
     * which does not exist
     * @return void
     */
    public function test_assert_inspection_deletion_fails_when_inspection_does_not_exist()
    {
        $response = $this->deleteJson(route('inspections.destroy', 99999)); // ID that doesn't exist

        $response->assertStatus(404);
    }
}

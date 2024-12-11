<?php

namespace Tests\Feature;

use App\Models\Turbine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TurbineTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching all turbines with their components and inspections.
     * This test is intended to check whether turbines can be fetched, 
     * and when they are that they will return the correct
     * json information - components and inspections also attached.
     * @return void
     */
    public function test_assert_can_fetch_all_turbines()
    {
        Turbine::factory()->count(3)->create();

        $response = $this->getJson(route('turbines.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'turbines' => [
                    '*' => [
                        'id',
                        'name',
                        'latitude',
                        'longitude',
                        'components' => [
                            '*' => [
                                'id',
                                'name',
                                'inspections' => [
                                    '*' => [
                                        'id',
                                        'inspection_date',
                                        'score',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /*
     * Test the creation of a turbine.
     * This test is intended to check whether turbine can be created, 
     * and when they are that they will return the correct
     * json information
     * @return void
     */
    public function test_assert_can_create_a_turbine()
    {
        $data = [
            'name' => 'Turbine 1',
            'latitude' => 45.0,
            'longitude' => 90.0,
        ];

        $response = $this->postJson(route('turbines.store'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Turbine created successfully.',
            ])
            ->assertJsonStructure([
                'message',
                'turbines',
            ]);

        $this->assertDatabaseHas('turbines', $data);
    }

    /**
     * Summary of test_assert_turbine_creation_fails_with_invalid_data
     * This test is created to ensure that validation errors will be 
     * returned when data is invalid upon turbine creation
     * @return void
     */
    public function test_assert_turbine_creation_fails_with_invalid_data()
    {
        $data = [
            'name' => '', // Missing name
            'latitude' => 100, // Out of bounds
            'longitude' => -200, // Out of bounds
        ];

        $response = $this->postJson(route('turbines.store'), $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'latitude', 'longitude']);
    }

    /**
     * Test the updating of a component.
     * This test is intended to check whether components can be updated, 
     * and when they are that they will return the correct
     * json information
     * @return void
     */
    public function test_assert_can_update_a_turbine()
    {
        $turbine = Turbine::factory()->create([
            'name' => 'Old Turbine',
            'latitude' => 30.0,
            'longitude' => 60.0,
        ]);

        $data = [
            'name' => 'Updated Turbine',
            'latitude' => 45.0,
            'longitude' => 90.0,
        ];

        $response = $this->putJson(route('turbines.update', $turbine), $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Turbine updated successfully.',
            ])
            ->assertJsonStructure([
                'message',
                'turbines',
            ]);

        $this->assertDatabaseHas('turbines', array_merge(['id' => $turbine->id], $data));
    }

    /**
     * Summary of test_assert_turbine_update_fails_with_invalid_data
     * This test is created to ensure that validation errors will be 
     * returned when data is invalid upon turbineupdate
     * @return void
     */
    public function test_assert_turbine_update_fails_with_invalid_data()
    {
        $turbine = Turbine::factory()->create();

        $data = [
            'name' => '', // Missing name
            'latitude' => 100, // Out of bounds
            'longitude' => -200, // Out of bounds
        ];

        $response = $this->putJson(route('turbines.update', $turbine), $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'latitude', 'longitude']);
    }

    /**
     * Test the deletion of a turbine.
     * This test is intended to check whether turbines can be deleted, 
     * and when they are that they will return the correct
     * json information
     * @return void
     */
    public function test_assert_can_delete_a_turbine()
    {
        $turbine = Turbine::factory()->create();

        $response = $this->deleteJson(route('turbines.destroy', $turbine));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Turbine deleted successfully.',
            ])
            ->assertJsonStructure([
                'message',
                'turbines',
            ]);

        $this->assertDatabaseMissing('turbines', [
            'id' => $turbine->id,
        ]);
    }

    /**
     * Summary of test_assert_turbine_deletion_fails_when_turbine_does_not_exist
     * This test is intended to check that a 404 error will return when a turbine is deleted
     * which does not exist
     * @return void
     */
    public function test_assert_turbine_deletion_fails_when_turbine_does_not_exist()
    {
        // Act: Attempt to delete a non-existent turbine
        $response = $this->deleteJson(route('turbines.destroy', 99999)); // ID that doesn't exist

        // Assert: Ensure a 404 status is returned
        $response->assertStatus(404);
    }
}

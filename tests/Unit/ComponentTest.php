<?php

namespace Tests\Feature;

use App\Models\Turbine;
use App\Models\Component;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ComponentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of a new component.
     * This test is intended to check whether components can be created,
     * and when they are that they will return the correct
     * json information
     * @return void
     */
    public function test_assert_can_create_a_component()
    {
        $turbine = Turbine::factory()->create();
        $data = [
            'turbine_id' => $turbine->id,
            'name' => 'Test Component',
        ];

        $response = $this->postJson(route('components.store'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Component created successfully.',
            ])
            ->assertJsonStructure([
                'message',
                'turbines',
            ]);

        $this->assertDatabaseHas('components', [
            'turbine_id' => $turbine->id,
            'name' => 'Test Component',
        ]);
    }


    /**
     * Summary of test_assert_component_creation_fails_with_invalid_data
     * This test is created to ensure that validation errors will be 
     * returned when data is invalid upon component creation
     * @return void
     */
    public function test_assert_component_creation_fails_with_invalid_data()
    {
        $data = [
            'turbine_id' => null, // Missing turbine_id
            'name' => '', // Missing or empty name
        ];

        $response = $this->postJson(route('components.store'), $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['turbine_id', 'name']);
    }

    /**
     * Test the update of an existing component.
     * This test is intended to check whether components can be updated, 
     * and when they are that they will return the correct
     * json information
     * @return void
     */
    public function test_assert_can_update_a_component()
    {
        $component = Component::factory()->create([
            'name' => 'Old Component',
        ]);

        $data = [
            'name' => 'Updated Component',
        ];

        $response = $this->putJson(route('components.update', $component), $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Component updated successfully.',
            ])
            ->assertJsonStructure([
                'message',
                'turbines',
            ]);

        $this->assertDatabaseHas('components', [
            'id' => $component->id,
            'name' => 'Updated Component',
        ]);
    }

    /**
     * Summary of test_assert_component_update_fails_with_invalid_data
     * This test is created to ensure that validation errors will be 
     * returned when data is invalid upon component update
     * @return void
     */
    public function test_assert_component_update_fails_with_invalid_data()
    {
        $component = Component::factory()->create();

        $data = [
            'name' => '', // Missing or empty name
        ];

        $response = $this->putJson(route('components.update', $component), $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * Test the deletion of a component.
     * This test is intended to check whether components can be deleted, 
     * and when they are that they will return the correct
     * json information
     * @return void
     */
    public function test_assert_can_delete_a_component()
    {
        $component = Component::factory()->create();

        $response = $this->deleteJson(route('components.destroy', $component));

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Component deleted successfully.',
            ])
            ->assertJsonStructure([
                'message',
                'turbines',
            ]);

        $this->assertDatabaseMissing('components', [
            'id' => $component->id,
        ]);
    }

    /**
     * Summary of test_assert_component_deletion_fails_when_component_does_not_exist
     * This test is intended to check that a 404 error will return when a component is deleted
     * which does not exist
     * @return void
     */
    public function test_assert_component_deletion_fails_when_component_does_not_exist()
    {
        $response = $this->deleteJson(route('components.destroy', 99999)); // ID that doesn't exist

        $response->assertStatus(404);
    }
}

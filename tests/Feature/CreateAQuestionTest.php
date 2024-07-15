<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

// it or test
// todo() == pending

// Write test, remeber three things
// AAA = Arrange = Preparar, Act = Agir, Assert = Verificar
// Factory create fakes data

it('should be able to create a new question bigger than 255 characters', function () {
    // Arrange
    // Create fake user
    $user = User::factory()->create();
    // logged with user
    actingAs($user);

    //Act
    // Create requisition the route for create question and repeat create string > 250
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    // Assert
    // Verify redirect
    $request->assertRedirect(route('dashboard'));

    // Verify BD
    assertDatabaseCount('questions', 1);
    // Verify Question in bd
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('should check if ends with question mark ?', function () {

});

it("should have at least 10 characters", function () {

});

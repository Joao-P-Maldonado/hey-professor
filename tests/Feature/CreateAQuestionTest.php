<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

// it or test
// todo() == pending

// Write test, remeber three things
// AAA = Arrange = Preparar, Act = Agir, Assert = Verificar
// Factory create fakes data

// Testing success
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

// Testing erros
it('should check if ends with question mark ?', function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route('question.store'), [
        'question' => str_repeat('*', 10),
    ]);

    $request->assertSessionHasErrors(['question' => 'Are you sure that is a question? It is missing the question mark at the end.']);
    assertDatabaseCount('questions', 0);
});

// Testing erros
it("should have at least 10 characters", function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['min' => 10, 'attribute' => 'question'])]);
    assertDatabaseCount('questions', 0);
});

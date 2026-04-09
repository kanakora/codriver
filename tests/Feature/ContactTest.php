<?php

use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

test('contact page is accessible to guests', function () {
    $response = $this->get(route('contact'));
    $response->assertOk();
    $response->assertInertia(fn ($page) => $page->component('Contact'));
});

test('contact form validation works', function () {
    // Test empty submission
    $response = $this->post(route('contact.send'), []);
    $response->assertSessionHasErrors(['name', 'email', 'message']);

    // Test invalid email
    $response = $this->post(route('contact.send'), [
        'name' => 'John Doe',
        'email' => 'invalid-email',
        'message' => 'Test message',
    ]);
    $response->assertSessionHasErrors(['email']);

    // Test message too short
    $response = $this->post(route('contact.send'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'Short',
    ]);
    $response->assertSessionHasErrors(['message']);
});

test('contact form sends email on valid submission', function () {
    Mail::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'This is a test message for the contact form.',
    ];

    $response = $this->post(route('contact.send'), $data);

    $response->assertRedirect(route('contact'));
    $response->assertSessionHas('success');

    Mail::assertSent(ContactMessage::class, function ($mail) use ($data) {
        return $mail->data['name'] === $data['name'] &&
               $mail->data['email'] === $data['email'] &&
               $mail->data['message'] === $data['message'] &&
               $mail->hasTo(config('mail.admin_email'));
    });
});

test('authenticated users can access contact page', function () {
    $this->seed(RolesAndPermissionsSeeder::class);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $response = $this->actingAs($admin)->get(route('contact'));
    $response->assertOk();
    $response->assertInertia(fn ($page) => $page->component('Contact'));

    $student = User::factory()->create();
    $student->assignRole('student');

    $response = $this->actingAs($student)->get(route('contact'));
    $response->assertOk();
    $response->assertInertia(fn ($page) => $page->component('Contact'));
});

test('contact form resets after successful submission', function () {
    $data = [
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
        'message' => 'Another test message for the contact form.',
    ];

    $response = $this->post(route('contact.send'), $data);
    $response->assertSessionHasNoErrors();
});
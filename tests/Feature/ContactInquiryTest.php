<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use App\Mail\ContactInquiry;

class ContactInquiryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test contact form validation failure.
     */
    public function test_contact_form_validation_fails_with_invalid_data()
    {
        Mail::fake();

        $response = $this->post(route('contact.submit'), [
            'name' => '',
            'email' => 'invalid-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        Mail::assertNothingSent();
    }

    /**
     * Test successful contact form submission and email dispatch.
     */
    public function test_contact_form_submission_dispatches_beautiful_email()
    {
        Mail::fake();

        $response = $this->post(route('contact.submit'), [
            'name' => 'Ramu Parasa',
            'email' => 'ramu.inquirer@example.com',
            'message' => 'Hello Veltrix, I would like to schedule a custom trial.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('contact_success');

        Mail::assertSent(ContactInquiry::class, function (ContactInquiry $mail) {
            return $mail->hasTo('veltrixcrm@gmail.com') &&
                   $mail->name === 'Ramu Parasa' &&
                   $mail->email === 'ramu.inquirer@example.com' &&
                   $mail->messageBody === 'Hello Veltrix, I would like to schedule a custom trial.';
        });
    }
}

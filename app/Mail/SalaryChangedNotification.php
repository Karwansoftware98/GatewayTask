<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SalaryChangedNotification extends Mailable
{
    use Queueable, SerializesModels;

    use Queueable, SerializesModels;

    public $employee;
    public $oldSalary;
    public $newSalary;

    public function __construct(Employee $employee, $oldSalary, $newSalary)
    {
        $this->employee = $employee;
        $this->oldSalary = $oldSalary;
        $this->newSalary = $newSalary;
    }

    public function build()
    {
        return $this->view('emails.salary_changed')
            ->with([
                'employee' => $this->employee,
                'oldSalary' => $this->oldSalary,
                'newSalary' => $this->newSalary
            ]);
    }
}

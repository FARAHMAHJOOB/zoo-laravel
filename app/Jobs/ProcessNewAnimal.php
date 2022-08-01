<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\Admin\User\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Http\Services\Message\MessageService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Services\Message\Email\EmailService;

class ProcessNewAnimal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $animalName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($animalName)
    {
        $this->animalName = $animalName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailService = new EmailService();
        $details = [
            'title' =>  $this->animalName,
            'body'  => "پست جدید در سایت درج شد\n",
        ];
        $emailService->setDetails($details);
        $emailService->setFrom('noreply@example.com', 'ZOO');
        $emailService->setSubject('سایت باغ وحش');

        $users = User::select('email')->get();
        foreach ($users as $user) {
            $emailService->setTo($user->email);
            $messagesService = new MessageService($emailService);
            $messagesService->send();
        }
    }


    public function failed()
    {
        $this->handle();
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExportNotification extends Notification
{
    use Queueable;
    public $status;
    public $filePath;

    public function __construct($status, $filePath = null)
    {
        $this->status = $status;
        $this->filePath = $filePath;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    
     public function via($notifiable)
     {
         return ['database'];
     }
 
     public function toArray($notifiable)
    {
        return [
            'message' => $this->status == 'started'
                ? 'The export process has started.'
                : 'The export is complete. You can download the file below.',
            'file_path' => $this->filePath, // Pass the shorter file path
        ];
    }
 }
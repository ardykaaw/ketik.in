<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class AiGenerationCompleted extends Notification
{
    use Queueable;

    public $queueId;
    public $featureType;
    public $contentId;

    public function __construct($queueId, $featureType, $contentId)
    {
        $this->queueId = $queueId;
        $this->featureType = $featureType;
        $this->contentId = $contentId;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $title = 'Quillio - AI Selesai!';
        $body = 'Tugas generasi AI Anda sudah selesai dan siap digunakan.';
        
        // Define action URL based on feature type
        $url = '/';
        if (str_contains($this->featureType, 'guru')) {
            $url = '/guru/pustaka/' . $this->contentId;
        }

        return (new WebPushMessage)
            ->title($title)
            ->icon('/favicon.ico')
            ->body($body)
            ->action('Lihat Hasil', 'view_result')
            ->data(['url' => $url])
            ->vibrate([100, 50, 100]);
    }
}

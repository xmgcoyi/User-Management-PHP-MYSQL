<?php


namespace Application;


class NotificationTransaction
{
    private $notificationGateway;
    private $notifications;
    private $total;

    public function __construct(NotificationGateway $notificationGateway)
    {
        $this->notificationGateway = $notificationGateway;
    }

    public function findAdminNotifications()
    {
        $reciver = 'Admin';
        $this->findNotificationsByReciver($reciver);

        return $this;
    }

    public function findNotificationsByReciver($reciver)
    {
        list($this->notifications , $this->total) = $this->notificationGateway->findByNotiReciver($reciver);
    }

    public function getNotications()
    {
        return $this->notifications;
    }

    public function getTotal()
    {
        return $this->total;
    }
}
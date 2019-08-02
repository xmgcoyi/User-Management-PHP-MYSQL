<?php


namespace Application;


use PDO;

class FeedbackGateway extends AbstractGateway
{
    public function insertSenderReciverTitleFeedbackAttachment($user, $reciver, $title, $description, $attachment)
    {
        $sql = "insert into feedback (sender, reciver, title,feedbackdata,attachment) values (:user,:reciver,:title,:description,:attachment)";
        $query = $this->pdo->prepare($sql);
        $query->bindParam(':user', $user, PDO::PARAM_STR);
        $query->bindParam(':reciver', $reciver, PDO::PARAM_STR);
        $query->bindParam(':title', $title, PDO::PARAM_STR);
        $query->bindParam(':description', $description, PDO::PARAM_STR);
        $query->bindParam(':attachment', $attachment, PDO::PARAM_STR);
        $query->execute();
    }

    public function countByReciver($reciver)
    {
        $sql1 = "SELECT id from feedback where reciver = (:reciver)";
        $query1 = $this->pdo->prepare($sql1);;
        $query1->bindParam(':reciver', $reciver, PDO::PARAM_STR);
        $query1->execute();
        $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
        return $query1->rowCount();
    }
}
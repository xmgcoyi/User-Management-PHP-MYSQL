<?php
namespace Application;

use PDO;

class NotificationGateway extends AbstractGateway
{
    public function insertUserReciverType($user, $notireciver, $notitype)
    {
        $sqlnoti="insert into notification (notiuser,notireciver,notitype) values (:notiuser,:notireciver,:notitype)";
        $querynoti = $this->pdo->prepare($sqlnoti);
        $querynoti-> bindParam(':notiuser', $user, PDO::PARAM_STR);
        $querynoti-> bindParam(':notireciver', $notireciver, PDO::PARAM_STR);
        $querynoti-> bindParam(':notitype', $notitype, PDO::PARAM_STR);
        $querynoti->execute();
    }

    public function countByReciver($reciver)
    {
        $sql12 ="SELECT id from notification where notireciver = (:reciver)";
        $query12 = $this->pdo -> prepare($sql12);;
        $query12-> bindParam(':reciver', $reciver, PDO::PARAM_STR);
        $query12->execute();
        $results12=$query12->fetchAll(PDO::FETCH_OBJ);
        $regbd2=$query12->rowCount();

        return $regbd2;
    }
}
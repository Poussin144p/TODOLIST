<?php

class Db {
    private $pdo;

    public function __construct() {
        if ($this->pdo === null) {
            $pdo = new PDO('mysql:dbname=todolist;host=localhost', 'root', '');
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function getTasks() {
        $sql = 'SELECT *
        FROM tasks
        ORDER BY date_created ASC';

        $sth = $this->pdo->prepare($sql);

        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTask($id) {
        $sql = 'SELECT *
        FROM tasks
        WHERE id=:id';

        $sth = $this->pdo->prepare($sql);
        $sth->execute([':id' => $id]);

        return $sth->fetch(PDO::FETCH_OBJ);
    }

    public function addtask($task) {
        $sql = "INSERT INTO `tasks`(`task`, `date_created`, `status`) VALUES (:task,CURRENT_TIMESTAMP(),'pending')";
        $sth = $this->pdo->prepare($sql);
        $r = $sth->execute(
            array(
                ":task"=>$task
            )
        );
        $id = $this->pdo->lastInsertId();
        if($r) return array($this->getTask($id));
        else return array("message" => "Erreur d'insertion en base de données");
    }

    public function updateTask($id, $status) {
        /**
         * TODO
         * 
         * Exemple de requête SQL
         * UPDATE tasks SET status = :status WHERE id=:id
         * 
         * Voir prepare et execute dans addTask pour vous inspirer 
         */
        $sql = "UPDATE tasks SET status=:status WHERE id=:id";
        $sth = $this->pdo->prepare($sql);
        $r = $sth->execute(
            array(
                "id"=>$id,
                "status"=>$status,
            ));
        if($r) return array($this->getTask($id));
        else return array("message" => "Erreur de modification dans la base de données");

    }

    public function lastInsertId() {
        $sql = "SELECT MAX(id) FROM tasks";

        $sth = $this->pdo->prepare($sql);

        $sth->execute();

        $id = $sth->fetchAll(PDO::FETCH_NUM);
        
        return intval($id[0][0]);
    }

    public function deleteTask($id) {
        /**
         * TODO
         * 
         * A vous de jouer :)
         */
        $sql = "DELETE FROM tasks WHERE id=:id";

        $sth = $this->pdo->prepare($sql);

        $r = $sth->execute(
            array(
                "id"=>$id,
        ));

        if ($r) return array("message" => "L'élément a été supprimé");
        else return array("message" => "Problème lors de la supression");
    }
}

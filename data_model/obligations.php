<?php

class Obligation {

    public $id;
    public $name;
    public $description;
    public $date;
    public $isDone;
    public $subject_id;

    public function __contruct($id, $name, $description, $date, $isDone, $subject_id){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->date = $date;
        $this->isDone = $isDone;
        $this->subject_id = $subject_id;
    }

    public static function getAll(mysqli $connection){
        $query = 'select o.id, o.name as task_name, o.description, o.date, o.isDone, s.name as subject_name from obligations o
                left join subjects s on s.id = o.subject_id;';

        return $connection->query($query);
    }

    public static function getOne($id, mysqli $connection){
        $query = 'select o.id, o.name as task_name, o.description, o.date, o.isDone, s.id as subject_id, s.name as subject_name from obligations o
                left join subjects s on s.id = o.subject_id
                where o.id='.$id.";";

        $arr = array();
        if($result = $connection->query($query)){
            
            while($row = $result->fetch_array(1)){
                $arr[] = $row;
            }
        }

        return $arr;
    }

    public static function update($id, $name, $description, $date, $isDone, $subject_id, mysqli $connection){
        $query = "update obligations set name='".$name."', description='".$description."', date='".$date."', isDone=".$isDone.", subject_id=".$subject_id." where id=".$id.";";

        return $connection->query($query);
    }

    public static function delete($id, mysqli $connection){
        $query = "delete from obligations where id=".$id.";";

        return $connection->query($query);
    }

    public static function insert($name, $description, $date, $isDone, $subject_id, mysqli $connection){
        $query = "insert into obligations (name, description, date, isDone, subject_id) values ('".$name."', '".$description."', '".$date."', ".$isDone.", ".$subject_id.");";

        return $connection->query($query);
    }
}

?>

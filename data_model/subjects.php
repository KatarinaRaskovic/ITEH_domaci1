<?php

class Subject {

    public $id;
    public $name;
    public $espb;
    public $semester;

    public function __contruct($id, $name, $espb, $semester){
        $this->id = $id;
        $this->name = $name;
        $this->espb = $espb;
        $this->semester = $semester;
    }

    public static function getAll(mysqli $connection){
        $query = 'select s.id as subject_id, s.name as subject_name, s.espb, s.semester from subjects s;';

        return $connection->query($query);
    }

    public static function getOne($id, mysqli $connection){
        $query = 'select * from subjects s
                where id='.$id.";";

        $arr = array();
        if($result = $connection->query($query)){
            
            while($row = $result->fetch_array(1)){
                $arr[] = $row;
            }
        }

        return $arr;
    }

    public static function update($id, $name, $espb, $semester, mysqli $connection){
        $query = "update subjects set name='".$name."', espb=".$espb.", semester=".$semester." where id=".$id.";";

        return $connection->query($query);
    }

    public static function delete($id, mysqli $connection){
        $query = "delete from subjects where id=".$id.";";

        return $connection->query($query);
    }

    public static function insert($name, $espb, $semester, mysqli $connection){
        $query = "insert into subjects (name, espb, semester) values ('".$name."',".$espb.",".$semester.");";

        return $connection->query($query);
    }
}

?>

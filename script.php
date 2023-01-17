<?php

class dbcon{
    static public function conn() {
        try{
            $db = new PDO('mysql:host=localhost;dbname=e-lyrics','root','');
            $db ->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC);
            return $db;
        }
        catch (PDOException $e){
            print "err". $e ->getMessage();
            die();
        }
    }
}

class song extends dbcon{
    private $song_name;
    private $singer_name;
    private $album_name;
    private $lyrics;
    function __construct($n,$s,$al,$l)
    {
        $this->song_name = $n;
        $this->singer_name = $s;
        $this->album_name = $al;
        $this->lyrics = $l;
    }

    function insertsong(){
        $sql = 'INSERT INTO `songs`(`song_name`, `singer_name`, `album_name`, `lyrics`) VALUES (?,?,?,?)';
        $exe = self::conn() -> prepare($sql);
        $exe ->execute([$this->song_name,$this->singer_name,$this->album_name,$this->lyrics]);
    }

    static function deletesong($id){
        $sql = 'DELETE FROM `songs` WHERE id = ?';
        $exe = self::conn() -> prepare($sql);
        $exe ->execute([$id]);
    }

    function updatesong($id){
        $sql = 'UPDATE `songs` SET `song_name`=?,`singer_name`=?,`album_name`=?,`lyrics`=? WHERE id = ?';
        $exe = self::conn() -> prepare($sql);
        $exe ->execute([$this->song_name,$this->singer_name,$this->album_name,$this->lyrics,$id]); 
    }

    static function update($where,$content,$id){
        $sql = 'UPDATE `songs` SET '.$where.' = ? WHERE id = ?';
        $exe = self::conn() -> prepare($sql);
        $exe ->execute([$content,intval($id)]);
    }

    static function getsongs(){
        $sql = 'SELECT * FROM songs';
        $exe = self::conn() -> prepare($sql);
        $exe ->execute([]);
        $res = $exe->fetchAll();
        return $res;
    }

    static function getstatistics(){
        $sql = 'SELECT COUNT(*) as songscount,COUNT(DISTINCT singer_name) as singerscount,COUNT(DISTINCT album_name) albumscount FROM `songs`;';
        $exe = self::conn() -> prepare($sql);
        $exe ->execute([]);
        $res = $exe->fetch();
        $sql = 'SELECT COUNT(*) as usercount from users';
        $exe = self::conn() -> prepare($sql);
        $exe ->execute([]);
        $res1 = $exe->fetch();
        return $res+$res1;
    }
}

// $song = new song('jjjjjjee','singer','album','lyrics');
// $song->insertsong();
// $song->updatesong(2);

// var_dump(song::getsongs());

if(isset($_GET['action'])){
    if($_GET['action']=='add'){
        $data = json_decode($_GET['data']);
        $song = new song($data[0],$data[1],$data[2],$data[3]);
        $song->insertsong();
    }elseif ($_GET['action']=='get') {
       echo json_encode( song::getsongs());
    }elseif ($_GET['action']=='delete') {
        song::deletesong($_GET['id']);
    }elseif ($_GET['action']=='update') {
        song::update($_GET['where'],$_GET['content'],$_GET['id']);
    }elseif ($_GET['action']=='getstatistics') {
        echo json_encode(song::getstatistics());
    }
}


<?php
//ambil data di database login lalu 
class SQL extends Server{
    static function GetData($table,$queri,$join=null,$filter=null)
    {
        $sql="select $queri from $table $join $filter";
        $query=self::RunQuery($sql,"query fail!");
        $data=[];
        while($datas=$query->fetch_assoc()){
            $data[]=$datas;
        }
        return $data;
    }

    static function InsertData($table,$data,$callback=null)
    {
        $queri="insert into $table values $data ";
        // return self::RunQuery($queri,"edit fail!");
        $callback;
        return self::RunQuery($queri,"insert data fail!");
    }

    static function EditData($table,$data,$id_column,$id,$callback=null)
    {
        $queri="update $table set $data where $id_column = $id";
        // return self::RunQuery($queri,"edit fail!");
        $callback;
        return self::RunQuery($queri,"Edit data fail!");
    }

    static function DeleteData($table,$id_column,$id,$callback=null)
    {//delete all data if u want to delete spesific data use update or use EditData method
        $queri="delete from $table  where $id_column = $id";
        // return self::RunQuery($queri,"edit fail!");
        $callback;
        return self::RunQuery($queri,"Delete data fail!");
    }

    static function RunQuery($query,$ifErrMsg=null)
    {
        $queri=self::Koneksi()->query($query);
        if($queri){
            return $queri;
        }else{
            echo $ifErrMsg;
        }
    }
}

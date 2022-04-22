<?php 
class Util{
    static function Refresh($time)
    {
        //refreshes your current page
        return header("Refresh:$time");
    }
     function Redirect($redirect)
    {   //error
           return header("location : $redirect");
    }

     function DeleteFoto($table,$col,$id,$callback=null)
    {//delete all data if u want to delete spesific data use update 
        $queri="update $table set $col=null  where id = $id";
        $callback;
        return SQL::RunQuery($queri,"DeleteFoto fail!");
    }

    function UniqueStr($name,bool $moreUniqueNess)
    {
        return uniqid($name,$moreUniqueNess);
    }

    function Delete($file)
    {
        return unlink($file);//delete file
    }

    function UploadFoto($tmp_name,$directory,$callback=null)
    {
        $callback;
        move_uploaded_file($tmp_name,$directory);
    }

    function Api(String $json,bool $isarr=false)
    {
            $Api=file_get_contents($json);
            if(!$Api){
                return "!onApi";
            }
            return json_decode($Api,$isarr);
    }

    function ApiSend(string $url,bool $post,array $data,$callback)
    {
        $options=[
            CURLOPT_URL=>$url,
            CURLOPT_POST=>$post,
            CURLOPT_POSTFIELDS=>http_build_query($data),
            CURLOPT_RETURNTRANSFER=>1
        ];
        $ch=curl_init();
        curl_setopt_array($ch,$options);
        curl_exec($ch);
        curl_close($ch);
        $callback;
    }
                //  error can update data trough api
    function ApiUpdate(string $url,$data,$callback=null)
    {
        $options=[
            CURLOPT_URL=>$url,
            CURLOPT_CUSTOMREQUEST=> "PUT", //tindakan 
            CURLOPT_POSTFIELDS=> $data,
            CURLOPT_RETURNTRANSFER=>1
        ];
        $ch=curl_init();
        curl_setopt_array($ch,$options);
        curl_exec($ch);
        curl_close($ch);
    }

    function ApiDelete(string $url,$callback=null)
    {
        $options=[
            CURLOPT_URL=>$url,
            CURLOPT_CUSTOMREQUEST => "DELETE", //tindakkan,
            CURLOPT_RETURNTRANSFER=>TRUE
        ];
        $ch=curl_init();
        curl_setopt_array($ch,$options);
       $res=curl_exec($ch);
       if($res){
           echo"nice 69!";
       }
        curl_close($ch);
        $callback;
    }

    function isError($ch,$res)
    {
        if($e=curl_error($ch)){
            echo $e;
        }else{
            $results=json_decode($res);
            print_r($results);
        }
    }
    
}
<?php
$host="localhost";
$user="eavnicom_eavni";
$pass="5597284@ea";
$db="eavnicom_eliran";

$conn=new mysqli($host,$user,$pass,$db);
$conn->set_charset("utf8");
if ($conn->connect_error){
die("Connection failed: ".$conn->connect_error);}

$routes = array(
    '/'      => 'Welcome! This is the main page. you can load data to database with routes or to click the buttons.',
    '/fetch-tweets' => 'fetch',
    '/tweet-report' => 'report'
);


function router($routes)
{
    
    foreach ($routes as $path => $content) {
        if ($path == $_SERVER['PATH_INFO']) {
            
           if($content=="Welcome! This is the main page. you can load data to database with routes or to click the buttons.")
           {
               echo $content;
               return;
           }
            else if($content=='fetch')
            {
                $host="localhost";
$user="eavnicom_eavni";
$pass="5597284@ea";
$db="eavnicom_eliran";

$conn=new mysqli($host,$user,$pass,$db);
$conn->set_charset("utf8");
if ($conn->connect_error){
die("Connection failed: ".$conn->connect_error);}
       $response = file_get_contents('http://api.datamuse.com/words?ml=affiliate');
$response = json_decode($response, JSON_PRETTY_PRINT);

$length =count($response);

for ($i=0;$i< $length;$i++)
{
$sql="INSERT INTO first (word,score) VALUES('".$response[$i]['word']."','".$response[$i]['score']."')";
$conn->query($sql) ;

}


$response = file_get_contents('http://api.datamuse.com/words?ml=marketing');
$response = json_decode($response, JSON_PRETTY_PRINT);

$length =count($response);

for ($i=0;$i< $length;$i++)
{
$sql="INSERT INTO second (words,scores) VALUES('".$response[$i]['word']."','".$response[$i]['score']."')";
$conn->query($sql) ;

}
$response = file_get_contents('http://api.datamuse.com/words?ml=influencer');
$response = json_decode($response, JSON_PRETTY_PRINT);

$length =count($response);

for ($i=0;$i< $length;$i++)
{
$sql="INSERT INTO third (wordt,scoret) VALUES('".$response[$i]['word']."','".$response[$i]['score']."')";
$conn->query($sql) ;

}
$conn->close();
           echo "data saved!";
            return;
            }
        else if($content=='report') 
        {
           $response = file_get_contents('http://api.datamuse.com/words?ml=affiliate');
           $response = json_decode($response, JSON_PRETTY_PRINT);
           $length =count($response); 
           echo "there are ".$length." "."for affilate";
           echo "  ";
           $response = file_get_contents('http://api.datamuse.com/words?ml=marketing');
           $response = json_decode($response, JSON_PRETTY_PRINT);
           $length2 =count($response); 
           echo "there are ".$length2." "."for marketing";
           echo "  ";
           $response = file_get_contents('http://api.datamuse.com/words?ml=influencer');
           $response = json_decode($response, JSON_PRETTY_PRINT);
           $length3 =count($response); 
           echo "there are ".$length3." "."for influencer";
           return;
        }
        }
    }

    
    echo 'Sorry! Page not found, try to add "/" to the url';
}


router($routes);


if(isset($_POST['fetchWords']))
{
$response = file_get_contents('http://api.datamuse.com/words?ml=affiliate');
$response = json_decode($response, JSON_PRETTY_PRINT);

$length =count($response);

for ($i=0;$i< $length;$i++)
{
$sql="INSERT INTO first (word,score) VALUES('".$response[$i]['word']."','".$response[$i]['score']."')";
$conn->query($sql) ;

}


$response = file_get_contents('http://api.datamuse.com/words?ml=marketing');
$response = json_decode($response, JSON_PRETTY_PRINT);

$length =count($response);

for ($i=0;$i< $length;$i++)
{
$sql="INSERT INTO second (words,scores) VALUES('".$response[$i]['word']."','".$response[$i]['score']."')";
$conn->query($sql) ;

}
$response = file_get_contents('http://api.datamuse.com/words?ml=influencer');
$response = json_decode($response, JSON_PRETTY_PRINT);

$length =count($response);

for ($i=0;$i< $length;$i++)
{
$sql="INSERT INTO third (wordt,scoret) VALUES('".$response[$i]['word']."','".$response[$i]['score']."')";
$conn->query($sql) ;

}
$conn->close();
echo "data saved!";
}



?>

<!DOCTYPE HTML>
<html>
    <head>
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> 
    </head>
<body>
   <div class="container">
       <div class="row">
           <div class="col-md-12">
             <form method="post" action="">
    <button class="btn btn-primary" id="fetchWords" name="fetchWords" type="submit">Fetch-words</button>
    </form>
    <form method="post" action="">
    <button class="btn btn-primary" name="show">Show-report</button>
    </form>
    <?php
    if(isset($_POST['show']))
{
     $sql="SELECT * from first" ;
      $result=$conn-> query($sql);
       if($result->num_rows>0)
         {
         $i=1;
       echo'<h3>for "affiliate"</h3>';
       while($row=$result->fetch_assoc())
        {
        
        echo $row['word'];
        echo"  ";
        echo $row['score'];
        echo"  ";
        }
}echo '<hr>';

     $sql="SELECT * from second" ;
      $result=$conn-> query($sql);
       if($result->num_rows>0)
         {
         $i=1;
        echo'<h3>for "marketing"</h3>';
       while($row=$result->fetch_assoc())
        {
       
        echo $row['words'];
        echo"  ";
        echo $row['scores'];
        echo"  ";
        }
} echo '<hr>';
    $sql="SELECT * from third" ;
      $result=$conn-> query($sql);
       if($result->num_rows>0)
         {
         $i=1;
       echo'<h3>for "influencer"</h3>';
       while($row=$result->fetch_assoc())
        {
         
        echo $row['wordt'];
        echo"  ";
        echo $row['scoret'];
        echo"  ";
        }
}
else
{
    echo'oops, looks like you need to "fetch" first.' .'<br>'.'click the "Fetch-words" button or add to the url "fetch-tweets" and try again!'; 
}
}
    
    
    ?>  
           </div>
       </div>
   </div>
   
  
</body>
</html>
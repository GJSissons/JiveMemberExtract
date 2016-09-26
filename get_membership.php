<html>
    
<style>
    body {
        color: #5e5e5e;
        font: 13px "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
    }
</style>
    
<body>

<style type="text/css">
    table.members {
        font-family: verdana,arial,sans-serif;
        font-size:11px;
        color:#333333;
        border-width: 1px;
        border-color: #3A3A3A;
        border-collapse: collapse;
        width:100%;
    }
    table.members th {
        font-size:14px;
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #3A3A3A;
        color:#ffffff;
        background-color: #006dbd;
    }
    table.members td {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #3A3A3A;
        background-color: #ffffff;
    }
</style>    

<?PHP

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, $_POST['username'].':'.$_POST['password']);

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}



$count = 0;
$loop = true;
$percent = 0;
$loop_count = 0;
$jive_url = $_POST['url'];

set_time_limit(300);

?>
<H2>Membership</h2>
<br>
<div id="progress" style="width:500px;border:1px solid #ccc;"></div>
<div id="information" style="width:500px;"></div>

<?php


while ($loop_count<20) {
    $loop_count++;   
    $result = CallAPI("GET", "{$jive_url}/api/core/v3/people?fields=@all,-resources&count=100&startIndex=$count"); 
    $json_result = json_decode($result, true);
    //print_r ($json_result);
    $size = sizeof($json_result['list']);

    for ($i=0; $i<$size; $i++) {
        $members[$count+$i]['id'] = $json_result['list'][$i]['id'];
        $members[$count+$i]['email'] = $json_result['list'][$i]['emails']['0']['value'];
        $members[$count+$i]['name'] =  $json_result['list'][$i]['name']['formatted'];
        //print_r($json_result['list'][$i]['jive']);
        $members[$count+$i]['company'] = '';            
        if (array_key_exists('profile',$json_result['list'][$i]['jive'])) {
            // Since profile exists, we should parse through the array for an existing customer label ...
            for ($j=0; $j<10; $j++) {
                if ($json_result['list'][$i]['jive']['profile'][$j]['jive_label']=='Company') {
                    $members[$count+$i]['company'] = $json_result['list'][$i]['jive']['profile'][$j]['value'];
                }
                
            }
            
 
        } 
        
    }
    $count = $count + $size;
    $percent = $percent + 5;

    
     // Javascript for updating the progress bar and information
    echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.'%;background-color:#ddd;\">&nbsp;</div>";
    document.getElementById("information").innerHTML="'.$size.' rows retrieved, '.$count.' total rows processed.";
    </script>';
        
    // This is for the buffer achieve the minimum size in order to flush data
    echo str_repeat(' ',1024*64);
    
    // Send output to browser immediately
    flush();

    if ($size<100) $loop = false;
}

if (sizeof($members) == 0) { 
    echo '<b>You have likely provided an incorrect username and password or your account does not have adminsitrator priveleges. </b>';
    echo '<br><br><a href="index.php">Go back and try another username / password</a>';
    echo '</body></html>'; exit;
}


echo '<p><a href="index.php">Return to the login screen</a></p>';
echo '<p>Report run on: '.date("Y-m-d h:i:sa").' (GMT)';

echo '<p>Total Membership:<b> '.sizeof($members).'</b></p>';

echo '<table class="members">';

echo '<thead>';
echo '<tr>';
echo '<th>#</th>';
echo '<th>ID</th>';
echo '<th>Name</th>';
echo '<th>e-Mail</th>';
echo '<th>Company</th>';
echo '</tr>';
echo '</thead>';



for ($i=0; $i<sizeof($members); $i++) {
    
    $style='';
    
    echo '<tr>';
    echo '<td '.$style.'>'.($i+1).'</td>';
    echo '<td '.$style.'>'.$members[$i]['id'].'</td>';
    echo '<td '.$style.'>'.$members[$i]['name'].'</td>';
    echo '<td '.$style.'>'.$members[$i]['email'].'</td>';
    echo '<td '.$style.'>'.$members[$i]['company'].'</td>';
    echo '</tr>';
}

echo '</table>'


?>
</body>
</html>

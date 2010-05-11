<?php
die(str_repeat("_",100));
error_reporting(E_ALL);
// Create 100 byte shared memory block with system id of 0xff3
$t = ftok("../php-projects/downloader/download.php","n");
$shm_id = shmop_open($t, "c", 0644, 10000000);
if (!$shm_id) {
    echo "Couldn't create shared memory segment\n";
}
echo "$t\n$shm_id";

// Get shared memory block's size
$shm_size = shmop_size($shm_id);
echo "SHM Block Size: " . $shm_size . " has been created.\n";

$blancos = str_repeat(chr(0),$shm_size);

$array = "";//array("uno","dos","tre"=>"tres","cuatro"=>"cuatro",3,4,array(4,5,6,"siete","ocho","nueve"=>"nueve"));
shmop_write($shm_id, serialize($array).$blancos, 0);
print_r(unserialize(shmop_read($shm_id, 0, $shm_size))); 
print_r($array);
foreach ($array as $q)
{echo "qwe";}

if (!shmop_delete($shm_id)) {
   echo "Couldn't mark shared memory block for deletion.";
}
shmop_close($shm_id);

/*set_q("asd");
$pid = pcntl_fork();
if ($pid == -1) {
     die('could not fork');
} else if ($pid) {
     // we are the parent
     sleep(5);
    print_r(get_q());
    echo ("teh parent ");
    pcntl_wait($status); //Protect against Zombie children
    die("teh parent, finish");
    if (!shmop_delete($shm_id)) {
       echo "Couldn't mark shared memory block for deletion.";
    }
    shmop_close($shm_id);
    die();
} else {
    set_q(str_repeat("a",4));
    echo("teh child");
     // we are the child
    die();
}

function set_q($value){
global $shm_id;
    $q[1] = $value;
    $q[2] = $value;
    
    shmop_write($shm_id, $value, 0);
}
function get_q()
{
    global $shm_id, $shm_size;
    return shmop_read($shm_id, 0, $shm_size);    
}*/


?>
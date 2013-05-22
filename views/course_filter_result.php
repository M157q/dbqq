<!DOCTYPE HTML>
<html>
<title>Searching Courses Result</title>
<body>
<?php
    session_start();
    require_once('../controllers/Session.php');
    require_once('../models/Course.php');
    require_once('../components/Mysqli.php');
 //   if ($_SESSION['ban']) RedirectByPerm($_SESSION['perm']);
    if ($_SESSION['perm'] != 'stu') RedirectByPerm($_SESSION['perm']);

    $redirect_url = '../views/stu_search_course.php';
    $errmsg = '';

    $mon = isset($_POST['mon']) ? $_POST['mon'] : array();
    $tue = isset($_POST['tue']) ? $_POST['tue'] : array();
    $wed = isset($_POST['wed']) ? $_POST['wed'] : array();
    $thu = isset($_POST['thu']) ? $_POST['thu'] : array();
    $fri = isset($_POST['fri']) ? $_POST['fri'] : array();
    $sat = isset($_POST['sat']) ? $_POST['sat'] : array();
    $sun = isset($_POST['sun']) ? $_POST['sun'] : array();

    $id = $_SESSION['id'];
    $dep = $_POST['dep'];
    $grade = $_POST['grade'];
    $mode = $_POST['mode'];
    $class_hours = array($mon, $tue, $wed, $thu, $fri, $sat, $sun);
    $name = "%";

    if(isset($_POST['name']))
        $name = "%".$_POST['name']."%";

    if(!isset($dep))
        $errmsg = '未選取任何系所，過濾器關閉';
    else if(!isset($grade))
        $errmsg = '未選取任何年級，過濾器關閉';
    else if(!isset($mode))
        $errmsg = '未選取過濾模式，過濾器關閉';
    else if(!isset($class_hours))
        $errmsg = '未選取任何時段，過濾器關閉';
    else
    {
        CourseFilter($dep,$grade,$mode,$class_hours,$name);
    }

    if($errmsg != '')
    {
        $_SESSION['errmsg'] = $errmsg;
        header("Location: $redirect_url");
    }

?>
<a href="../views/stu_search_course.php">回上頁</a>
</body>
</html>

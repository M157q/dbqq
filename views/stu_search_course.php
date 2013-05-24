<!DOCTYPE HTML>
<html>
<title>Course Filter</title>
<h2>課程過濾器</h2>
<body>
    <?php
        session_start();
        require_once('../controllers/Session.php');
        require_once('../models/User.php');
        require_once('../models/Course.php');
        CheckPermAndRedirect($_SESSION['perm'], 'stu');

        showWarning();

    ?>

    <form method="post" action="../views/course_filter_result.php">
        <p>系所:</p>
        <p>
        <input type="checkbox" name="dep[]" value="1">資訊工程學系
        <input type="checkbox" name="dep[]" value="2">電資學士班
        <input type="checkbox" name="dep[]" value="3">人文社會學系
        <input type="checkbox" name="dep[]" value="4">管理科學學系
        </p>
        <p>
        <input type="checkbox" name="dep[]" value="5">電子工程學系
        <input type="checkbox" name="dep[]" value="6">電機工程學系
        <input type="checkbox" name="dep[]" value="7">機械工程學系
        <input type="checkbox" name="dep[]" value="8">土木工程學系
        </p>
        <p>
        <input type="checkbox" name="dep[]" value="9">材料科學與工程學系
        <input type="checkbox" name="dep[]" value="10">奈米科學及工程學士學位學程
        <input type="checkbox" name="dep[]" value="11">電子物理學系
        </p>
        <p>
        <input type="checkbox" name="dep[]" value="12">財金管理學系
        <input type="checkbox" name="dep[]" value="13">應用數學系
        <input type="checkbox" name="dep[]" value="14">外國語文學系
        <input type="checkbox" name="dep[]" value="15">生物科技學系
        </p>
        <p>
        <input type="checkbox" name="dep[]" value="16">電信工程學系
        <input type="checkbox" name="dep[]" value="17">光電工程學系
        </p>

        <p>年級:</p>
        <p>
        <input type="checkbox" name="grade[]" value="1">大一
        <input type="checkbox" name="grade[]" value="2">大二
        <input type="checkbox" name="grade[]" value="3">大三
        <input type="checkbox" name="grade[]" value="4">大四
        <input type="checkbox" name="grade[]" value="5">研一
        <input type="checkbox" name="grade[]" value="6">研二
        </p>

        <p>時間過濾:
        <input type="radio" name="mode" value="1">模式一
        <input type="radio" name="mode" value="2">模式二
        </p>

        <table border="2">
        <tr>
            <th>時段\星期</th>
            <th>一</th>
            <th>二</th>
            <th>三</th>
            <th>四</th>
            <th>五</th>
            <th>六</th>
            <th>日</th>
        </tr>
        <?php
            $k = 1;
            $hours = array("A","B","C","D","X","E","F","G","H","Y","I","J","K","L");

            foreach($hours as $i)
            {
                echo "<tr>";
                echo "<td>$i</td>";
                echo "<td><input type=\"checkbox\" name=\"mon[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"tue[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"wed[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"thu[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"fri[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"sat[]\" value=\"$k\"></td>";
                echo "<td><input type=\"checkbox\" name=\"sun[]\" value=\"$k\"></td>";
                echo "</tr>";
                $k++;
            }
        ?>
        </table>
        <p>課程關鍵字:<input type="text" name="name"></p>

        <button type="submit">啟動過濾器</button>

    </form>
    <a href="../views/stu.php">回上頁</a>
</body>
</html>

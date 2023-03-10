<?php
include "dbconnect.php";

date_default_timezone_set("Asia/Kolkata");
$doi = date("Y/m/d");
$Available=true;
$sql_m;
$BookNoIssue=1;
$b=$_POST["Book_No"];
$m=$_POST["Member_ID"];
$issueBy= $_POST["issuedBy"];
$sql_b="SELECT * from books;";

$sql_check="SELECT * from member;";
$result_check=$conn->query($sql_check);

if($issueBy =="Student")
{
    $sql_m="SELECT * from student;";
}
else if($issueBy =="Faculty")
{
    $sql_m="SELECT * from faculty;";
}
$result_b = $conn->query($sql_b);
$result_m = $conn->query($sql_m);

function bookcheck($x,$y)
{
    if($x)
    {
        while($row=$x->fetch_assoc())
        {
            if($row["Book_No"] == $y && $row["Status"] == "Available")
            {
                return true;
            }
        }
    }
    return false;
}

function membercheck($x,$y)
{
    if($x)
    {
        while($row=$x->fetch_assoc())
        {
            if($row["Member_ID"] == $y)
            {
                return true;
            }
        }
    }
    return false;
}
function memberTypeCheck($x,$y,$z)
{
    if($x && $z =="Student")
    {
        while($row=$x->fetch_assoc())
        {
            if($row["Student_Rollno"] == $y)
            {
                return true;
            }
        }
    }
    else if($x && $z == "Faculty")
    {
        while($row=$x->fetch_assoc())
        {
            if($row["Faculty_ID"] == $y)
            {
                return true;
            }
        }
    }
    return false;
}


$result_m->data_seek(0);
$checkedb=bookcheck($result_b,$b);
$checkedm=membercheck($result_check,$m);
$checkedmt=memberTypeCheck($result_m,$m,$issueBy);

if($checkedb)
{
    if($checkedm && $checkedmt)
    {
        if($result_b && $result_m)
        {
            $result_m->data_seek(0);
            if($issueBy =="Student")
            {
                while($row = $result_m->fetch_assoc())
                {
                    if($row["Student_Rollno"]== $m)
                    {
                        if($row["Student_Book1"]==null)
                        {
                            $BookNoIssue = 1;
                        }
                        else if($row["Student_Book2"]==null)
                        {
                            $BookNoIssue = 2;
                        }
                        else if($row["Student_Book3"]==null)
                        {
                            $BookNoIssue = 3;
                        }
                        else
                        {
                            echo "Book issue limit reached for $m";
                            $Available = false;
                        }
                    }
                }  
            } 
            if($issueBy =="Faculty")
            {
                while($row = $result_m->fetch_assoc())
                {
                    if($row["Faculty_ID"]== $m)
                    {
                        if($row["Faculty_Book1"]==null)
                        {
                            $BookNoIssue = 1;
                        }
                        else if($row["Faculty_Book2"]==null)
                        {
                            $BookNoIssue = 2;
                        }
                        else if($row["Faculty_Book3"]==null)
                        {
                            $BookNoIssue = 3;
                        }
                        else if($row["Faculty_Book4"]==null)
                        {
                            $BookNoIssue = 4;
                        }
                        else if($row["Faculty_Book5"]==null)
                        {
                            $BookNoIssue = 5;
                        }
                        else
                        {
                            echo "Book issue limit reached for $m";
                            $Available= false;
                        }
                    }
                }
            }
            if($Available )
            {
                $sql_ir="INSERT INTO issue_return (Issue_By,Issue_Bookno,Issue_Date)
                values ('$m','$b','$doi');";
                $resultIssue=$conn->query($sql_ir);
                if($resultIssue)
                {
                    if($issueBy =="Student")
                    {
                        $slot ="Student_Book".$BookNoIssue; 
                        $sql_UpdateS="UPDATE student set $slot=$b where Student_Rollno = '$m';";  
                        $update_student = $conn->query($sql_UpdateS);
                        $sql_Update = "UPDATE books set Status='$m' where Book_No = $b;";
                        $update_book = $conn->query($sql_Update);
                        if($update_book && $update_student) echo"Book issued by $m successfully";
                        else echo $conn->error;
                    }
                    else if($issueBy == "Faculty")
                    {
                        $slot ="Faculty_Book".$BookNoIssue; 
                        $sql_UpdateF="UPDATE faculty set $slot=$b where Faculty_ID = '$m';";  
                        $update_faculty = $conn->query($sql_UpdateF);
                        $sql_Update = "UPDATE books set Status='$m' where Book_No = $b;";
                        $update_book = $conn->query($sql_Update);
                        if($update_book && $update_faculty) echo"Book issued by $m successfully";
                        else echo $conn->error;
                    }
                }
                else
                {
                    echo $conn->error;
                }
            }
            else
            {
                echo "Book $b not Available!!!";
            }
        }
        else
        {
            echo $conn->error;
        }
    }
    else
    {
        echo "Member $m not found!!!";
    }
}
else
{
    echo "Book $b is not Available!!!";
}
?>
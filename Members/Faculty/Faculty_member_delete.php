<?php
@session_start();
//include $_SERVER['DOCUMENT_ROOT'] . "/LibraryManagement/Auth/auth.php";
include "../../Auth/auth.php";
function delete_faculty($id)
{
    include "../../connection/dbconnect.php";
    $result_member = $conn->query("DELETE from member where Member_ID = '$id';");
    $result_faculty = $conn->query("DELETE from faculty where Faculty_ID = '$id';");
    if ($result_member) {
        if ($result_faculty) {
            return true;
        } else
            return false;
    }
    return false;
}

function check($fId)
{
    include "../../connection/dbconnect.php";
    $sql1 = "SELECT Member_ID from member where Member_ID = '$fId';";
    $result1 = $conn->query($sql1);
    $sql2 = "SELECT Faculty_ID from faculty where Faculty_ID = '$fId';";
    $result2 = $conn->query($sql2);
    if ($result1) {
        if ($result2) {
            if (mysqli_num_rows($result1) == 1 && mysqli_num_rows($result2) == 1) {
                return true;
            }
            return false;
        } else
            echo
                "
            <div title='Error❌' id='dialog-confirm'>
                <p class='notification-message'>$conn->error</p>
            </div>
        ";
    } else
        echo
            "
        <div title='Error❌' id='dialog-confirm'>
            <p class='notification-message'>$conn->error</p>
        </div>
    ";
    echo"<script>
        $( function() {
        $( '#dialog-confirm' ).dialog({
            resizable: false,
            height: 'auto',
            width: 400,
            modal: true,
            buttons: {
            'Ok': function() {
                $( this ).dialog( 'close' );
            }
            }
        });
        } );
        </script>";
}

function checkIssue($fId)
{
    include "../../connection/dbconnect.php";
    $sql = "SELECT * from issue_return where Issue_By = '$fId' and Return_Date is NULL";
    $result = $conn->query($sql);
    if ($result) {
        if (mysqli_num_rows($result) != 0) {
            return false;
        }
        return true;
    } else
        echo
            "
        <div title='Error❌' id='dialog-confirm'>
            <p class='notification-message'>$conn->error</p>
        </div>        
    ";
    echo"<script>
        $( function() {
        $( '#dialog-confirm' ).dialog({
            resizable: false,
            height: 'auto',
            width: 400,
            modal: true,
            buttons: {
            'Ok': function() {
                $( this ).dialog( 'close' );
            }
            }
        });
        } );
        </script>";
}
if (!verification() || $_POST["Access"] != "Main-Delete-Faculty-Member") {
    header("Location: /LibraryManagement/");
} else {
    if (!empty($_POST["fac_id"])) {
        $Fac_Id = $_POST["fac_id"];
        $Fac_Id = strtoupper($Fac_Id);
        $Fac_Id = preg_replace('/[^A-Za-z0-9]/', '', $Fac_Id);
        if (check($Fac_Id)) {
            if (checkIssue($Fac_Id)) {
                if (delete_faculty($Fac_Id)) {
                    echo
                        "
                        <div title='Success✅' id='dialog-confirm'>
                            <p class='notification-success-message'>Faculty '$Fac_Id' deleted successfully!!!</p>
                        </div>
                    ";
                } else {
                    echo
                        "
                        <div title='Error❌' id='dialog-confirm'>
                            <p class='notification-message'>Some error occurred!!!</p>
                        </div>
                    ";
                }
            } else
                echo
                "
                <div title='Error❌' id='dialog-confirm'>
                    <p class='notification-message'>Faculty $Fac_Id has not returned a book, so it can`t be deleted!!!</p>
                </div>
            ";
        } else
            echo
                "
                <div title='Error❌' id='dialog-confirm'>
                    <p class='notification-message'>Faculty '$Fac_Id' Record not found, Please check once!!!</p>
                </div>
            ";
            echo"<script>
                $( function() {
                $( '#dialog-confirm' ).dialog({
                    resizable: false,
                    height: 'auto',
                    width: 400,
                    modal: true,
                    buttons: {
                    'Ok': function() {
                        $( this ).dialog( 'close' );
                    }
                    }
                });
                } );
                </script>";
    }
     else
        header("Location: /LibraryManagement/");
}

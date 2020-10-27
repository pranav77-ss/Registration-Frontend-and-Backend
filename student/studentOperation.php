<?php 
    require_once("../server/db.php");

    session_start();

    $con = Createdb();

    if(!$con) {
        echo "Cannot connect to the Database";
    }

    if(isset($_POST['S_login'])) {
        studentVerification();
    }

    function studentVerification() {

        $student_GRNo = $_POST['S_Gr_No_check'];
        $student_mail = $_POST['S_Email_check'];
        $student_pswd = $_POST['S_pswd_check'];

        if( $student_GRNo && $student_mail && $student_pswd) {

        $verify = "SELECT * FROM students WHERE GR_No = '$student_GRNo'";

        $success = mysqli_query($GLOBALS['con'], $verify);

        if(mysqli_num_rows($success) > 0) {
            $registration = true;
            while($row = mysqli_fetch_assoc($success)) {
                if($row['Email'] == $student_mail &&  $row['Pswd'] == $student_pswd) {
                    $_SESSION['isstudentloggedin'] = true;
                    $_SESSION['GR_No'] = $row['GR_No'];
                    $_SESSION['First_Name'] = $row['first_Name'];
                    $_SESSION['Middle_Name'] = $row['middle_Name'];
                    $_SESSION['Last_Name'] = $row['last_Name'];
                    $_SESSION['Email'] = $row['Email'];
                    $_SESSION['Department'] = $row['Department'];
                    $_SESSION['branch_Id'] = $row['branch_Id'];
                    
                    header('location: studentHome.php');
                    
                }
                else {
                    $_SESSION['isstudentloggedin'] = false;
                    textNode('tomato', "Error: Invalid Credentials!");
                } 
            }
        }
        else {
            $_SESSION['isstudentloggedin'] = false;
            textNode('tomato', "Error: No such user Exists!");
        }
        
    }
    }
    function personalData() {
        $personal_data = '';
        return $personal_data;
    }
    function eduData() {
        return $Edu_data;
    }
    
    function checkData() {
        $student_GRNo = $_SESSION['GR_No'];
        $verify = "SELECT * FROM students WHERE GR_No = '$student_GRNo'";

        $success = mysqli_query($GLOBALS['con'], $verify);

        if(mysqli_num_rows($success) > 0) {
            $registration = true;
            while($row = mysqli_fetch_assoc($success)) {
                $_SESSION['Personal_Email'] = $row['Personal_Email'];
                $_SESSION['C_address'] = $row['C_address'];
                $_SESSION['P_address'] = $row['P_addess'];
                $_SESSION['contact_No'] = $row['contact_No'];
                $_SESSION['guardians_contact_No'] = $row['guardians_contact_No'];
                $_SESSION['Semister'] = $row['Semister'];
                $_SESSION['Divison'] = $row['Divison'];
                $_SESSION['Roll_No'] = $row['Roll_No'];
            }
        }
        $personal_data = $_SESSION['Personal_Email']&&$_SESSION['C_address']&&$_SESSION['P_address']&&$_SESSION['contact_No']&&$_SESSION['guardians_contact_No'];
        $Edu_data = $_SESSION['Semister']&&$_SESSION['Divison']&&$_SESSION['Roll_No'];

        if(empty($personal_data) && empty($Edu_data)) {
            $profile_strength = '33';
        }
        elseif(empty($personal_data) ||empty( $Edu_data)) {
            $profile_strength = '66';
        }
        else {
            $profile_strength = '100';
        }
        return $profile_strength;
    }

    function formStatus() {
        $profile_strength = checkData();
        $personal_data = $_SESSION['Personal_Email']&&$_SESSION['C_address']&&$_SESSION['P_address']&&$_SESSION['contact_No']&&$_SESSION['guardians_contact_No'];
        $Edu_data = $_SESSION['Semister']&&$_SESSION['Divison']&&$_SESSION['Roll_No'];

        if($profile_strength == '33') {
            $form = "displayboth";
        }
        elseif($profile_strength == '66') {
            if(empty($personal_data)) {
                $form = "displayPform";
            }
            else {
                $form = "displayEform";
            }
        }
        else {
            $form ="displaynone";
        }
        return $form;
    }
    function textNode($color, $msg) {
        $element = "<h4 style='background-color: $color;padding: 1em;'>$msg</h4>";
        echo $element;
    }

    if(isset($_POST['p_confirm'])) {
        insertPersonalData();
    }
    if(isset($_POST['ed_confirm'])) {
        insertEduData();
    }


    function insertPersonalData() {
        $Grno = $_SESSION['GR_No'];
        $Personal_Email = $_POST['p_email'];
        $Corresp_address = $_POST['c_address'];
        $Permant_address = $_POST['p_address'];
        $Contact_No = $_POST['c_number'];
        $Guardian_No = $_POST['g_c_number'];

        $sql = "UPDATE students SET Personal_Email = '$Personal_Email' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET C_address = '$Corresp_address' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET P_addess = '$Permant_address' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET contact_No = '$Contact_No' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET guardians_contact_No = '$Guardian_No' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        checkData();
        formStatus();
    }


    function insertEduData() {
        $Grno = $_SESSION['GR_No'];
        $Semister = $_POST['Semister'];
        $Division = $_POST['Division'];
        $Roll_No = $_POST['rollno'];


        $sql = "UPDATE students SET Semister = '$Semister' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET Divison = '$Division' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        $sql = "UPDATE students SET Roll_No = '$Roll_No' WHERE GR_No = '$Grno'";
        mysqli_query($GLOBALS['con'], $sql);

        checkData();
        formStatus();
    }
?>
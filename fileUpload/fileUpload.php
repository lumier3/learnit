<?php 

        $statusMsg = "";
        $fileName = "";
        $target_file= "";
        $fileType = "";
        $status = "danger";

        //file upload directory
        $target_dir = "../uploads/";
        
        if(isset($_POST["submit"]) || 
           isset($_POST["edit_instructor"]) || 
           isset($_POST["edit_course"]) ||
           isset($_POST["submitAssignment"])
           ) {
            if(!empty($_FILES["file"]["name"])) {
                $fileName = basename($_FILES["file"]["name"]);
                $target_file = $target_dir. $fileName;
                $fileType = pathinfo($target_file, PATHINFO_EXTENSION);
        }}




?>


   

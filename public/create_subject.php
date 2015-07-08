<?php session_start(); $_SESSION["message"] = null;?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
  if (isset($_POST["submit"])) {
    $menu_name = mysqli_real_escape_string($connection,$_POST["menu_name"]);
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];

    $required_fields = array("menu_name","position","visible");
    validat_presence($required_fields);
    $field_with_max_length = array("menu_name" => 15);
    validate_max_length($field_with_max_length);
    if (!empty($errors)) {
      redirect_to("new_subject.php");
    }
    $query = "INSERT INTO subjects (menu_name, position, visible) VALUES ('$menu_name', {$position}, {$visible})";
    $result = mysqli_query($connection,$query);

    if ($result) {
      $_SESSION["message"] = "Subject created";
      redirect_to("manage_content.php");
    }else {
      $_SESSION["message"] = "Subject Creation Failed";
      redirect_to("new_subject.php");
    }


  }else {
    redirect_to("new_subject.php");
  }
 ?>

<?php if (isset($connection)) { mysqli_close($connection);}?>

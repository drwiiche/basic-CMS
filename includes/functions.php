<?php
  $errors =[];
  function fieldname_as_text($fieldname){
    $fieldname = str_replace("_"," ",$fieldname);
    $fieldname = ucfirst($fieldname);
    return $fieldname;
  }
  function confirm_query($result_set){
    if (!$result_set) {
      die("Database query failed ");
    }
  }

  function redirect_to($location){
    header("location: ".$location);
  }

  function find_all_subjects(){
    global $connection;
    $query = "SELECT * FROM subjects ORDER BY position ASC ";
    $subjects = mysqli_query($connection,$query);
    confirm_query($subjects);
    return $subjects;
  }

  function find_pages_for_subject($subject_id){
    global $connection;
    $query = "SELECT * FROM pages WHERE visible = 1 AND subject_id = {$subject_id}";
    $pages = mysqli_query($connection,$query);
    confirm_query($pages);
    return $pages;
  }

  function find_subject_id($selected_subject_id){
    global $connection;
    $safe_sub = mysqli_real_escape_string($connection,$selected_subject_id);
    $query = "SELECT * FROM subjects WHERE id = {$safe_sub} LIMIT 1";
    $selected_set = mysqli_query($connection,$query);
    confirm_query($selected_set);

    if ($subject = mysqli_fetch_assoc($selected_set)) {
      return $subject;
    }else {
      return null;
    }
  }

  function find_page_id($selected_page_id){
    global $connection;
    $safe_select = mysqli_real_escape_string($connection,$selected_page_id);
    $query = "SELECT * FROM pages WHERE id = $safe_select LIMIT 1";
    $selected_page = mysqli_query($connection,$query);
    confirm_query($selected_page);

    if ($selected_page) {
      return $page = mysqli_fetch_assoc($selected_page);
    }else {
      return null;
    }
  }

  function has_presence($item){
    return isset($item) && !empty($item);
  }
  function validat_presence($required_fields){
    global $errors;
    foreach ($required_fields as $field ){
      if (!has_presence($field)){
        $errors[$field] = ucfirst($field) . "can't be blank";
      }
    }
  }

  function has_max_length($value,$length){
    return strlen($value) <= $length;
  }

  function validate_max_length($field_with_max_length){
    foreach($field_with_max_lngth as $field => $max){
      $field = trim($_POST[$field]);
      if (!has_max_length($field,$max)) {
        $errors["$field"] = ucfirst($field) . " is too long";
      }
    }
  }
 ?>

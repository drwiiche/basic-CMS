<?php session_start(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include('../includes/layouts/header.php'); ?>
<?php
  if (isset($_GET["subject"])) {
    $selected_subject_id = htmlspecialchars($_GET["subject"]);
    $current_subject = find_subject_id($selected_subject_id);
    $selected_page_id = null;
    $current_page = null;

  }elseif (isset($_GET["page"])) {
    $selected_subject_id = null;
    $current_subject = null;
    $selected_page_id = htmlspecialchars($_GET["page"]);
    $current_page = find_page_id($selected_page_id);
  }else {
    $current_subject = null;
    $current_page = null;
    $selected_page_id = null;
    $selected_subject_id = null;

  }
 ?>
<div id="main">

    <div id="navigation">
      <ul class="subjects">
      <?php $subjects = find_all_subjects(); ?>
      <?php while ($subject = mysqli_fetch_assoc($subjects)) { ?>

        <!-- add class="selected" to selected item -->
        <?php echo "<li";
            if ($subject["id"] == $selected_subject_id) {
              echo " class=\"selected\"";
            }
            echo ">";
         ?>

      <a href="manage_content.php?subject=<?php echo $subject["id"]; ?>">
        <?php echo $subject["menu_name"]; ?>
      </a><ul class="pages">
          <?php
          $pages = find_pages_for_subject($subject["id"]);
            while ($page = mysqli_fetch_assoc($pages)) {?>
              <?php echo "<li";
                if ($page["id"] == $selected_page_id) {
                echo " class=\"selected\"";
                }
                echo ">";
               ?>

              <a href="manage_content.php?page=<?php echo $page["id"]; ?>">
              <?php echo $page["menu_name"]; ?>
            </a></li>
          <?php  } ?>

      </ul>
    </li>
      <?php } ?>
      </ul>
        <?php mysqli_free_result($pages); ?>
        <?php mysqli_free_result($subjects);?>
        <br>
        <a href="new_subject.php">+ Add a Subject</a>
    </div>

    <div id="page">
      <?php
            $output = "<div class=\"message\">";
            $output .=  htmlentities($_SESSION["message"]);
            $output .= "</div>";
            if (isset($_SESSION["message"])) {
              echo $output;
              $_SESSION["message"] = null;
            }
       ?>
      <?php if ($current_subject) { ?>
         <h2>Manage Subject</h2>
         <?php echo $current_subject["menu_name"]; } ?><br>
         <a href="edit_subject.php?subject=<?php echo $current_subject["id"]; ?>">Edit Subject</a>
      <?php if ($current_page) { ?> <h2>Manage Page</h2> <?php echo $current_page["menu_name"]; } ?>

      <?php if (!isset($current_subject) && !isset($current_page)) {
        echo "<h2>Please select a subject</h2>";
      } ?>
    </div>
  </div>
<?php include("../includes/layouts/footer.php"); ?>

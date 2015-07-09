<?php session_start(); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include('../includes/layouts/header.php'); ?>
<?php
  if (empty($_GET["subject"])) {
    redirect_to("manage_content.php");
  }
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
    </div>

    <div id="page">
      <?php echo $subject["id"]; ?>
      <?php
            if (isset($_SESSION["message"])) {
            $output = "<div class=\"message\">";
            $output .=  htmlentities($_SESSION["message"]);
            $output .= "</div>";
              echo $output;
              $_SESSION["message"] = null;
            }
       ?>
      <h2>Edit Subject : <?php $subject_title = find_subject_id("$selected_subject_id");
                               echo $subject_title['menu_name'];
                            ?></h2>
      <form action="create_subject.php" method="post">
        <p>
          Subject name:
          <input type="text" name="menu_name" value="<?php echo $subject_title['menu_name']; ?>">
        </p>
        <p>
          Position:
          <select name="position">
            <?php
            $all_subjects = find_all_subjects();
            $subject_count = mysqli_num_rows($all_subjects);
            for ($count=1; $count <= $subject_count ; $count++) {
            echo "<option value=\"{$count}\"";
                  if ($current_subject["position"] == $count) {
                    echo " selected";
                  }
            echo ">{$count}</option>";

            } ?>
          </select>
        </p>
        <p>
          visible:
          <input type="radio" name="visible" value="0" <?php if ($current_subject["visible"] == 0) {
            echo " checked";
          } ?>> NO
          &nbsp;
          <input type="radio" name="visible" value="1"  <?php if ($current_subject["visible"] == 1) {
            echo " checked";
          } ?>> YES
        </p>
        <input type="submit" name="submit" value="Edit Subject">
      </form>
      <br>
      <a href="manage_content.php">Cancel</a>
      <?php mysqli_free_result($subjects); ?>
    </div>
  </div>
<?php include("../includes/layouts/footer.php"); ?>

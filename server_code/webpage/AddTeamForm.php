<?php
require_once "config/session_stuff.php";
require_once "config/config_local_new.php";

function getTeamInfo()
{
  $a = array();
 
  $sql = "SELECT * FROM `teams` ORDER BY id";
  //echo "here";
  if ($result = mysqli_query(LOCAL_DB::conn(), $sql))
  {
    if (mysqli_num_rows($result) > 0) 
    {
            $count = 0;
            while($row = mysqli_fetch_assoc($result)) 
            {
              $tempArr = array('name' => $row["name"], 'ip' => $row["ip"], 'color' => $row["color"]);
              array_push($a, $tempArr); 
               //echo "state " . $row["state"]. "<br>";
            }
        }
        else 
        {
            //echo "0 results";
        }
        // mysqli_close($conn);
  }
  else
  {

  }
  // close the db connection
  //mysqli_close($conn);

  return$a;



}

$php_list = json_encode(getTeamInfo());
//echo $php_list


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Add a Power-Pi unit</title>
    <style>
      #EmptySpaceSelector {
        display: "none"
      }
    </style>
    <link rel="stylesheet" href="main.css">
    <script type="text/javascript">

      let count = 0;
      let js_list = JSON.parse('<?php echo $php_list ?>');

      window.onload = () => {
        if (js_list.length === 0) {
          addTeam("", "", "");
        } else {
          for (let team of js_list) {
            addTeam(team.name, team.ip, team.color)
          }
        }
      }

      function addTeam(name, ip, color) {
        count++;
        document.getElementById("EmptySpaceSelector").outerHTML = "<label> Team " + count.toString() + ": </label>" +
          "<input name=\"team" + count.toString() + "_name\" type=\"text\" placeholder=\"Enter Team Name\" value=\"" + name + "\" />" +
          "<input name=\"team" + count.toString() + "_ip\" type=\"text\" placeholder=\"Enter IP Address\" value=\"" + ip + "\" />" +
          "<input name=\"team" + count.toString() + "_color\" type=\"text\" placeholder=\"Enter team color (#0F0F0F)\" value=\"" + color + "\" />" +
          "<input name=\"team"+count.toString() + "_clear\" type=\"checkbox\" />" + 
          "<br />" +
          "<span id=\"EmptySpaceSelector\"></span>";
      }

    </script>
  </head>
  <body>
    <form id="controller" action="form_processor_addTeams.php" method="get">
      <!--
      <label> Team 1: </label>
      <input type="text" name="team1_name" placeholder="Enter Team Name"></input>
      <input type="text" name="team1_ip" placeholder="Enter IP Address"></input>
      <br />
      -->
      <span id="EmptySpaceSelector"></span>
      <button type="button" onclick="addTeam('','','')"> Add Team </button>
      <button type="submit"> Submit </button>
    </form>


    <div class="wrapper">
          <div class="footer">
            <h3><a href="HomeView1.php">Home View 1</a></h3>
              <h3><a href="HomeView2.php">Home View 2</a></h3>
              <h3><a href="dynamicDashboardNew.php">Show All Teams</a></h3>
              <h3><a href="AddTeamForm.php">Add Teams</a></h3>
              <h3><a href="logout.php">Log Out</a></h3>
          </div>
        </div>
  </body>
</html>

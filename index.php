<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="main.css" rel="stylesheet" />
    <title>Company App</title>
  </head>
  <body>
    <?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $db = "marioskyr";

      $nameEdit='';
      $addressEdit='';
      $cityEdit='';
      $pCodeEdit='';
      $pNumEdit='';

      $conn = new mysqli($servername, $username, $password, $db);
      $connPDO = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
      $connPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      if(!empty($_GET['edit'])) {
        $buttonName='Update';
        $buttonCheck='updateBtn';
        $editLocate = mysqli_real_escape_string($conn, $_GET['edit']);
        $editData = "SELECT * FROM customersappdb WHERE id='$editLocate'";
      
        $result = $conn->query($editData);
        while($row = $result->fetch_assoc()) {
          $nameEdit = $row["names"];
          $addressEdit = $row["addresses"];
          $cityEdit = $row["cities"];
          $pCodeEdit = $row["pCodes"];
          $pNumEdit =  $row["pNumbers"];
        }

        if(isset($_POST['updateBtn'])) {
            $name = $_POST["fname"];
            $address = $_POST["address"];
            $city = $_POST["city"];
            $pCode = $_POST["pCode"];
            $pNumber = $_POST["pNumber"];

            $updateData = "UPDATE customersappdb SET names=?, addresses=?, cities=?, pCodes=?, pNumbers=? WHERE id=?";
            $stmt = $connPDO->prepare($updateData);
            $stmt->execute([$name, $address, $city, $pCode, $pNumber, $editLocate]);

            header("location:/");
        }

        $conn->close();
      } else {
        $buttonName="Add";
        $buttonCheck='submitBtn';
      }
    ?>
    <form method="POST" id="formInfo">
      <!-- Name -->
      <input
        type="text"
        class="inputCommon"
        id="fnameInput"
        name="fname"
        value="<?php echo $nameEdit ?>"
        placeholder="Name"
      />

      <!-- Address -->
      <input
        type="text"
        class="inputCommon"
        id="addressInput"
        name="address"
        value="<?php echo $addressEdit ?>"
        placeholder="Address"
      />

      <!-- Container -->
      <div class="pCodeCity">
        <!-- City -->
        <input
          type="text"
          class="inputCommon"
          id="cityInput"
          name="city"
          value="<?php echo $cityEdit ?>"
          placeholder="City"
        />

        <!-- Postal Code -->
        <input
          type="text"
          class="inputCommon"
          id="pCodeInput"
          name="pCode"
          value="<?php echo $pCodeEdit ?>"
          placeholder="Postal Code"
        />
      </div>

      <!-- Phone Number -->
      <input
        type="number"
        class="inputCommon"
        id="pNumberInput"
        name="pNumber"
        value="<?php echo $pNumEdit ?>"
        placeholder="Phone Number"
      />
      <!-- Submit Button -->
      <input type="submit" id="submitBtn" name="<?php echo $buttonCheck; ?>" value="<?php echo $buttonName; ?>" />
    </form>

    <center>
    <table style="width:80vw; margin-top: 40px;">
      <tr>
        <th style="border: 1px solid black;">Name</th>
        <th style="border: 1px solid black;">Address</th>
        <th style="border: 1px solid black;">City</th>
        <th style="border: 1px solid black;">Postal Code</th>
        <th style="border: 1px solid black;">Phone Number</th>
      </tr>

<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "marioskyr";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $db);
  /* check connection */
  if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
  } 

if(isset($_POST["submitBtn"])) {

  $name = $_POST["fname"];
  $address = $_POST["address"];
  $city = $_POST["city"];
  $pCode = $_POST["pCode"];
  $pNumber = $_POST["pNumber"];

  $stmt = $conn->prepare("INSERT INTO customersappdb (names, addresses, cities, pCodes, pNumbers) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param('sssii', $name, $address, $city, $pCode, $pNumber);
  $stmt->execute();

  $stmt->close();

  $conn->close();
  header("location:/");
  }

  $result = mysqli_query($conn,"SELECT * FROM customersappdb");
  while($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td style="border: 1px solid black; padding: 10px 5px;">' . $row['names'] . '</td>';
    echo '<td style="border: 1px solid black; padding: 10px 5px;">' . $row['addresses'] . "</td>";
    echo '<td style="border: 1px solid black; padding: 10px 5px;">' . $row['cities'] . "</td>";
    echo '<td style="border: 1px solid black; padding: 10px 5px;">' . $row['pCodes'] . "</td>";
    echo '<td style="border: 1px solid black; padding: 10px 5px;">' . $row['pNumbers'] . "</td>";
    echo '<td><a href="?edit='.$row['id'].'" class="fas fa-pencil-alt edit" name="edit"></a><a href="?delete='.$row['id'].'" class="far fa-times-circle delete" name="delete"></a></td>';
    echo '</tr>';
    }
    echo '</table>';
    echo '</center>';
    echo '</body>';
    echo '</html>';

    if(!empty($_GET['delete'])) {
      $idLocate = mysqli_real_escape_string($conn, $_GET['delete']);
      $deleteID = "DELETE FROM customersappdb WHERE id='$idLocate'";

      if($conn->query($deleteID) === TRUE) {
        echo "<script>console.log('deleted succesfully')</script>";
        header("location:/");
      } else {
        echo "Error deleting record: " . $conn->error;
      }

      $conn->close();
      
    }
?>

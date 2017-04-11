<?php
  function fetch_data(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $output = '';
    try {
      $conn = new PDO("mysql:host=$servername;dbname=dreamhome", $username, $password);
    // set the PDO error mode to exception
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "SELECT client.clientno, client.fname, client.lname, viewing.viewdate FROM client INNER JOIN viewing ON client.clientno = viewing.clientno ";
    // use exec() because no results are returned
    // $conn->exec($sql);
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

      foreach ($stmt->fetchAll() as $key => $value){
        // echo $value["propertyno"];
        $output .= '<tr>
                          <td>'.$value["clientno"].'</td>
                          <td>'.$value["fname"].'</td>
                          <td>'.$value["lname"].'</td>
                          <td>'.$value["viewdate"].'</td>
                     </tr>
                          ';
      }

    }
    catch(PDOException $e)
    {
      echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
    return $output;
  }




if (isset($_POST['submit']))
{


if($_POST['selectFormat'] == "PDF"){
  require_once('tcpdf/tcpdf.php');
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $obj_pdf->SetCreator(PDF_CREATOR);
      $obj_pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      $obj_pdf->SetDefaultMonospacedFont('helvetica');
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
      $obj_pdf->setPrintHeader(false);
      $obj_pdf->setPrintFooter(false);
      $obj_pdf->SetAutoPageBreak(TRUE, 10);
      $obj_pdf->SetFont('helvetica', '', 12);
      $obj_pdf->AddPage();
      $content = '';
      $content .= '
      <h3 align="center">Export HTML Table data to PDF using TCPDF in PHP</h3><br /><br />
      <table border="1" cellspacing="0" cellpadding="5">
           <tr>
                <th width="15%">Client Number</th>
                <th width="30%">First Name</th>
                <th width="30%">Last Name</th>
                <th width="25%">View Date</th>
           </tr>
      ';
      $content .= fetch_data();
      $content .= '</table>';
      $obj_pdf->writeHTML($content);
      $obj_pdf->Output('sample.pdf', 'I');
}
else if($_POST['selectFormat'] == "EXCEL"){
  header('Location: exportExcel.php');
}



}

?>
<!DOCTYPE html>
<html>
     <head>
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
          <title>lab7_5710451401</title>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
     </head>
     <body>
          <br /><br />
          <div class="container" style="width:700px;">
               <h3 align="center">lab7_5710451401</h3><br />
               <div class="table-responsive">
                    <table class="table table-bordered">
                         <tr>
                              <th width="15%">Client Number</th>
                              <th width="30%">First Name</th>
                              <th width="30%">Last Name</th>
                              <th width="25%">View Date</th>
                         </tr>
                    <?php
                    echo fetch_data();
                    ?>
                    </table>
                    <br />
                    <form method="post" >
                      <select class="btn btn-danger" name="selectFormat" >
                          <option value="PDF">PDF</option>
                          <option value="EXCEL">EXCEL</option>
                      </select>
                      <br />  <br />
                         <input type="submit" name="submit" class="btn btn-success" value="Create" />
                    </form>
               </div>
          </div>
     </body>
</html>

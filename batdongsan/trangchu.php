<?php
require("ketnoi.php");
$sql = "SELECT * FROM Full_Contract";
$query = sqlsrv_query($conn, $sql);
if($query === false) {
    die(print_r(sqlsrv_errors(), true));
}

if(isset($_POST["submit"])){
  
  $Customer_Name = $_POST["Customer_Name"];
  $Year_Of_Birth = $_POST["Year_Of_Birth"];
  $SSN = $_POST["SSN"];
  $Customer_Address = $_POST["Customer_Address"];
  $Mobile = $_POST["Mobile"];
  $Property_ID  = $_POST["Property_ID"];
  $Date_Of_Contract = $_POST["Date_Of_Contract"];
  $Price = $_POST["Price"];
  $Deposit = $_POST["Deposit"];
  $Remain = $_POST["Remain"];
  $Status = isset($_POST["Status"]) ? 1 : 0;
    if (!is_numeric($Price) || !is_numeric($Deposit) || !is_numeric($Remain)) {
    echo "<script>
            alert('Price, Deposit, and Remain must be numeric values.');
            window.location.href='trangchu.php';
          </script>";
    return;
}
  $sql = "INSERT INTO Full_Contract ( Customer_Name, Year_Of_Birth, SSN, Customer_Address, Mobile, Property_ID, Date_Of_Contract, Price, Deposit, Remain, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $params = array($Customer_Name, $Year_Of_Birth, $SSN, $Customer_Address, $Mobile, $Property_ID, $Date_Of_Contract, $Price, $Deposit, $Remain, $Status);
  $query = sqlsrv_query($conn, $sql, $params);

  if($query === false) {
      die(print_r(sqlsrv_errors(), true));
  } else {
      echo "<script>alert('Bạn đã thêm thành công')</script>";
      header("Location:trangchu.php");
  }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hợp đồng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <h1 class="mt-4 mb-4">Quản lí danh sách hợp đồng</h1>
        <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">Thêm hợp đồng</a>        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã hợp đồng</th>
                    <th>Tên khách hàng</th>
                    <th>Năm sinh</th>
                    <th>CMND</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Mã Bất động sản</th>
                    <th>Ngày hợp đồng</th>
                    <th>Giá</th>
                    <th>Đặt cọc</th>
                    <th>Còn lại</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)){
                ?>
                <tr>
                    <td><?=$row['ID'] ?></td>
                    <td><?=$row['Full_Contract_Code'] ?></td>
                    <td><?=$row['Customer_Name'] ?></td>
                    <td><?=$row['Year_Of_Birth'] ?></td>
                    <td><?=$row['SSN'] ?></td>
                    <td><?=$row['Customer_Address'] ?></td>
                    <td><?=$row['Mobile'] ?></td>
                    <td><?=$row['Property_ID'] ?></td>
                    <td><?=$row['Date_Of_Contract']->format('Y-m-d') ?></td>
                    <td><?=$row['Price'] ?></td>
                    <td><?=$row['Deposit'] ?></td>
                    <td><?=$row['Remain'] ?></td>
                    <td><?=$row['Status'] ?></td>
                    <td>
                        <a href='api/suaFullContract.php?id=<?= $row['ID']?>' class="btn btn-warning">Sửa</a>
                        <a onclick="return confirm('Bạn có chắc xóa hợp đồng này không?')" href="api/xoaFullContract.php?id=<?=$row['ID']?>" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
                    </div>
        
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createModalLabel">Tạo mới hợp đồng</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form id="createForm" method="post" action="trangchu.php">
      <div class="form-group">
        <label for="Customer_Name">Tên khách hàng:</label>
        <input type="text" class="form-control" name="Customer_Name">
      </div>
      <div class="form-group">
        <label for="Year_Of_Birth">Năm sinh:</label>
        <input type="text" class="form-control" name="Year_Of_Birth">
      </div>
      <div class="form-group">
        <label for="SSN">CMND:</label>
        <input type="text" class="form-control" name="SSN">
      </div>
      <div class="form-group">
        <label for="Customer_Address">Địa chỉ:</label>
        <input type="text" class="form-control" name="Customer_Address">
      </div>
      <div class="form-group">
        <label for="Mobile">Số điện thoại:</label>
        <input type="text" class="form-control" name="Mobile">
      </div>
      <div class="form-group">
        <label for="Property_ID">Mã Bất động sản:</label>
        <input type="text" class="form-control" name="Property_ID">
      </div>
      <div class="form-group">
        <label for="Date_Of_Contract">Ngày hợp đồng:</label>
        <input type="date" class="form-control" name="Date_Of_Contract">
      </div>
      <div class="form-group">
        <label for="Price">Giá:</label>
        <input type="text" class="form-control" name="Price">
      </div>
      <div class="form-group">
        <label for="Deposit">Tiền cọc:</label>
        <input type="text" class="form-control" name="Deposit">
      </div>
      <div class="form-group">
        <label for="Remain">Còn lại:</label>
        <input type="text" class="form-control" name="Remain">
      </div>
      <div class="form-group form-check">
        <label class="form-check-label" for="Status">Trạng thái</label>
        <input type="checkbox" class="form-check-input" id="Status" name="Status">

      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            <button type="submit" name="submit" class="btn btn-primary">Tạo mới</button>
        </div>
    </form>
      </div>
       
        </div>
    </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

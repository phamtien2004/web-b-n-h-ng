<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="dualeo.js"></script>
    <style>

        table{
            width: 80%;
            margin-left: 10%;
            border-collapse: collapse;
            text-align: center;
            border-radius: 5px;
            border: 0.5px solid grey;
        }
        th{
            background-color: grey;  
            padding: 10px 2px;
        }
        .button button{ 
            background-color: transparent;
            border: transparent;          
        }
        .button button:hover {
            box-shadow:  -5px 0px 6px rgba(0, 0, 0, 0.3);;
            background-color: #DDDDDD;
            border: 0.5px solid grey;
            border-radius: 4px;
        }
       a{
        text-decoration: none;
        color: black;
        
       }
        img{
            width: 245px;
        }
    </style>
</head>
<body>
    <h1>Trang giỏ hàng</h1>
    <table border="1" id="table"> 
        <thead>
        <tr>
            <th>ID</th>
            <th>Sản Phẩm</th>
            <th>Ảnh minh họa</th>
            <th>Giá thành</th>
            <th colspan="2">Số lượng</th>
            <th>Tổng giá</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
        <iframe name="hidden_giohang" style="display: none;"></iframe>
        <?php
        include("handle_giohang.php");
            $sql = "SELECT `ma_nguoi_dung`, `tenSP`, `soLuong`, `giaSP`, `anhSP` FROM `giohang` WHERE 1";
            $result = mysqli_query($conn, $sql);
            $total = 0;
            while($row = mysqli_fetch_array($result)){   
        ?>
        <td><?php echo $row['ma_nguoi_dung']; ?></td>
            <td><?php echo $row['tenSP']; ?></td>
            <td><img src="<?php echo $row['anhSP']; ?>" alt="Product Image"></td>
            <td >
                  <?php echo $row['giaSP'] ;?>  đ
             </td>
             <td colspan="2"> 
            <div style="display:flex;justify-content: space-around; align-items: center;">
                <span style="margin-left:10px;"><?php echo $row['soLuong']; ?></span>
                <div class="button" style=" display: flex;
            flex-direction: column;">
                     <form action="handle_reduce.php" method="POST" style="display: inline;" target="hidden_giohang">
                          <input type="hidden" name="id" value="<?php echo $row['ma_nguoi_dung']; ?>">
                          <input type="hidden" name="soLuong" value="<?php echo $row['soLuong']; ?>">
                          <button type="submit" name="action" value="increase">&#9650;</button>
                    </form>
                <form action="handle_reduce.php" method="POST" style="display: inline;" target="hidden_giohang">
                          <input type="hidden" name="id" value="<?php echo $row['ma_nguoi_dung']; ?>">
                          <input type="hidden" name="soLuong" value="<?php echo $row['soLuong']; ?>">
                          <button type="submit" name="action" value="decrease">&#9660;</button>
                </form>       
                </div>      
            </div>
            </td>
            <td ><?php $itemTotal = $row['giaSP'] * $row['soLuong']; echo $itemTotal . "  đ"; $total += $itemTotal; ?></td>  
           <td> <button>
               <?php   echo "<p>"  . " <a class='delete' href='Delete.php?id=" . $row['ma_nguoi_dung'] . "' onclick='return confirm(\"Bạn có chắc chắn muốn xóa không?\");'>Xoá</a></p>";?>
            </button>
        </td>
        </tr>
        </tbody>
        <?php } ?>
    </table>
    <div>Tổng thanh toán: <?php echo $total . " đ"; ?></div>  
    <button style="align-item:center">
        <a href="trangchu.php#food"> Thêm sản phẩm</a>
    </button>
    <form method="POST" action="handle_checkout.php">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <input type="hidden" name="total" value="<?php echo $total; ?>"> <!-- Gửi tổng số tiền ẩn -->
    <button type="submit" style="padding: 10px 20px; background-color: green; color: white; border: none; border-radius: 5px;">Thanh toán</button>
</form>

</body>
</html>
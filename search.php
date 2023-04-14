<html>
    <body>
        <div align="center">
            <form action="search.php" method="get">
                <input type="text" name="search" />
                <input type="submit" name="ok" value="search" />
            </form>
        </div>
        <?php
        // Nếu người dùng submit form thì thực hiện
        if (isset($_REQUEST['ok'])) 
        {
            // Gán hàm addslashes để chống sql injection
            $search = addslashes($_GET['search']);
 
            // Nếu $search rỗng thì báo lỗi, tức là người dùng chưa nhập liệu mà đã nhấn submit.
            if (empty($search)) {
                echo "Yeu cau nhap du lieu vao o trong";
            } 
            else
            {
                // Kết nối sql
                $conn = mysqli_connect('localhost','root','','cart_db');
                
                // Kiểm tra kết nối có thành công hay không
                if (!$conn) {
                    die("Kết nối thất bại: " . mysqli_connect_error());
                }

                // Dùng câu lệnh LIKE trong SQL và sử dụng toán tử % của PHP để tìm kiếm dữ liệu chính xác hơn.
                $query = "SELECT * FROM users WHERE product_name LIKE '%$search%'";

                // Thực thi truy vấn
                $result = mysqli_query($conn, $query);

                // Đếm số dòng trả về
                $num = mysqli_num_rows($result);

                // Nếu có kết quả thì hiển thị, ngược lại thì thông báo không tìm thấy kết quả
                if ($num > 0 && $search != "") 
                {
                    // Dùng $num để đếm số dòng trả về.
                    echo "$num kết quả trả về với từ khóa <b>$search</b>";

                    // Tạo bảng để hiển thị kết quả
                    echo '<table border="1" cellspacing="0" cellpadding="10">';
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                            echo "<td>{$row['product_name']}</td>";
                            echo "<td>{$row['product_price']}</td>";
                            echo "<td>{$row['product_image']}</td>";
                            // echo "<td>{$row['address']}</td>";
                        echo '</tr>';
                    }
                    echo '</table>';
                } 
                else {
                    echo "Không tìm thấy kết quả!";
                }

                // Đóng kết nối
                mysqli_close($conn);
            }
        }
        ?>   
    </body>
</html>

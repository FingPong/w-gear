<?php
    session_start();

    include('../../admincp/config/config.php');

    $msgName = "";
    $msgPhone = '';
    $flag = 1;

    $name = '';
    $phone = '';

    if (isset($_GET['name'])) {
        if (preg_match('/^([a-zA-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ\s]+)$/i', $_GET['name']) == 0) {
            $msgName = "<span class='error-message'>Tên có ký tự không hợp lệ!</span>";     
            $flag = 0;
        }
        else {
            $name = $_GET['name'];
        }
    }   
    
    if (isset($_GET['phone'])) {
        if (preg_match('/[0-9]/', $_GET['phone']) == 0) {
            $msgPhone = "<span class='error-message'>Số điện thoại không hợp lệ!</span>";   
            $flag = 0;  
        }
        else {
            $phone = $_GET['phone'];
        }
    }  
    
    if (isset($_GET['reptoid'])) {
        if (isset($_GET['content']) && $_GET['content'] != '') {
            $sql = "INSERT INTO tb_comment(id_product, name, content, date, reply, status, admin) VALUES({$_GET['id']}, '{$_GET['name']}', '{$_GET['content']}', CURRENT_TIMESTAMP(), {$_GET['reptoid']}, 0, 1)";
            // echo $sql;
            mysqli_query($mysqli, $sql);
        }
        $flag = 2;
    }
    
    // THÊM BÌNH LUẬN CỦA MỘT SẢN PHẨM
    if ($flag == 1) {
        $sql = "INSERT INTO tb_comment(id_product, name, phone, content, date, status) VALUES({$_GET['id']},'{$name}', '{$phone}', '{$_GET['content']}', CURRENT_TIMESTAMP(), 0)";
        mysqli_query($mysqli, $sql);
        // echo $sql;
    }
?>

<div class="comment"> 
    <div class="comment-info">
        <div class="comment-info-box">
            <input type="text" class="input name" name="name" id='name' placeholder="Nhập họ tên" value="<?php //echo $name; ?>" required>
            <?php echo $msgName; ?>
        </div>
        <div class="comment-info-box">
            <input type="text" class="input phone" name="phone" id='phone' placeholder="Nhập số điện thoại" value="<?php //echo $phone; ?>" required>
            <?php echo $msgPhone; ?>
        </div>
    </div>
    <textarea style="resize: none" class="input" name="" id="content" placeholder="Nhập bình luận..." required></textarea>
    <div class="button-comment">
        <button onclick="comment()" name="comment" class="btn btn--pri">ĐĂNG</button>
    </div> 
</div>

<div class="others-comment" id="others-comment">
    <?php
        $sql_cmt = "SELECT * FROM tb_comment WHERE id_product={$_GET['id']} AND reply=0 ORDER BY date DESC";
        $query_cmt = mysqli_query($mysqli, $sql_cmt);
        if (isset($_SESSION['USERNAME'])) {
            $sql_admin = "SELECT * FROM tb_account WHERE username='{$_SESSION['USERNAME']}'";
            $query_admin = mysqli_query($mysqli, $sql_admin);
            $row_admin = mysqli_fetch_array($query_admin); 
        }
        while ($row_cmt = mysqli_fetch_array($query_cmt)) {
            // if ($row_cmt['reply'] == 0) {
    ?>
        <div class="other-comment input">
            <div class="account-info">
                <span><?php echo $row_cmt['name']; ?></span> 
                <?php
                    if (isset($_SESSION['USERNAME']) && $row_admin['type'] == 1) {
                ?>
                    <span><?php echo $row_cmt['phone']; ?></span> 
                <?php
                    }
                ?>
            </div>
            <div class="comment-date">
                <span><?php echo $row_cmt['date']; ?></span>
            </div>
            <div class="comment-content">
                <p>
                    <?php echo $row_cmt['content']; ?> 
                </p>
            </div>
            <?php
                if (isset($_SESSION['USERNAME']) && $row_admin['type'] == 1) {
            ?>
                <!-- <div class="comment-reply">
                    <i class="fa-solid fa-reply"></i>
                    <span>Trả lời</span>
                </div> -->
            <?php
                }
            ?> 
        </div>
        
        <?php 
                // }
                // else { 
            if (isset($_SESSION['USERNAME']) && $row_admin['type'] == 1) { 
        ?>
            <div class="rep-cover">
                <textarea placeholder="Nhập bình luận..." name="" class="other-comment reply admin input" id="<?php echo $row_cmt['id']; ?>" style="resize:none" cols="30" rows="10"></textarea>
                <button onclick="repComment(<?php echo $row_cmt['id']; ?>)" name="recomment" class="btn btn--pri">TRẢ LỜI</button>
            </div>
        <?php
            }
            $sql_cmt_rep = "SELECT * FROM tb_comment WHERE reply={$row_cmt['id']}";
            $query_cmt_rep = mysqli_query($mysqli, $sql_cmt_rep);
            $admin = '';
            while ($row_cmt_rep = mysqli_fetch_array($query_cmt_rep)) {
        ?>

        <div class="other-comment admin input"> 
            <div class="account-info">
                <span>Nhân viên <?php echo $row_cmt_rep['name']; ?></span> 
                <?php
                    if ($row_admin['type'] == 1) {
                ?>
                    <span><?php echo $row_cmt_rep['phone']; ?></span> 
                <?php
                    }
                ?>
            </div>
            <div class="comment-date">
                <span>Trả lời khách hàng <?php echo $row_cmt['name']; ?> <?php echo $row_cmt_rep['date']; ?></span>
            </div>
            <div class="comment-content">
                <p>
                    <?php echo $row_cmt_rep['content']; ?> 
                </p>
            </div>
        </div>
    <?php
            }
            // }
        }
    ?>
</div>
<?php
    // echo "DANH SÁCH ĐƠN HÀNG";
    
    if (!isset($_SESSION['USERNAME_ADMIN'])) {
        header('Location: ../admincp/login.php');
    } 
?>

<link rel="stylesheet" href="./css/productsadmincp.css?v=<?php echo time(); ?>">

<script>
    document.querySelector('#comments').classList.add('active');
    document.querySelector('.name-page').innerHTML = "Comments";
</script>

<div class="detail-page home-content" id="home-content">
    <div class="add-product">
        <!-- <span onclick="addProduct()"><i class="fa-solid fa-plus"></i> New product</span> -->
    </div>
    <div class="products-table-cover" id="customers-table-cover">

    </div>
</div>

<script>  
    function reply(name, id) {
        window.open(`../index.php?chitietsanpham=${name}&rep=${id}`, "_blank");
    } 

    function removeComment(id) {
        location.href = `modules/manageComments/handle.php?id=${id}`;
    }

    function showComments(page) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("customers-table-cover").innerHTML = this.responseText;
            } 
        };    
        // console.log(path);
        var path = `modules/manageComments/show.php?page=${page}`;
        // alert(path);
        xhttp.open("GET", path, true);
        xhttp.send();
    }
    showComments(1);
</script>

<script>
    $(document).ready(function() {
        $(document).on('click', '.pagination_link', function(){  
           var page = $(this).attr("id");   
           showComments(page);   
        });   
    });
</script>
<?php 
    include("../.././config/config.php"); 
?> 

<table class="products-table">
    <thead>
        <tr style="height: 50px">  
            <th rowspan='1' colspan='1' style='width:200px; min-width: 200px'>CUSTOMER</th> 
            <th rowspan='1' colspan='1' style='width:50px; min-width: 50px'>CONTENT</th>
            <th rowspan='1' colspan='1' style='width:150px; min-width: 100px'>DATE</th>
            <th rowspan='1' colspan='1' style='width:150px; text-align:center'>PRODUCT</th>
            <th rowspan='1' colspan='1' style='width:50px; text-align:center'>STATUS</th>
            <th rowspan='1' colspan='1' style='width:100px; min-width:100px'>REPLY</th>
        </tr>
    </thead>
    <tbody id="table-body">
        <?php 
            $sql = "SELECT * FROM tb_comment WHERE admin=0 ORDER BY date DESC";
            $query = mysqli_query($mysqli, $sql);  

            while ($row = mysqli_fetch_array($query)) { 
        ?>
        <tr> 
            <td><?php echo $row['name']; ?></td> 
            <td><?php echo $row['content']; ?></td> 
            <td><?php echo $row['date']; ?></td>
            <td style="font-weight:bold">
                <?php
                    $sql_product = "SELECT * FROM tb_product WHERE id={$row['id_product']}";
                    $query_product = mysqli_query($mysqli, $sql_product);
                    $row_product = mysqli_fetch_array($query_product);
                    echo $row_product['name'];
                ?>    
            </td>
            <td style="text-align:center">
            <?php
                if ($row['status'] == 0) {
                    echo "<span style='display:inline-block; width: auto; padding:5px 10px' class='progress status-span'>New</span>";
                }
                else if ($row['status'] == 1) {
                    echo "<span style='display:inline-block; width: auto; padding:5px 10px' class='success status-span'>Read</span>";
                } 
            ?>
            </td> 
            <td>
                <i onclick="reply('<?php echo $row_product['name']; ?>', <?php echo $row['id']; ?>)" style="margin-right:10px" class="detail-product fa-solid fa-reply"></i>
                <i onclick="removeComment(<?php echo $row['id']; ?>)" id="remove"  class="detail-product fa-solid fa-square-minus"></i>
                <!-- <i class="fa-solid fa-reply"></i> -->
            </td>
        </tr> 
        <?php
            }
        ?>  
    </tbody>
</table> 
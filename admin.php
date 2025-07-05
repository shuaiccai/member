<?php
include_once 'checkAdmin.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>会员管理系统</title>
    <style>
        .main {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        h2 {
            font-size: 20px
        }

        h2 a {
            color: navy;
            text-decoration: none;
            margin-right: 15px
        }

        h2 a:last-child {
            margin-right: 0
        }

        h2 a:hover {
            color: brown;
            text-decoration: underline
        }
        tr:hover{background: azure}
        .trClick1{background-color: yellow}
        .trClick2{background-color: white}
    </style>
</head>
<body>
<div class="main">
    <?php
    include_once 'nav.php';
    include_once 'conn.php';
    include_once 'page.php';
    $sql = "select count(id) as total from info";
    $result = mysqli_query($conn, $sql);
    $info = mysqli_fetch_assoc($result);
    $total = $info['total'];
    $perPage = 3;
    $page = $_GET['page'] ?? 1;
    paging($total, $perPage);

    $sql = "select * from info order by id desc limit $firstCount,$displayPG";
    $result = mysqli_query($conn, $sql);
    ?>
    <table border="1" cellspacing="0" cellpadding="10" style="border-collapse:collapse" align="center" width="90%">
        <tr>
            <td>序号</td>
            <td>用户名</td>
            <td>性别</td>
            <td>邮箱</td>
            <td>爱好</td>
            <td>是否管理员</td>
            <td>操作</td>
        </tr>

        <?php
        $i = ($page - 1) * $perPage + 1;
        while ($info = mysqli_fetch_assoc($result)) {

            ?>
            <tr onclick="if(this.className === 'trClick2'){
                this.className = 'trClick1'
            }else{
                this.className = 'trClick2'
            }" class="trClick2">
                <td><?php echo $i; ?></td>
                <td><?php echo $info['username'] ?></td>
                <td><?php echo $info['sex'] ? '男' : '女'; ?></td>
                <td><?php echo $info['email'] ?></td>
                <td><?php echo $info['fav'] ?></td>
                <td><?php echo $info['admin'] ? '是' : '否'; ?></td>

                <td><a href="modify.php?id=4&username=<?php echo $info['username'] ?>&source=admin&page=<?php echo $page;?>">修改资料</a>
                    <?php if ($info['username'] <> 'admin') {
                        ?><a href="javascript:del(<?php echo $info['id']; ?>,'<?php echo $info['username'] ?>');">删除会员</a>
                        <?php
                    }else{
                        echo "<span style='color:gray'>删除管理员</span> ";
                    }
                    if ($info['admin']) {
                        if ($info['username'] <> 'admin') {
                            ?><a href="setAdmin.php?action=0&id=<?php echo $info['id']; ?>">取消管理员</a>
                            <?php
                        } else {
                            echo '<span style="color: gray">取消管理员</span>';
                        }
                    } else {
                        if ($info['username'] <> 'admin') {
                            ?><a href="setAdmin.php?action=1&id=<?php echo $info['id']; ?>">设置管理员<?php
                        } else {
                            echo '<span style="color: gray">设置管理员</span>';
                        }

                    }
                    ?></td>
            </tr>
            <?php
            $i++;
        }
        ?>
    </table>
    <?php
    echo $pageNav;
    ?>
</div>
<script>
    function del(id,name){
        if(confirm('您确定要删除会员' + name + ' ?')){
            location.href = 'del.php?id=' + id + '&username=' +name;

        }
    }
</script>
</body>
</html>
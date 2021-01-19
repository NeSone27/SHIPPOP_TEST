<html>
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    </head>
    <body>
    <section style="padding:50px;">
        <form action="index.php" method="POST">
            <div class="row" style="padding:5px;">
                <div class="col-md-1">
                    <span>List</span>
                </div>
                <div class="col-md-4">
                    <input type="text" name="list" class="form-control" id="" autocomplete="off">
                </div>
            </div>
            <div class="row" style="padding:5px;">
                <div class="col-md-1">
                    <span>ค้นหา</span>
                </div>
                <div class="col-md-2">
                    <input type="text" name="search" class="form-control" id="" autocomplete="off"> 
                </div>
                <div class="col-md-2">
                    <button type="submit" name="search_btn" class="btn btn-warning" value="1" style="font-color:white;">ค้นหา</button>
                </div>
            </div>
            <div class="row" style="padding:5px;">
                <div class="col-md-1">
                    <span>ประเภทการค้นหา</span>
                </div>
                <div class="col-md-2">
                    <select name="search_type" id="" class="form-control" autocomplete="off">
                        <option value="1">Linear Search</option>
                        <option value="2">Binary Search</option>
                        <option value="3">Bubble Search</option>
                    </select>
                </div>
            </div>
        </form>
        <?php
        if(isset($_REQUEST['search_btn'])){
            $list = $_REQUEST['list'];
            $search = $_REQUEST['search'];
            $search_type = $_REQUEST['search_type'];

            if($list == ""){
                echo 'ไม่มีข้อมูล List';
                return;
            }
            if($search == "" && $search_type != 3){
                echo 'ไม่มีข้อมูล Search';
                return;
            }
            $list = str_replace(' ','',$list);
            $arr = explode(",",$list);
            // echo '<pre>';
            // print_r($list_arr);
            // exit;

            if($search_type == 1){ //linear
                $txt = "";
                foreach ($arr as $key => $list_arr) {
                    if(trim($list_arr) != trim($search)){
                        $txt.= '<div class="row" style="padding:5px;">
                                    <div class="col-md-12">
                                        <span>Round '.($key+1).' :  ===> '.$search.' != '.$list_arr.'</span>
                                    </div>
                                </div>';
                        if($key == (count($arr)-1)){
                            $txt.= '<div class="row" style="padding:5px;">
                            <div class="col-md-12">
                                <span>not found !!</span>
                            </div>
                        </div>';      
                        }     
                    }else{
                        $txt.= '<div class="row" style="padding:5px;">
                                    <div class="col-md-12">
                                        <span>Round '.($key+1).' :  ===> '.$search.' = '.$list_arr.' found !! </span>
                                    </div>
                                </div>';
                        break;
                    }
                }
            }else if($search_type == 2){
                $txt = "";
                $n = 0;
                sort($arr);
                $start = 0;
                $end = count($arr)-1;
                // echo '<pre>';
                // print_r($arr);
                // exit;
                while($start<=$end){
                    $n++;

                    $mid = floor(($start + $end)/2);
                    // echo $mid.'<br>'; // 4 2
                    // echo $arr[$mid].'<br>';//5 3
                    if($search == trim($arr[$mid])){
                        $txt .= '<div class="row" style="padding:5px;">
                                    <div class="col-md-12">
                                        <span>Round '.$n.' :  ===> '.$search.' = '.trim($arr[$mid]).' found !! </span>
                                    </div>
                                </div>';
                                break;
                    }else{
                        $txt .= '<div class="row" style="padding:5px;">
                                    <div class="col-md-12">
                                        <span>Round '.$n.' :  ===> '.$search.' != '.trim($arr[$mid]).'</span>
                                    </div>
                                </div>';

                        if($search > trim($arr[$mid])){
                            $start = $mid + 1;
                        }else if($search < trim($arr[$mid])){
                            $end = $mid - 1;
                        }
                    }
                    if($start>$end){
                    $txt .= '<div class="row" style="padding:5px;">
                                <div class="col-md-12">
                                    <span>not found !!</span>
                                </div>
                            </div>';
                    }

                }
            }
            else if($search_type == 3){
                $txt = "";
                for ($j=0; $j < count($arr); $j++) { 
                    $n = 0;
                    for ($i=1; $i < count($arr); $i++) {
                        if($arr[$i-1] > $arr[$i]){
                            $n++;
                            $temp = $arr[$i];
                            $arr[$i] = $arr[$i-1];
                            $arr[$i-1] = $temp;
                        }
                    }
                    if($n == 0){
                        break;
                    }
                    $data = "";
                    foreach ($arr as $key => $sort_list) {
                        $data .= $sort_list;
                        if($key+1 != count($arr)){
                            $data.=',';
                        }
                    }
                    $txt .= '<div class="row" style="padding:5px;">
                                    <div class="col-md-12">
                                        <span>Round '.($j+1).' :  ===> [ '.$data.' ]</span>
                                    </div>
                                </div>';
                }


            }
        ?>
        <div class="row">
        <span>ผลลัพธ์</span>
            <div style="border: 1px solid black;" class="col-md-5">
                <div class="row" style="padding:5px;">
                    <div class="col-md-12">
                        <span>List : [ <?php echo $list; ?> ]</span>
                    </div>
                </div>
                <?php
                    if($search_type!=3){
                    ?>
                <div class="row" style="padding:5px;">
                    <div class="col-md-12">
                        <span>Search : <?php echo $search; ?></span>
                    </div>
                </div>
                <?php 
                } 
                ?>
                <div class="row" style="padding:5px;">
                    <div class="col-md-12">
                        <span>Result:::</span>
                    </div>
                </div>
                <?php
                echo $txt;
                ?>
            </div>
        </div>
        <?php
        }
        ?>
    </section>
    </body>
</html>
<?php
require_once '../connection.php';
require_once 'security.php';

$obj = new model();

if(isset($_POST['up_state']))
{
    $wh['name'] = $_POST['txt_state'];
    $wh['lable'] = "state";
    //unique
    $count = $obj->count_record("tbl_location",$wh);
    
    if($count == 0)
    {
        //insert
        $data['name'] = $_POST['txt_state'];
        $data['parent_id'] = $_POST['country'];
    
        $ans = $obj->my_update("tbl_location", $data,array("location_id"=>$_GET['up']));
        header('location:managestate.php');
    }
    else
    {   //eroor
        $er = $_POST['txt_state']." Already Exist.";
    }
}

if(isset($_GET['del']))
{
    $where['location_id']=$_GET['del'];
    $obj->my_delete("tbl_location", $where);
    header('location:managestate.php');
}

if(isset($_POST['state'])) 
{

    $data['name'] = $_POST['add_state'];
    $data['lable'] = "state";
    $data['parent_id'] = $_POST['country'];
    
    $c = $obj->count_record("tbl_location", $data);
    if ($c == 0) {
        $ans = $obj->my_insert("tbl_location", $data);
    } else {
        $er = $_POST['add_state'] . " Already Exist.";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Panel</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php
        require_once 'headlink.php';
        ?>
        <script src="js/jquery-3.1.1.min.js" type="text/javascript"></script>
    </head>
    <body class="skin-coreplus">
        <?php
        require_once 'headline.php';
        ?>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <?php
            require_once 'sidebar.php';
            ?>
            <aside class="right-side">
                <section class="content-header">
                    <h1>
                        Manage State                    </h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="dashboard.php">
                                <i class="fa fa-fw fa-home"></i> Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#">Location</a>
                        </li>
                        <li class="active">
                            State
                        </li>
                    </ol>
                </section>
                <div class="panel panel-widget">
                    <hr/>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <?php
                                    if(isset($_GET['up']))
                                    {
                                        $d = $obj->my_select("tbl_location",NULL,array("location_id"=>$_GET['up']))->fetch_object();
                                ?>
                                
                        <!-- Update form-->
                                
                                <form class="comment-form respond-form" action="" method="post" id="myform">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 comment-form-name">
                                            <br/>
                                            <h4 style="font-size: 14px;">Update State..</h4>
                                            <br/>
                                            <?php
                                            $ww['lable'] = "country";

                                            $dd = $obj->my_select("tbl_location", NULL, $ww);
                                            ?>
                                            <select tabindex="1" name="country" class="form-control" data-bvalidator="required" style="font-size: 13px">
                                                <option value="">Select Country</option>
                                                <?php
                                                while ($row = $dd->fetch_object()) 
                                                {
                                                ?>
                                                    <option value="<?php echo $row->location_id; ?>" <?php if($d->parent_id == $row->location_id){echo "selected";} ?>><?php echo $row->name; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <br/>
                                            <input tabindex="2" type="text" name="txt_state" class="form-control" value="<?php echo $d->name;?>" style="font-size: 13px"  placeholder="Enter State" data-bvalidator="required"/>

                                        </div>
                                    </div>
                                    <div class="form-submit">
                                        <span class="button-set padding-30"><br/>
                                            <button type="submit" name="up_state" class="btn btn-button global-bg white">Update</button>
                                        </span>
                                        <span class="button-set padding-30">
                                            <button  type="reset" class="btn btn-button global-bg white">Clear</button>
                                        </span>
                                        <span class="button-set padding-30">
                                            <a href="managestate.php" class="btn btn-button global-bg white">Cancel</a>
                                        </span>
                                        <?php
                                        
                                        if (isset($er)) {
                                            ?>    
                                            <span style="color: red;font-size: 12px;">&nbsp;&nbsp;&nbsp;<?php echo $er; ?></span>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </form>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                         
                        <!-- Insert form-->
                       
                         <form class="comment-form respond-form" action="" method="post" id="myform">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 comment-form-name">
                                            <br/>
                                            <h4 style="font-size: 14px;">Add State..</h4>
                                            <br/>
                                            <?php
                                            $wh['lable'] = "country";

                                            $data = $obj->my_select("tbl_location", NULL, $wh);
                                            ?>
                                            <select name="country" class="form-control" data-bvalidator="required" style="font-size: 13px">
                                                <option value="">Select Country</option>
                                                <?php
                                                while ($row = $data->fetch_object()) 
                                                {
                                                ?>
                                                    <option value="<?php echo $row->location_id; ?>"><?php echo $row->name; ?></option>
                                                  <?php
                                                }
                                                ?>
                                            </select>
                                            <br/>
                                            <input type="text" name="add_state" class="form-control" style="font-size: 13px"  placeholder="Enter State" data-bvalidator="required"/>

                                        </div>

                                    </div>
                                    <div class="form-submit">
                                        <span class="button-set padding-30"><br/>
                                            <button type="submit" name="state" class="btn btn-button global-bg white">Add</button>
                                        </span>
                                        <span class="button-set padding-30">
                                            <button  type="reset" class="btn btn-button global-bg white">Clear</button>
                                        </span>
                                        <?php
                                        if (isset($ans)) {
                                            if ($ans == 1) {
                                                ?>
                                                <span style="color: green;font-size: 12px;">&nbsp;&nbsp;&nbsp;Insert Successfully.</span>
                                                <?php
                                            } else {
                                                ?>
                                                <span style="color: red;font-size: 12px;">&nbsp;&nbsp;&nbsp;Something is Wrong. Try Again.</span>
                                                <?php
                                            }
                                        }
                                        if (isset($er)) {
                                            ?>    
                                            <span style="color: red;font-size: 12px;">&nbsp;&nbsp;&nbsp;<?php echo $er; ?></span>
                                            <?php
                                        }
                                        ?>

                                    </div>
                                </form>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6">
                                <table class="table table-responsive nova-pagging" >
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th style="width: 10%;text-align: center; padding-bottom: 13px;" nova-search="yes">
                                                No
                                            </th>
                                            <th style="width: 10%;text-align: center; padding-bottom: 13px;" nova-search="yes">
                                                Country
                                            </th>
                                            <th style="width: 10%;text-align: center; padding-bottom: 13px;" nova-search="yes">
                                                State
                                            </th>
                                            <th style="width: 10%;text-align: center; padding-bottom: 13px" nova-search="no">
                                                Remove
                                            </th>
                                            <th style="width: 10%;text-align: center; padding-bottom: 13px" nova-search="no">
                                                Update
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $c = 0;
                                        $query="SELECT state.location_id,state.name as state,country.name as country FROM tbl_location as state,tbl_location as country WHERE state.lable = 'state' AND state.parent_id = country.location_id";
                                        $data = $obj->my_query($query);
                                        
                                        while ($row = $data->fetch_object()) 
                                        {
                                            $c++;
                                            ?>
                                            <tr style="text-align: center;">
                                                <td style="width: 10%;text-align: center;">
                                                    <?php echo $c; ?>
                                                </td>
                                                <td style="width: 10%;text-align: center;">
                                                    <?php echo $row->country; ?>
                                                </td>
                                                <td>
                                                    <?php echo $row->state; ?>
                                                </td>
                                                <td style="width: 10%" >
                                                   <a href="managestate.php?del=<?php echo $row->location_id; ?>" onclick="return confirm('Are you sure want to delete ?');"><i class="fa fa-recycle remove" title="Remove"></i></a>
                                                </td>
                                                <td style="width: 10%" >
                                                    <a href="managestate.php?up=<?php echo $row->location_id; ?>"><i class="fa fa-pencil remove"  title="Update"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>

            </aside>
        </div>
        <div id="qn"></div>
        <?php
        require_once 'footersclink.php';
        ?>
        <script type="text/javascript">
            $("#myform").bValidator();
        </script>
    </body>
</html>
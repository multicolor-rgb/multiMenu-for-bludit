 
 

<div class="multiMenu">


    <h3 class="lead mt-2 border-bottom pb-3">Menus List</h3>


    <div class="multimenu-add bg-light border p-2 mb-2">
        <a class="btn btn-primary btn-sm text-light text-decoration-none" style="text-decoration:none;" href="<?php echo DOMAIN_ADMIN; ?>plugin/multimenu?&addMultiMenu">
            Add Menu</a>
    </div>


    <table class="table col-md-12 text-center">

        <tr>    <th class="text-center">Name</th>
            <th class="text-center">Code</th>
            <th class="text-center">Edit</th>
            <th class="text-center">Delete</th>
        </tr>


        <?php

        foreach (glob(PATH_CONTENT . 'multiMenu/*json') as $file) {

            echo '
    <tr>
    <td style="height:50px;" ><p style="margin:0;line-height:2.2">' . pathinfo($file)['filename'] . '</p></td>
    <td style="padding:5px;background:#fafafa;display:flex;align-items:center;justify-content:center;height:50px"><code >&#x3c;?php multiMenu("' . pathinfo($file)['filename'] . '"); ?&#x3e;</code></td>
    <td style="width:50px;"><a class="btn btn-sm btn-primary text-light" href="' . DOMAIN_ADMIN . 'plugin/multimenu?&addMultiMenu&menuname=' . pathinfo($file)['filename'] . '  "><i class="fa fa-edit"></i></a></td>
    <td style="width:50px;"><a class="btn btn-sm btn-danger text-light" href="' . DOMAIN_ADMIN . 'plugin/multimenu?&delthis=' . pathinfo($file)['filename'] . '  "><i class="fa fa-trash"></i></a></td>
 </tr>';
        }; ?>



    </table>

</div>

<?php



if (isset($_GET['delthis'])) {
    global $SITEURL;
    global $GSADMIN;
    unlink(PATH_CONTENT . 'multiMenu/' . $_GET['delthis'] . '.json');

    echo "
    <script>


        window.location.href = '" . DOMAIN_ADMIN . "plugin/multimenu';


    </script>
    ";
}; ?>

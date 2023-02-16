
<?php 

global $security;
$tokenCSRF = $security->getTokenCSRF();

;?>

<style>
.multimenu-add{
    background: #fafafa;
    border:solid 1px #ddd;
    padding:10px;
    margin-bottom: 10px;
}
    .tables tr{
        display: grid;
        grid-template-columns: 120px 1fr 60px 60px;
        gap:0;
        border:none !important;
        border-bottom: #fafafa solid 1px;
       font-size: 12px;
       
    }

    .tables th{
        text-align: center !important;
    }

    .tables tr{
        text-align: center;
    }
  
</style>

<div class="multimenu-add">
<a href="<?php echo DOMAIN.'/'.ADMIN_URI_FILTER;?>/plugin/multimenu?addNew" class="btn btn-primary">Add Menu</a>
</div>


<h3>List Menus</h3>

<table class="tables table">

<tr>
<th>name</th>
<th>code for template</th>
<th>edit</th>
<th>delete</th>
</tr>


<?php 

foreach(glob($this->phpPath().'multiMenuList/*json') as $file){

    echo '
    <tr>
    <td><b>'.pathinfo($file)['filename'].'</b></td>
    <td  ><code >&#x3c;?php multiMenu("'.pathinfo($file)['filename'].'"); ?&#x3e;</code></td>
    <td><a class="btn btn-dark btn-sm" href="'.DOMAIN_ADMIN.'plugin/multimenu?addNew&menuname='.pathinfo($file)['filename'].'">edit</a></td>
    <td><form action="#" method="post">
    <input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="'.$tokenCSRF.'">
    <input type="hidden" name="delthis" value="'.pathinfo($file)['filename'].'"><input type="submit" class="btn btn-danger btn-sm"  value="delete"  onclick="return confirm(`Are you sure?`);"></form></td>
</tr>';

}

;?>



</table>


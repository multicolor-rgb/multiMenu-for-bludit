
<?php 

global $security;
$tokenCSRF = $security->getTokenCSRF();

;?>


<style>
    .multiMenu input{
width: 100%;
padding:5px;
box-sizing: border-box;
margin-top: 5px;
border:#ddd solid 1px;
     }

    .multiMenu{
        display: flex;
        flex-wrap: wrap;
    }

    .multiMenu label{
        margin-left: 5px;
    }

    .multiMenu select{
        width: 80%;
        padding: 10px;
        box-sizing: border-box;
        background: none;
        border:solid 1px #ddd;
        margin-top: 20px;
    }

    .addToMenu{
        display: inline-flex;
        width: 20%;
        margin: 0;
        padding: 10px;
        box-sizing: border-box;
        margin-top: 20px;
        border: none;
        background: #000;
        color:#fff;
        align-items: center;
        justify-content: center;
    }

    .multiMenu input[type="checkbox"]{
        all:revert;
    }

.multiMenu-ul{
width:100%;
list-style-type:none;
margin: 0 !important;
padding: 0 !important;
 }

.multiMenu-ul li{
    border:solid 1px;
    width: 100%;
    padding:10px;
    background: #fafafa;
    border:solid 1px #ddd;
    box-sizing:border-box;
    display: grid;
    grid-template-columns: 1fr 1fr 20px;
    gap:20px;
    align-items: center;
}

.multiMenu input[type="submit"]{
    background: #000;
    padding: 10px 15px;
margin-top: 10px;
    color:#fff;
}
 

.nameMenu{
    background: #fafafa;
    border:solid 1px #ddd;
    padding: 10px;
}

.closeMM{
    background: red;
    border:none;
    color:#fff;
    width:20px;
    height:20px;
}


.parentHave{
    border-left:solid 5px grey !important;
}
</style>


<h3>Create new menu</h3>
<hr>

<form class="multiMenu"method="post" action="<?php 

 
    echo DOMAIN_ADMIN.'plugin/multimenu?multiMenu=true';
 

;?>">


<?php

if(isset($_GET['menuname'])){
    $checkbox = file_get_contents($this->phpPath().'multiMenuList/'.$_GET['menuname'].'.json');
$reJsonCheckbox = json_decode($checkbox);
 
}
 
;?>

<input type="hidden" id="jstokenCSRF" name="tokenCSRF" value="<?php echo $tokenCSRF;?>">


<input type="text" name="nameFile" value="<?php echo @$_GET['menuname'];?>" required pattern="[a-zA-Z0-9]+">
<label for="name" class="small text-muted">Name menu for function without spacebar and special characters</label>

<div style="width:100%; margin:10px auto;background:#333; color:#fff !important;border:solid 1px #ddd;padding:10px;">
<label for="" style="color:#fff; display:flex; justify-content:space-between;align-items:center;">
<span>Show Menu name on frontend?</span><input type="checkbox" class="check " value="yes" name="front"

<?php 

if(@$reJsonCheckbox->front !==null){

    echo 'checked';

};

?>

></label>
</div>

<div style="width:100%" class="hidecheck nameMenu">
<label for="name">Name menu on frontend</label>
<input type="text" name="nameFront" value="

<?php 

if(isset($_GET['menuname'])){
    $files = file_get_contents($this->phpPath().'multiMenuList/'.$_GET['menuname'].'.json');
    $reJsonFiles = json_decode($files);
    
   echo $reJsonFiles->name;
}


;?>

" >
</div>


<select class="selectMultiMenu">

 <?php 

foreach(glob(PATH_PAGES.'/*', GLOB_ONLYDIR) as $file){


echo '<option value="'.pathinfo($file)['basename'].'"  >'.pathinfo($file)['basename'].'</option>';
}
;?>
 </select>

 <button class="addToMenu btn btn-dark">Add this to menu</button>



 <h3 style="margin-top:20px;">Edit menu</h3>

 

 <ul class="multiMenu-ul" id="sortable" style="text-align:center">
<li>
    <p style="margin:0;padding:0;color: #222;
font-weight: bold;
text-transform: uppercase;
line-height: 20px !important;
text-align: left;font-size:11px;
text-align:center;">Link</p>
    <p style="margin:0;padding:0;color: #222;
font-weight: bold;
text-transform: uppercase;
line-height: 20px !important;
text-align: left;font-size:11px;text-align:center;">Name</p>

</li>







<?php



if(isset($_GET['menuname'])){
    
foreach($reJsonFiles->link as $key => $value){

    echo '<li data-link="'.$value.'">
    <input type="text" name="link[]" value="'.$value.'">
    <input name="names[]" value="'.$reJsonFiles->names[$key].'">
    
    
    <button class="closeMM btn btn-sm btn-danger d-flex align-items-center justify-content-center">X</button>

 
    </li>';


};
}

 

;?>

 </ul>
 

 <input type="submit" name="saveMenu" value="save menu" >
</form>





<script>


document.querySelector('.addToMenu').addEventListener('click',(e)=>{

    e.preventDefault();

    $ars = document.querySelector('.selectMultiMenu').value;


    const lis = document.createElement('li');

    const inputer = document.createElement('input');

    inputer.setAttribute('type','text');
    inputer.value =  $ars;
    inputer.setAttribute('name','link[]');
    
    const inputer2 = document.createElement('input');
    inputer2.value = $ars;
    inputer2.setAttribute('name','names[]');
 
    
    document.querySelector('.multiMenu-ul').appendChild(lis);

    const close = document.createElement('button');
    close.innerHTML = 'X';
    close.classList.add('btn','btn-sm','btn-danger','d-flex','align-items-center','justify-content-center');
  
    close.classList.add('closeMM');


    lis.appendChild(inputer);
    lis.appendChild(inputer2);
   
    lis.appendChild(close);
    

    
document.querySelectorAll('.closeMM').forEach(x=>{

x.addEventListener('click',e=>{
e.preventDefault();
x.parentElement.remove();
    });

})


 



})


 



document.querySelectorAll('.closeMM').forEach(x=>{

x.addEventListener('click',e=>{
e.preventDefault();
x.parentElement.remove();
    });

})


</script>

<?php
    class multiMenu extends Plugin {
      


        public function adminView(){

            if(isset($_GET['multiMenu'])){
                include($this->phpPath().'php/settings.php');
            };

            if(isset($_GET['addNew'])){
                include($this->phpPath().'php/addNew.php');
            };
        

            echo '<form action="https://www.paypal.com/cgi-bin/webscr" class="bg-light border p-2" method="post" target="_top" style="display:block;text-align:center; margin-top:20px;">
                <p style="margin:0;padding:0;margin-bottom:10px;">Support my work:)</p>
                <input type="hidden" name="cmd" value="_s-xclick" />
                <input type="hidden" name="hosted_button_id" value="KFZ9MCBUKB7GL" />
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
                <img alt="" border="0" src="https://www.paypal.com/en_PL/i/scr/pixel.gif" width="1" height="1" />
                </form>';

        }



    public function adminController(){



if(isset($_POST['saveMenu'])){


    $data = array();
    $data['name'] = $_POST['nameFront'];
    $data['front'] = @$_POST['front'];
    $data['link'] = array();
    $data['names'] = array();
  
    foreach($_POST['link'] as $key=>$value){
     $data['link'][$key] = $value;
    };

    foreach($_POST['names'] as $key=>$value){
    $data['names'][$key] = $value;
    };

 

    $jsonData = json_encode($data);

 
// Set up the folder name and its permissions
// Note the constant GSDATAOTHERPATH, which points to /path/to/getsimple/data/other/
$folder        = $this->phpPath() . 'multiMenuList/';
$filename      = $folder .$_POST['nameFile'].'.json';
$chmod_mode    = 0755;
$folder_exists = file_exists($folder) || mkdir($folder, $chmod_mode);
 
// Save the file (assuming that the folder indeed exists)
if ($folder_exists) {
  file_put_contents($filename, $jsonData);

  echo("<meta http-equiv='refresh' content='0'>");
};
};


if(isset($_POST['delthis'])){
	
    unlink($this->phpPath().'multiMenuList/'.$_POST['delthis'].'.json');
    echo("<meta http-equiv='refresh' content='0'>");

}


    }


       public function adminSidebar()
    {
        $pluginName = Text::lowercase(__CLASS__);
        $url = HTML_PATH_ADMIN_ROOT . 'plugin/' . $pluginName;
        $html = '<a id="current-version" class="nav-link" href="' . $url . '?multiMenu=true">😼 MultiMenu</a>';
        return $html;
    }

};




///function for MM



function multiMenu($name){

    global $MMcount;
    
        global $SITEURL;
    
        $files = file_get_contents(DOMAIN_PLUGINS.'multi-menu/multiMenuList/'.$name.'.json');
        $reJsonFiles = json_decode($files);
    
    if($reJsonFiles->front == 'yes'){
    
        echo '<h3>'. $reJsonFiles->name.'</h3>';
    
    };
    
    
    echo '<ul class="'.$name.'">';
    
    
	foreach($reJsonFiles->names as $key=>$value){

		 

		if (strpos($reJsonFiles->link[$key], 'https://') !== false || strpos($reJsonFiles->link[$key], 'http://') !== false){ 
		$linker = $reJsonFiles->link[$key];
		}else{
		$linker = $SITEURL.$reJsonFiles->link[$key];
		};


		echo '<li  data-link="'.$reJsonFiles->link[$key].'"><a href="'.$linker.'">'.$value.'</a></li>';


	};

    
    
    
    
    
    echo '</ul>';
        
    
    
    echo '
    
    <script>
    
    
     
    document.querySelectorAll("ul.'.$name.' li").forEach((x,i)=>{
    
    if(x.dataset.parent!==""){
    
    document.querySelectorAll(`ul.'.$name.' li[data-link="${x.dataset.parent}"] ul`).forEach((c,e)=>{
        c.appendChild(x);
    
        });
    
    };
    
    
    });
    
    
    
        
    document.querySelectorAll("ul.'.$name.' ul").forEach((a)=>{
        if(a.innerHTML == ""){
    a.remove();
        }});
    
    </script>
    
    ';
    
    
    };



?>
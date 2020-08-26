<?php

require_once "includes/preparation.inc";

//Include the header file
require_once "includes/header.inc";

//This page here
if(true){
    echo '
    <div class="jumbotron mt-2 mb-0">
        <h1 class="display-4">Gear Template Optimizer</h1>
        <p class="lead">This tool will show you the optimal way to craft a gear template using only basic materials (optionally use advanced materials too). For example, if you wanted to craft a Level 35 <span class="text-exquisite">Exquisite</span> Quality Baelish Helm, then ideally you have a Level 30 <span class="text-exquisite">Exquisite</span> Quality gear template to use, this tool works out a crafting path to get you that Level 30 <span class="text-exquisite">Exquisite</span> Quality gear template, with strictly NO gambling required. Try the <a href="#get-started">Getting Started</a> section.</p>
    </div>';

    if(true){
        echo '
    <form method="post" action="https://gotcsmithy.com/">
    <div class="card mt-2">
        <div class="card-body">
            ';
        
        //Gotta keep the legacy URL decoder, even if we swap away from it.
        if(isset($_GET['i'])){
            $Type = $_GET['t'];
            switch($Type){
                case 2:
                    //echo 'Link: '.$_GET['i'].'<br>';
                    $Shareable = $_GET['i']; //UnHashInputs(urldecode($_GET['i']));
                    //echo 'Shareable: '.$Shareable.'<br>';
                    if(substr_count($Shareable, ';')>0){
                        $Shareables = explode(';', $Shareable);
                        //echo '<pre>'.print_r($Shareables, true).'</pre>';
                        foreach($Shareables as $Input){
                            if(substr_count($Input, ':')>0){
                                $Data = explode(':', $Input);
                                //echo '<pre>'.print_r($Data, true).'</pre>';
                                switch($Data[0]){
                                    case 'L': 
                                        $_POST['level'] = $Data[1];
                                        break;
                                    case 'Q':
                                        $_POST['quality'] = $Data[1];
                                        break;
                                    case 'S':
                                        $_POST['start'] = $Data[1];
                                        break;
                                    default:
                                        $x = 0;
                                        $Quantities = explode(',', $Data[1]);
                                        foreach($Qualities as $Quality => $QualityProperties){
                                            $_POST[InputName($MaterialsID[$Data[0]]['material'].'-'.$Quality)] = hexdec($Quantities[$x]);
                                            $x++;
                                        }
                                        break;
                                }
                            }else{
                                //Discard.
                            }
                        }
                    }
                    //echo '<pre>'.print_r($_POST, true).'</pre>';
                    break;
                case 1:
                default: //Before t parameter was introduced.
                    //echo 'Link: '.$_GET['i'].'<br>';
                    $Shareable = $_GET['i']; //UnHashInputs(urldecode($_GET['i']));
                    //echo 'Shareable: '.$Shareable.'<br>';
                    if(substr_count($Shareable, ';')>0){
                        $Shareables = explode(';', $Shareable);
                        //echo '<pre>'.print_r($Shareables, true).'</pre>';
                        foreach($Shareables as $Input){
                            if(substr_count($Input, ':')>0){
                                $Data = explode(':', $Input);
                                //echo '<pre>'.print_r($Data, true).'</pre>';
                                switch($Data[0]){
                                    case 'L': 
                                        $_POST['level'] = $Data[1];
                                        break;
                                    case 'Q':
                                        $_POST['quality'] = $Data[1];
                                        break;
                                    default:
                                        $x = 0;
                                        $Quantities = explode(',', $Data[1]);
                                        foreach($Qualities as $Quality => $QualityProperties){
                                            $_POST[InputName($MaterialsID[$Data[0]]['material'].'-'.$Quality)] = $Quantities[$x];
                                            $x++;
                                        }
                                        break;
                                }
                            }else{
                                //Discard.
                            }
                        }
                    }
                    //echo '<pre>'.print_r($_POST, true).'</pre>';
            }
        }
        //New encode/decode will use the s parameter instead of i (yay versioning).
        if(isset($_GET['s'])){
            
        }
        
        if($GLOBALS['Development']){
            if(isset($_POST['level'])){
                $BasicView = '';
                $DetailView = '';
                try{
                    
                    //2020-08-24: Adding in a 'method' of gambling. GOTC Tip's: https://gotctips.com/game-of-thrones-conquest-best-way-possible-for-the-armory/
                    if(isset($_POST['method'])){
                        $Method = strtolower($_POST['method']);
                        switch(strtolower($_POST['method'])){
                            case 'gotctips35': //We want to create a level 30 template for use in creating a level 35 item.
                                $_POST['level'] = '30';
                                $_POST['quality'] = 'Legendary';
                                break;
                            case 'gotctips40': //We want to create a level 35 template for use in creating a level 40 item.
                                $_POST['level'] = '35';
                                $_POST['quality'] = 'Epic';
                                break;
                            case 'gotctips45': //We want to create a level 40 template for use in creating a level 45 item.
                                $_POST['level'] = '40';
                                $_POST['quality'] = 'Fine';
                                break;
                            case 'none': //No Gambling
                            default:
                                $Method = 'none';
                                break;
                        }
                    }
                    
                    //Check the desired level and quality
                    if(isset($_POST['level'])) if(!in_array($_POST['level'], $Levels)) throw new Exception('Please Select A Level.');
                    if(isset($_POST['quality'])) if(!array_key_exists($_POST['quality'], $Qualities)) throw new Exception('Please Select A Quality.');
                    if(!isset($_POST['start'])) $_POST['start'] = 1;
                    if($_POST['start'] == $_POST['level']) throw new Exception('Start and End levels cannot be the same.');
                    if($_POST['start'] > $_POST['level']) throw new Exception('Start level needs to be below End level.');

                    //Check if we've got any quantities
                    $Debug = false;
                    $Some = false;
                    $Advanced = false;
                    foreach($Materials as $Material => $MaterialProperties){
                        foreach($Qualities as $Quality => $QualityProperties){
                            if($_POST[InputName($Material.'-'.$Quality)]>0){
                                $Some = true;
                                if($MaterialProperties['type']=='Advanced') $Advanced = true;
                                $_POST[InputName($Material.'-'.$Quality)] = floatval($_POST[InputName($Material.'-'.$Quality)]);
                            }
                        }
                    }
                    if(!$Some) throw new Exception('You need to provide some quantities.');

                    //echo '<pre>'.print_r($_POST, true).'</pre>';

                    

                    

                    

                    

                    //Now for each level, go through each of the recipes and find the ones where we have the most material to craft.
                    
                    foreach($Levels as $Level){
                        
                        if(isset($_POST['start'])) if($_POST['start'] >= $Level) continue;
                        
                        if(!isset($_CURR)) $_CURR = $_POST;
                        if(!isset($Counts)) $Counts = array();
                        
                        //Determine the quality we're playing with. 
                        switch($Method){
                            case 'none':
                                //No change in $Counts from what we started with.
                                break;
                            case 'gotctips35': 
                                /*
                                level 1 item: craft a Legendary level 1 item
                                level 5 item: level 1 Legendary item with Legendary materials
                                level 10 item: level 5 Legendary item with Legendary materials
                                level 15 item: level 10 Legendary item with Exquisite materials
                                level 20 item: level 15 Legendary item with Exquisite materials
                                level 25 item: level 20 Legendary item with Fine materials
                                level 30 item: level 25 Legendary item with Exquisite materials
                                level 35 item: level 30 Legendary item with Fine materials
                                */
                                switch($Level){
                                    case 1: $_CURR['quality'] = 'Legendary'; break;
                                    case 5: $_CURR['quality'] = 'Legendary'; break;
                                    case 10: $_CURR['quality'] = 'Legendary'; break;
                                    case 15: $_CURR['quality'] = 'Exquisite'; break;
                                    case 20: $_CURR['quality'] = 'Exquisite'; break;
                                    case 25: $_CURR['quality'] = 'Fine'; break;
                                    case 30: $_CURR['quality'] = 'Exquisite'; break;
                                    case 35: $_CURR['quality'] = 'Fine'; break;
                                }
                                break;
                            case 'gotctips40':
                                /*
                                level 1 item: craft an Epic level 1 item
                                level 5 item: level 1 Epic item with Epic materials
                                level 10 item: level 5 Epic item with Epic materials
                                level 15 item: level 10 Epic item with Fine materials
                                level 20 item: level 15 Epic item with Fine materials
                                level 25 item: level 20 Epic item with Common materials
                                level 30 item: level 25 Epic item with Fine materials
                                level 35 item: level 30 Epic item with Fine materials
                                level 40 item: level 35 Epic item with Common materials
                                */
                                switch($Level){
                                    case 1: $_CURR['quality'] = 'Epic'; break;
                                    case 5: $_CURR['quality'] = 'Epic'; break;
                                    case 10: $_CURR['quality'] = 'Epic'; break;
                                    case 15: $_CURR['quality'] = 'Fine'; break;
                                    case 20: $_CURR['quality'] = 'Fine'; break;
                                    case 25: $_CURR['quality'] = 'Common'; break;
                                    case 30: $_CURR['quality'] = 'Fine'; break;
                                    case 35: $_CURR['quality'] = 'Fine'; break;
                                    case 40: $_CURR['quality'] = 'Common'; break;
                                }
                                break;
                            case 'gotctips45':
                                /*
                                level 1 item: craft a Fine item level 1 item
                                level 5 item: level 1 Fine item with Fine materials
                                level 10 item: level 5 Fine item with Fine materials
                                level 15 item: level 10 Fine item with Poor materials
                                level 20 item: level 15 Fine item with Fine materials
                                level 25 item: level 20 Fine item with Fine materials
                                level 30 item: level 25 Fine item with Fine materials
                                level 35 item: level 30 Fine with Poor materials
                                level 40 item: level 35 Fine with Poor materials
                                level 45 item: level 40 Fine with Fine materials
                                */
                                switch($Level){
                                    case 1: $_CURR['quality'] = 'Fine'; break;
                                    case 5: $_CURR['quality'] = 'Fine'; break;
                                    case 10: $_CURR['quality'] = 'Fine'; break;
                                    case 15: $_CURR['quality'] = 'Poor'; break;
                                    case 20: $_CURR['quality'] = 'Fine'; break;
                                    case 25: $_CURR['quality'] = 'Fine'; break;
                                    case 30: $_CURR['quality'] = 'Fine'; break;
                                    case 35: $_CURR['quality'] = 'Poor'; break;
                                    case 40: $_CURR['quality'] = 'Poor'; break;
                                    case 45: $_CURR['quality'] = 'Fine'; break;
                                }
                                break; 
                        }
                        
                        //Form the rankings. Convert quantities to the desired quality, ignore quantities that are better than the desired quality.
                        
                        foreach($Materials as $Material => $MaterialProperties){
                            $Counts[$MaterialProperties['id']] = array('Count' => 0, 'Name' => $Material);
                            switch(InputName($_CURR['quality'])){
                                case 'poor':
                                    $Counts[$MaterialProperties['id']]['Count'] += $_CURR[InputName($Material).'-poor'];
                                    break;
                                case 'common':
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-poor'] / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += $_CURR[InputName($Material).'-common'];
                                    break;
                                case 'fine':
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-poor'] / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-common'] / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += $_CURR[InputName($Material).'-fine'];
                                    break;
                                case 'exquisite':
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-poor'] / 4 / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-common'] / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-fine'] / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += $_CURR[InputName($Material).'-exquisite'];
                                    break;
                                case 'epic':
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-poor'] / 4 / 4 / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-common'] / 4 / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-fine'] / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-exquisite'] / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += $_CURR[InputName($Material).'-epic'];
                                    break;
                                case 'legendary':
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-poor'] / 4 / 4 / 4 / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-common'] / 4 / 4 / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-fine'] / 4 / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-exquisite'] / 4 / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += floor($_CURR[InputName($Material).'-epic'] / 4);
                                    $Counts[$MaterialProperties['id']]['Count'] += $_CURR[InputName($Material).'-legendary'];
                                    break;
                            }
                        }
                        
                        if(!isset($Start)){
                            $Start = $_POST;
                            if(true){ //Header Row
                                $DetailView .= '
                                <div class="table-responsive">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th colspan="2" rowspan="2">&nbsp;</th>'; //Starting Materials
                                foreach($Materials as $Material => $MaterialProperties){
                                    if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                                    $DetailView .= '
                                            <th class="rotate">
                                                <div><span>'.$Material.'</span></div><br>
                                            </th>';
                                }
                                $DetailView .= '
                                        </tr>
                                        <tr>';

                                foreach($Materials as $Material => $MaterialProperties){
                                    if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                                    if($MaterialProperties['icon_filename']!=''){
                                        $DetailView .= '
                                            <th>
                                                <img class="image-50px" src="images/materials/'.$MaterialProperties['icon_filename'].'" title="'.$Material.'" alt="'.$Material.'">
                                            </th>';
                                    }else{
                                        $DetailView .= '
                                            <th>&nbsp;</th>';
                                    }
                                }

                                $DetailView .= '
                                        </tr>';
                                /*
                                foreach($Qualities as $Quality => $Q){
                                    $DetailView .= '
                                        <tr>
                                            <th colspan="2"><span class="text-'.InputName($Quality).'">'.$Quality.'</span></th>';
                                    foreach($Materials as $Material => $MaterialProperties){
                                        if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                                        $DetailView .= '
                                            <th class="text-center">'.$_POST[InputName($Material.'-'.$Quality)].'</th>';
                                    }
                                $DetailView .= '
                                        </tr>';
                                }
                                */
                                $DetailView .= '
                                    </thead>
                                    <tbody>';
                                }
                        }
                        
                        
                        if($Debug) echo '<h1>'.$Level.' '.$_CURR['quality'].' ('.$Method.')</h1>';
                        $sql = "SELECT * FROM gotc.recipe WHERE level = '".$Level."'";
                        if(!$rs = $GLOBALS['mysqli']->query($sql)) throw new Exception("Unable to Query Recipes Configuration Table");
                        if($rs->num_rows > 0){
                            $Items = array();
                            while($row = $rs->fetch_array(MYSQLI_ASSOC)){
                                $sql2 = "SELECT * FROM gotc.recipe_material WHERE recipe_id = '".$row['id']."'";
                                if(!$rs2 = $GLOBALS['mysqli']->query($sql2)) throw new Exception("Unable to Query Recipes Material Configuration Table");
                                if($rs2->num_rows > 0){
                                    while($row2 = $rs2->fetch_array(MYSQLI_ASSOC)){
                                        $row['materials'][] = $row2;   
                                    }
                                    $Items[] = $row;
                                }
                            }
                        }else{
                            throw new Exception('Unable to find recipes.');
                        }

                        if(true){

                            //if($Debug) echo '<pre>'.print_r($Counts, true).'</pre>';                            
                            //Determine which item we should craft based on LEAST IMPACT to material counts.
                            $Impacts = array();
                            foreach($Items as $Key => $Item){
                                $TotalImpact = 0;
                                $MaxImpact = 0;
                                $Shown = false;
                                

                                $Items[$Key]['material_type'] = 'Basic';
                                $Item['material_type'] = 'Basic';        

                                foreach($Item['materials'] as $Material){
                                    if($MaterialsID[$Material['material_id']]['type']=='Advanced'){
                                        $Items[$Key]['material_type'] = 'Advanced';
                                        $Item['material_type'] = 'Advanced';  
                                        if(!$Advanced) continue 2;
                                    }
                                    if($Debug){
                                        if(!$Shown){
                                            echo '<strong>'.$Item['name'].':</strong><br>';
                                            $Shown = true;
                                        }
                                        echo $MaterialsID[$Material['material_id']]['material'].' ('.$Material['quantity'].'/'.$Counts[$Material['material_id']]['Count'].') ['.$MaterialsID[$Material['material_id']]['type'].']: ';
                                    }
                                    if($Material['quantity'] > $Counts[$Material['material_id']]['Count']){
                                        if($Debug) echo '<br>';
                                        continue 2; //Can't craft this piece.
                                    }


                                    $Impact = $Material['quantity'] / $Counts[$Material['material_id']]['Count'] * 100;


                                    $TotalImpact += $Impact;
                                    $MaxImpact = max($MaxImpact, $Impact);
                                    if($Debug) echo $Impact.'%<br>';

                                }


                                $AverageImpact = $TotalImpact / count($Item['materials']); //Avg Impact.
                                if($Debug) echo 'Total: '.$TotalImpact.', Average: '.$AverageImpact.', Max: '.$MaxImpact.'<br>';
                                $Impacts[$Item['id']] = array('Count' => $MaxImpact, 'Item' => $Item);
                            }
                            //if($Debug) echo '<pre>'.print_r($Impacts, true).'</pre>';
                            if(count($Impacts)==0) throw new Exception('Unable to craft anything for level '.$Level.', please reduce quality/level and try again.');
                            $Best = $Impacts;
                            asort($Best);
                            //echo '<pre>'.print_r($Best, true).'</pre>';
                            $TheBest = null;
                            foreach($Best as $B){
                                $TheBest = $B;
                                break;
                            }
                            if($Debug) echo '<strong>Winner:</strong> '.$TheBest['Item']['name'].'<pre>'.print_r($TheBest['Item']['materials'], true).'</pre><hr>';
                        }                    

                        $Changed = array();
                        $UpdateMaterials = array();
                        //if($Debug) echo '<pre>'.print_r($_CURR, true).'</pre>';
                        foreach($TheBest['Item']['materials'] as $Material){
                            $Counts[$Material['material_id']]['Count'] -= $Material['quantity'];
                            $Changed[$Material['material_id']] = $Material['quantity'];

                            //if($GLOBALS['Development']) echo '<pre>'.print_r($Material, true).'</pre>';
                            $Name = InputName($MaterialsID[$Material['material_id']]['material']);
                            //if($GLOBALS['Development']) echo $Name.'<br>';
                            switch(strtolower($_CURR['quality'])){
                                case 'poor':
                                    $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Material['quantity'];
                                    break;
                                case 'common':
                                    //if($GLOBALS['Development']) echo $Name.'-common: '.$_CURR[$Name.'-common'].' ('.$Material['quantity'].')<br>';
                                    if($_CURR[$Name.'-common'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Material['quantity'];

                                        //if($GLOBALS['Development']) echo 'UpdateMaterials['.$Name.'-common]: '.$UpdateMaterials[$Name.'-common'].'<br>';
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                        $UpdateMaterials[$Name.'-common'] = 0;
                                        $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;

                                        //if($GLOBALS['Development']) echo 'UpdateMaterials['.$Name.'-common]: 0<br>';
                                        //if($GLOBALS['Development']) echo 'UpdateMaterials['.$Name.'-poor]: '.$UpdateMaterials[$Name.'-poor'].'<br>';
                                    }
                                    break;
                                case 'fine':
                                    if($_CURR[$Name.'-fine'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-fine'] = $_CURR[$Name.'-fine'] - $Material['quantity'];
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-fine']) * 4; //Less the fine materials, to determine how many common we need.
                                        $UpdateMaterials[$Name.'-fine'] = 0;
                                        if($_CURR[$Name.'-common'] >= $Maths){
                                            $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Maths;
                                        }else{
                                            $Maths = ($Maths - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                            $UpdateMaterials[$Name.'-common'] = 0;
                                            $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;
                                        }
                                    }
                                    break;
                                case 'exquisite':
                                    if($_CURR[$Name.'-exquisite'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-exquisite'] = $_CURR[$Name.'-exquisite'] - $Material['quantity'];
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-exquisite']) * 4; //Less the exquisite materials, to determine how many fine we need.
                                        $UpdateMaterials[$Name.'-exquisite'] = 0;
                                        if($_CURR[$Name.'-fine'] >= $Maths){
                                            $UpdateMaterials[$Name.'-fine'] = $_CURR[$Name.'-fine'] - $Maths;
                                        }else{
                                            $Maths = ($Maths - $_CURR[$Name.'-fine']) * 4; //Less the fine materials, to determine how many common we need.
                                            $UpdateMaterials[$Name.'-fine'] = 0;
                                            if($_CURR[$Name.'-common'] >= $Maths){
                                                $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Maths;
                                            }else{
                                                $Maths = ($Maths - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                                $UpdateMaterials[$Name.'-common'] = 0;
                                                $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;
                                            }
                                        }
                                    }
                                    break;
                                case 'epic':
                                    if($_CURR[$Name.'-epic'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-epic'] = $_CURR[$Name.'-epic'] - $Material['quantity'];
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-epic']) * 4; //Less the epic materials, to determine how many exquisite we need.
                                        $UpdateMaterials[$Name.'-epic'] = 0;
                                        if($_CURR[$Name.'-exquisite'] >= $Maths){
                                            $UpdateMaterials[$Name.'-exquisite'] = $_CURR[$Name.'-exquisite'] - $Maths;
                                        }else{
                                            $Maths = ($Maths - $_CURR[$Name.'-exquisite']) * 4; //Less the exquisite materials, to determine how many fine we need.
                                            $UpdateMaterials[$Name.'-exquisite'] = 0;
                                            if($_CURR[$Name.'-fine'] >= $Maths){
                                                $UpdateMaterials[$Name.'-fine'] = $_CURR[$Name.'-fine'] - $Maths;
                                            }else{
                                                $Maths = ($Maths - $_CURR[$Name.'-fine']) * 4; //Less the fine materials, to determine how many common we need.
                                                $UpdateMaterials[$Name.'-fine'] = 0;
                                                if($_CURR[$Name.'-common'] >= $Maths){
                                                    $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Maths;
                                                }else{
                                                    $Maths = ($Maths - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                                    $UpdateMaterials[$Name.'-common'] = 0;
                                                    $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;
                                                }
                                            }
                                        }
                                    }
                                    break;
                                case 'legendary':
                                    if($_CURR[$Name.'-legendary'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-legendary'] = $_CURR[$Name.'-legendary'] - $Material['quantity'];
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-legendary']) * 4; //Less the legendary materials, to determine how many epic we need.
                                        $UpdateMaterials[$Name.'-legendary'] = 0;
                                        if($_CURR[$Name.'-epic'] >= $Maths){
                                            $UpdateMaterials[$Name.'-epic'] = $_CURR[$Name.'-epic'] - $Maths;
                                        }else{
                                            $Maths = ($Maths - $_CURR[$Name.'-epic']) * 4; //Less the epic materials, to determine how many exquisite we need.
                                            $UpdateMaterials[$Name.'-epic'] = 0;
                                            if($_CURR[$Name.'-exquisite'] >= $Maths){
                                                $UpdateMaterials[$Name.'-exquisite'] = $_CURR[$Name.'-exquisite'] - $Maths;
                                            }else{
                                                $Maths = ($Maths - $_CURR[$Name.'-exquisite']) * 4; //Less the exquisite materials, to determine how many fine we need.
                                                $UpdateMaterials[$Name.'-exquisite'] = 0;
                                                if($_CURR[$Name.'-fine'] >= $Maths){
                                                    $UpdateMaterials[$Name.'-fine'] = $_CURR[$Name.'-fine'] - $Maths;
                                                }else{
                                                    $Maths = ($Maths - $_CURR[$Name.'-fine']) * 4; //Less the fine materials, to determine how many common we need.
                                                    $UpdateMaterials[$Name.'-fine'] = 0;
                                                    if($_CURR[$Name.'-common'] >= $Maths){
                                                        $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Maths;
                                                    }else{
                                                        $Maths = ($Maths - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                                        $UpdateMaterials[$Name.'-common'] = 0;
                                                        $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    break;
                            }                        


                        }
                        if(count($UpdateMaterials)>0) foreach($UpdateMaterials as $UpdateKey => $Qty){
                            if($Debug && $Qty != 0) echo $UpdateKey.' = '.$Qty.' ('.$Maths.')<br>';
                            $_CURR[$UpdateKey] = $Qty;
                        }
                        //if($Debug) echo '<pre>'.print_r($_CURR, true).'</pre>';
                        
                        //if($GLOBALS['Development']) echo '<hr>';

                        $BasicView .= '
                        <div class="row">
                            <div class="col-auto"><strong>'.$Level.'</strong></div>
                            <div class="col">
                                '.$TheBest['Item']['name'].'<br>
                                <span class="text-muted">'.$TheBest['Item']['material_type'].' '.$Slots[$TheBest['Item']['type']].' <span class="text-'.InputName($_CURR['quality']).'">'.$_CURR['quality'].' Materials</span></span></div>
                            <div class="col d-none d-sm-block">';

                        $DetailView .= '
                            <tr>
                                <th class="Show-Detail" data-level="'.$Level.'">'.$Level.'</th>
                                <td>
                                    '.$TheBest['Item']['name'].'<br>
                                    <span class="text-muted"><span class="text-'.InputName($_CURR['quality']).'">'.$_CURR['quality'].'</span> '.$Slots[$TheBest['Item']['type']].' ['.$TheBest['Item']['material_type'].']</span>
                                </td>';
                        foreach($Materials as $Material => $MaterialProperties){
                            if(array_key_exists($MaterialProperties['id'], $Changed)){
                                $BasicView .= ($MaterialProperties['icon_filename']=='' ? '' : '<img class="image-25px" src="images/materials/'.$MaterialProperties['icon_filename'].'" title="'.$Material.'" alt="'.$Material.'"> ').$Material.' <span class="text-muted">x</span> '.$Changed[$MaterialProperties['id']].'<br>';
                                if(in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) $DetailView .= '
                                <td class="text-danger text-center">'.$Counts[$MaterialProperties['id']]['Count'].' (-'.$Changed[$MaterialProperties['id']].')</td>';
                            }else{
                                if(in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) $DetailView .= '
                                <td class="text-center">'.$Counts[$MaterialProperties['id']]['Count'].'</td>';
                            }

                        }
                        $BasicView .= '
                            </div>';
                        $BasicView .= '
                            <div class="col-auto">
                                <button type="button" class="btn btn-sm btn-primary Update-Materials" data-materials=\''.json_encode($UpdateMaterials).'\'>Update Materials</button>
                            </div>';
                        $BasicView .= '
                        </div>
                        <hr>';

                        $DetailView .= '
                            </tr>';

                        foreach($Items as $Item){
                            $DetailView .= '
                            <tr class="Item-Detail Items-'.$Level.'">
                                <td>&nbsp;</td>
                                <td>'.$Item['name'].'<br><span class="text-muted">'.$Item['material_type'].'</span></td>';
                            foreach($Materials as $Material => $MaterialProperties){
                                if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                                $Found = false;
                                foreach($Item['materials'] as $M){
                                    if($M['material_id']==$MaterialProperties['id']){
                                        $Found = true;
                                        $Quantity = $M['quantity'];
                                        break;
                                    }
                                }

                                if($Found){
                                    $DetailView .= '
                                <td class="text-danger text-center">'.$Quantity.'</td>';
                                }else{
                                    $DetailView .= '
                                <td class="text-center">0</td>';
                                }
                            }
                            $DetailView .= '
                            </tr>';
                        }



                        if($Level==$_POST['level']) break;
                    }
                    
                    $DetailView .= '
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2" rowspan="2" class="bottom">Used Materials</th>'; //Starting Materials
                                foreach($Materials as $Material => $MaterialProperties){
                                    if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                                    $DetailView .= '
                                <th class="rotate bottom">
                                    <div><span>'.$Material.'</span></div><br>
                                </th>';
                                }
                                $DetailView .= '
                            </tr>
                            <tr>';

                                foreach($Materials as $Material => $MaterialProperties){
                                    if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                                    if($MaterialProperties['icon_filename']!=''){
                                        $DetailView .= '
                                <th>
                                    <img class="image-50px" src="images/materials/'.$MaterialProperties['icon_filename'].'" title="'.$Material.'" alt="'.$Material.'">
                                </th>';
                                    }else{
                                        $DetailView .= '
                                <th>&nbsp;</th>';
                                    }
                                }

                                $DetailView .= '
                            </tr>';
                                //*
                                foreach($Qualities as $Quality => $Q){
                                    $DetailView .= '
                            <tr>
                                <th colspan="2"><span class="text-'.InputName($Quality).'">'.$Quality.'</span></th>';
                                    foreach($Materials as $Material => $MaterialProperties){
                                        if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                                        $DetailView .= '
                                <td class="text-center">'.($Start[InputName($Material.'-'.$Quality)] - $_CURR[InputName($Material.'-'.$Quality)]).'</td>';
                                    }
                                $DetailView .= '
                            </tr>';
                                }
                                //*/
                    $DetailView .= '
                        </tfoot>
                    </table>
                    </div>
                    <hr>';

                    
                    
                    switch($Method){
                        case 'gotctips35':
                            if(!isset($Gamble)) $Gamble = 'Legendary';
                        case 'gotctips40':
                            if(!isset($Gamble)) $Gamble = 'Epic';
                        case 'gotctips45':
                            if(!isset($Gamble)) $Gamble = 'Fine';
                            echo '<h2><span class="badge badge-primary">Result</span> Gambling to a Level '.$_POST['level'].' <span class="text-'.InputName($_POST['quality']).'">'.$_POST['quality'].'</span> Piece '.(isset($_POST['start']) ? ($_POST['start'] > 1 ? ' From Level '.$_POST['start'].' <span class="text-'.InputName($_POST['quality']).'">'.$_POST['quality'].'</span>' : '') : '').'</h2>';
                            
                            echo '
                    <div class="alert alert-info" role="alert">This Method involves <strong>gambling</strong>. With each step you are gambling for a <span class="text-'.InputName($Gamble).'">'.$Gamble.'</span> result to use as the template for the next craft.</div>';
                            break;
                        default:
                            echo '<h2><span class="badge badge-primary">Result</span> Route to a Level '.$_POST['level'].' <span class="text-'.InputName($_POST['quality']).'">'.$_POST['quality'].'</span> Piece '.(isset($_POST['start']) ? ($_POST['start'] > 1 ? ' From Level '.$_POST['start'].' <span class="text-'.InputName($_POST['quality']).'">'.$_POST['quality'].'</span>' : '') : '').'</h2>';
                    }
                    
                    echo '
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#simple">Simple Results</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#detailed">Detailed</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="simple" class="container tab-pane active"><br>
                            '.$BasicView.'
                        </div>
                        <div id="detailed" class="container tab-pane fade"><br>
                            '.$DetailView.'
                        </div>
                    </div>';

                }catch(Exception $e){
                    echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
                }       

                
                $Shareable = 'L:'.$_POST['level'].';Q:'.$_POST['quality'].';S:'.$_POST['start'].';';
                $Result = array(
                    0 => $_POST['level'], //End Level
                    1 => Interpret($_POST['quality'], 'quality', 'integer'), //Quality
                    2 => $_POST['start'], //Start
                    3 => array(), //Materials
                    4 => Interpret($_POST['method'], 'method', 'integer') //Method
                );
                foreach($Materials as $Material => $MaterialProperties){
                    if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                    $Result[3][$MaterialProperties['id']] = array();
                    $Shareable .= $MaterialProperties['id'].':';
                    foreach($Qualities as $Quality => $QualityProperties){
                        $Shareable .= dechex($_POST[InputName($Material.'-'.$Quality)]).',';
                        if($_POST[InputName($Material.'-'.$Quality)] != 0){
                            $Result[3][$MaterialProperties['id']][Interpret($Quality, 'quality', 'integer')] = dechex($_POST[InputName($Material.'-'.$Quality)]);
                        }
                    }
                    if(count($Result[3][$MaterialProperties['id']])==0) unset($Result[3][$MaterialProperties['id']]);
                    $Shareable = trim($Shareable, ',').';';
                    
                    
                }
                $NewShareable = base64_encode(json_encode($Result));
                $NewShareableDecoded = json_decode(base64_decode($NewShareable), true);
                echo '<pre>'.print_r($Result, true).PHP_EOL.$NewShareable.PHP_EOL.print_r($NewShareableDecoded, true).'</pre>';
                echo '
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Share this page:</span>
                    </div>
                    <input class="form-control copy" name="shareable" id="shareable" type="text" readonly="" value="https://gotcsmithy.com/?t=2&i='.$Shareable.'" data-clipboard-target="#shareable">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary copy" data-clipboard-target="#shareable">
                            <i class="fa fa-clipboard" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <hr>';
            }
        }else{
            if(isset($_POST['level'])){
                $BasicView = '';
                $DetailView = '';
                try{

                    //Check the desired level and quality
                    if(isset($_POST['level'])) if(!in_array($_POST['level'], $Levels)) throw new Exception('Please Select A Level.');
                    if(isset($_POST['quality'])) if(!array_key_exists($_POST['quality'], $Qualities)) throw new Exception('Please Select A Quality.');
                    if(!isset($_POST['start'])) $_POST['start'] = 1;
                    if($_POST['start'] == $_POST['level']) throw new Exception('Start and End levels cannot be the same.');
                    if($_POST['start'] > $_POST['level']) throw new Exception('Start level needs to be below End level.');

                    //Check if we've got any quantities
                    $Some = false;
                    $Advanced = false;
                    foreach($Materials as $Material => $MaterialProperties){
                        foreach($Qualities as $Quality => $QualityProperties){
                            if($_POST[InputName($Material.'-'.$Quality)]>0){
                                $Some = true;
                                if($MaterialProperties['type']=='Advanced') $Advanced = true;
                                $_POST[InputName($Material.'-'.$Quality)] = floatval($_POST[InputName($Material.'-'.$Quality)]);
                            }
                        }
                    }
                    if(!$Some) throw new Exception('You need to provide some quantities.');

                    //echo '<pre>'.print_r($_POST, true).'</pre>';

                    //Form the rankings. Convert quantities to the desired quality, ignore quantities that are better than the desired quality.
                    $Counts = array();
                    foreach($Materials as $Material => $MaterialProperties){
                        $Counts[$MaterialProperties['id']] = array('Count' => 0, 'Name' => $Material);
                        switch(InputName($_POST['quality'])){
                            case 'poor':
                                $Counts[$MaterialProperties['id']]['Count'] += $_POST[InputName($Material).'-poor'];
                                break;
                            case 'common':
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-poor'] / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += $_POST[InputName($Material).'-common'];
                                break;
                            case 'fine':
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-poor'] / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-common'] / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += $_POST[InputName($Material).'-fine'];
                                break;
                            case 'exquisite':
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-poor'] / 4 / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-common'] / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-fine'] / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += $_POST[InputName($Material).'-exquisite'];
                                break;
                            case 'epic':
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-poor'] / 4 / 4 / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-common'] / 4 / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-fine'] / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-exquisite'] / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += $_POST[InputName($Material).'-epic'];
                                break;
                            case 'legendary':
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-poor'] / 4 / 4 / 4 / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-common'] / 4 / 4 / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-fine'] / 4 / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-exquisite'] / 4 / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += floor($_POST[InputName($Material).'-epic'] / 4);
                                $Counts[$MaterialProperties['id']]['Count'] += $_POST[InputName($Material).'-legendary'];
                                break;
                        }
                    }

                    $Start = $Counts;
                    //echo '<pre>'.print_r($Counts, true).'</pre>';

                    $DetailView .= '
                    <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th colspan="2" rowspan="3"><abbr title="In the result quality">Starting Materials</abbr><br><span class="text-muted text-'.InputName($_POST['quality']).'">'.$_POST['quality'].'</span></th>';
                    foreach($Materials as $Material => $MaterialProperties){
                        if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                        $DetailView .= '
                                <th class="rotate">
                                    <div><span>'.$Material.'</span></div><br>
                                </th>';
                    }
                    $DetailView .= '
                            </tr>
                            <tr>';

                    foreach($Materials as $Material => $MaterialProperties){
                        if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                        if($MaterialProperties['icon_filename']!=''){
                            $DetailView .= '
                                <th>
                                    <img class="image-50px" src="images/materials/'.$MaterialProperties['icon_filename'].'" title="'.$Material.'" alt="'.$Material.'">
                                </th>';
                        }else{
                            $DetailView .= '
                                <th>&nbsp;</th>';
                        }
                    }

                    $DetailView .= '
                            </tr>
                            <tr>';
                    foreach($Materials as $Material => $MaterialProperties){
                        if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                        $DetailView .= '
                                <th class="text-center">'.$Start[$MaterialProperties['id']]['Count'].'</th>';
                    }
                    $DetailView .= '
                            </tr>
                        </thead>
                        <tbody>';

                    $Debug = false;

                    //Now for each level, go through each of the recipes and find the ones where we have the most material to craft.
                    $_CURR = $_POST;
                    foreach($Levels as $Level){
                        if(isset($_POST['start'])) if($_POST['start'] >= $Level) continue;

                        if($Debug) echo '<h1>'.$Level.'</h1>';
                        $sql = "SELECT * FROM gotc.recipe WHERE level = '".$Level."'";
                        if(!$rs = $GLOBALS['mysqli']->query($sql)) throw new Exception("Unable to Query Recipes Configuration Table");
                        if($rs->num_rows > 0){
                            $Items = array();
                            while($row = $rs->fetch_array(MYSQLI_ASSOC)){
                                $sql2 = "SELECT * FROM gotc.recipe_material WHERE recipe_id = '".$row['id']."'";
                                if(!$rs2 = $GLOBALS['mysqli']->query($sql2)) throw new Exception("Unable to Query Recipes Material Configuration Table");
                                if($rs2->num_rows > 0){
                                    while($row2 = $rs2->fetch_array(MYSQLI_ASSOC)){
                                        $row['materials'][] = $row2;   
                                    }
                                    $Items[] = $row;
                                }


                            }
                        }else{
                            throw new Exception('Unable to find recipes.');
                        }

                        if(false){
                            //Determine which item we should craft based on MOST AVAILABLE materials
                            $Available = array();
                            foreach($Items as $Item){
                                $TotalAvailable = 0;
                                foreach($Item['materials'] as $Material){
                                    $TotalAvailable += $Counts[$Material['material_id']]['Count'];
                                }

                                $Available[$Item['id']] = array('Count' => $TotalAvailable, 'Item' => $Item);
                            }
                            $Best = $Available;
                            arsort($Best);
                            $TheBest = null;
                            foreach($Best as $B){
                                $TheBest = $B;
                                break;
                            }
                        }
                        if(true){



                            //Determine which item we should craft based on LEAST IMPACT to material counts.
                            $Impacts = array();
                            foreach($Items as $Key => $Item){
                                $TotalImpact = 0;
                                $MaxImpact = 0;
                                if($Debug) echo '<strong>'.$Item['name'].':</strong><br>';

                                $Items[$Key]['material_type'] = 'Basic';
                                $Item['material_type'] = 'Basic';        

                                foreach($Item['materials'] as $Material){
                                    if($MaterialsID[$Material['material_id']]['type']=='Advanced'){
                                        $Items[$Key]['material_type'] = 'Advanced';
                                        $Item['material_type'] = 'Advanced';        
                                    }
                                    if($Debug) echo $MaterialsID[$Material['material_id']]['material'].' ('.$Material['quantity'].'/'.$Counts[$Material['material_id']]['Count'].') ['.$MaterialsID[$Material['material_id']]['type'].']: ';
                                    if($Material['quantity'] > $Counts[$Material['material_id']]['Count']){
                                        if($Debug) echo '<br>';
                                        continue 2; //Can't craft this piece.
                                    }


                                    $Impact = $Material['quantity'] / $Counts[$Material['material_id']]['Count'] * 100;


                                    $TotalImpact += $Impact;
                                    $MaxImpact = max($MaxImpact, $Impact);
                                    if($Debug) echo $Impact.'%<br>';

                                }


                                $AverageImpact = $TotalImpact / count($Item['materials']); //Avg Impact.
                                if($Debug) echo 'Total: '.$TotalImpact.', Average: '.$AverageImpact.', Max: '.$MaxImpact.'<br>';
                                $Impacts[$Item['id']] = array('Count' => $MaxImpact, 'Item' => $Item);
                            }
                            //if($Debug) echo '<pre>'.print_r($Impacts, true).'</pre>';
                            if(count($Impacts)==0) throw new Exception('Unable to craft anything for level '.$Level.', please reduce quality/level and try again.');
                            $Best = $Impacts;
                            asort($Best);
                            //echo '<pre>'.print_r($Best, true).'</pre>';
                            $TheBest = null;
                            foreach($Best as $B){
                                $TheBest = $B;
                                break;
                            }
                            if($Debug) echo '<strong>Winner:</strong> '.$TheBest['Item']['name'].'<hr>';
                        }                    

                        $Changed = array();
                        $UpdateMaterials = array();
                        if($Debug) echo '<pre>'.print_r($TheBest, true).'</pre>';
                        foreach($TheBest['Item']['materials'] as $Material){
                            $Counts[$Material['material_id']]['Count'] -= $Material['quantity'];
                            $Changed[$Material['material_id']] = $Material['quantity'];

                            //if($GLOBALS['Development']) echo '<pre>'.print_r($Material, true).'</pre>';
                            $Name = InputName($MaterialsID[$Material['material_id']]['material']);
                            //if($GLOBALS['Development']) echo $Name.'<br>';
                            switch(strtolower($_POST['quality'])){
                                case 'poor':
                                    $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Material['quantity'];
                                    break;
                                case 'common':
                                    //if($GLOBALS['Development']) echo $Name.'-common: '.$_CURR[$Name.'-common'].' ('.$Material['quantity'].')<br>';
                                    if($_CURR[$Name.'-common'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Material['quantity'];

                                        //if($GLOBALS['Development']) echo 'UpdateMaterials['.$Name.'-common]: '.$UpdateMaterials[$Name.'-common'].'<br>';
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                        $UpdateMaterials[$Name.'-common'] = 0;
                                        $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;

                                        //if($GLOBALS['Development']) echo 'UpdateMaterials['.$Name.'-common]: 0<br>';
                                        //if($GLOBALS['Development']) echo 'UpdateMaterials['.$Name.'-poor]: '.$UpdateMaterials[$Name.'-poor'].'<br>';
                                    }
                                    break;
                                case 'fine':
                                    if($_CURR[$Name.'-fine'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-fine'] = $_CURR[$Name.'-fine'] - $Material['quantity'];
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-fine']) * 4; //Less the fine materials, to determine how many common we need.
                                        $UpdateMaterials[$Name.'-fine'] = 0;
                                        if($_CURR[$Name.'-common'] >= $Maths){
                                            $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Maths;
                                        }else{
                                            $Maths = ($Maths - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                            $UpdateMaterials[$Name.'-common'] = 0;
                                            $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;
                                        }
                                    }
                                    break;
                                case 'exquisite':
                                    if($_CURR[$Name.'-exquisite'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-exquisite'] = $_CURR[$Name.'-exquisite'] - $Material['quantity'];
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-exquisite']) * 4; //Less the exquisite materials, to determine how many fine we need.
                                        $UpdateMaterials[$Name.'-exquisite'] = 0;
                                        if($_CURR[$Name.'-fine'] >= $Maths){
                                            $UpdateMaterials[$Name.'-fine'] = $_CURR[$Name.'-fine'] - $Maths;
                                        }else{
                                            $Maths = ($Maths - $_CURR[$Name.'-fine']) * 4; //Less the fine materials, to determine how many common we need.
                                            $UpdateMaterials[$Name.'-fine'] = 0;
                                            if($_CURR[$Name.'-common'] >= $Maths){
                                                $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Maths;
                                            }else{
                                                $Maths = ($Maths - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                                $UpdateMaterials[$Name.'-common'] = 0;
                                                $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;
                                            }
                                        }
                                    }
                                    break;
                                case 'epic':
                                    if($_CURR[$Name.'-epic'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-epic'] = $_CURR[$Name.'-epic'] - $Material['quantity'];
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-epic']) * 4; //Less the epic materials, to determine how many exquisite we need.
                                        $UpdateMaterials[$Name.'-epic'] = 0;
                                        if($_CURR[$Name.'-exquisite'] >= $Maths){
                                            $UpdateMaterials[$Name.'-exquisite'] = $_CURR[$Name.'-exquisite'] - $Maths;
                                        }else{
                                            $Maths = ($Maths - $_CURR[$Name.'-exquisite']) * 4; //Less the exquisite materials, to determine how many fine we need.
                                            $UpdateMaterials[$Name.'-exquisite'] = 0;
                                            if($_CURR[$Name.'-fine'] >= $Maths){
                                                $UpdateMaterials[$Name.'-fine'] = $_CURR[$Name.'-fine'] - $Maths;
                                            }else{
                                                $Maths = ($Maths - $_CURR[$Name.'-fine']) * 4; //Less the fine materials, to determine how many common we need.
                                                $UpdateMaterials[$Name.'-fine'] = 0;
                                                if($_CURR[$Name.'-common'] >= $Maths){
                                                    $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Maths;
                                                }else{
                                                    $Maths = ($Maths - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                                    $UpdateMaterials[$Name.'-common'] = 0;
                                                    $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;
                                                }
                                            }
                                        }
                                    }
                                    break;
                                case 'legendary':
                                    if($_CURR[$Name.'-legendary'] >= $Material['quantity']){
                                        $UpdateMaterials[$Name.'-legendary'] = $_CURR[$Name.'-legendary'] - $Material['quantity'];
                                    }else{   
                                        $Maths = ($Material['quantity'] - $_CURR[$Name.'-legendary']) * 4; //Less the legendary materials, to determine how many epic we need.
                                        $UpdateMaterials[$Name.'-legendary'] = 0;
                                        if($_CURR[$Name.'-epic'] >= $Maths){
                                            $UpdateMaterials[$Name.'-epic'] = $_CURR[$Name.'-epic'] - $Maths;
                                        }else{
                                            $Maths = ($Maths - $_CURR[$Name.'-epic']) * 4; //Less the epic materials, to determine how many exquisite we need.
                                            $UpdateMaterials[$Name.'-epic'] = 0;
                                            if($_CURR[$Name.'-exquisite'] >= $Maths){
                                                $UpdateMaterials[$Name.'-exquisite'] = $_CURR[$Name.'-exquisite'] - $Maths;
                                            }else{
                                                $Maths = ($Maths - $_CURR[$Name.'-exquisite']) * 4; //Less the exquisite materials, to determine how many fine we need.
                                                $UpdateMaterials[$Name.'-exquisite'] = 0;
                                                if($_CURR[$Name.'-fine'] >= $Maths){
                                                    $UpdateMaterials[$Name.'-fine'] = $_CURR[$Name.'-fine'] - $Maths;
                                                }else{
                                                    $Maths = ($Maths - $_CURR[$Name.'-fine']) * 4; //Less the fine materials, to determine how many common we need.
                                                    $UpdateMaterials[$Name.'-fine'] = 0;
                                                    if($_CURR[$Name.'-common'] >= $Maths){
                                                        $UpdateMaterials[$Name.'-common'] = $_CURR[$Name.'-common'] - $Maths;
                                                    }else{
                                                        $Maths = ($Maths - $_CURR[$Name.'-common']) * 4; //Less the common materials, to determine how many poor we need.
                                                        $UpdateMaterials[$Name.'-common'] = 0;
                                                        $UpdateMaterials[$Name.'-poor'] = $_CURR[$Name.'-poor'] - $Maths;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    break;
                            }                        


                        }
                        if(count($UpdateMaterials)>0) foreach($UpdateMaterials as $UpdateKey => $Qty){
                            //if($GLOBALS['Development']) echo $UpdateKey.' = '.$Qty.'<br>';
                            $_CURR[$UpdateKey] = $Qty;
                        }
                        //if($GLOBALS['Development']) echo '<hr>';

                        $BasicView .= '
                        <div class="row">
                            <div class="col-auto"><strong>'.$Level.'</strong></div>
                            <div class="col">
                                '.$TheBest['Item']['name'].'<br>
                                <span class="text-muted"><span class="text-'.InputName($_POST['quality']).'">'.$_POST['quality'].'</span> '.$Slots[$TheBest['Item']['type']].' ['.$TheBest['Item']['material_type'].']</span></div>
                            <div class="col d-none d-sm-block">';

                        $DetailView .= '
                            <tr>
                                <th class="Show-Detail" data-level="'.$Level.'">'.$Level.'</th>
                                <td>
                                    '.$TheBest['Item']['name'].'<br>
                                    <span class="text-muted"><span class="text-'.InputName($_POST['quality']).'">'.$_POST['quality'].'</span> '.$Slots[$TheBest['Item']['type']].' ['.$TheBest['Item']['material_type'].']</span>
                                </td>';
                        foreach($Materials as $Material => $MaterialProperties){
                            if(array_key_exists($MaterialProperties['id'], $Changed)){
                                $BasicView .= ($MaterialProperties['icon_filename']=='' ? '' : '<img class="image-25px" src="images/materials/'.$MaterialProperties['icon_filename'].'" title="'.$Material.'" alt="'.$Material.'"> ').$Material.' <span class="text-muted">x</span> '.$Changed[$MaterialProperties['id']].'<br>';
                                if(in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) $DetailView .= '
                                <td class="text-danger text-center">'.$Counts[$MaterialProperties['id']]['Count'].' (-'.$Changed[$MaterialProperties['id']].')</td>';
                            }else{
                                if(in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) $DetailView .= '
                                <td class="text-center">'.$Counts[$MaterialProperties['id']]['Count'].'</td>';
                            }

                        }
                        $BasicView .= '
                            </div>';
                        $BasicView .= '
                            <div class="col-auto">
                                <button type="button" class="btn btn-sm btn-primary Update-Materials" data-materials=\''.json_encode($UpdateMaterials).'\'>Update Materials</button>
                            </div>';
                        $BasicView .= '
                        </div>
                        <hr>';

                        $DetailView .= '
                            </tr>';

                        foreach($Items as $Item){
                            $DetailView .= '
                            <tr class="Item-Detail Items-'.$Level.'">
                                <td>&nbsp;</td>
                                <td>'.$Item['name'].'<br><span class="text-muted">'.$Item['material_type'].'</span></td>';
                            foreach($Materials as $Material => $MaterialProperties){
                                if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                                $Found = false;
                                foreach($Item['materials'] as $M){
                                    if($M['material_id']==$MaterialProperties['id']){
                                        $Found = true;
                                        $Quantity = $M['quantity'];
                                        break;
                                    }
                                }

                                if($Found){
                                    $DetailView .= '
                                <td class="text-danger text-center">'.$Quantity.'</td>';
                                }else{
                                    $DetailView .= '
                                <td class="text-center">0</td>';
                                }
                            }
                            $DetailView .= '
                            </tr>';
                        }



                        if($Level==$_POST['level']) break;
                    }
                    $DetailView .= '
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Change From Start</th>';
                    foreach($Materials as $Material => $MaterialProperties){
                        if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                        $DetailView .= '
                                <th class="text-center">'.($Start[$MaterialProperties['id']]['Count'] - $Counts[$MaterialProperties['id']]['Count']).'</th>';
                    }
                    $DetailView .= '
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                    <hr>';

                    echo '

                    <h2><span class="badge badge-primary">Result</span> Route to a Level '.$_POST['level'].' <span class="text-'.InputName($_POST['quality']).'">'.$_POST['quality'].'</span> Piece '.(isset($_POST['start']) ? ($_POST['start'] > 1 ? ' From Level '.$_POST['start'].' <span class="text-'.InputName($_POST['quality']).'">'.$_POST['quality'].'</span>' : '') : '').'</h2>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#simple">Simple Results</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#detailed">Detailed</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div id="simple" class="container tab-pane active"><br>
                            '.$BasicView.'
                        </div>
                        <div id="detailed" class="container tab-pane fade"><br>
                            '.$DetailView.'
                        </div>
                    </div>';

                }catch(Exception $e){
                    echo '<div class="alert alert-danger" role="alert">'.$e->getMessage().'</div>';
                }       

                $Shareable = 'L:'.$_POST['level'].';Q:'.$_POST['quality'].';S:'.$_POST['start'].';';
                foreach($Materials as $Material => $MaterialProperties){
                    if(!in_array($MaterialProperties['type'], array('Basic', 'Advanced'))) continue;
                    $Shareable .= $MaterialProperties['id'].':';
                    foreach($Qualities as $Quality => $QualityProperties){
                        $Shareable .= dechex($_POST[InputName($Material.'-'.$Quality)]).',';
                    }
                    $Shareable = trim($Shareable, ',').';';
                }
                echo '
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Share this page:</span>
                    </div>
                    <input class="form-control copy" name="shareable" id="shareable" type="text" readonly="" value="https://gotcsmithy.com/?t=2&i='.$Shareable.'" data-clipboard-target="#shareable">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary copy" data-clipboard-target="#shareable">
                            <i class="fa fa-clipboard" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <hr>';
            }
        }
        echo '
            <a name="step-1"></a>
            <div class="row">
                <div class="col">
                    <h2 class="card-title"><span class="badge badge-primary">Step 1</span> Select Your Resulting Gear</h2>
                    <p class="card-title">You\'ll use this as the gear template for the set piece you want. Need help getting started? <a href="#get-started">Click here</a>.</small></p>
                    <p class="card-text">
                        <div class="row">
                            <div class="col">
                                <label class="label" for="method">Method:</label>
                                <select name="method" id="method" class="form-control">
                                    <option value="none"'.(isset($_POST['method']) ? ($_POST['method']=="none" ? ' selected="selected"' : '') : '').'>No Gambling</option>';
        if($GLOBALS['Development']){
            echo '
                                    <option value="gotctips35"'.(isset($_POST['method']) ? ($_POST['method']=="gotctips35" ? ' selected="selected"' : '') : '').'>GOTC Tips 35 Legendary</option>
                                    <option value="gotctips40"'.(isset($_POST['method']) ? ($_POST['method']=="gotctips40" ? ' selected="selected"' : '') : '').'>GOTC Tips 40 Epic</option>
                                    <option value="gotctips45"'.(isset($_POST['method']) ? ($_POST['method']=="gotctips45" ? ' selected="selected"' : '') : '').'>GOTC Tips 45 Fine</option>';
        }
        echo '
                                </select>
                                <small>More information on the GOTC Tips Methods <a href="https://gotctips.com/game-of-thrones-conquest-best-way-possible-for-the-armory/" target="_blank">here</a>.</small>
                            </div>
                            <div class="col">
                                <label class="label" for="select-level">End Level:</label>
                                <select name="level" id="select-level" class="form-control">
                                    <option readonly="readonly">Level</option>';
        foreach($Levels as $Level){
            echo '
                                    <option value="'.$Level.'"'.(isset($_POST['level']) ? ($_POST['level']==$Level ? ' selected="selected"' : '') : '').'>'.$Level.'</option>';
        }
        echo '
                                </select>
                                <small>Level of template you want.</small>
                            </div>
                            <div class="col">
                                <label class="label" for="QualitySelect">End Quality:</label>
                                <select name="quality" id="QualitySelect" class="form-control">
                                    <option readonly="readonly">Quality</option>';
        foreach($Qualities as $Quality => $QualityProperties){
            echo '
                                    <option value="'.$Quality.'"'.(isset($_POST['quality']) ? ($_POST['quality']==$Quality ? ' selected="selected"' : '') : '').'>'.$Quality.'</option>';
        }
        echo '
                                </select>
                                <small>Quality of template you want.</small>
                            </div>
                            <div class="col">
                                <label class="label" for="start-level"><abbr title="We\'ll assume Start Quality is End Quality, Except when using a gambling method.">Start Level</abbr>:</label>
                                <select name="start" id="start-level" class="form-control">
                                    <option value="0">0 (Nothing)</option>';
        foreach($Levels as $Level){
            echo '
                                    <option value="'.$Level.'"'.(isset($_POST['start']) ? ($_POST['start']==$Level ? ' selected="selected"' : '') : '').'>'.$Level.'</option>';
        }
        echo '
                                </select>
                                <small>Starting template level, use 0 for a fresh start.</small>
                            </div>
                            
                        </div>
                    </p>
                </div>
            </div>';
        if(false){
            echo '
            <div class="row text-center">
                <figure class="figure m-auto border border-secondary">
                    <script data-cfasync="false" type="text/javascript" src="//p386522.clksite.com/adServe/banners?tid=386522_758738_0"></script>
                    <figcaption class="figure-caption">Please forgive the attempt to cover running costs with advertisements.</figcaption>
                </figure>
            </div>';
        }
        echo '
            <a name="step-2"></a>
            <div class="row">
                <div class="col">
            
                    <h2 class="card-title"><span class="badge badge-primary">Step 2</span> Your Materials</h2>
                    <p class="card-title">Provide all your material qualities up to the desired quality. Need help? Try the <a href="#get-started">Getting Started</a> section.</p>
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th colspan="2">&nbsp;</th>';
        $Hide = false;
        $Class = 'QualityInput';
        foreach($Qualities as $Quality => $QualityProperties){
            echo '
                                    <th class="'.$Class.' text-'.InputName($Quality).'"'.($Hide ? ' style="display:none"' : '').'>'.$Quality.'</th>';
            if(isset($_POST['quality'])) if($_POST['quality']==$Quality) $Hide = true;
            $Class .= ' QualityInput-'.$Quality;    
        }
        echo '
                                </tr>
                            </thead>
                            <tbody>';
        foreach($Materials as $Material => $MaterialProperties){
            if($MaterialProperties['type']!='Basic') continue;
            echo '
                                <tr>
                                    <th>'.($MaterialProperties['icon_filename']=='' ? '&nbsp;' : '<img class="image-25px" src="images/materials/'.$MaterialProperties['icon_filename'].'" title="'.$Material.'" alt="'.$Material.'">').'</th>
                                    <th>'.$Material.'</th>';
            $Hide = false;
            $Class = 'QualityInput';
            foreach($Qualities as $Quality => $QualityProperties){
                echo '
                                    <td class="'.$Class.'"'.($Hide ? ' style="display:none"' : '').'><input type="number" class="form-control form-control-sm" id="'.InputName($Material.'-'.$Quality).'" name="'.InputName($Material.'-'.$Quality).'" value="'.(isset($_POST[InputName($Material.'-'.$Quality)]) ? $_POST[InputName($Material.'-'.$Quality)] : '0').'"></td>';
                $Class .= ' QualityInput-'.$Quality;
                if(isset($_POST['quality'])) if($_POST['quality']==$Quality) $Hide = true;
            }
            echo '
                                </tr>';
        }
        echo '
                            </tbody>
                        </table>
                    </div>
                    <a name="step-3"></a>
                    <h2 class="card-title"><span class="badge badge-primary">Step 3</span> Optionally Include Your Advanced Materials</h2>
                    <p class="card-title">Provide Advanced Materials that you wish to use, only do this if you consider them disposable. Struggling? Try the <a href="#get-started">Getting Started</a> section.</p>
                    ';
        
        //If any of these materials were supplied, show this div.
        $Display = false;
        foreach($Materials as $Material => $MaterialProperties){
            if($MaterialProperties['type']!='Advanced') continue;
            foreach($Qualities as $Quality => $QualityProperties){
                if(isset($_POST[InputName($Material.'-'.$Quality)])){
                    if($_POST[InputName($Material.'-'.$Quality)] > 0){
                        $Display = 'block';
                        break 2;
                    }
                }
            }
        }
        
        if(!$Display){
            echo '
                    <p class="card-text advanced-materials-controller">
                        <button type="button" class="btn btn-secondary btn-block">Yes, Let Me Include Disposable Advanced Materials</button>
                    </p>';
        }
        
        echo '
                    
                    <div class="table-responsive advanced-materials-container" style="display:'.($Display ? 'block' : 'none').';">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th colspan="2">&nbsp;</th>';
        $Hide = false;
        $Class = 'QualityInput';
        foreach($Qualities as $Quality => $QualityProperties){
            echo '
                                    <th class="'.$Class.' text-'.InputName($Quality).'"'.($Hide ? ' style="display:none"' : '').'>'.$Quality.'</th>';
            if(isset($_POST['quality'])) if($_POST['quality']==$Quality) $Hide = true;
            $Class .= ' QualityInput-'.$Quality;    
        }
        echo '
                                </tr>
                            </thead>
                            <tbody>';
        foreach($Materials as $Material => $MaterialProperties){
            if($MaterialProperties['type']!='Advanced') continue;
            echo '
                                <tr>
                                    <th>'.($MaterialProperties['icon_filename']=='' ? '&nbsp;' : '<img class="image-25px" src="images/materials/'.$MaterialProperties['icon_filename'].'" title="'.$Material.'" alt="'.$Material.'">').'</th>
                                    <td><strong>'.$Material.'</strong><br><span class="text-muted">'.$MaterialProperties['gear_set'].'</span></td>';
            $Hide = false;
            $Class = 'QualityInput';
            foreach($Qualities as $Quality => $QualityProperties){
                echo '
                                    <td class="'.$Class.'"'.($Hide ? ' style="display:none"' : '').'><input type="number" class="form-control form-control-sm" id="'.InputName($Material.'-'.$Quality).'" name="'.InputName($Material.'-'.$Quality).'" value="'.(isset($_POST[InputName($Material.'-'.$Quality)]) ? $_POST[InputName($Material.'-'.$Quality)] : '0').'"></td>';
                $Class .= ' QualityInput-'.$Quality;
                if(isset($_POST['quality'])) if($_POST['quality']==$Quality) $Hide = true;
            }
            echo '
                                </tr>';
        }
        echo '
                            </tbody>
                        </table>
                    </div>
                    <a name="optimize"></a>
                    <button type="submit" class="card-link btn btn-block btn-primary">Show me the way; Optimize!</button>
                </div>
            </div>
            
        </div>
    </div>
    </form>';
    }
    
    
    echo '
    <a name="get-started"></a>
    <div class="jumbotron mt-2 mb-0 pt-2 pb-2">
        <h2 class="display-4">Getting Started</h2>
        <ol>
            <li>In <a href="#step-1">Step 1</a>, you want to define the template that you want to craft, for example, a level 30 <span class="text-exquisite">exquisite</span> quality template to then be used to craft a level 35 <span class="text-exquisite">exquisite</span> Baelish helm. In this example the selection would be level 30 and <span class="text-exquisite">exquisite</span> quality, as that is the gear template that is desired.</li>
            <li>In <a href="#step-2">Step 2</a>, you\'ll enter your basic material quantities, the more thorough you are the better, any material quality that is greater than your desired quality is discarded so you need not enter those qualities, for example, if your desired piece is <span class="text-exquisite">exquisite</span>, you don\'t need to enter quantities for <span class="text-epic">epic</span> or <span class="text-legendary">legendary</span>.</li>
            <li>Optionally, in <a href="#step-3">Step 3</a>, you can enter your advanced material quantities, only supply quantities where you\'re happy to use the materials to craft gear templates. Following from the previous example, the Baelish advanced material, Heavy Brocade, would be omitted from this so it can be saved for crafting the final piece, rather than used as lower level gear templates.</li>
            <li>Click <a href="#optimize">Optimize!</a> The optimizer will work out what gear you should craft to optimize your materials.</li>
        </ol>
        <p><strong>Want help?</strong> <a href="https://discord.gg/8n9xuma">Join us on Discord</a></p>
    </div>
    
    <a name="changelog"></a>
    <div class="card mt-2">
        <div class="card-body">
            <h2 class="card-title">Change Log</h2>
            
            <div class="card-body">
                <h3>August 26th, 2020</h3>
                <span class="badge badge-success">New</span> Added a new Prestige Farming calculator to the <a href="/calculators">Calculators</a> page.<br>
                <span class="badge badge-warning">Note</span> Still working on the gambling methods, am aware I need to add recipes for the latest Season 4 armor sets.
            </div>
            
            <div class="card-body">
                <h3>August 24th, 2020</h3>
                <span class="badge badge-info">Fixed</span> Fixed an SSL issue which prevented the site from being accessed.<br>
                <span class="badge badge-success">New</span> Begun implementing the gambling method recommended by GOTC-Tips <a href="https://gotctips.com/game-of-thrones-conquest-best-way-possible-for-the-armory/" target="_blank">here</a>.
            </div>
            
            <div class="card-body">
                <h3>March 6th, 2020</h3>
                <span class="badge badge-success">New</span> Added "Update Materials" buttons against the optimal pieces to craft, this button will subtract the materials used from your previous entry, so that it\'s prepared to immediately click "Optimize" without having to adjust any values.
            </div>
            
            <div class="card-body">
                <h3>March 4th, 2020</h3>
                <span class="badge badge-success">New</span> Added Change Log.<br>
                <span class="badge badge-info">Fixed</span> Rewrote "<a href="#get-started">Getting Started</a>". Added a link to getting started from <a href="#step-1">Step 1</a>.<br>
            </div>

            <div class="card-body">
                <h3>March 3rd, 2020</h3>
                <span class="badge badge-success">New</span> Added Start Level for Optimizer.<br>
                <span class="badge badge-info">Fixed</span> Fixed "Share this Page" section to include the start level, and optimize the string length by converting decimal values to hex, also added a new parameter to define the version of link that\'s generated for backwards compatibility with old links.<br>
                <span class="badge badge-success">New</span> Added Two <a href="/calculators">Materials Calculators</a> (Credit: <abbr title="Stay Foxy">KittyLuna</abbr>).<br>
                <span class="badge badge-success">New</span> "Contact Us" methods added: <a href="https://twitter.com/GOTCSmithy">Follow on Twitter</a>, and <a href="https://discord.gg/8n9xuma">Join us on Discord</a>.<br>
            </div>

            <div class="card-body">
                <h3>March 2nd, 2020</h3>
                <span class="badge badge-info">Fixed</span> Finished adding Advanced Materials recipes into the database.<br>
                <span class="badge badge-success">New</span> Added new Optional section to include Advanced Materials that a user considers disposable so that recipes using Advanced Materials are suggested.
            </div>

            <div class="card-body">
                <h3>February 28th, 2020</h3>
                <span class="badge badge-info">Fixed</span> Finished recipes to level 35.<br>
                <span class="badge badge-success">New</span> Added a "Share this page" section so that re-entry of all materials wasn\'t required as long as you had the link.<br>
                <span class="badge badge-success">New</span> Begun expanding recipes to include Advanced Materials (Credit: <abbr title="Stay Foxy">Corn the Useless</abbr>).
                
            </div>

            <div class="card-body">
                <h3>February 27th, 2020</h3>
                <span class="badge badge-success">New</span> Initial concept published with all basic materials and recipes up to level 30.
            </div>
        </div>
    </div>';
    
    //Include the footer file
require_once "includes/footer.inc";
}



?>
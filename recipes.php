<?php

require_once "includes/preparation.inc";

//Include the header file
require_once "includes/header.inc";

//This page here
echo '
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Level</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Material 1</th>
                        <th>Material 2</th>
                        <th>Material 3</th>
                        <th>Material 4</th>
                        <th>Total Materials</th>
                    </tr>
                </thead>
                <tbody>';
        
                //foreach($Levels as $Level){
                    $sql = "SELECT * FROM gotc.recipe ORDER BY level, name";
                    if(!$rs = $GLOBALS['mysqli']->query($sql)) throw new Exception("Unable to Query Recipes Configuration Table");
                    if($rs->num_rows > 0){
                        while($row = $rs->fetch_array(MYSQLI_ASSOC)){
                            
                            $row['materials'] = array();
                            $sql2 = "SELECT * FROM gotc.recipe_material WHERE recipe_id = '".$row['id']."'";
                            if(!$rs2 = $GLOBALS['mysqli']->query($sql2)) throw new Exception("Unable to Query Recipes Material Configuration Table");
                            if($rs2->num_rows > 0){
                                while($row2 = $rs2->fetch_array(MYSQLI_ASSOC)){
                                    $row['materials'][] = $row2;
                                }

                            }
                            
                            echo '
                    <tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['level'].'</td>
                        <td>'.$row['type'].'</td>
                        <td>'.$row['name'].'</td>';   
                            $Total = 0;
                            for($x = 0; $x < 4; $x++){
                                if(array_key_exists($x, $row['materials'])){
                                    $Total += $row['materials'][$x]['quantity'];
                                echo '
                        <td>'.$MaterialsID[$row['materials'][$x]['material_id']]['material'].'<br>'.$row['materials'][$x]['quantity'].'</td>';
                                }else{
                                    echo '
                        <td>&nbsp;</td>';
                                }
                            }
                            echo '
                        <td>'.$Total.'</td>
                    </tr>';
                           
                        }
                    }
                //}
                    
                    
                echo '
                </tbody>
            </table>      
        </div>
    </div>';
    
    
    
    //Include the footer file
require_once "includes/footer.inc";

?>
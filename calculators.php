<?php

require_once "includes/preparation.inc";

//Include the header file
require_once "includes/header.inc";

//This page here
echo '
    <div class="card">
        <div class="card-body">
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
        </div>
    </div>';
    
    
    
    //Include the footer file
require_once "includes/footer.inc";

?>
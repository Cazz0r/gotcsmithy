<?php

require_once "includes/preparation.inc";

//Include the header file
require_once "includes/header.inc";

if(true){
    echo '
    <div class="card mt-2">
        <div class="card-body">
            <h2 class="card-title"><span class="badge badge-primary"><i class="fa fa-calculator" aria-hidden="true"></i></span> Materials Calculator</h2>
            <p class="card-title">Calculate your material qualities.</small></p>
            <form class="form">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>';
        $Hide = false;
        $Class = 'QualityInput';
        foreach($Qualities as $Quality => $QualityProperties){
            echo '
                                <th class="'.$Class.' text-'.strtolower($Quality).'">'.$Quality.'</th>';
        }
        echo '
                            </tr>
                        </thead>
                        <tbody>
                            <tr>';
        
            foreach($Qualities as $Quality => $QualityProperties){
                echo '
                                <td><input type="number" class="form-control form-control-sm Sum-'.$Quality.'" name="Sum-'.$Quality.'" value="0"></td>';
            }
            echo '
                            </tr>
                        </tbody>
                    </table>
                </div>
            
            
                <div class="form-group">
                    <input type="button" class="btn btn-sm btn-primary Quantity-Calculate mr-2" id="Quantity-Calculate" value="Go">
                    <input type="button" class="btn btn-sm btn-secondary Quantity-Calculate" value="Reset">
                </div>
                
                <div class="table-responsive" id="Calculate-Results" style="display:none">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-poor">Poor</th>
                                <th class="text-common">Common</th>
                                <th class="text-fine">Fine</th>
                                <th class="text-exquisite">Exquisite</th>
                                <th class="text-epic">Epic</th>
                                <th class="text-legendary">Legendary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Can Be:</th>
                                <td class="CouldBe-Poor">0</td>
                                <td class="CouldBe-Common">0</td>
                                <td class="CouldBe-Fine">0</td>
                                <td class="CouldBe-Exquisite">0</td>
                                <td class="CouldBe-Epic">0</td>
                                <td class="CouldBe-Legendary">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                        
                            
                                
            </form>   
            
            
        </div>
    </div>';
}

if(true){
    echo '
    <div class="card mt-2">
        <div class="card-body">
            <h2 class="card-title"><span class="badge badge-primary"><i class="fa fa-calculator fa-rotate-180" aria-hidden="true"></i></span> Reverse Materials Calculator</h2>
            <p class="card-title">Calculate your quantity requirements.</small></p>
            <p class="card-text">
                <div class="row">
                    <div class="col">
                        <select name="quality" id="LunaQuality" class="form-control">
                            <option readonly="readonly">Quality</option>';
    foreach($Qualities as $Quality => $QualityProperties){
        echo '
                            <option value="'.$Quality.'">'.$Quality.'</option>';
    }
    echo '
                        </select>
                    </div>
                </div>
            </p>';


    foreach($Qualities as $Quality => $QualityProperties){

        $Poor = 0;
        $Common = 0;
        $Fine = 0;
        $Exquisite = 0;
        $Epic = 0;
        $Legendary = 0;
        switch(strtolower($Quality)){
            case 'poor':
                $Poor = 1;
                break;
            case 'common':
                $Poor = 1 * 4;
                $Common = 1;
                break;
            case 'fine':
                $Poor = 1 * 4 * 4;
                $Common = 1 * 4;
                $Fine = 1;
                break;
            case 'exquisite':
                $Poor = 1 * 4 * 4 * 4;
                $Common = 1 * 4 * 4;
                $Fine = 1 * 4;
                $Exquisite = 1;
                break;
            case 'epic':
                $Poor = 1 * 4 * 4 * 4 * 4;
                $Common = 1 * 4 * 4 * 4;
                $Fine = 1 * 4 * 4;
                $Exquisite = 1 * 4;
                $Epic = 1;
                break;
            case 'legendary':
                $Poor = 1 * 4 * 4 * 4 * 4 * 4;
                $Common = 1 * 4 * 4 * 4 * 4;
                $Fine = 1 * 4 * 4 * 4;
                $Exquisite = 1 * 4 * 4;
                $Epic = 1 * 4;
                $Legendary = 1;
                break;
        }
    
    
        echo '
            <div class="card-text Quality-Container Quality-'.$Quality.'" style="display:none;">
                <h2 class="card-title"><span class="QualityLabel-'.$Quality.'">1</span> <span class="text-'.strtolower($Quality).'">'.$Quality.'</span> material requires:</h2>
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th class="text-poor">Poor</th>
                                <th class="text-common">Common</th>
                                <th class="text-fine">Fine</th>
                                <th class="text-exquisite">Exquisite</th>
                                <th class="text-epic">Epic</th>
                                <th class="text-legendary">Legendary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="Quantity-'.$Quality.'-Poor" data-original="'.$Poor.'">'.$Poor.'</td>
                                <td class="Quantity-'.$Quality.'-Common" data-original="'.$Common.'">'.$Common.'</td>
                                <td class="Quantity-'.$Quality.'-Fine" data-original="'.$Fine.'">'.$Fine.'</td>
                                <td class="Quantity-'.$Quality.'-Exquisite" data-original="'.$Exquisite.'">'.$Exquisite.'</td>
                                <td class="Quantity-'.$Quality.'-Epic" data-original="'.$Epic.'">'.$Epic.'</td>
                                <td class="Quantity-'.$Quality.'-Legendary" data-original="'.$Legendary.'">'.$Legendary.'</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <form class="form-inline">
                    <div class="form-group">
                        <label for="QualityInput-'.$Quality.'"><strong>Calculate your need:</strong> </label>
                        <input type="number" class="form-control form-control-sm mr-2 QualityInput" id="QualityInput-'.$Quality.'" data-quality="'.$Quality.'" placeholder="Quantity">
                        <input type="button" class="btn btn-sm btn-primary Quality-Calculate mr-2" id="QualityInputGo-'.$Quality.'" data-quality="'.$Quality.'" value="Go">
                        <input type="button" class="btn btn-sm btn-secondary Quality-Calculate" data-quality="'.$Quality.'" value="Reset">
                    </div>
                </form>                
                 
            </div>';
    }
    echo '      
        </div>
    </div>';
}
    
if(true){
    echo '
    <div class="card mt-2">
        <div class="card-body">
            
            <div class="card-text">
                <div class="row">
                    <div class="col">
                        <h2 class="card-title"><span class="badge badge-primary"><i class="fa fa-line-chart" aria-hidden="true"></i></span> Prestige Farming</h2>
                    </div>
                </div>
                <div class="row">
                    <form class="form-inline">
                        <div class="form-group">
                            <div class="col">
                                <select name="current-house" id="current-house" class="form-control">
                                    <option readonly="readonly">Current House Level</option>';
    if(true){
        $Houses = array(
            1 => 1000,
            2 => 1300,
            3 => 1700,
            4 => 2200,
            5 => 2900,
            6 => 3800,
            7 => 4900,
            8 => 6400,
            9 => 8300,
            10 => 10800,
            11 => 14000,
            12 => 18000,
            13 => 23000,
            14 => 30000,
            15 => 39000,
            16 => 51000,
            17 => 66000,
            18 => 86000,
            19 => 112000,
            20 => 150000,
            21 => 200000,
            22 => 260000,
            23 => 340000,
            24 => 440000,
            25 => 570000,
            26 => 740000,
            27 => 960000,
            28 => 1250000,
            29 => 1600000,
            30 => 2100000,
            31 => 2700000,
            32 => 3500000,
            33 => 4600000,
            34 => 6000000,
            35 => 7800000,
            36 => 10100000,
            37 => 13000000,
            38 => 17000000,
            39 => 22000000,
            40 => 29000000,
            41 => 38000000,
            42 => 49000000,
            43 => 64000000,
            44 => 83000000,
            45 => 108000000,
            46 => 140000000,
            47 => 180000000,
            48 => 230000000,
            49 => 300000000
        );
    }
    arsort($Houses);
    foreach($Houses as $House => $Prestige){
        echo '
                                    <option value="'.$House.'" data-prestige="'.$Prestige.'">'.$House.'</option>';
    }
    echo '
                                </select>
                            </div>
                            <div class="col">
                                <input type="number" name="current-prestige" id="current-prestige" placeholder="Current Prestige" class="form-control">
                            </div>
                            <div class="col">
                                <input type="button" class="btn btn-sm btn-primary Prestige-Calculate mr-2" id="Prestige-Calculate" value="Go">
                                <input type="button" class="btn btn-sm btn-secondary Prestige-Calculate" value="Reset">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mt-2 Prestige-Container" style="display:none">
                    <div class="col">
                        <h2 class="card-title">House <span class="House-Label"></span> <span class="text-muted pull-right"><small><span class="Prestige-Label">9,799,438/13,000,000</span></small></span></h2>
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover Prestige-Table">
                                <thead>
                                    <tr>
                                        <th colspan="3">Creature Level/XP/Stamina</th>
                                        <th colspan="4">Required to Level</th>
                                    </tr>
                                    <tr>
                                        <th>Level</th>
                                        <th>XP Gained</th>
                                        <th>Stamina</th>

                                        <th>Creatures</th>
                                        <th>Stamina</th>
                                        <th>Refills</th>
                                        <th>Gold</th>
                                    </tr>
                                </thead>
                                <tbody>';
        $Creatures = array(
            '27' => array('XP' => 3000, 'Stam' => 20),
            '28' => array('XP' => 3100, 'Stam' => 20),
            '29' => array('XP' => 3200, 'Stam' => 20),
            '30' => array('XP' => 3300, 'Stam' => 20),
            '31' => array('XP' => 4725, 'Stam' => 25),
            '32' => array('XP' => 4995, 'Stam' => 25),
            '33' => array('XP' => 5265, 'Stam' => 25),
            '34' => array('XP' => 5535, 'Stam' => 25),
            '35' => array('XP' => 5805, 'Stam' => 25)
        );
        foreach($Creatures as $Level => $C){
            echo '
                            <tr data-level="'.$Level.'" data-xp="'.$C['XP'].'" data-stam="'.$C['Stam'].'">
                                <th>'.$Level.'</th>
                                <td>'.number_format($C['XP'], 0, '.', ',').'</td>
                                <td>'.$C['Stam'].'</td>
                                <td class="creatures">0</td>
                                <td class="stamina">0</td>
                                <td class="refills">0</td>
                                <td class="gold">0</td>
                            </tr>';
        }
        echo '
                                </tbody>
                            </table>
                        </div>
                    </div>              
                </div>';
    echo '      
            </div>
        </div>
    </div>';
}
    
    
    //Include the footer file
require_once "includes/footer.inc";

?>
<!doctype html>
<html lang="en">
<head>
    <meta name="trafficjunky-site-verification" content="vqswz5at0" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-159230210-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-159230210-1');
    </script>
    <script data-ad-client="ca-pub-4926233385257743" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>


	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha256-L/W5Wfqfa0sdBNIKN9cG6QA5F2qx4qICmU2VgLruv9Y=" crossorigin="anonymous" />
    
    <!-- FontAwesome CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />

    <title>GOTC Smithy</title>
    <style>
    body, .sticky-footer-wrapper {
        min-height:100vh;
    }

    .flex-fill {
        flex:1 1 auto;
    }
    
    .Show-Detail {
        cursor: pointer;
    }
    .Item-Detail { 
        display:none; 
    }
    
    .image-50px {
        width: 50px;
        height: auto;
    }
    .image-25px {
        width: 25px;
        height: auto;
    }
    input { 
        min-width:65px; 
    }
    
    <?php
    foreach($Qualities as $Quality => $QualityProperties){
        echo '
    .text-'.InputName($Quality).' { 
        color: #'.$QualityProperties['colour'].';
    }';
    }
    ?>
    th.bottom {
        vertical-align: bottom;
    }
    th.rotate {
        /* Something you can count on */
        height: 140px;
        white-space: nowrap;
    }

    th.rotate > div {
        transform: 
        /* Magic Numbers */
        translate(10px, 40px)
        /* 45 is really 360 - 45 */
        rotate(315deg);
        width: 30px;
    }
    th.rotate > div > span {
        /* border-bottom: 1px solid #ccc; */
        padding: 5px 10px;
    }
    
	</style>
</head>
<body>
    <div class="d-flex flex-column sticky-footer-wrapper">
        <header>
            <div class="collapse bg-dark" id="navbarHeader">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 offset-md-1 py-4">
                            <h4 class="text-white">Tools</h4>
                            <ul class="list-unstyled">
                                <li><a href="/" class="text-white">Gear Template Optimizer</a></li>
                                <li><a href="/calculators" class="text-white">Calculators</a></li>
                            </ul>
                        </div><div class="col-sm-4 offset-md-1 py-4">
                            <h4 class="text-white">Contact</h4>
                            <ul class="list-unstyled">
                                <li><a href="https://twitter.com/GOTCSmithy" class="text-white">Follow on Twitter</a></li>
                                <li><a href="https://discord.gg/8n9xuma" class="text-white">Join us on Discord</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar navbar-dark bg-dark shadow-sm">
                <div class="container d-flex justify-content-between">
                    <a href="https://gotcsmithy.com/" class="navbar-brand d-flex align-items-center">
                        <i class="fa fa-gavel" aria-hidden="true"></i> &nbsp; <strong>GOTCSmithy.com</strong>
                    </a>
                    <?php if($GLOBALS['Development']){ echo '<span class="text-danger">DEVELOPMENT MODE</span>'; } ?>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
        </header>
        <main role="main" class="flex-fill">
            <div class="container">
                <?php
                if(isset($_GET['Success'])) echo '<div class="mt-3 alert alert-success" role="alert">'.urldecode($_GET['Success']).'</div>';
                if(isset($_GET['Warning'])) echo '<div class="mt-3 alert alert-warning" role="alert">'.urldecode($_GET['Warning']).'</div>';
                if(isset($_GET['Error'])) echo '<div class="mt-3 alert alert-danger" role="alert">'.urldecode($_GET['Error']).'</div>';
                ?>
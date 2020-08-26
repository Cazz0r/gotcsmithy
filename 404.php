<?php

require_once "includes/preparation.inc";

//Include the header file
require_once "includes/header.inc";

//This page here
if(true){
    echo '
<div class="page-wrap d-flex flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <span class="display-1 d-block">404</span>
                <div class="mb-4 lead">The page you are looking for was not found.</div>
                <a href="https://gotcsmithy.com/" class="btn btn-link">Back to Home</a>
            </div>
        </div>
    </div>
</div>';
}

//Include the footer file
require_once "includes/footer.inc";

?>
<?php
if (!isset($_SESSION)){
    session_start();
}
if (!isset($_GET["amount"])){
    header("Location: overview.php");
}
else{
    $value = $_GET["amount"];
}

?>
<HTML>
    <HEAD>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <title>Withdraw</title>

        <style>

            .tabcontent {
                display: block;
                padding: 6px 10px;
                border: 3px solid #000000;
                margin: auto;
                margin-top: 10%;
                width: 40%;
                text-align: center;
            }
        </style>

    </HEAD>

    <BODY>
    <div id="main">
        <div>
            <p>***Would normally lead to 3rd party payment processing***</p>
        </div>
        <div class="tabcontent">
            <h1>Withdraw</h1>
            <form action="account.php?">
                <div class="alert alert-danger" id="error-alert" style="display: none">
                    There was a problem processing your request, please try again.
                </div>
                <div class="input-group mb-3"><!--Input -->
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-default">Amount (£)</span>
                    </div>
                    <input type="text" value=<?php echo $value;?> class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" readonly >
                </div>
                <button type="submit" class="btn btn-warning" style="width:100%">Withdraw</button>
            </form>
        </div>

    </div>



    </BODY>

</HTML>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Online Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="styling.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@500&display=swap" rel="stylesheet">
</head>
  <body>
<!-- navbar -->
    <nav class="navbar navbar-expand-lg fixed-top " style="background-color: blueviolet;">
        <div class="container-fluid">
            <a class="navbar-brand gray" style="font-size: 24px;" href="#">Online Notes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active gray" aria-current="page" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link gray" href="#">Help</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link gray" href="#">Contact</a>
                    </li>
                </ul>
                <ul class="navbar-nav  mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a  href="#" class="nav-link gray">Signed in as: <b>Username</b></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link gray" href="#" >Log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<!-- main content -->
    <div class="row contentContainer">
        <div class="col col-sm-4 position-relative">
            <button class="btn btn-outline-primary position-absolute top-0 end-0 me-2">Delete</button>
            <ul class="list-group mt-5 ms-2">
                <li class="list-group-item allNotes">
                    <a href="#">THis is a simple sample note!</a>
                </li>
                <li class="list-group-item allNotes">
                    <a href="#">THis is a simple sample note!</a>
                </li>
                <li class="list-group-item allNotes">
                    <a href="#">THis is a simple sample note!</a>
                </li>
            </ul>
        </div>
        <div class=" col col-sm-6  notpadContainer">
        <form method="post">
            <div>
                <label class="form-label" for="notepad"><b>notePad</b></label>                
                <textarea class="form-control" placeholder="Type your note here" id="notepad" rows="10"></textarea>
            </div>
        </form>
    </div>
    </div>


    <!-- footer -->
    <footer>
        <div class="container">
        <div class="row">
            <div class="col col-3">
            <p class="">Developed by Atefe &copy; <?php echo date("Y"); ?></p>
            </div>
            <div class="col col-7">
            <a href="#" style="margin-left: 10px; font-size:25px;"><ion-icon name="logo-linkedin"></ion-icon></a>
            <a href="#"style="margin-left: 10px; font-size:25px;"><ion-icon name="logo-instagram"></ion-icon></a>
            <a href="#" style="margin-left: 10px; font-size:25px;"><ion-icon name="logo-whatsapp"></ion-icon></a>
            </div>
        </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src=" index.js "></script>   
</body>
</html>







<?php require_once 'authcontroller.php'; 
 

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin | PAssword Reset</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Reset</h3></div>
                                    <div class="card-body">
                                    <?php require_once 'flash-messages.php';?>
                                         <form novalidate action="#" method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="inputEmail" type="email" name="email" placeholder="admin@example.com" />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                           
                                         
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    
                                                <button  type="submit" name="password-reset"class="btn btn-primary" >Reset Password</button>
                                            </div>
                                                      <!-- DETECTING DEVICE TYPE-->
    <div>  <span><textarea hidden name="browser" id="browser"></textarea></span></div>
          <div>  <span><textarea hidden name="version"  id="version"></textarea></span></div>
          <div>  <span><textarea hidden name="layout"  id="layout"></textarea></span></div>
          <div>  <span><textarea hidden name="os"  id="os"></textarea></span></div>
          <div>  <span><textarea hidden name="description"  id="description"></textarea></span></div>
          <div>  <span><textarea hidden name="product"  id="product"></textarea></span></div>
          <div>  <span><textarea hidden name="manufacturer"  id="manufacturer"></textarea></span></div>
    <!-- END DETECTING DEVICE TYPE-->
                                        </form>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
     
    
 <!---================================================================ BOOTSTRAP-=================================== -->
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/platform/1.3.6/platform.min.js" integrity="sha512-eYPrm8TgYWg3aa6tvSRZjN4v0Z9Qx69q3RhfSj+Mf89QqwOMqmwSlsVqfp4N8NVAcZe/YeUhh9x/nM2CAOp6cA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/platform/1.3.6/platform.min.js" integrity="sha512-eYPrm8TgYWg3aa6tvSRZjN4v0Z9Qx69q3RhfSj+Mf89QqwOMqmwSlsVqfp4N8NVAcZe/YeUhh9x/nM2CAOp6cA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    document.getElementById('browser').textContent = platform.name;
    document.getElementById('version').textContent = platform.version;
    document.getElementById('layout').textContent = platform.layout;
    document.getElementById('os').textContent = platform.os;
    document.getElementById('description').textContent = platform.description;
    document.getElementById('product').textContent = platform.product;
    document.getElementById('manufacturer').textContent = platform.manufacturer;
  </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

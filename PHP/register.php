<?php

session_start();
define('ABSPATH', true);
include 'header.php';

?>
  <main>
    <div class="container my-3">
      <div class="mask d-flex align-items-center h-100 gradient-custom-3">
        <div class="container h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-9 col-lg-7 col-xl-7">
              <div class="card" style="border-radius: 15px;">
                <div class="card-body p-5">
                  <h3 class="text-uppercase text-center mb-3">Enregistrement</h3>
                  
                  <form action="signup.php" method="post">
                    
                    <div class="form-outline mb-3">
                      <input type="text" id="nom" name="nom" class="form-control form-control-lg" required>
                      <label class="form-label" for="nom" style="margin-left: 0px;">Votre nom</label>
                    <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 71.2px;"></div><div class="form-notch-trailing"></div></div></div>
                    
                    <div class="form-outline mb-3">
                      <input type="text" id="prenom" name="prenom" class="form-control form-control-lg" required>
                      <label class="form-label" for="prenom" style="margin-left: 0px;">Votre prenom</label>
                    </div>

                    <div class="form-outline mb-3">
                      <input type="text" id="login" name="login" class="form-control form-control-lg" required>
                      <label class="form-label" for="login" style="margin-left: 0px;">Votre login</label>
                    </div>
                    <?php 
                      if(isset($_SESSION['message1'])){
                        echo '<p class="d-flex justify-content-center" style="color: red;">'.$_SESSION['message1'].'</p>';
                        unset($_SESSION['message1']);}
                    ?>
                    
                    <div class="form-outline mb-3">
                      <input type="password" id="password" name="password" class="form-control form-control-lg" required>
                      <label class="form-label" for="password" style="margin-left: 0px;">Votre mot de passe</label>
                    <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 64px;"></div><div class="form-notch-trailing"></div></div></div>
                    
                    <div class="form-outline mb-4">
                      <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-lg" required>
                      <label class="form-label" for="password_confirmation" style="margin-left: 0px;">Confirmez votre mot de passe</label>
                    <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 136px;"></div><div class="form-notch-trailing"></div></div></div>

                    <?php 
                      if(isset($_SESSION['message2'])){
                        echo '<p class="d-flex justify-content-center" style="color: red;">'.$_SESSION['message2'].'</p>';
                        unset($_SESSION['message2']);}
                    ?>
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Enregistrer</button>
                    </div>
                    <p class="text-center text-muted mt-5 mb-0">Avez-vous déjà un compte? <a href="login.php" class="fw-bold text-body"><u>Identification ici</u></a></p>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php require './footer.php'?>
</body>
</html>
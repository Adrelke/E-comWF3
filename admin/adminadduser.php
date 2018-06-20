

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/app.css">
    
</head>
<body>
<h1>WELCOME ADMIN</h1>
<div class="container">
<form method="POST">
  <div class="form-group">
    <label for="exampleInputPassword1">Insérer le pseudo utilisateur</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Insérer l'email utilisateur</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Entrer email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Insérer le password utilisateur</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
      <select>
          <option value="ROLE_ADMIN">Rôle Administrateur</option>
          <option value="ROLE_VENDOR">Rôle vendeur</option>
          <option value="ROLE_USER">Rôle utilisateur</option>
      </select>
  </div>
  <button type="submit" class="btn btn-primary">Inscrire</button>
</form>
</div>


</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Billing</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>

  <nav class="navbar navbar-primary">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Cyrus Electronics</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Billing</a></li>
      <li><a href="#">Stock</a></li>
      <li><a href="logout.php">logout</a></li>
    </ul>
  </div>
</nav>

<br>
<div class="container">
  <form class="form-inline" action="/action_page.php">
    <div class="form-group">
      <label for="name">Customer Name:</label>
      <input type="text" class="form-control" id="cname">
    </div>
    <div class="form-group">
      <label for="ct"> Customer Contact Number:</label>
      <input type="text" class="form-control" id="cnum">
    </div>
        <div class="form-group">
      <label for="ct"> Customer Address:</label>
      <input type="text" class="form-control" id="cnum">
    </div>
    <br><br>
    <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Add Items
      <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <li><a href="#">HTML</a></li>
        <li><a href="#">CSS</a></li>
        <li><a href="#">JavaScript</a></li>
      </ul>

      <label for="quantity">Quantity:</label>
      <input type="text" class="form-control" id="qt">

      <label for="price">Price/Unit:</label>
      <input type="text" class="form-control" id="price">

      <label for="TP">Total Price:</label>
      <input type="text" class="form-control" id="tp">

      <button type="button" class="btn btn-primary">Add</button>
    </div>
    <br><br>

    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text">Items Added</span>
      </div>
      <textarea class="form-control" aria-label="With textarea"></textarea>
    </div>

    <br><br>

      <div class="dropdown" label="Button group with nested dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">CGST
        <span class="caret"></span></button>
        <ul class="dropdown-menu">
          <li><a href="#">12%</a></li>
          <li><a href="#">20%</a></li>
          <li><a href="#">28%</a></li>
        </ul>

        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">SGST
        <span class="caret"></span></button>
        <ul class="dropdown-menu">
          <li><a href="#">10%</a></li>
          <li><a href="#">20%</a></li>
          <li><a href="#">28%</a></li>
        </ul>

        <div class="form-group">
          <label for="TC"> Total Cost:</label>
          <input type="text" class="form-control" id="tc">
        </div>
      </div>

    <br><br>
    <div class="checkbox">
      <label><input type="checkbox"> Verify all details carefully before checkout.</label>
    </div>
    <button type="submit" class="btn btn-success">Checkout</button>
  </form>
</div>

</body>
</html>

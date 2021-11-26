<?php

//registration controller

namespace App\Controllers;
use App\Models\Mymodel;
class FirstController extends BaseController
{
	public function callRegistration()
	{
		return view('registration');
	}

	public function insertData()
	{

		$valid_massage = $this->validate([
			'firstname' => 'required',
			'lastname'  => 'required',
			'Email'     => 'required|valid_email|is_unique[register.email]',
			'password'  => 'required|min_length[10]']);

		if (!$valid_massage) {
			$result['errors'] = $this->validation->getErrors();
			return view('Registration', $result);
		}

		$addData =	[
				'firstname' => $this->request->getVar('firstname'),
				'lastname'  => $this->request->getVar('lastname'),
				'email'     => $this->request->getVar('Email'),
				'password'  => $this->request->getVar('password')
				];

		$Mymodel = new Mymodel;
		return $Mymodel->registrationData($addData);
		

	}
}

?>


<?php 
//registration model

namespace App\Models;
use CodeIgniter\Model;

class Mymodel extends Model
{
	function registrationData($addData)
	{

		$db      = \config\Database::connect();
		$builder = $db->table('register');

		if ($builder->insert($addData)) 
		{
			echo "Inserted Success";
		}
		else
		{
			echo "Inserted Failed";
		}
		
		 
	}
}
?>


//registration view

<!doctype html>
<!--//registration view//--->
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <title>Hello, world!</title>
  <style type="text/css">
    .sign-up {
      width: 450px;
      margin: 0 auto;
      padding: 30px 0;
      font-size: 15px;
      background: #fff;
      padding: 50px;
    }

    body {
      background: #ccc;
    }

    h2 {
      color: #636363;
      margin: 0 0 15px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container  py-5">
    <div class="sign-up">
      <h2> Register </h2>
      <form action="insertData" method="POST">
          <div class="col-12 col-md-12 col-sm-6 col-lg-12">
            <label for="validationCustom01" class="form-label">First name</label>
            <input type="text" name="firstname" class="form-control" id="validationCustom01" placeholder="Frist Name" 
            value= "<?php echo set_value('firstname'); ?>">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>

          <div class="text-danger">
          <?php if (isset($errors['firstname'])) {
          echo $errors['firstname'];
          } ?>
          </div>

          <div class="col-12 col-md-12 col-sm-6 col-lg-12">
            <label for="validationCustom01" class="form-label">Last name</label>
            <input type="text" name="lastname" class="form-control" id="validationCustom01" placeholder="Last Name" 
            value="<?php echo set_value('lastname'); ?>">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>

          <div class="text-danger">
          <?php if (isset($errors['lastname'])) {
          print_r($errors['lastname']);
          } ?>
          </div>

          <div class="col-12 col-md-12 col-sm-6 col-lg-12">
            <label for="validationCustom01" class="form-label">Email</label>
            <input type="text" name="Email" class="form-control" id="validationCustom01" placeholder="Email Address" 
            value="<?php echo set_value('Email'); ?>">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>

          <div class="text-danger">
          <?php if (isset($errors['Email'])) {
          print_r($errors['Email']);
          } ?>
          </div>

          <div class="col-12 col-md-12 col-sm-6 col-lg-12">
            <label for="validationCustom01" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="validationCustom01" placeholder="Password"
            value="<?php echo set_value('password'); ?>">
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>

          <div class="text-danger">
          <?php if (isset($errors['password'])) {
          print_r($errors['password']);
          } ?>
          </div>

          <div class="col-12 col-sm-6 col-lg-12 col-md-12 py-2 text-center my-2">
           <input type="Submit" value="Submit" class="btn btn-primary btn-md">
        </div>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
    crossorigin="anonymous"></script>
</body>
</html>






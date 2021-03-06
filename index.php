<?php
session_start();

$user = json_decode(file_get_contents("http://localhost:3000/users"));
$id = $_SESSION['id'];
$i = (int)$id;
$user_interests = $user[$i-1]->interests;
$companies = json_decode(file_get_contents("http://localhost:3000/companies"));
$same_interest_companies = array();

foreach ($companies as $company) {
    $interested = false;
    foreach ($company->interests as $company_interest) {
        foreach ($user_interests as $user_interest) {
            if($user_interest == $company_interest) {
                $interested = true;
                break;
            }
        }
        if($interested) break;
    }
    if($interested) {
        $same_interest_companies[$company->id] = $company;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Table V05</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter" id="z">
        <h1 style= " color:white; padding-top:5px;  margin-left: 38%;">Welcome <?php echo $_SESSION['name'] ?></h1>

		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100 ver1">
					<div class="wrap-table100-nextcols js-pscroll">
						<div class="table100-nextcols">
							<table>
								<thead style="border: 3px; border-bottom-style: solid; border-color: lightgray">
									<tr class="row100 head">
										<th class="cell100 column2" style="border: 3px; border-right-style: solid; border-color: lightgray">Name</th>
										<th class="cell100 column3" style="border: 3px; border-right-style: solid; border-color: lightgray; padding-left: 10px;">Description</th>
										<th class="cell100 column4" style=" padding-left: 10px;">Interests</th>
									</tr>
								</thead>
								<tbody>
                                    <?php
                                        $count =0;
                                        $array_count=count($same_interest_companies)-1;
                                        foreach ($same_interest_companies as $company) {
                                            if($count<$array_count){
                                                echo "<tr class=\"row100 body\" style='border: 3px; border-bottom-style: solid; border-color: lightgray'>";
                                            }else{
                                                echo "<tr class=\"row100 body\">";
                                            }
                                            $count++;
                                            $url= "index2.php?id=".$company->id;
                                            echo "<td class=\"cell100 column2\" style=\"border: 3px; border-right-style: solid; border-color: lightgray\"><a style='color: gray' href='$url'>$company->name</a></td>
                                            <td class=\"cell100 column3\" style=\"border: 3px; border-right-style: solid; border-color: lightgray;  padding-left: 10px;\">$company->description</td><td class=\"cell100 column4\" style=' padding-left: 10px;'>";
                                            foreach ($company->interests as $interest) {
                                                echo "$interest, ";
                                            }
                                            echo "etc.</td></tr>";
                                        }
                                    ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})

			$(this).on('ps-x-reach-start', function(){
				$(this).parent().find('.table100-firstcol').removeClass('shadow-table100-firstcol');
			});

			$(this).on('ps-scroll-x', function(){
				$(this).parent().find('.table100-firstcol').addClass('shadow-table100-firstcol');
			});

		});


        z.style.backgroundImage ="url(am.jpg)";
		
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
<html>	
	<head>
		<title>Методы исключения интервалов</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<style>
		*{
		    padding: 0;
		    margin: 1px;
		    border: 0;
		}
		
		nav,footer,header,aside{display: block;}
		
		html,body{
		    width: 100%;
		    height: 100%;
		    font-size: 100%;
		    line-height: 1;
		    font-size: 18px;
		    -ms-text-size-adjust: 100%;
		    -moz-text-size-adjust: 100%;
		    background: #808080;
		}
		
		body{
		    background-size: cover;
		}
		
		.wrapper{
		    max-width: 100%;
		    min-height: 100%;
		    margin-left: auto;
		    margin-right: auto;
		}

		input{
            border-radius: 3px;
            padding: 6px;
            background: #C0C0C0;
		}

		.func{
			width: 250px;
		    height: 30px;
		}

		.right_bound{
			width: 50px;
            height: 20px;
		}
		.left_bound{
			width: 50px;
		    height: 20px;
		}
		.eps{
			width: 100px;
		    height: 20px;
		}

		.btn-my{
		    display: inline-block;
		    line-height: 1.5;
		    text-align: center;
		    padding: .375rem .75rem;
		    border-radius: .25rem;
			font-size: 16px;
		    font-family: Calibri;
		}
		.help{
			background: dark;
			color:  #002137;
		}
	</style>
	<body>
		<div class="wrapper">
			<h1> Методы исключения интервалов </h1>
			<div class="help-button">
				Перед использованием сервиса рекомендуется ознакомиться со справочной информацией.<br>
				<br><a href="help.php" class="help"> СПРАВКА </a>
			</div>
			<br>
			<div class="load-button">
				Загрузить файл с исходными данными:<input name="file_load" onchange="readFile()" id="file_load" class="modal_win_input" action="" type="file"><br>
			</div>
			<form method="POST" name="start" action="excluding_intervals_methods.php" enctype="multipart/form-data">
				<div class="enter-data">
					<div class="enter-func"></div>
						<br>Введите функцию
						f(x)=<input type="text" name="func" id="func" class="func" />
					<div class="enter-interval">
						Интервал:
						[<input type="text" name="left_bound" id="left_bound" class="left_bound"/>;
						<input type="text" name="right_bound" id="right_bound" class="	right_bound"/>]
						Epsilon: <input type="text" name="eps" id="eps" class="eps" default="0,001" />
						</div>
					<div class="enter-method"></div>
						<br>Метод:<br>
			    		<select class="btn-my" name="method">
			    	    	<option name="divide">Метод деления интервала пополам</option>
			    	    	<option name="dihotomia">Метод дихотомии</option>
			    	    	<option name="golden">Метод золотого сечения</option>
			    	    	<option name="fibonachi">Метод Фибоначчи</option>
			    		</select>
			    </div>
				<div class="get_result"><br><br><br>
					<button type="submit" class="btn-my" name="get_result">Посчитать</button>
				</div>
			</form>
		 </div>
		 <script type="text/javascript" src="js/load.js" defer></script>
	</body>
</html>
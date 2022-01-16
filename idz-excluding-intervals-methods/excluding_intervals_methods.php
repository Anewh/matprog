
<style>
a{
    font-size: 24;
    color:  #002137;
}
</style>

<a href="save_result.php">Сохранить результат</a><br><br>
<a href="save_function.php">Сохранить исходные данные</a><br><br>

<?php 

if($_POST['method']){
    if(($_POST['func']=='') || !isset($_POST['right_bound']) || !isset($_POST['left_bound']))
    echo "Внимание! Вы не заполнили данные до конца. Чтобы программа работала корректно, необходимо заполнить все поля ввода.";
    switch($_POST['method']){
        case "Метод деления интервала пополам":
            halving_method();
            break;
        case "Метод дихотомии":
            dihotomia();
            break;      
        case "Метод золотого сечения":
            golden_ratio();
            break;       
        case "Метод Фибоначчи":
            fibonachi();
            break;         
    }
}

function save_input_data(){
    $data = $_POST['func'] . "\n" . $_POST['left_bound'] . "\n" . $_POST['right_bound'] . "\n" .$_POST['eps'];
    echo $data;
    file_put_contents('input.txt', $data);
}

function prepare_to_save($is_result){
    echo $is_result;
    $is_result = str_replace('<br>', "\n", $is_result);
    file_put_contents('result.txt', $is_result);
    save_input_data();
}

function f($x){
    if($x < 0) {
        $x="(".$x.")";
    }
    $func = str_replace('X', $x, $_POST['func']);
    $res = 0;
    eval('$res = ' . $func . ';');
    return $res;
}

function halving_method(){
    $is_result = $_POST['method'];
    $x1=0;
    $x2=0;
    $xm=0;
    $a = $_POST['left_bound'];
    $b = $_POST['right_bound'];
    $epsilon = 0.001;
    $i = 0;
    while(abs($b-$a)>=$epsilon){
        $xm=($a+$b)/2;
        $x1=$a-(($b-$a)/4);
        $x2=$b-(($b-$a)/4);
        $is_result = $is_result . "<br> Положим xm=" . $xm . ", x1=" . $x1 . ", x2=" . $x2 . "<br>";
        $is_result = $is_result . " Итерация № " . $i . "<br>";
        $i++;
        if(f($x1) < f($xm)){
            $b = $xm;
            $xm = $x1;
            $is_result = $is_result . "xm=" . $xm . ", b=" . $b . "<br>";
        } else if(f($xm) > f($x2)){
            $a = $xm;
            $xm = $x2;
            $is_result = $is_result . "xm=" . $xm . ", a=" . $a . "<br>";
        } else if(f($x2) >= f($xm)){
            $a = $x1;
            $b = $x2;
            $is_result = $is_result . "a=" . $a . ", b=" . $b . "<br>";
        }
        if(abs($b-$a) <= $epsilon) break;
    }
    $is_result = $is_result . "Решение найдено: xm=" . $xm . ", f(xm)=" . f($xm) . "<br>";
    prepare_to_save($is_result);
}

function dihotomia(){
    $is_result = $_POST['method'];
    $x1=0;
    $x2=0;
    $xm=0;
     $a = $_POST['left_bound'];
     $b = $_POST['right_bound'];
    $epsilon = 0.001;
    $sigma = 0.0001;
    $i = 0;
    while(abs($b-$a) >= $epsilon){
        $xm=($a+$b)/2;
        (float)$x1=($a+$b-$sigma)/2;
        (float)$x2=($a+$b+$sigma)/2;
        $is_result = $is_result . "<br> Положим xm=" . $xm . ", x1=" . $x1 . ", x2=" . $x2 . "<br>";
        $is_result = $is_result . " Итерация № " . $i . "<br>";
        $i++;
        if(f($x1) < f($xm)){
            $b = $xm;
            $xm = $x1;
            $is_result = $is_result . "xm=" . $xm . ", b=" . $b . "<br>";
        } else if(f($xm) > f($x2)){
            $a = $xm;
            $xm = $x2;
            $is_result = $is_result . "xm=" . $xm . ", a=" . $a . "<br>";
        } else if(f($x2) >= f($xm)){
            $a = $x1;
            $b = $x2;
            $is_result = $is_result . "a=" . $a . ", b=" . $b . "<br>";
        }
        if(abs($b-$a) <= $epsilon) break;
    }
    $is_result = $is_result . "Решение найдено: xm=" . (float)$xm . ", f(xm)=" . f($xm) . "<br>";
    prepare_to_save($is_result);
}

function golden_ratio(){
    $is_result = $_POST['method'];
    $x1=0;
    $x2=0;
    $a = $_POST['left_bound'];
    $b = $_POST['right_bound'];
    $tau = 0.618;
    $epsilon = 0.001;
    $i = 0;
    while(abs($b-$a)>=$epsilon){
        $x1 = $a + (1 - $tau)*($b - $a);
        $x2 = $a + $tau*($b - $a);
        $is_result = $is_result . "<br> Положим x1=" . $x1 . ", x2=" . $x2 . "<br>";
        $is_result = $is_result . " Итерация № " . $i . "<br>";
        $i++;
        if(f($x1) < f($x2)){
            $b=$x2;
            $x2=$x1;
            $is_result = $is_result . "x2=" . $x2 . ", b=" . $b . "<br>";
        } else if(f($x1) > f($x2)){
            $a = $x1;
            $x1 = $x2;
            $is_result = $is_result . "x1=" . $x1 . ", a=" . $a . "<br>";
        }
        if(abs($b-$a) <= $epsilon){ 
            $xmin=($a+$b)/2;
            break;
        }
    }
    $is_result = $is_result . "Решение найдено: x(min)=" . $xmin . ", f(xmin)=" . f($xmin) . "<br>";
    prepare_to_save($is_result);
}

function fibo($n){
    if ($n == 0 ) return 0; 
    if ($n == 1 || $n == 2) { 
        return 1; 
    } else { 
        return fibo($n - 1) + fibo($n - 2); 
    } 
}

function fibonachi(){
    $is_result = $_POST['method'];
    $x1=0;
    $x2=0;
    $a = $_POST['left_bound'];
    $b = $_POST['right_bound'];
    $epsilon = 0.001;
    $i = 1;
    while(abs($b-$a)>=$epsilon){
        $x1 = $a + (fibo($i)/fibo($i+2))*($b - $a);
        $x2 = $a + $b - $x1;
        $is_result = $is_result . "<br> Положим x1=" . $x1 . ", x2=" . $x2 . "<br>";
        $is_result = $is_result . " Итерация № " . $i . "<br>";
        $i++;
        if(f($x1) < f($x2)){
            $b=$x2;
            $x2=$x1;
            $is_result = $is_result . "x2=" . $x2 . ", b=" . $b . "<br>";
        } else if(f($x1) > f($x2)){
            $a = $x1;
            $x1 = $x2;
            $is_result = $is_result . "x1=" . $x1 . ", a=" . $a . "<br>";
        }
        if(abs($b-$a) <= $epsilon){ 
            $xmin=($a+$b)/2;
            break;
        }
    }
    $is_result = $is_result . "Решение найдено: x(min)=" . $xmin . ", f(xmin)=" . f($xmin) . "<br>";
    prepare_to_save($is_result);
}


?>
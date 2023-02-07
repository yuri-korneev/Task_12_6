<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Практическое задание 12_6</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
   #gender {
    border-bottom: 2px dashed black;
   }
  </style>
</head>
<body>

<?php

$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

function getPartsFromFullname($string) {
    $fullnameParts = explode(" ", $string);
    $array = ['surname', 'name', 'patronamyc'];
    $fullnameParts = array_combine($array, $fullnameParts);
    return $fullnameParts;
}

/*$fullnamePart = getPartsFromFullname($example_persons_array[7]['fullname']);

print_r($fullnamePart);
echo "<br/>";*/

function getFullnameFromParts($surname, $name, $patronamyc) {
    $fullname = $surname . " " . $name . " " . $patronamyc;
    print_r($fullname);   
    return $fullname;
}

//getFullnameFromParts($fullnamePart['surname'], $fullnamePart['name'], $fullnamePart['patronamyc']);

function getShortName($string) {
    $fullNameFromParts = getPartsFromFullname($string);
    unset($fullNameFromParts['patronamyc']);
    $fullNameFromParts['surname'] = mb_substr($fullNameFromParts['surname'], 0, 1) . ".";
    $fullNameShort = $fullNameFromParts['name'] . " " . $fullNameFromParts['surname'];
    echo "<br/>";
    echo $fullNameShort;
    return $fullNameShort;
}

/* $length = count($example_persons_array);

for ($i = 0; $i < $length; $i++) {
    getShortName($example_persons_array[$i]['fullname']);
} */

function getGenderFromName($string) {

    $fullnameParts = getPartsFromFullname($string);
    $gender = 0;

    if (mb_substr($fullnameParts['surname'], -1) === 'в') {
        $gender += 1;
    }
    
    if (mb_substr($fullnameParts['name'], -1) === 'й' || mb_substr($fullnameParts['name'], -1) === 'н' ) {
        $gender += 1;
    }

    if (mb_substr($fullnameParts['patronamyc'], -2) === 'ич') {
        $gender += 1;
    }
    
    if (mb_substr($fullnameParts['surname'], -2) === 'ва') {
        $gender -= 1;
    }

    if (mb_substr($fullnameParts['name'], -1) === 'а') {
        $gender -= 1;
    }

    if (mb_substr($fullnameParts['patronamyc'], -3) === 'вна') {
        $gender -= 1;
    }
    
    $genderNumber = $gender <=> 0;
    return $genderNumber;

}

/* $gender = getGenderFromName($example_persons_array[8]['fullname']);
echo "<br/>";
echo $gender;
echo "<br/>"; */

function getGenderDescription ($array) {

    $length = count($array);
    $newArray = [];
    for ($i = 0; $i < $length; $i++) {
        $newArray[] = $array[$i]['fullname'];
    }

    $length1 = count($newArray);
    $newArray1 = [];
    for ($i = 0; $i < $length1; $i++) {
        $newArray1[] = getGenderFromName($newArray[$i]);
    }

    $maleArray = array_filter($newArray1, function($number) {
        return $number > 0;
    });

    $femaleArray = array_filter($newArray1, function($number) {
        return $number < 0;
    });

    $nonGenderArray = array_filter($newArray1, function($number) {
        return $number == 0;
    });

    $male = round(count($maleArray)/count($newArray1)*100, 1);
    
    $female = round(count($femaleArray)/count($newArray1)*100, 1);
  
    $nonGender = round(count($nonGenderArray)/count($newArray1)*100, 1);

    echo "<br/>";
    echo "<span id=\"gender\">Гендерный состав аудитории:</span><br/>
    Мужчины - $male%<br/>
    Женщины - $female%<br/>
    Не удалось определить - $nonGender%";
    echo "<br/>";

}

//getGenderDescription($example_persons_array);

$surname = "АнтОнова";
$name = "АННА";
$patronymic = "МихайЛОВНА";

$str = "";


function random_float($min, $max) {
    return random_int($min, $max - 1) + (random_int(0, PHP_INT_MAX - 1) / PHP_INT_MAX );
}

function upFirstLetter($str, $encoding = 'UTF-8')
{
return mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding)
. mb_substr($str, 1, null, $encoding);
}

function getPerfectPartner($surname, $name, $patronymic, $array) {

    $surname = mb_strtolower($surname);
    $name = mb_strtolower($name);
    $patronymic = mb_strtolower($patronymic);

    $surname = upFirstLetter($surname);
    $name = upFirstLetter($name);
    $patronymic = upFirstLetter($patronymic);

    /*echo "<br/>";
    echo $surname, $name, $patronymic; 
    echo "<br/>";*/

    $fullname = getFullnameFromParts($surname, $name, $patronymic);

    $gender = getGenderFromName($fullname);
    echo "<br/>";
    echo $gender;

    genderRandom:
    $fullnameRandom = $array[array_rand($array)]['fullname'];
    echo "<br/>";
    echo "$fullnameRandom";

    $genderRandom = getGenderFromName($fullnameRandom);

    echo "<br/>";
    print_r($genderRandom);

    if ($gender == 0) {
        echo "<br/>";
        echo "\u{1F615}Невозможно подобрать пару, т.к. пол не определен\u{1F615}";
        echo "<br/>";
    } 
    elseif ($genderRandom == -$gender) {
        $genderRandomShort = getShortName($fullnameRandom);
        $genderShort = getShortName($fullname);
        $percent = round(random_float(50, 100),2);
        echo "<br/>";
        echo "$genderRandomShort + $genderShort =<br/>
        \u{2661} Идеально на $percent% \u{2661}";
        echo "<br/>";
    } else {
        goto genderRandom; 
    }

    
}


// getPerfectPartner($surname, $name, $patronymic, $example_persons_array);

$length = count($example_persons_array);

for ($i = 0; $i < $length; $i++) {

    $fullnamePart = getPartsFromFullname($example_persons_array[$i]['fullname']);

    $surname = $fullnamePart['surname'];
    $name = $fullnamePart['name'];
    $patronymic = $fullnamePart['patronamyc'];

    getPerfectPartner($surname, $name, $patronymic, $example_persons_array);

}

?>
</body>
</html>
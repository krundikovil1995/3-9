<?php

function dm($data)
{
    echo "<pre>" . print_r($data, 1) . "</pre>";
}

$year = $_POST['search'];
$year = "{$year}-09-01";

$begin = new DateTime($year);
$end = new DateTime($year);
$end -> modify('+9 month');

$interval = new DateInterval('P1M');
$daterange = new DatePeriod($begin, $interval, $end);

$result = [];
$count = $begin->format('W');

foreach ($daterange as $startmonth){
    $endMonth = new DateTime($startmonth->format('Y-m-d'));
    $endMonth->modify('+1 month');

    $dayinterval = new DateInterval('P1D');
    $daydaterange = new DatePeriod($startmonth, $dayinterval, $endMonth);


    $month = ['month' => $startmonth->format('F')];

    $week = [];

    foreach ($daydaterange as $day){
        if ($count % 7 == 0){
            $month['weeks'][]=$week;
            $week = [];
        }
        $count++;
        $week[] = $day->format('d');
    }
    $month['weeks'][]=$week;
    $result[]=$month;

    dm($month);
}

dm($result);

foreach ($result as $item):
?>

<table>
    <thead>
    <tr>
        <th colspan='7'><?php echo $item['month']; ?></th>
    </tr>
    <tr>
        <th>Пн</th>
        <th>Вт</th>
        <th>Ср</th>
        <th>Чт</th>
        <th>Пт</th>
        <th>Сб</th>
        <th>Вс</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($item['weeks'] as $week): ?>
    <tr>
  <?php foreach ($week as $day): ?>
                    <td>
                        <?php echo $day; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endforeach; ?>
<style>
    body {
        display: flex;
    }

    body table {
        margin: 10px;
    }
</style>
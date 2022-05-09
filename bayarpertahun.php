<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayar Per Tahun</title>
    <style>
        table tr th {
            border: 1px solid black;
        }
        table tr td {
            border: 1px solid black;
        }
        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Data Awal</th>
                <th colspan="2">Sebelum Migrasi</th>
                <th colspan="2">Setelah Migrasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tahun</td>
                <td>Lembar</td>
                <td>total</td>
                <td>Lembar</td>
                <td>total</td>
            </tr>
            <?php 
                require_once('connection.php');
                $sql = "SELECT YEAR(tgl_bayar) AS tahun, COUNT(*) AS lembar, SUM(total_tarif+denda) as total FROM billing WHERE tgl_bayar IS NOT NULL AND tahun >= '2016' GROUP BY YEAR(tgl_bayar)";
                $result = $conn->query($sql);
                $sql2 = "SELECT YEAR(tglbayar) AS tahun, COUNT(*) AS lembar, SUM(rekair+dendatunggakan) AS total FROM bayar GROUP BY YEAR(tglbayar)";
                $result2 = $conn2->query($sql2);
                if ($result->num_rows > 0) {
                    $row2 = $result2->fetch_all(MYSQLI_ASSOC);
                    $i = 0;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row['tahun']."</td>
                                <td style='text-align:right;'>".$row['lembar']."</td>
                                <td style='text-align:right; padding:2px;'>Rp".number_format($row['total'],0,',','.')."</td>";
                        if ($row['tahun'] == $row2[$i]['tahun']) {
                            echo "<td style='text-align:right;'>".$row2[$i]['lembar']."</td>
                                    <td style='text-align:right;'>Rp".number_format($row2[$i]['total'],0,',','.')."</td>";
                            $i++;
                        } else {
                            echo "<td></td><td></td>";
                        }
                        echo "</tr>";
                    }
                }
            ?>
        </tbody>
    </table>
</body>
</html>